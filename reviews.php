<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // ถ้าผู้ใช้ยังไม่ได้ล็อกอินด้วย Google ให้ Redirect ไปยัง google-login.php เพื่อล็อกอิน
    header('Location: google-login.php');
    exit();
}


?>

<!DOCTYPE html>
<html>

<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <link rel="import" href="files.html">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Content/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="./Content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <style>
        .btn-circle {
            border-radius: 50%;
        }

        .btn-hover:hover {
            background-color: red;
            /* เปลี่ยนสีพื้นหลังเมื่อเมาส์โฮเวอร์ */
            color: white;
            /* เปลี่ยนสีตัวอักษรเป็นสีขาวเมื่อเมาส์โฮเวอร์ */
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

        .logout-button:hover {
            background-color: #515151;
        }

        .btn-circle {
            border-radius: 50%;
        }

        .btn-hover:hover {
            background-color: red;
            color: white;
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

        .logout-button:hover {
            background-color: #515151;
        }

        /* ปรับขนาดตัวอักษรในตารางให้เล็กลง */
        .table td,
        .table th {
            font-size: 12px;
        }
        .table-responsive {
        height: 400px;
        overflow: auto;
    }
    </style>
</head>

<body class="hold-transition sidebar-mini">


    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-fixed-top bg-white navbar-light border-bottom elevation-1">
            <!-- Left navbar links -->
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
                <!-- Sidebar Menu -->
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
                            <a href="index.php" class="nav-link "><i class="fa fa-home nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reviews.php" class="nav-link active">
                                <i class="fa fa-rocket nav-icon" style="font-size:24px"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sentiment.php" class="nav-link">
                                <i class="fa fa-user-secret nav-icon" style="font-size:24px"></i>
                                <p>sentiment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sematicreport.php" class="nav-link"><i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
                                <p> รายงาน</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="analyzebytrain.php" class="nav-link"><i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
                                <p> sentimentByTrain</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>
    </div>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#InstEng"><small style="font-size: medium; font-weight: 600">Review To Analyze Sentiment</small></a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="tab-content">
                                            <div class="text-center">
                                                <tr>
                                                    <td colspan="5" style="display: flex; gap: 10px;">
                                                        <button id="allAnalyzeBtn" class="btn btn-primary" style="margin-bottom: 5px;">All Analyze With AI ForThai</button>
                                                        <form action="predict.php" method="post" style="margin-right: 10px;">
                                                            <button type="submit" class="btn btn-success" style="margin-bottom: 5px;">Analyze All Comments With TrainModel</button>
                                                        </form>
                                                        <!-- <a href="analyzebytrain.php" class="btn btn-success" style="margin-bottom: 5px;">View Analyzed Comments</a> -->
                                                    </td>
                                                </tr>
                                                <button class="btn btn-danger btn-sm delete-all-btn"><i class="fa fa-trash"></i> Delete All</button>
                                            </div>
                                            <div id="InstEng" class="active tab-pane" style="padding-top: 1%">
                                                <?php
                                                include 'database.php';
                                                $query = 'SELECT * FROM reviews1';
                                                $result = pg_query($query);
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-condensed">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Comment</th>
                                                            <th>Created Date</th>
                                                            <th>Button</th>
                                                            <th>Delete</th>
                                                        </tr>
                                                        <?php
                                                        while ($row = pg_fetch_row($result)) {
                                                            echo '<tr>';
                                                            for ($i = 0; $i < count($row); $i++) {
                                                                // ไม่แสดง Review Entity Type Id (index 1)
                                                                if ($i != 1) {
                                                                    echo '<td>' . $row[$i] . '</td>';
                                                                }
                                                            }
                                                            echo '<td>
                    <form action="sent.php" method="POST">
                        <input type="hidden" name="index" value="' . $row[0] . '">
                        <input type="submit" name="name" value="Analyze">
                    </form>
                </td>';
                                                            echo '<td>
                    <form action="delete.php" method="post" class="deletebtn">
                        <input type="hidden" name="id" value="' . $row[0] . '">
                        <button type="submit" class="btn btn-danger btn-circle btn-hover"><i class="fa fa-trash"></i> </button>
                    </form>
                </td>';
                                                            echo '</tr>';
                                                        }
                                                        pg_free_result($result);
                                                        ?>

                                                    </table>



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
    <script src="./Content/plugins/jquery/jquery.min.js"></script>
    <script src="./Content/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"></script>
    <script src="./Content/dist/js/adminlte.min.js"></script>
    <!-- <script src="./allAnalyze.js"></script> -->
    <script>
        // JavaScript function to handle delete button click
        $(document).ready(function() {
            $('.delete-btn').click(function() {
                var button = $(this);
                if (confirm('คุณแน่ใจหรือไม่ที่ต้องการลบรายการนี้?')) {
                    var sentimentId = button.data('id'); // Get the ID of the sentiment to delete
                    $.ajax({
                        url: 'delete_sentiment.php',
                        type: 'POST',
                        data: {
                            id: sentimentId
                        },
                        success: function(response) {
                            alert(response); // Display success or error message
                            // Remove the deleted row from the table
                            button.closest('tr').remove();
                        },
                        error: function(xhr, status, error) {
                            alert('เกิดข้อผิดพลาดในการลบรายการ');
                        }
                    });
                }
            });
        });
        // JavaScript function to handle delete all button click
        $(document).ready(function() {
            $('.delete-all-btn').click(function() {
                if (confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลทั้งหมด?')) {
                    $.ajax({
                        url: 'delete_all_review_comments.php',
                        type: 'POST',
                        success: function(response) {
                            // Handle success response here
                            alert('ลบข้อมูลทั้งหมดสำเร็จ');
                            // Remove all rows from the table
                            $('table tbody tr').not(':first').remove();
                        },
                        error: function(xhr, status, error) {
                            // Handle error response here
                            alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                        }
                    });
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#allAnalyzeBtn').click(function() {
                // Ask for confirmation before proceeding
                var confirmMessage = 'Are you sure you want to analyze all reviews with AI ForThai?\n\nPress OK to proceed, or Cancel to abort.';
                if (confirm(confirmMessage)) {
                    var reviewIds = [];
                    // Loop through each table row except the header row
                    $('table tr').each(function() {
                        var id = $(this).find('td:first').text().trim(); // Get the text content of the first column
                        if (id !== 'ID' && id !== '') { // Ensure it's not the header row and ID is not empty
                            reviewIds.push(id); // Push the ID into the array
                        }
                    });

                    // Check if there are review IDs to process
                    if (reviewIds.length > 0) {
                        $.ajax({
                            url: 'processAllAnalyze.php',
                            type: 'POST',
                            data: {
                                reviewIds: reviewIds
                            },
                            success: function(response) {
                                // Redirect to sentiment.php after processing
                                window.location.href = 'sentiment.php';
                            },
                            error: function(xhr, status, error) {
                                // Handle errors with an alert
                                alert('Error: ' + error);
                            }
                        });
                    } else {
                        // Alert if no review IDs were found
                        alert('No review IDs found to process.');
                    }
                } else {
                    // Action cancelled by the user
                    alert('Operation cancelled.');
                }
            });
        });
    </script>

</body>

</html>