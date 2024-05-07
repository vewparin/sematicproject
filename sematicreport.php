<?php
// กำหนดข้อมูลตัวอย่าง
$data = [
    "positive" => 99,
    "neutral" => 99,
    "negative" => 99,
];

// ข้อมูลเพิ่มเติม
$teacher = "ดร.สมชาย อาจารย์ดี";
$subject = "การวิเคราะห์ข้อมูล";
$semester = "ภาคการศึกษาที่ 1/2566";

// คำนวณเปอร์เซ็นต์ของคะแนน
$total = array_sum($data);
foreach ($data as $key => $value) {
    $data[$key] = round($value / $total * 100, 2);
}
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <!-- <meta charset="UTF-8"> -->
    <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />

    <title>รายงานการวิเคราะห์ความรู้สึก</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="import" href="files.html">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://unpkg.com/ionicons@4.5.5/dist/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./Content/dist/css/adminlte.min.css">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
    <link href="./Content/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        .btn-circle {
            border-radius: 50%;
        }

        .btn-hover:hover {
            background-color: red;
            /* เปลี่ยนสีพื้นหลังเมื่อเมาส์โฮเวอร์ */
            color: white;
            /* เปลี่ยนสีตัวอักษรเป็นสีขาวเมื่อเมาส์โฮเวอร์ */
        }

        .btn-danger {}

        .card-body {
            padding: 30px;
            /* ปรับขนาด Padding ตามต้องการ */
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
                        <li class="nav-item mt-3">
                            <a class="nav-link elevation-2" style="color: #fff; background-color: rgba(255,255,255,.1)"><i class="fa fa-user-o nav-icon" style="font-size:24px;color:White"></i>
                                <p>User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="index.php" class="nav-link "><i class="fa fa-home nav-icon"></i>
                                <p>Home</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="reviews.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'reviews.php' ? 'active' : ''; ?>">
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
                            <a href="sematicreport.php" class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'sematicreport.php' ? 'active' : ''; ?>">
                                <i class="fa fa-file-text nav-icon" style="font-size:24px"></i>
                                <p>รายงาน</p>
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
                                    <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#InstEng"><small style="font-size: medium; font-weight: 600">Report</small></a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="tab-content">
                                            <div class="container mt-10 d-flex justify-content-center">
                                                <div class="row">
                                                    <div class="col-md-20 offset-md-10 ">
                                                        <div class="card">
                                                            <div class="card-header bg-primary text-white">
                                                                <h3 class="mb-0">รายงานการวิเคราะห์ความรู้สึก</h3>
                                                            </div>
                                                            <div class="card-body">
                                                                <p><strong>อาจารย์ผู้สอน:</strong> <?php echo $teacher; ?></p>
                                                                <p><strong>วิชา:</strong> <?php echo $subject; ?></p>
                                                                <p><strong>ภาคปีการศึกษา:</strong> <?php echo $semester; ?></p>
                                                                <div class="text-center">
                                                                    <canvas id="positiveChart"></canvas>
                                                                    <p class="mt-2"><strong>คะแนน Positive: <?php echo $data["positive"]; ?></strong></p>
                                                                </div>
                                                                <table class="table table-striped mt-4">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>ประเภท</th>
                                                                            <th>คะแนน</th>
                                                                            <th>เปอร์เซ็นต์</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>&#128516; บวก</td>
                                                                            <td><?php echo $data["positive"]; ?></td>
                                                                            <td>
                                                                                <div class="percentage-curve">
                                                                                    <div class="percentage-bar" style="width: <?php echo $data["positive"]; ?>%;"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>&#128528; กลาง</td>
                                                                            <td><?php echo $data["neutral"]; ?></td>
                                                                            <td>
                                                                                <div class="percentage-curve">
                                                                                    <div class="percentage-bar" style="width: <?php echo $data["neutral"]; ?>%;"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>&#128546; ลบ</td>
                                                                            <td><?php echo $data["negative"]; ?></td>
                                                                            <td>
                                                                                <div class="percentage-curve">
                                                                                    <div class="percentage-bar" style="width: <?php echo $data["negative"]; ?>%;"></div>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
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
                    </div>
                </div>
            </div>
        </section>
    </div>
    </div>
    <script>
        var ctx = document.getElementById('positiveChart').getContext('2d');
        var positiveChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Positive', 'Others'],
                datasets: [{
                    data: [<?php echo $data["positive"]; ?>, <?php echo 100 - $data["positive"]; ?>],
                    backgroundColor: ['#4CAF50', '#e0e0e0']
                }]
            },
            options: {
                rotation: -90,
                circumference: 180,
                title: {
                    display: true,
                    text: 'คะแนน Positive'
                },
                plugins: {
                    datalabels: {
                        display: false
                    }
                }
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="./Content/plugins/jquery/jquery.min.js"></script>
    <script src="./Content/plugins/bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fastclick/1.0.6/fastclick.js"></script>
    <script src="./Content/dist/js/adminlte.min.js"></script>
    <script src="allAnalyze.js"></script>
</body>


</html>