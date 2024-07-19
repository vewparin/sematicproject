    <?php
    // // Include database connection
    // include 'database.php';

    // // Prepare a DELETE statement
    // $query = "DELETE FROM reviews1";

    // // Execute the DELETE statement
    // if(pg_query($query)) {
    //     // Delete successful
    //     echo 'ลบข้อมูลทั้งหมดเรียบร้อยแล้ว';
    // } else {
    //     // Delete failed
    //     echo 'เกิดข้อผิดพลาดในการลบข้อมูล';
    // }

    // Include database connection
    include 'database.php';

    // Start a transaction
    pg_query("BEGIN");

    // Delete dependent rows in sentiments table
    $deleteSentimentsSql = "DELETE FROM sentiments WHERE review_id IN (SELECT id FROM reviews1)";
    $deleteSentimentsResult = pg_query($deleteSentimentsSql);

    if ($deleteSentimentsResult) {
        // Delete all rows from reviews1 table
        $deleteReviewsSql = "DELETE FROM reviews1";
        $deleteReviewsResult = pg_query($deleteReviewsSql);

        if ($deleteReviewsResult) {
            // Commit the transaction
            pg_query("COMMIT");
            // Deletion successful
            echo 'ลบข้อมูลทั้งหมดเรียบร้อยแล้ว'; // "All data has been successfully deleted."
        } else {
            // Rollback the transaction in case of error
            pg_query("ROLLBACK");
            echo 'เกิดข้อผิดพลาดในการลบข้อมูลจาก reviews1'; // "An error occurred while deleting data from reviews1."
        }
    } else {
        // Rollback the transaction in case of error
        pg_query("ROLLBACK");
        echo 'เกิดข้อผิดพลาดในการลบข้อมูลจาก sentiments'; // "An error occurred while deleting data from sentiments."
    }

    ?>
