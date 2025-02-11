<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $sql = "
        SELECT 
            a.id_books, 
            a.title, 
            a.price 
        FROM books AS a
    ";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $books = [];
        while ($row = $result->fetch_assoc()) {
            $books[] = array_map('utf8_encode', $row);
        }
        $res = json_encode($books, JSON_NUMERIC_CHECK);
        header('Content-type: application/json; charset=utf-8');
        echo $res;
    } else {
        echo json_encode([]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();
?>