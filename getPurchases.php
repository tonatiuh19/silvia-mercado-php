<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $sql = "
        SELECT 
            a.id_book_purchases, 
            a.id_books, 
            a.name, 
            a.email, 
            a.price, 
            a.stripe_id, 
            a.date, 
            b.title 
        FROM book_purchases AS a
        INNER JOIN books AS b ON b.id_books = a.id_books
    ";

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $purchases = [];
        while ($row = $result->fetch_assoc()) {
            $purchases[] = array_map('utf8_encode', $row);
        }
        $res = json_encode($purchases, JSON_NUMERIC_CHECK);
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