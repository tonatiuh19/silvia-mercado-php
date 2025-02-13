<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_books_coupons = isset($input['id_books_coupons']) ? intval($input['id_books_coupons']) : 0;
    $id_books = isset($input['id_books']) ? intval($input['id_books']) : 0;
    $value = isset($input['value']) ? $input['value'] : '';
    $discount = isset($input['discount']) ? floatval($input['discount']) : 0.0;
    $active = 1;
    $expiration_date = isset($input['expiration_date']) ? $input['expiration_date'] : '';

    if ($id_books_coupons > 0 && $id_books > 0 && !empty($value) && $discount > 0 && !empty($expiration_date)) {
        // Update the coupon
        $sql = "UPDATE books_coupons SET id_books = ?, value = ?, discount = ?, active = ?, expiration_date = ? WHERE id_books_coupons = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("isdiss", $id_books, $value, $discount, $active, $expiration_date, $id_books_coupons);
        if ($stmt->execute()) {
            // Fetch all coupons
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
            echo json_encode(["message" => "Failed to update coupon"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Invalid input data"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();
?>