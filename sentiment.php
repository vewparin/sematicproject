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
                        <li class="nav-item mt-3">
                            <a class="nav-link elevation-2" style="color: #fff; background-color: rgba(255,255,255,.1)">
                                <i class="fa fa-user-o nav-icon" style="font-size:24px;color:White"></i>
                                <p>User</p>
                            </a>
                        </li>
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
                                                ?>
                                                <div class="table-responsive">
                                                    <table class="table table-hover table-condensed">
                                                        <tr>
                                                            <th>ID</th>
                                                            <th>Review Id</th>
                                                            <th>Sentiment</th>
                                                            <th>Label</th>
                                                            <th>Keywords</th>
                                                            <th>Analyzed Date</th>
                                                            <th>Actions</th> <!-- เพิ่มส่วนนี้ -->
                                                        </tr>
                                                        <?php
                                                        while ($row = pg_fetch_assoc($result)) {
                                                            echo '<tr>';
                                                            foreach ($row as $cell) {
                                                                echo '<td>' . $cell . '</td>';
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
                        url: 'delete_all_sentiments.php',
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
</body>

</html>