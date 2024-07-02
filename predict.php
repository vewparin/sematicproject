<?php
$text = "สวัสดี";
$data = array('text' => $text);
$json_data = json_encode($data);

$ch = curl_init('http://localhost:5000/predict');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($json_data))
);

$result = curl_exec($ch);

// Check for cURL errors
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}

$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Status Code: " . $http_code . "<br>";
echo "Raw result: " . $result . "<br>";

$response = json_decode($result, true);

if ($response === null && json_last_error() !== JSON_ERROR_NONE) {
    echo "JSON decode error: " . json_last_error_msg() . "<br>";
}

if (is_array($response) && isset($response['prediction'])) {
    $prediction = $response['prediction'];
    echo "ผลการทำนาย: " . $prediction;
} else {
    echo "ไม่สามารถอ่านค่า prediction ได้";
}
?>
