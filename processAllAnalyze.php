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

//==========================================================================================================

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
//         $processingTime = ($endTime - $startTime) / 60; // คำนวณเวลาที่ใช้ในการประมวลผล
//         $formattedTime = number_format($processingTime, 2); // จัดรูปแบบเวลาให้แสดงทศนิยมสองตำแหน่ง

//         // ส่งเวลาที่ใช้ในการประมวลผลกลับไปยัง JavaScript
//         echo json_encode(array("processing_time" => $formattedTime));
//         exit();
//     }
// }
//===========================================================



//ดีแต่นานหน่อย====================================================================================
require 'database.php';

function analyze_sentiment($comment, $apiKey)
{
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
            "Apikey: $apiKey"
        )
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

    if ($err) {
        error_log("cURL error: " . $err);
        return false;
    } else {
        return json_decode($response, true);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['reviewIds'])) {
        $reviewIds = $_POST['reviewIds'];
        $apiKey = 'msRgjUVGv57iCExJT034HWVMWh0zC1g3';
        $mh = curl_multi_init();
        $curlHandles = [];
        $batchSize = 5;
        $startTime = microtime(true);

        foreach (array_chunk($reviewIds, $batchSize) as $batch) {
            foreach ($batch as $reviewId) {
                $query = "SELECT * FROM public.reviews1 WHERE id = $reviewId";
                $result = pg_query($dbconn, $query);
                if (!$result) {
                    error_log("Query error for review ID $reviewId: " . pg_last_error($dbconn));
                    continue;
                }

                $row = pg_fetch_assoc($result);
                if (!$row) {
                    error_log("No data found for review ID $reviewId");
                    continue;
                }

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
                        "Apikey: $apiKey"
                    )
                ));

                curl_multi_add_handle($mh, $curl);
                $curlHandles[$reviewId] = $curl;
            }

            $running = null;
            do {
                $status = curl_multi_exec($mh, $running);
                if ($status > 0) {
                    error_log("cURL multi read error: " . curl_multi_strerror($status));
                }
                curl_multi_select($mh);
            } while ($running > 0);

            foreach ($curlHandles as $reviewId => $curl) {
                $response = curl_multi_getcontent($curl);
                curl_multi_remove_handle($mh, $curl);

                $data = json_decode($response, true);
                if (isset($data['error'])) {
                    error_log("API error for review ID $reviewId: " . $data['error']);
                } else {
                    $sentiment = isset($data['sentiment']['score']) ? $data['sentiment']['score'] : '';
                    $label = isset($data['sentiment']['polarity']) ? $data['sentiment']['polarity'] : '';
                    $keywords = isset($data['preprocess']['keyword']) ? implode(',', $data['preprocess']['keyword']) : '';

                    if ($sentiment == 0) {
                        $label = "neutral";
                    }

                    $insert_query = "INSERT INTO public.sentiments (review_id, sentiment, label, keywords, created_on) VALUES ($1, $2, $3, $4, NOW())";
                    $params = array($reviewId, $sentiment, $label, $keywords);
                    $insert_result = pg_query_params($dbconn, $insert_query, $params);

                    if (!$insert_result) {
                        error_log("Insert error for review ID $reviewId: " . pg_last_error($dbconn));
                    }
                }
            }

            $curlHandles = [];
            usleep(1000000); // 1 second
        }

        curl_multi_close($mh);

        $endTime = microtime(true);
        $processingTime = ($endTime - $startTime) / 60;
        $formattedTime = number_format($processingTime, 2);

        echo json_encode(array("processing_time" => $formattedTime));
        exit();
    }
}
