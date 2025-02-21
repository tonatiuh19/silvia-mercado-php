<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $value = isset($input['value']) ? $input['value'] : '';
    $current_date = date('Y-m-d'); // Get the current date

    if (!empty($value)) {
        // Validate the coupon
        $sql = "SELECT id_books_coupons, discount FROM books_coupons WHERE value = ? AND expiration_date >= ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $value, $current_date);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $coupon = $result->fetch_assoc();
            $coupon = array_map('utf8_encode', $coupon);
            $res = json_encode($coupon, JSON_NUMERIC_CHECK);
            header('Content-type: application/json; charset=utf-8');
            echo $res;
        } else {
            echo json_encode(false);
        }
        $stmt->close();
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}

$conn->close();
?>