<?php
include 'database.php';

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $query = "DELETE FROM sentiments WHERE id = $1";
    $result = pg_query_params($dbconn, $query, array($id));

    if ($result) {
        echo json_encode(array('status' => 'success'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => pg_last_error()));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'No ID provided.'));
}
?>
