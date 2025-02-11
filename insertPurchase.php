<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
require 'vendor/autoload.php'; // Make sure to include the PHPMailer and Stripe libraries

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Stripe\StripeClient;

function sendConfirmationEmail($email, $name, $id_books, $last_id, $price, $date) {
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
        $mail->Subject = 'Confirmación de Compra';
        $mail->Body    = "Estimado/a $name,<br><br>¡Gracias por tu compra!<br><br>ID del Libro: $id_books<br>ID de la Compra: $last_id<br>Precio: $$price<br>Fecha: $date<br><br>Saludos cordiales,<br>Silvia Mercado";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id_books = isset($input['id_books']) ? intval($input['id_books']) : 0;
    $name = isset($input['name']) ? $input['name'] : '';
    $email = isset($input['email']) ? $input['email'] : '';
    $price = isset($input['price']) ? floatval($input['price']) : 0.0;
    $payment_type = isset($input['payment_type']) ? $input['payment_type'] : '';
    $token = isset($input['token']) ? $input['token'] : '';
    $date = date('Y-m-d H:i:s'); // Get the current date and time

    if ($id_books > 0 && !empty($name) && !empty($email) && $price > 0 && !empty($payment_type) && !empty($token)) {
        $stripe = new StripeClient("sk_test_51NO85CLKzoJjDTKGSoppGywMhLVRTqZncs5D4NQviIID27G6MuiXU2LSACuQMpBxBINXKLIdvF2S13KhuY69AESa00NP0P8K7P");

        try {
            if ($payment_type === 'stripe') {
                $charge = $stripe->charges->create([
                    'amount' => $price * 100,
                    'currency' => 'mxn',
                    'source' => $token,
                    'metadata' => [
                        'name' => $name,
                        'email' => $email
                    ]
                ]);
                $stripe_id = $charge["id"];
            } else {
                $stripe_id = $token;
            }

            $sql = "
                INSERT INTO book_purchases (id_books, name, email, price, stripe_id, date)
                VALUES (?, ?, ?, ?, ?, ?)
            ";

            $stmt = $conn->prepare($sql);
            $stmt->bind_param("issdss", $id_books, $name, $email, $price, $stripe_id, $date);
            if ($stmt->execute()) {
                $last_id = $conn->insert_id; // Get the last inserted ID

                if (sendConfirmationEmail($email, $name, $id_books, $last_id, $price, $date)) {
                    echo json_encode(true);
                } else {
                    echo json_encode(true);
                }
            } else {
                echo json_encode(false);
            }

            $stmt->close();
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