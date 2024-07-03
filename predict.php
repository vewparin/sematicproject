<?php
// $text = "สวัสดี";
// $data = array('text' => $text);
// $json_data = json_encode($data);

// $ch = curl_init('http://localhost:5000/predict');
// curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
// curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//     'Content-Type: application/json',
//     'Content-Length: ' . strlen($json_data))
// );

// $result = curl_exec($ch);

// // Check for cURL errors
// if(curl_errno($ch)){
//     echo 'Curl error: ' . curl_error($ch);
// }

// $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// curl_close($ch);

// echo "HTTP Status Code: " . $http_code . "<br>";
// echo "Raw result: " . $result . "<br>";

// $response = json_decode($result, true);

// if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
//     echo "JSON decode error: " . json_last_error_msg() . "<br>";
// }

// if (is_array($response) && isset($response['prediction'])) {
//     $prediction = $response['prediction'];
//     echo "ผลการทำนาย: " . $prediction;
// } else {
//     echo "ไม่สามารถอ่านค่า prediction ได้";
// }

include 'database.php';

// Fetch all comments
$query = "SELECT id, comment FROM public.reviews1";
$result = pg_query($dbconn, $query);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $review_id = $row['id'];
        $comment = $row['comment'];

        // Prepare data for API request
        $data = json_encode(array('text' => $comment));

        // Send API request
        $ch = curl_init('http://localhost:5000/predict');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($http_code == 200) {
            $response = json_decode($result, true);
            if (isset($response['prediction'])) {
                $label = $response['prediction'];

                // Insert the result into analyzed_comments
                $query_insert = "INSERT INTO public.analyzed_comments (review_id, label) VALUES ($1, $2)";
                $result_insert = pg_query_params($dbconn, $query_insert, array($review_id, $label));

                if (!$result_insert) {
                    echo "Insert failed: " . pg_last_error($dbconn);
                }
            }
        }
    }

    pg_free_result($result);
} else {
    echo "Failed to fetch comments: " . pg_last_error($dbconn);
}

header("Location: analyzebytrain.php");




?>
