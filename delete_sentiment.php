<?php
// Include database connection
include 'database.php';

// Check if sentiment ID is set and not empty
if(isset($_POST['id']) && !empty($_POST['id'])) {
    // Sanitize the sentiment ID
    $sentiment_id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);

    // Prepare a DELETE statement
    $query = "DELETE FROM sentiments WHERE id = $sentiment_id";

    // Execute the DELETE statement
    if(pg_query($query)) {
        // Delete successful
        echo 'ลบรายการเรียบร้อยแล้ว';
    } else {
        // Delete failed
        echo 'เกิดข้อผิดพลาดในการลบรายการ';
    }
} else {
    // If sentiment ID is not set or empty
    echo 'ไม่พบรหัสรายการ';
}
?>
