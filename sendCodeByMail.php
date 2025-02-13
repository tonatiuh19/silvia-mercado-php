<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
require 'vendor/autoload.php'; // Make sure to include the PHPMailer library

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $requestBody = file_get_contents('php://input');
    $params = json_decode($requestBody, true);

    if (isset($params['email'])) {
        $email = $params['email'];

        // Fetch id_books_admin from books_admin by email
        $sql = "SELECT id_books_admin, name, email, active FROM books_admin WHERE email = ? AND active = 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $adminData = $result->fetch_assoc();
            $id_books_admin = $adminData['id_books_admin'];
            $name = $adminData['name'];
        } else {
            echo json_encode(false);
            $stmt->close();
            exit;
        }
        $stmt->close();


        $sql = "DELETE FROM books_admin_sessions WHERE id_books_admin = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_books_admin);
        $stmt->execute();
        $stmt->close();

        // Fetch session details from books_admin_sessions by id_books_admin
        do {
            $session_code = rand(100000, 999999);
            $sql = "SELECT COUNT(*) as count FROM books_admin_sessions WHERE code = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $session_code);
            $stmt->execute();
            $result = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        } while ($result['count'] > 0);

        // Insert the new session code into platforms_users_sessions
        $date_start = date('Y-m-d H:i:s');
        $sql = "INSERT INTO books_admin_sessions (id_books_admin, code, session, date_start) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $session_active = false;
        $stmt->bind_param("iiss", $id_books_admin, $session_code, $session_active, $date_start);
        $stmt->execute();
        $stmt->close();

        // Send session details via PHPMailer
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = 0;     
            $mail->Host = 'mail.silviamercadofinanzas.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'no-reply@silviamercadofinanzas.com';
            $mail->Password = 'Mailer123';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 469;
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('no-reply@silviamercadofinanzas.com', 'Silvia Mercado');
            $mail->addAddress($email, $name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Detalles de la sesión de administración de Silvia Mercado';
            $mail->Body = "Estimado/a $name,<br><br>Aquí están los detalles de tu sesión:<br><br>Codigo de la sesión: $session_code<br>Fecha de inicio: $date_start<br><br>Saludos cordiales,<br>Silvia Mercado";

            $mail->send();
            echo json_encode(true);
        } catch (Exception $e) {
            echo json_encode(false);
        }
    } else {
        echo json_encode(false);
    }
} else {
    echo json_encode(false);
}

$conn->close();
?>