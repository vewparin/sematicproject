<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    // ถ้าผู้ใช้ยังไม่ได้ล็อกอินด้วย Google ให้ Redirect ไปยัง google-login.php เพื่อล็อกอิน
    header('Location: google-login.php');
    exit();
}

// ต่อไปคือโค้ด HTML และอื่น ๆ ใน index.php
?>
<!DOCTYPE html>
<html>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />

<head>
    <link rel="import" href="./files.html">
    <style type="text/css">
        #box {
            width: 300px;
            padding: 25px;
            margin: 25px 150px;
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

        #box {
            width: 100%;
            max-width: 100%;
            /* ขอบเขตความกว้างสูงสุด */
            margin: 25px auto;
            margin-left: 75%;
            /* ปรับให้ box อยู่ตรงกลาง */
            padding: 25px;
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: #f8f9fa;
            /* สีพื้นหลัง */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* เงา */
        }

        .custom-file-input::before {
            content: 'Browse';
            display: inline-block;
            background: #007bff;
            color: white;
            border: 1px solid #007bff;
            border-radius: 5px;
            padding: 8px 12px;
            outline: none;
            white-space: nowrap;
            cursor: pointer;
            font-weight: 700;
        }

        .custom-file-input:hover::before {
            border-color: #0056b3;
        }

        .custom-file-input:active::before {
            background: #0b62e1;
        }

        /* เสริมสไตล์สำหรับแสดงชื่อไฟล์ที่เลือก */
        .custom-file-label::after {
            content: 'Choose file';
            /* เพิ่มข้อความที่แสดงหลังจากชื่อไฟล์ */
        }

        .custom-file-input {
            overflow: hidden;
            position: relative;
            cursor: pointer;
            z-index: 2;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Content/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="./Content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <script type="text/javascript" src="/validCSV.js"></script>
</head>

<body class="hold-transition sidebar-mini">

    <div class="wrapper">
        <!--navbar -->
        <nav class="main-header navbar navbar-expand navbar-fixed-top bg-white navbar-light border-bottom elevation-1">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#">
                        <i class="fa fa-bars"></i></a>
                </li>
            </ul>
            <span class="ml-2" style="font-weight: 600; font-size: x-large; color: #515151">Comment Sentiment Analysis System</span>
        </nav>
        <!-- / navbar -->
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
                            <a href="index.php" class="nav-link active">
                                <i class="fa fa-home nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reviews.php" class="nav-link"><i class="fa fa-rocket nav-icon" style="font-size:24px"></i>
                                <p> Reviews</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sentiment.php" class="nav-link"><i class="fa fa-user-secret nav-icon" style="font-size:24px"></i>
                                <p>Sentiment</p>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#InstEng"><small style="font-size: medium; font-weight: 600">Welcome</small></a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="tab-content">
                                            <div id="InstEng" class="active tab-pane" style="padding-top: 1%">

                                                <!-- <div id="box">
                                                    <form enctype="multipart/form-data" onsubmit="return Validate(this);" method="post" name="myform" action="import_csv.php">
                                                        <table border="0px" width="500px" height="150px">
                                                            <tr>
                                                                <td colspan="2" align="center"><strong>
                                                                        <h4>IMPORT CSV FILE</h4>
                                                                    </strong><br></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; CSV File:</td>
                                                                <td> <input type="file" name="file" id="file" accept="csv/*"><br><br></td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" align="center"><input type="submit" value="submit"></td>
                                                            </tr>
                                                        </table>
                                                    </form>
                                                </div> -->

                                                <div id="box">
                                                    <form enctype="multipart/form-data" onsubmit="return Validate(this);" method="post" name="myform" action="import_csv.php">
                                                        <table class="table">

                                                            <thead class="thead-dark">
                                                                <tr>
                                                                    <th colspan="2" class="text-center">
                                                                        <h4>IMPORT CSV FILE</h4>
                                                                    </th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class="align-middle text-right">CSV File:</td>
                                                                    <td>
                                                                        <div class="custom-file">
                                                                            <input type="file" class="custom-file-input" id="file" name="file" accept=".csv">
                                                                            <label class="custom-file-label" for="file">Choose file</label>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td colspan="2" class="text-center">
                                                                        <button type="submit" class="btn btn-primary">Submit</button>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <h6 style="font-weight: bold; color:#CD5C5C">รองรับไฟล์ได้สูงสุด 500 rows</h6>

                                                    </form>
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
    <script>
        document.getElementById('file').addEventListener('change', function() {
            var fullPath = this.value;
            var fileName = fullPath.replace(/^.*[\\\/]/, '');
            var label = document.querySelector('.custom-file-label');
            label.innerHTML = fileName;
        });
    </script>
</body>

</html>