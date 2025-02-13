<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_books = isset($input['id_books']) ? intval($input['id_books']) : 0;
    $new_price = isset($input['price']) ? floatval($input['price']) : 0.0;

    if ($id_books > 0 && $new_price > 0) {
        // Update the price of the book
        $sql = "UPDATE books SET price = ? WHERE id_books = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $new_price, $id_books);
        if ($stmt->execute()) {
            // Fetch the updated book details
            $sql = "
                SELECT 
                    a.id_books, 
                    a.title, 
                    a.price 
                FROM books AS a
                WHERE a.id_books = ?
            ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_books);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $book = $result->fetch_assoc();
                $book = array_map('utf8_encode', $book);
                $res = json_encode($book, JSON_NUMERIC_CHECK);
                header('Content-type: application/json; charset=utf-8');
                echo $res;
            } else {
                echo json_encode(["message" => "Book not found"]);
            }
        } else {
            echo json_encode(["message" => "Failed to update book price"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Invalid book ID or price"]);
    }
} else {
    echo json_encode(["message" => "Invalid request method"]);
}

$conn->close();
?>