<?php

// require 'database.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['reviewIds'])) {
//         $reviewIds = $_POST['reviewIds'];

//         foreach ($reviewIds as $reviewId) {
//             $query = "SELECT * FROM public.reviews1 WHERE id = $reviewId";
//             $result = pg_query($dbconn, $query);
//             if ($result) {
//                 $row = pg_fetch_assoc($result);
//                 $comment = $row['comment'];

//                 // Call sentiment analysis API
//                 $curl = curl_init();
//                 curl_setopt_array($curl, array(
//                     CURLOPT_URL => "https://api.aiforthai.in.th/ssense",
//                     CURLOPT_RETURNTRANSFER => true,
//                     CURLOPT_ENCODING => "",
//                     CURLOPT_MAXREDIRS => 10,
//                     CURLOPT_TIMEOUT => 30,
//                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                     CURLOPT_CUSTOMREQUEST => "POST",
//                     CURLOPT_POSTFIELDS => "text=" . urlencode($comment),
//                     CURLOPT_HTTPHEADER => array(
//                         "Content-Type: application/x-www-form-urlencoded",
//                         "Apikey: msRgjUVGv57iCExJT034HWVMWh0zC1g3"
//                     )
//                 ));

//                 $response = curl_exec($curl);
//                 $err = curl_error($curl);
//                 curl_close($curl);

//                 if ($err) {
//                     // Handle error
//                 } else {
//                     $data = json_decode($response, true);
//                     if (isset($data['error'])) {
//                         // Handle API error
//                     } else {
//                         $sentiment = isset($data['sentiment']['score']) ? $data['sentiment']['score'] : '';
//                         $label = isset($data['sentiment']['polarity']) ? $data['sentiment']['polarity'] : '';
//                         $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

//                         if ($sentiment == 0) {
//                             $label = "neutral";
//                         }
//                         $insert_query = "INSERT INTO public.sentiments (review_id, sentiment, label, keywords, created_on) VALUES ($reviewId, '$sentiment', '$label', '$keywords', NOW())";
//                         $insert_result = pg_query($dbconn, $insert_query);
//                         if (!$insert_result) {
//                             // Handle insert error
//                         }
//                     }
//                 }
//             } else {
//                 // Handle query error
//             }
//         }
//         // Redirect to sentiment.php after processing
//         header("Location: sentiment.php");
//         exit();
//     }
// }


//===================================================================================================

// require 'database.php';

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     if (isset($_POST['reviewIds'])) {
//         $reviewIds = $_POST['reviewIds'];

//         $startTime = microtime(true); // เริ่มจับเวลา

//         foreach ($reviewIds as $reviewId) {
//             $query = "SELECT * FROM public.reviews1 WHERE id = $reviewId";
//             $result = pg_query($dbconn, $query);
//             if ($result) {
//                 $row = pg_fetch_assoc($result);
//                 $comment = $row['comment'];

//                 // Call sentiment analysis API
//                 $curl = curl_init();
//                 curl_setopt_array($curl, array(
//                     CURLOPT_URL => "https://api.aiforthai.in.th/ssense",
//                     CURLOPT_RETURNTRANSFER => true,
//                     CURLOPT_ENCODING => "",
//                     CURLOPT_MAXREDIRS => 10,
//                     CURLOPT_TIMEOUT => 30,
//                     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//                     CURLOPT_CUSTOMREQUEST => "POST",
//                     CURLOPT_POSTFIELDS => "text=" . urlencode($comment),
//                     CURLOPT_HTTPHEADER => array(
//                         "Content-Type: application/x-www-form-urlencoded",
//                         "Apikey: msRgjUVGv57iCExJT034HWVMWh0zC1g3"
//                     )
//                 ));

//                 $response = curl_exec($curl);
//                 $err = curl_error($curl);
//                 curl_close($curl);

//                 if ($err) {
//                     // Handle error
//                 } else {
//                     $data = json_decode($response, true);
//                     if (isset($data['error'])) {
//                         // Handle API error
//                     } else {
//                         $sentiment = isset($data['sentiment']['score']) ? $data['sentiment']['score'] : '';
//                         $label = isset($data['sentiment']['polarity']) ? $data['sentiment']['polarity'] : '';
//                         $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

//                         if ($sentiment == 0) {
//                             $label = "neutral";
//                         }
//                         $insert_query = "INSERT INTO public.sentiments (review_id, sentiment, label, keywords, created_on) VALUES ($reviewId, '$sentiment', '$label', '$keywords', NOW())";
//                         $insert_result = pg_query($dbconn, $insert_query);
//                         if (!$insert_result) {
//                             // Handle insert error
//                         }
//                     }
//                 }
//             } else {
//                 // Handle query error
//             }
//         }

//         $endTime = microtime(true); // จับเวลาสิ้นสุด
//         $processingTime = $endTime - $startTime; // คำนวณเวลาที่ใช้ในการประมวลผล
//         $formattedTime = number_format($processingTime, 2); // จัดรูปแบบเวลาให้แสดงทศนิยมสองตำแหน่ง

//         // ส่งเวลาที่ใช้ในการประมวลผลกลับไปยัง JavaScript
//         echo json_encode(array("processing_time" => $formattedTime));
//         exit();
//     }
// }

require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reviewIds'])) {
        $reviewIds = $_POST['reviewIds'];

        $startTime = microtime(true); // เริ่มจับเวลา

        foreach ($reviewIds as $reviewId) {
            $query = "SELECT * FROM public.reviews1 WHERE id = $reviewId";
            $result = pg_query($dbconn, $query);
            if ($result) {
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
                    // Handle error
                } else {
                    $data = json_decode($response, true);
                    if (isset($data['error'])) {
                        // Handle API error
                    } else {
                        $sentiment = isset($data['sentiment']['score']) ? $data['sentiment']['score'] : '';
                        $label = isset($data['sentiment']['polarity']) ? $data['sentiment']['polarity'] : '';
                        $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

                        if ($sentiment == 0) {
                            $label = "neutral";
                        }
                        $insert_query = "INSERT INTO public.sentiments (review_id, sentiment, label, keywords, created_on) VALUES ($reviewId, '$sentiment', '$label', '$keywords', NOW())";
                        $insert_result = pg_query($dbconn, $insert_query);
                        if (!$insert_result) {
                            // Handle insert error
                        }
                    }
                }
            } else {
                // Handle query error
            }
        }

        $endTime = microtime(true); // จับเวลาสิ้นสุด
        $processingTime = ($endTime - $startTime) / 60; // คำนวณเวลาที่ใช้ในการประมวลผล
        $formattedTime = number_format($processingTime, 2); // จัดรูปแบบเวลาให้แสดงทศนิยมสองตำแหน่ง

        // ส่งเวลาที่ใช้ในการประมวลผลกลับไปยัง JavaScript
        echo json_encode(array("processing_time" => $formattedTime));
        exit();
    }
}
