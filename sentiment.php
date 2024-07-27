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
    <link rel="stylesheet" href="./style.css">
    <style>
        .table .keywords-column {
            max-width: 500px;
            /* ปรับความกว้างตามต้องการ */
            word-wrap: break-word;
            white-space: normal;
        }

        .table-responsive {
            max-height: 400px;
            overflow-y: auto;
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
        <!-- /.navbar -->
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
                            <a href="reviews.php" class="nav-link">
                                <i class="fa fa-rocket nav-icon" style="font-size:24px"></i>
                                <p>Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sentiment.php" class="nav-link active">
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
                            <a href="analyzebytrain.php" class="nav-link "><i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#InstEng"><small style="font-size: medium; font-weight: 600">Sentiment Analyzed Reviews</small></a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="tab-content">
                                            <div id="InstEng" class="active tab-pane" style="padding-top: 1%">
                                                <?php
                                                include 'database.php';
                                                $query = 'SELECT * FROM sentiments';
                                                $result = pg_query($query);
                                                $rowCount = pg_num_rows($result);
                                                ?>
                                                <div style="padding:10px">Number of Sentiment: <?php echo $rowCount; ?></div> <!-- แสดงจำนวน rows -->

                                                <div class="table-responsive">
                                                    <table class="table table-hover table-condensed">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Review Id</th>
                                                            <th>Sentiment</th>
                                                            <th>Label</th>
                                                            <th class="keywords-column">Keywords</th>
                                                            <th>Analyzed Date</th>
                                                            <th>Actions</th> <!-- เพิ่มส่วนนี้ -->
                                                        </tr>
                                                        <?php
                                                        // while ($row = pg_fetch_assoc($result)) {
                                                        //     echo '<tr>';
                                                        //     foreach ($row as $cell) {
                                                        //         echo '<td>' . $cell . '</td>';
                                                        //     }
                                                        //     echo '<td><button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</button></td>';
                                                        //     echo '</tr>';
                                                        // }
                                                        // pg_free_result($result);

                                                        while ($row = pg_fetch_assoc($result)) {
                                                            echo '<tr>';
                                                            $i = 0;
                                                            foreach ($row as $cell) {
                                                                if ($i == 4) { // คอลัมน์ที่ 5 คือ Keywords (นับจาก 0)
                                                                    echo '<td class="keywords-column">' . $cell . '</td>';
                                                                } else {
                                                                    echo '<td>' . $cell . '</td>';
                                                                }
                                                                $i++;
                                                            }
                                                            echo '<td><button class="btn btn-danger btn-sm delete-btn" data-id="' . $row['id'] . '"><i class="fa fa-trash"></i> Delete</button></td>';
                                                            echo '</tr>';
                                                        }
                                                        pg_free_result($result);
                                                        ?>
                                                    </table>
                                                </div>

                                                <div class="text-center">
                                                    <button class="btn btn-danger btn-sm delete-all-btn"><i class="fa fa-trash"></i> Delete All</button>
                                                </div>
                                                <div class="text-center" style="padding: 15px;">
                                                    <button style="background-color:cadetblue;">
                                                        <a href="./sematicreport.php" style="color:#fff">View Semantic Report</a>
                                                    </button>
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
    <script src="./Content/plugins/jquery/jquery.min.js"></script>
    <script src="./Content/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"></script>
    <script src="./Content/dist/js/adminlte.min.js"></script>
    <script>
        $(document).ready(function() {
            // ลบแถวเดียว
            $('.delete-btn').click(function() {
                var id = $(this).data('id');
                var row = $(this).closest('tr');

                if (confirm('Are you sure you want to delete this sentiment?')) {
                    $.ajax({
                        url: 'delete_sentiment.php',
                        type: 'POST',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status == 'success') {
                                row.remove();
                            } else {
                                alert('Delete failed: ' + result.message);
                            }
                        },
                        error: function() {
                            alert('An error occurred while deleting the sentiment.');
                        }
                    });
                }
            });

            // ลบทั้งหมด
            $('.delete-all-btn').click(function() {
                if (confirm('คุณแน่ใจหรือไม่ที่ต้องการลบข้อมูลทั้งหมด?')) {
                    $.ajax({
                        url: 'delete_all_sentiments.php',
                        type: 'POST',
                        success: function(response) {
                            var result = JSON.parse(response);
                            if (result.status == 'success') {
                                alert('ลบข้อมูลทั้งหมดสำเร็จ');
                                // Remove all rows from the table
                                $('table tbody tr').remove();
                            } else {
                                alert('Delete all failed: ' + result.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            alert('เกิดข้อผิดพลาดในการลบข้อมูล');
                        }
                    });
                }
            });
        });
    </script>
</body>

</html>