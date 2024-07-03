<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // ถ้าผู้ใช้ยังไม่ได้ล็อกอินด้วย Google ให้ Redirect ไปยัง google-login.php เพื่อล็อกอิน
    header('Location: google-login.php');
    exit();
}

// Include database connection
include 'database.php';

// Initialize an array to store sentiment counts
$sentimentCounts = [
    'positive' => 0,
    'neutral' => 0,
    'negative' => 0
];

// Query to fetch sentiment data
$query = 'SELECT label FROM sentiments';
$result = pg_query($query);

// Count the number of each sentiment label
$totalCount = 0;
while ($row = pg_fetch_assoc($result)) {
    switch (strtolower($row['label'])) {
        case 'positive':
            $sentimentCounts['positive']++;
            break;
        case 'neutral':
            $sentimentCounts['neutral']++;
            break;
        case 'negative':
            $sentimentCounts['negative']++;
            break;
        default:
            // Handle other cases if necessary
            break;
    }
    $totalCount++;
}
pg_free_result($result);

// Calculate percentages
$data = [
    'positive' => $totalCount ? round(($sentimentCounts['positive'] / $totalCount) * 100, 2) : 0,
    'neutral' => $totalCount ? round(($sentimentCounts['neutral'] / $totalCount) * 100, 2) : 0,
    'negative' => $totalCount ? round(($sentimentCounts['negative'] / $totalCount) * 100, 2) : 0,
];

// Additional information
$teacher = "ดร.สมชาย อาจารย์ดี";
$subject = "การวิเคราะห์ข้อมูล";
$semester = "ภาคการศึกษาที่ 1/2566";

// Function to fetch comments based on sentiment
function fetchCommentsBySentiment($sentiment)
{
    include 'database.php'; // Ensure you have database connection included
    $query = "SELECT comment FROM reviews1 
              JOIN sentiments ON reviews1.id = sentiments.review_id 
              WHERE sentiments.label = '$sentiment'";
    $result = pg_query($query);

    $comments = [];
    while ($row = pg_fetch_assoc($result)) {
        $comments[] = $row['comment'];
    }
    pg_free_result($result);
    return $comments;
}

// Fetch comments for each sentiment
$positiveComments = fetchCommentsBySentiment('positive');
$neutralComments = fetchCommentsBySentiment('neutral');
$negativeComments = fetchCommentsBySentiment('negative');
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    <title>รายงานการวิเคราะห์ความรู้สึก</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Content/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="./Content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .percentage-curve {
            width: 100%;
            height: 20px;
            background-color: #eee;
            border-radius: 5px;
            overflow: hidden;
        }

        .percentage-bar {
            height: 100%;
            background-color: #4CAF50;
        }

        .card-body {
            padding: 30px;
        }

        .chart-container {
            position: relative;
            width: 60%;
            margin: auto;
        }
        .logout-button {
            margin: 10px;
            background-color: #CD5C5C;
            border-radius: 40px;
            color: white;
            font-size: 14px;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
        .logout-button:hover{
            background-color: #515151;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-fixed-top bg-white navbar-light border-bottom elevation-1">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
            <span class="ml-2" style="font-weight: 600; font-size: x-large; color: #515151">Comment Sentiment Analysis System</span>
        </nav>
        <!-- /Navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-info elevation-4">
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <div class="logoutcontainer">
                            <div class="insidelogout">
                                <li class="nav-item mt-3">
                                    <a class="nav-link elevation-2" style="color: #fff;">
                                        <i class="fa fa-user-o nav-icon" style="font-size:24px; color:white;"></i>
                                        <?php
                                        if (isset($_SESSION['user_id'])) {
                                            echo '<span class="user-info">' . $_SESSION['user_name'];
                                            echo '<a href="logout.php"><button class="logout-button">Logout</button></a></span>';
                                        } else {
                                            echo '<p>User</p>';
                                        }
                                        ?>
                                    </a>
                                </li>
                            </div>
                        </div>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link"><i class="fa fa-home nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reviews.php" class="nav-link">
                                <i class="fa fa-rocket nav-icon" style="font-size:24px"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sentiment.php" class="nav-link">
                                <i class="fa fa-user-secret nav-icon" style="font-size:24px"></i>
                                <p>Sentiment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sematicreport.php" class="nav-link active"><i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
                                <p>รายงาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="analyzebytrain.php" class="nav-link "><i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
                                <p> sentimentByTrain</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <div class="container-fluid"></div>
            </section>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 mt-5">
                            <div class="card card-info card-outline elevation-2">
                                <div class="card-header">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#InstEng"><small style="font-size: medium; font-weight: 600">รายงาน</small></a></li>
                                    </ul>
                                </div>
                                <div class="card-body">
                                    <div class="text-center">
                                        <h3 class="mb-4">รายงานการวิเคราะห์ความรู้สึก</h3>
                                        <!-- <p><strong>อาจารย์ผู้สอน:</strong> <?php echo $teacher; ?></p>
                                        <p><strong>วิชา:</strong> <?php echo $subject; ?></p>
                                        <p><strong>ภาคปีการศึกษา:</strong> <?php echo $semester; ?></p> -->
                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5>บวก (Positive): <?php echo $sentimentCounts['positive']; ?> ครั้ง</h5>
                                                <button class="btn btn-success" onclick="showComments('positive')">ดูคอมเมนต์</button>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>กลาง (Neutral): <?php echo $sentimentCounts['neutral']; ?> ครั้ง</h5>
                                                <button class="btn btn-warning" onclick="showComments('neutral')">ดูคอมเมนต์</button>
                                            </div>
                                            <div class="col-md-4">
                                                <h5>ลบ (Negative): <?php echo $sentimentCounts['negative']; ?> ครั้ง</h5>
                                                <button class="btn btn-danger" onclick="showComments('negative')">ดูคอมเมนต์</button>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <div class="chart-container">
                                                    <canvas id="sentimentChart"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>ระดับความรู้สึก</th>
                                                            <th>เปอร์เซ็นต์</th>
                                                            <th>กราฟแสดงเปอร์เซ็นต์</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>&#128516; บวก</td>
                                                            <td><?php echo $data["positive"]; ?>%</td>
                                                            <td>
                                                                <div class="percentage-curve">
                                                                    <div class="percentage-bar" style="width: <?php echo $data["positive"]; ?>%;"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&#128528; กลาง</td>
                                                            <td><?php echo $data["neutral"]; ?>%</td>
                                                            <td>
                                                                <div class="percentage-curve">
                                                                    <div class="percentage-bar" style="width: <?php echo $data["neutral"]; ?>%; background-color: #FFC107;"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>&#128546; ลบ</td>
                                                            <td><?php echo $data["negative"]; ?>%</td>
                                                            <td>
                                                                <div class="percentage-curve">
                                                                    <div class="percentage-bar" style="width: <?php echo $data["negative"]; ?>%; background-color: #F44336;"></div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Modal Structure -->
                                        <div class="modal fade" id="commentsModal" tabindex="-1" role="dialog" aria-labelledby="commentsModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="commentsModalLabel">Comments</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <ul id="commentsList" class="list-group">
                                                            <!-- Comments will be appended here -->
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </section>
    </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('sentimentChart').getContext('2d');
        var sentimentChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['บวก (Positive)', 'กลาง (Neutral)', 'ลบ (Negative)'],
                datasets: [{
                    data: [<?php echo $data['positive']; ?>, <?php echo $data['neutral']; ?>, <?php echo $data['negative']; ?>],
                    backgroundColor: ['#4CAF50', '#FFC107', '#F44336']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'การวิเคราะห์ความรู้สึก'
                }
            }
        });

        // JavaScript function to show comments in the modal
        function showComments(sentiment) {
            var comments = [];
            var modalTitle = '';

            // Fetch the comments based on sentiment
            switch (sentiment) {
                case 'positive':
                    comments = <?php echo json_encode($positiveComments); ?>;
                    modalTitle = 'บวก (Positive) Comments';
                    break;
                case 'neutral':
                    comments = <?php echo json_encode($neutralComments); ?>;
                    modalTitle = 'กลาง (Neutral) Comments';
                    break;
                case 'negative':
                    comments = <?php echo json_encode($negativeComments); ?>;
                    modalTitle = 'ลบ (Negative) Comments';
                    break;
            }

            // Set the modal title
            document.getElementById('commentsModalLabel').textContent = modalTitle;

            // Clear previous comments
            var commentsList = document.getElementById('commentsList');
            commentsList.innerHTML = '';

            // Append new comments
            comments.forEach(function(comment) {
                var li = document.createElement('li');
                li.textContent = comment;
                li.className = 'list-group-item';
                commentsList.appendChild(li);
            });

            // Show the modal
            $('#commentsModal').modal('show');
        }
    </script>
    <script src="./Content/plugins/jquery/jquery.min.js"></script>
    <script src="./Content/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"></script>
    <script src="./Content/dist/js/adminlte.min.js"></script>
</body>

</html>