<?php

// $curl = curl_init();

// $text_to_analyze = "Outside it looks like a flower from a bouquet. But when u open it u get a surprise gift from ur beloved ones. Interesting product. There wasnt any default in the product. Good one";

// curl_setopt_array($curl, array(
//   CURLOPT_URL => "https://api.aiforthai.in.th/ssense",
//   CURLOPT_RETURNTRANSFER => true,
//   CURLOPT_ENCODING => "",
//   CURLOPT_MAXREDIRS => 10,
//   CURLOPT_TIMEOUT => 30,
//   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//   CURLOPT_CUSTOMREQUEST => "POST",
//   CURLOPT_POSTFIELDS => "text=" . urlencode($text_to_analyze),
//   CURLOPT_HTTPHEADER => array(
//     "Content-Type: application/x-www-form-urlencoded",
//     "Apikey: msRgjUVGv57iCExJT034HWVMWh0zC1g3" // เปลี่ยน YOUR_API_KEY_HERE เป็น API key ของคุณ
//   )
// ));

// $response = curl_exec($curl);
// $err = curl_error($curl);

// curl_close($curl);

// if ($err) {
//   echo "cURL Error #:" . $err;
// } else {
//   $data = json_decode($response, true); // แปลง JSON เป็น array
//   $polarity = $data['sentiment']['polarity']; // เลือกค่า polarity จาก array

//   echo "Polarity: $polarity"; // แสดงค่า polarity ออกทางหน้าจอ
// }
require 'database.php';

$query = "SELECT id, comment FROM public.reviews1";
$result = pg_query($dbconn, $query);

if ($result) {
    while ($row = pg_fetch_assoc($result)) {
        $review_id = $row['id'];
        $comment = $row['comment'];

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
                continue; // Skip to the next iteration of the loop
            }

            
            $sentiment = $data['sentiment']['score'];
            $label = $data['sentiment']['polarity'];

            $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

            // Insert sentiment data into the new 'sentiments_new' table
            $insert_query = "INSERT INTO public.sentiments_new (review_id, sentiment, label, keywords) 
                           VALUES ($review_id, '$sentiment', '$label', '$keywords')";
            $insert_result = pg_query($dbconn, $insert_query);
            if (!$insert_result) {
                echo "Error inserting sentiment data for review id $review_id: " . pg_last_error($dbconn);
            } else {
                echo "Sentiment analysis successful for review id $review_id: Sentiment - $sentiment <br> " ;
            }
        }
    }
} else {
    echo "Error executing query: " . pg_last_error($dbconn);
}

