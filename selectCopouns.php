<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $sql = "
        SELECT 
            a.id_books_coupons, 
            a.id_books, 
            a.value, 
            a.discount, 
            a.active, 
            a.expiration_date, 
            a.date 
        FROM books_coupons AS a
    ";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $coupons = [];
        while ($row = $result->fetch_assoc()) {
            $coupons[] = array_map('utf8_encode', $row);
        }
        $res = json_encode($coupons, JSON_NUMERIC_CHECK);
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