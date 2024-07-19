<?php
// include 'database.php';

// // Check if ID parameter is set
// if (isset($_POST["id"])) {
//     $id = $_POST["id"];
    
//     // Delete the row with the specified ID
//     $sql = "DELETE FROM reviews1 WHERE id = $id";
//     $result = pg_query($sql);
    
//     if ($result) {
//         // Redirect back to the reviews page after deletion
//         header("Location: reviews.php");
//         exit();
//     } else {
//         echo "Error: Failed to delete record.";
//     }
// } else {
//     echo "Error: No ID specified.";
// }

include 'database.php';

// Check if ID parameter is set
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    
    // Start a transaction
    pg_query("BEGIN");

    // Delete related rows in sentiments table
    $deleteSentiments = "DELETE FROM sentiments WHERE review_id = $id";
    $resultSentiments = pg_query($deleteSentiments);

    if ($resultSentiments) {
        // Delete the row with the specified ID in reviews1 table
        $deleteReview = "DELETE FROM reviews1 WHERE id = $id";
        $resultReview = pg_query($deleteReview);
        
        if ($resultReview) {
            // Commit transaction
            pg_query("COMMIT");
            // Redirect back to the reviews page after deletion
            header("Location: reviews.php");
            exit();
        } else {
            // Rollback transaction
            pg_query("ROLLBACK");
            echo "Error: Failed to delete record from reviews1.";
        }
    } else {
        // Rollback transaction
        pg_query("ROLLBACK");
        echo "Error: Failed to delete related records from sentiments.";
    }
} else {
    echo "Error: No ID specified.";
}
?>
