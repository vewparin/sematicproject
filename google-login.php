<?php
session_start();
require_once './vendor/autoload.php';

$client = new Google_Client();
$client->setAuthConfig('C:\xampp\htdocs\websematic\goo\client_secret_209282203185-1p8fjshiaf3lpd88vf47qj1cve9jk6vh.apps.googleusercontent.com.json'); // เปลี่ยนเป็นที่อยู่ของไฟล์ JSON ของคุณ
$client->setRedirectUri('http://localhost/websematic/google-login.php'); // กำหนด URI สำหรับการ Redirect กลับหลังจากล็อกอินเสร็จสิ้น
$client->addScope('email');
$client->addScope('profile');

if (isset($_GET['code'])) {
    $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    $client->setAccessToken($token['access_token']);

    $oauth = new Google_Service_Oauth2($client);
    $userInfo = $oauth->userinfo->get();
    
    $_SESSION['user_id'] = $userInfo->id;
    $_SESSION['user_name'] = $userInfo->name;

    header('Location: index.php');
    exit();
} else {
    $authUrl = $client->createAuthUrl();
    header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
}
?>