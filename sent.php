<?php
require 'database.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if index is set
    if (isset($_POST['index'])) {
        // Retrieve review ID from the form
        $review_id = $_POST['index'];

        // Query the review based on ID
        $query = "SELECT * FROM public.reviews1 WHERE id = $review_id";
        $result = pg_query($dbconn, $query);
        if ($result) {
            // Fetch the comment
            $row = pg_fetch_assoc($result);
            $comment = $row['comment'];

            // Call sentiment analysis API
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => "https://api.aiforthai.in.th/ssense",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => "text=" . urlencode($comment),
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded",
                    "Apikey: msRgjUVGv57iCExJT034HWVMWh0zC1g3"
                )
            ));

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                $data = json_decode($response, true);
                if (isset($data['error'])) {
                    echo "Error from API: " . $data['error'];
                } else {
                    // Determine sentiment
                    $label = $data['sentiment']['polarity'];
                    $sentiment = $data['sentiment']['score'];
                    // Extract keywords
                    $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

                    // Check if sentiment score is 0, then set label to "neutral"
                    if ($sentiment == 0) {
                        $label = "neutral";
                    }
                    // Insert sentiment data into sentiments table
                    $insert_query = "INSERT INTO public.sentiments (review_id, sentiment ,label, keywords, created_on) VALUES ($review_id, $sentiment,'$label', '$keywords', NOW())";
                    $insert_result = pg_query($dbconn, $insert_query);
                    if (!$insert_result) {
                        echo "Error inserting sentiment data for review id $review_id: " . pg_last_error($dbconn);
                    } else {
                        // Redirect back to the original page with a success message
                        header('Location: sentiment.php?success=true');
                        exit();
                    }
                }
            }
        } else {
            echo "Error executing query: " . pg_last_error($dbconn);
        }
    }
}
