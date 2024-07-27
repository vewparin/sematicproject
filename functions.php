<?php
require './vendor/autoload.php';
include 'database.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function getSentimentCounts()
{
    $sentimentCounts = [
        'positive' => 0,
        'neutral' => 0,
        'negative' => 0
    ];

    $query = 'SELECT label FROM sentiments';
    $result = pg_query($query);

    if ($result === false) {
        die('Error in query: ' . pg_last_error());
    }

    $totalCount = 0;
    while ($row = pg_fetch_assoc($result)) {
        switch (strtolower($row['label'])) {
            case 'positive':
                $sentimentCounts['positive']++;
                break;
            case 'neutral':
                $sentimentCounts['neutral']++;
                break;
            case 'negative':
                $sentimentCounts['negative']++;
                break;
        }
        $totalCount++;
    }
    pg_free_result($result);

    $data = [
        'positive' => $totalCount ? round(($sentimentCounts['positive'] / $totalCount) * 100, 2) : 0,
        'neutral' => $totalCount ? round(($sentimentCounts['neutral'] / $totalCount) * 100, 2) : 0,
        'negative' => $totalCount ? round(($sentimentCounts['negative'] / $totalCount) * 100, 2) : 0,
    ];

    return ['counts' => $sentimentCounts, 'data' => $data];
}


function fetchCommentsBySentiment($sentiment)
{
    include 'database.php';
    $sentiment = pg_escape_string($sentiment);
    $query = "SELECT comment FROM reviews1 
              JOIN sentiments ON reviews1.id = sentiments.review_id 
              WHERE sentiments.label = '$sentiment'";
    $result = pg_query($query);

    if ($result === false) {
        die('Error in query: ' . pg_last_error());
    }

    $comments = [];
    while ($row = pg_fetch_assoc($result)) {
        $comments[] = htmlspecialchars($row['comment'], ENT_QUOTES, 'UTF-8');
    }
    pg_free_result($result);
    return $comments;
}

function downloadExcelReport($sentimentCounts, $data)
{
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'Sentiment Analysis Report');
    $sheet->setCellValue('A3', 'Sentiment');
    $sheet->setCellValue('B3', 'Count');
    $sheet->setCellValue('C3', 'Percentage');

    $sheet->setCellValue('A4', 'Positive');
    $sheet->setCellValue('B4', $sentimentCounts['positive']);
    $sheet->setCellValue('C4', $data['positive'] . '%');

    $sheet->setCellValue('A5', 'Neutral');
    $sheet->setCellValue('B5', $sentimentCounts['neutral']);
    $sheet->setCellValue('C5', $data['neutral'] . '%');

    $sheet->setCellValue('A6', 'Negative');
    $sheet->setCellValue('B6', $sentimentCounts['negative']);
    $sheet->setCellValue('C6', $data['negative'] . '%');

    $filename = 'sentiment_analysis_report.xlsx';

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');
    exit();
}

//หน้า analyzebytrain.php
function deleteAllAnalyzedComments()
{
    include 'database.php';
    $query = "DELETE FROM analyzed_comments";

    if (pg_query($query)) {
        return 'ลบข้อมูลทั้งหมดเรียบร้อยแล้ว';
    } else {
        return 'เกิดข้อผิดพลาดในการลบข้อมูล';
    }
}

// Check if this file is accessed via an AJAX request to call the delete function
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_all') {
    session_start();

    if (!isset($_SESSION['user_id'])) {
        echo 'ผู้ใช้ไม่ได้ล็อกอิน';
        exit();
    }

    $response = deleteAllAnalyzedComments();
    echo $response;
    exit();
}
//==================================================================================
