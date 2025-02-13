<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
require_once './vendor/autoload.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $requestBody = file_get_contents('php://input');
    $params = json_decode($requestBody, true);

    if (isset($params['email']) && isset($params['code'])) {
        $email = $params['email'];
        $code = $params['code'];

        // Fetch the id_books_admin from platforms_users using email
        $sql = "SELECT id_books_admin FROM books_admin WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $userData = $result->fetch_assoc();
            $id_books_admin = $userData['id_books_admin'];
        } else {
            echo json_encode(false);
            $stmt->close();
            exit;
        }
        $stmt->close();

        // Fetch the session code from platforms_users_sessions
        $sql = "SELECT code FROM books_admin_sessions WHERE id_books_admin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_books_admin);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $sessionData = $result->fetch_assoc();
            $session_code = $sessionData['code'];
        } else {
            echo json_encode(false);
            $stmt->close();
            exit;
        }
        $stmt->close();

        // Validate the session code
        if ($code == $session_code) {
            // Update the session to true
            $sql = "UPDATE books_admin_sessions SET session = 1 WHERE id_books_admin = ? AND code = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_books_admin, $code);
            $stmt->execute();
            $stmt->close();

            // Fetch and return the user data along with platform info
            $sql = "SELECT a.id_books_admin, a.name, a.email FROM books_admin as a WHERE a.id_books_admin = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id_books_admin);
            $stmt->execute();
            $userData = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            echo json_encode($userData);
        } else {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}

$conn->close();
