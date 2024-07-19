<?php
// session_start();
// require_once './vendor/autoload.php';

// // โหลดตัวแปรสภาพแวดล้อมจากไฟล์ .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// $client = new Google_Client();
// $client->setAuthConfig($_ENV['GOOGLE_CLIENT_SECRET_JSON']);
// $client->setRedirectUri('http://localhost/websematic/google-login.php'); // กำหนด URI สำหรับการ Redirect กลับหลังจากล็อกอินเสร็จสิ้น
// $client->addScope('email');
// $client->addScope('profile');

// if (isset($_GET['code'])) {
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
//     $client->setAccessToken($token['access_token']);

//     $oauth = new Google_Service_Oauth2($client);
//     $userInfo = $oauth->userinfo->get();

//     $_SESSION['user_id'] = $userInfo->id;
//     $_SESSION['user_name'] = $userInfo->name;

//     header('Location: index.php');
//     exit();
// } else {
//     $authUrl = $client->createAuthUrl();
//     header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
// }

// session_start();
// require_once './vendor/autoload.php';

// // โหลดตัวแปรสภาพแวดล้อมจากไฟล์ .env
// $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

// // ตรวจสอบว่าตัวแปรสภาพแวดล้อมถูกตั้งค่าหรือไม่
// if (!isset($_ENV['GOOGLE_CLIENT_SECRET_JSON'])) {
//     die('GOOGLE_CLIENT_SECRET_JSON is not set in the .env file');
// }


// $client = new Google_Client();
// $client->setAuthConfig($_ENV['GOOGLE_CLIENT_SECRET_JSON']);
// $client->setRedirectUri('http://localhost/websematic/google-login.php'); // กำหนด URI สำหรับการ Redirect กลับหลังจากล็อกอินเสร็จสิ้น
// $client->addScope('email');
// $client->addScope('profile');

// if (isset($_GET['code'])) {
//     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

//     // ตรวจสอบข้อผิดพลาดการรับ token
//     if (isset($token['error'])) {
//         die('Error fetching access token: ' . htmlspecialchars($token['error']));
//     }

//     $client->setAccessToken($token['access_token']);

//     $oauth = new Google_Service_Oauth2($client);
//     $userInfo = $oauth->userinfo->get();

//     $_SESSION['user_id'] = $userInfo->id;
//     $_SESSION['user_name'] = $userInfo->name;

//     header('Location: index.php');
//     exit();
// } else {
//     $authUrl = $client->createAuthUrl();
//     header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
// }

session_start();
require_once './vendor/autoload.php';
require_once 'database.php'; // เรียกใช้ไฟล์ database.php

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

if (!isset($_ENV['GOOGLE_CLIENT_SECRET_JSON'])) {
    die('GOOGLE_CLIENT_SECRET_JSON is not set in the .env file');
}

$client = new Google_Client();
$client->setAuthConfig($_ENV['GOOGLE_CLIENT_SECRET_JSON']);
$client->setRedirectUri('http://localhost/websematic/google-login.php');
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (isset($token['error'])) {
        die('Error fetching access token: ' . htmlspecialchars($token['error']));
    }

    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();

    $_SESSION['user_id'] = $userInfo->id;
    $_SESSION['user_name'] = $userInfo->name;

    // ตรวจสอบและบันทึกข้อมูลผู้ใช้ในฐานข้อมูล
    if ($dbconn) {
        $result = pg_query_params($dbconn, 'SELECT id FROM users WHERE oauth_provider = $1 AND oauth_uid = $2', array('google', $userInfo->id));
        if (!$result) {
            die('Query failed: ' . pg_last_error());
        }

        $user = pg_fetch_assoc($result);

        if (!$user) {
            $result = pg_query_params($dbconn, 'INSERT INTO users (oauth_provider, oauth_uid, first_name, last_name, email, picture, created) VALUES ($1, $2, $3, $4, $5, $6, NOW())', array(
                'google',
                $userInfo->id,
                $userInfo->givenName,
                $userInfo->familyName,
                $userInfo->email,
                $userInfo->picture
            ));

            if (!$result) {
                die('Insert failed: ' . pg_last_error());
            }
        }

        header('Location: src\php\index.php');
        exit();
    } else {
        die('Database connection failed.');
    }
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
