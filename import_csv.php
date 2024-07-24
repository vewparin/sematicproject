<?php

//เพิ่มการเก็บ log ของผู้ใช้ที่ login เข้ามา  
session_start();
include 'database.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('User is not logged in.');
}

// Get the user's database id using their oauth_uid
$oauth_uid = $_SESSION['user_id'];
$userQuery = pg_query_params($dbconn, "SELECT id FROM users WHERE oauth_uid = $1", array($oauth_uid));
if (!$userQuery) {
    die('Query failed: ' . pg_last_error());
}
$user = pg_fetch_assoc($userQuery);
if (!$user) {
    die('User not found in the database.');
}

$userId = $user['id']; // Get the database id

// Check if file is uploaded
if (isset($_FILES["file"])) {
    $filename = $_FILES["file"]["name"];
    $_SESSION['uploaded_file_name'] = $filename;
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Get file extension in lowercase

    // Check if the file is a CSV
    if ($ext == "csv") {
        // Open the file
        $file = fopen($_FILES["file"]["tmp_name"], "r");

        if ($file !== FALSE) {
            $uploadTime = date('Y-m-d H:i:s');
            
            // Insert upload record
            $insertUploadQuery = "INSERT INTO user_uploads (user_id, file_name, upload_time) VALUES ($1, $2, $3)";
            $result = pg_query_params($dbconn, $insertUploadQuery, array($userId, $filename, $uploadTime));
            
            if (!$result) {
                die('Upload insert failed: ' . pg_last_error());
            }

            // Loop through each row of the CSV file
            while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
                // Ensure array indices exist before accessing
                if (isset($emapData[1]) && isset($emapData[2])) {
                    $comment = pg_escape_string($emapData[1]);
                    $created_on = date('Y-m-d H:i:s', strtotime($emapData[2]));
                    $review_entity_type_id = 1; // Set a default value for review_entity_type_id

                    // Insert data into reviews1 table
                    $sql = "INSERT INTO reviews1 (review_entity_type_id, comment, created_on) VALUES ('$review_entity_type_id', '$comment', '$created_on')";
                    $result = pg_query($sql);

                    if (!$result) {
                        // Handle query failure
                        die('Query failed: ' . pg_last_error());
                    }
                } else {
                    echo "Error: Missing comment or created_on data in CSV row.";
                }
            }
            fclose($file);

            // Redirect after successful upload
            header("Location: http://localhost/websematic/reviews.php");
            exit(); // Stop further execution
        } else {
            echo "Error: Failed to open file.";
        }
    } else {
        echo "Error: Please upload only CSV files.";
    }
} else {
    echo "Error: No file uploaded.";
}


?>
