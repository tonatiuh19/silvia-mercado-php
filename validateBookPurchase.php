<?php
/*header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
require 'vendor/autoload.php'; // Incluir la biblioteca FPDI y spatie/pdf-to-image

use setasign\Fpdi\Tcpdf\Fpdi;
use Spatie\PdfToImage\Pdf;

// Aumentar el tiempo máximo de ejecución
set_time_limit(300);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $id_purchase = isset($_GET['id_purchase']) ? intval($_GET['id_purchase']) : 0;
    $email = isset($_GET['email']) ? $_GET['email'] : '';

    if ($id_purchase > 0 && !empty($email)) {
        // Validar la compra
        $sql = "SELECT id_books, name, email, price, stripe_id, date FROM book_purchases WHERE id_book_purchases = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_purchase, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $purchase = $result->fetch_assoc();

            // Generar PDF
            $pdf = new Fpdi();
            $pdf->AddPage();
            $pdf->SetFont('helvetica', '', 12);
            $pdf->Write(0, 'Confirmación de Compra', '', 0, 'C', true, 0, false, false, 0);
            $pdf->Ln(10);
            $pdf->Write(0, 'ID de Compra: ' . $id_purchase, '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(0, 'ID del Libro: ' . $purchase['id_books'], '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(0, 'Nombre: ' . $purchase['name'], '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(0, 'Correo Electrónico: ' . $purchase['email'], '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(0, 'Precio: $' . $purchase['price'], '', 0, 'L', true, 0, false, false, 0);
            $pdf->Write(0, 'Fecha: ' . $purchase['date'], '', 0, 'L', true, 0, false, false, 0);
            $pdf->Ln(10);
            $pdf->Write(0, '¡Gracias por tu compra!', '', 0, 'C', true, 0, false, false, 0);

            // Verificar si el archivo PDF existe
            $pdfFilePath = './thebook_decrypted.pdf';
            if (file_exists($pdfFilePath)) {
                // Crear el directorio temporal si no existe
                if (!is_dir('./temp')) {
                    mkdir('./temp', 0777, true);
                }

                // Convertir las páginas del PDF a imágenes
                $pdfToImage = new Pdf($pdfFilePath);
                $pageCount = $pdfToImage->getNumberOfPages();
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $imagePath = './temp/page_' . $pageNo . '.jpg';
                    $pdfToImage->setPage($pageNo)->saveImage($imagePath);
                    $pdf->AddPage();
                    $pdf->Image($imagePath, 0, 0, 210, 297); // Ajustar las dimensiones según sea necesario
                }

                // Salida del PDF
                $pdf->Output('compra_' . $id_purchase . '.pdf', 'D');

                // Eliminar las imágenes temporales
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $imagePath = './temp/page_' . $pageNo . '.jpg';
                    unlink($imagePath);
                }
            } else {
                echo json_encode(["message" => "El archivo PDF no existe"]);
            }
        } else {
            echo json_encode(["message" => "ID de compra o correo electrónico inválido"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Datos de entrada inválidos"]);
    }
} else {
    echo json_encode(["message" => "Método de solicitud inválido"]);
}

$conn->close();*/
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');

// Aumentar el tiempo máximo de ejecución
set_time_limit(300);

$method = $_SERVER['REQUEST_METHOD'];

if ($method == 'GET') {
    $id_purchase = isset($_GET['id_purchase']) ? intval($_GET['id_purchase']) : 0;
    $email = isset($_GET['email']) ? $_GET['email'] : '';

    if ($id_purchase > 0 && !empty($email)) {
        // Validar la compra
        $sql = "SELECT id_books, name, email, price, stripe_id, date FROM book_purchases WHERE id_book_purchases = ? AND email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $id_purchase, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Verificar si el archivo PDF existe
            $pdfFilePath = './FinanzasFelices_digital_2025.pdf';
            if (file_exists($pdfFilePath)) {
                // Forzar la descarga del archivo PDF
                header('Content-Type: application/pdf');
                header('Content-Disposition: attachment; filename="FinanzasFelices_digital_2025.pdf"');
                readfile($pdfFilePath);
                exit;
            } else {
                echo json_encode(["message" => "El archivo PDF no existe"]);
            }
        } else {
            echo json_encode(["message" => "ID de compra o correo electrónico inválido"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["message" => "Datos de entrada inválidos"]);
    }
} else {
    echo json_encode(["message" => "Método de solicitud inválido"]);
}

$conn->close();
?>