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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>รายงานการวิเคราะห์ความรู้สึก</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    </style>
</head>
<body>
    
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
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
</body>
</html>