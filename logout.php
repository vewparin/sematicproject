<?php
// เริ่ม Session
session_start();

// ลบ Session ทั้งหมด
session_destroy();

// หากต้องการลบ Session บางตัวเท่านั้น
// unset($_SESSION['user_id']);
// unset($_SESSION['user_name']);

// นำกลับไปยังหน้า login หรือหน้าหลักอื่น ๆ
header("Location: login.php"); // เปลี่ยนเส้นทาง URL ตามที่คุณต้องการ
exit();
?>
