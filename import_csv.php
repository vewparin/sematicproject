<?php
// include 'database.php';

// // Check if file is uploaded
// if (isset($_FILES["file"])) {
//   $filename = $_FILES["file"]["name"];
//   $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Get file extension in lowercase

//   // Check if the file is a CSV
//   if ($ext == "csv") {
//     // Open the file
//     $file = fopen($_FILES["file"]["tmp_name"], "r");

//     if ($file !== FALSE) {
//       // Loop through each row of the CSV file
//       while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
//         // Extract data from the CSV row
//         $review_entity_type_id = trim($emapData[0], "\u{FEFF}"); // Remove BOM
//         $comment = pg_escape_string($emapData[1]);
//         $created_on = pg_escape_string($emapData[2]);

//         // Check if review_entity_type_id exists
//         $check_id_sql = "SELECT * FROM review_entity_types WHERE id = '$review_entity_type_id'";
//         $check_result = pg_query($check_id_sql);

//         if ($check_result) { // Ensure valid result
//           if (pg_num_rows($check_result) > 0) {
//             // Insert if ID exists
//             $sql = "INSERT INTO reviews1 (review_entity_type_id, comment, created_on) VALUES ('$review_entity_type_id', '$comment', '$created_on')";
//             $result = pg_query($sql);

//             if (!$result) {
//               // Handle query failure
//               die('Query failed: ' . pg_last_error());
//             }
//           } else {
//             // Handle non-existent ID (e.g., log error, skip row)
//             echo "Error: review_entity_type_id $review_entity_type_id does not exist.";
//           }
//         } else {
//           // Handle error in the check query (optional logging)
//           echo "Error: An error occurred while checking the ID.";
//         }
//       }
//       fclose($file);

//       // Redirect after successful upload
//       header("Location: http://localhost/websematic/reviews.php");
//       exit(); // Stop further execution
//     } else {
//       echo "Error: Failed to open file.";
//     }
//   } else {
//     echo "Error: Please upload only CSV files.";
//   }
// } else {
//   echo "Error: No file uploaded.";
// }
//=======================================================================================================================
// include 'database.php';

// // Check if file is uploaded
// if (isset($_FILES["file"])) {
//   $filename = $_FILES["file"]["name"];
//   $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Get file extension in lowercase

//   // Check if the file is a CSV
//   if ($ext == "csv") {
//     // Open the file
//     $file = fopen($_FILES["file"]["tmp_name"], "r");

//     if ($file !== FALSE) {
//       // Loop through each row of the CSV file
//       while (($emapData = fgetcsv($file, 10000, ",")) !== FALSE) {
//         // Extract data from the CSV row
//         $comment = pg_escape_string($emapData[1]); // Use the second column for the comment
//         $created_on = date('Y-m-d H:i:s', strtotime($emapData[2])); // Convert to timestamp with time zone format
//         $review_entity_type_id = 1; // Set a default value for review_entity_type_id

//         // Insert data into reviews1 table
//         $sql = "INSERT INTO reviews1 (review_entity_type_id, comment, created_on) VALUES ('$review_entity_type_id', '$comment', '$created_on')";
//         $result = pg_query($sql);

//         if (!$result) {
//           // Handle query failure
//           die('Query failed: ' . pg_last_error());
//         }
//       }
//       fclose($file);

//       // Redirect after successful upload
//       header("Location: http://localhost/websematic/reviews.php");
//       exit(); // Stop further execution
//     } else {
//       echo "Error: Failed to open file.";
//     }
//   } else {
//     echo "Error: Please upload only CSV files.";
//   }
// } else {
//   echo "Error: No file uploaded.";
// }

include 'database.php';

// Check if file is uploaded
if (isset($_FILES["file"])) {
  $filename = $_FILES["file"]["name"];
  $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION)); // Get file extension in lowercase

  // Check if the file is a CSV
  if ($ext == "csv") {
    // Open the file
    $file = fopen($_FILES["file"]["tmp_name"], "r");

    if ($file !== FALSE) {
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
