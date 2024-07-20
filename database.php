<?php

require 'vendor/autoload.php';

use Dotenv\Dotenv;

// โหลดไฟล์ .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// รับค่าจาก .env
$dbhost = $_ENV['DB_HOST'];
$dbport = $_ENV['DB_PORT'];
$dbname = $_ENV['DB_NAME'];
$dbuser = $_ENV['DB_USER'];
$dbpassword = $_ENV['DB_PASSWORD'];

// สร้างการเชื่อมต่อฐานข้อมูล
$dbconn = pg_connect("host=$dbhost port=$dbport dbname=$dbname user=$dbuser password=$dbpassword") or die('Could not connect: ' . pg_last_error());
if (!$dbconn) {
  die('Error: Could not connect: ' . pg_last_error());
}
