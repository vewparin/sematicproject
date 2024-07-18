<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Google</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-btn {
            background-color: #4285F4;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
            text-decoration: none;
        }
        .login-btn:hover {
            background-color: #357ae8;
        }
    </style>
</head>
<body>
    <div class="px-4 py-5 my-5 text-center">
        <!-- <img class="d-block mx-auto mb-4" src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="" width="72" height="57"> -->
        <h1 class="display-5 fw-bold text-body-emphasis">Sentiment Analysis System</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">ระบบวิเคราะห์ความคิดเห็นของเราช่วยให้คุณสามารถตรวจสอบและวิเคราะห์ความคิดเห็นของลูกค้าหรือผู้ใช้งานได้อย่างรวดเร็วและแม่นยำ โดยใช้เทคโนโลยีปัญญาประดิษฐ์ที่ทันสมัย เราสามารถประมวลผลข้อความจากหลายแหล่งข้อมูล ไม่ว่าจะเป็นโซเชียลมีเดีย รีวิวสินค้า หรือแบบสอบถาม เพื่อให้คุณได้รับข้อมูลเชิงลึกที่เป็นประโยชน์ในการปรับปรุงและพัฒนาธุรกิจของคุณ</p>
            <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                <a href="google-login.php" class="btn login-btn">Login with Google</a>
                <button type="button" class="btn btn-outline-secondary btn-lg px-4">Secondary</button>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
