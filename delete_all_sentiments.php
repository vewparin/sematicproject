<?php
// Include database connection
include 'database.php';

// Prepare a DELETE statement
$query = "DELETE FROM sentiments";

// Execute the DELETE statement
if(pg_query($query)) {
    // Delete successful
    echo 'ลบข้อมูลทั้งหมดเรียบร้อยแล้ว';
} else {
    // Delete failed
    echo 'เกิดข้อผิดพลาดในการลบข้อมูล';
}
?>
