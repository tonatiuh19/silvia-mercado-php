<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
require_once('db_cnn/cnn.php');
require 'vendor/autoload.php'; // Make sure to include the PHPMailer and Stripe libraries

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Stripe\StripeClient;
use Stripe\Exception\CardException;
use Stripe\Exception\ApiErrorException;

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
        $mail->Subject = 'Confirmación de compra: ¡Tu guía hacia unas finanzas felices está en camino!';
        //$mail->Body    = "Estimado/a $name,<br><br>¡Gracias por tu compra!<br><br>ID del Libro: $id_books<br>ID de la Compra: $last_id<br>Precio: $$price<br>Fecha: $date<br><br>Saludos cordiales,<br>Silvia Mercado";
        $mail->Body    = '<!DOCTYPE html>

        <html
          lang="en"
          xmlns:o="urn:schemas-microsoft-com:office:office"
          xmlns:v="urn:schemas-microsoft-com:vml"
        >
          <head>
            <title></title>
            <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
            <meta content="width=device-width, initial-scale=1.0" name="viewport" />
            <style>
              * {
                box-sizing: border-box;
              }
        
              body {
                margin: 0;
                padding: 0;
              }
        
              a[x-apple-data-detectors] {
                color: inherit !important;
                text-decoration: inherit !important;
              }
        
              #MessageViewBody a {
                color: inherit;
                text-decoration: none;
              }
        
              p {
                line-height: inherit;
              }
        
              .desktop_hide,
              .desktop_hide table {
                mso-hide: all;
                display: none;
                max-height: 0px;
                overflow: hidden;
              }
        
              .image_block img + div {
                display: none;
              }
        
              sup,
              sub {
                font-size: 75%;
                line-height: 0;
              }
        
              #converted-body .list_block ul,
              #converted-body .list_block ol,
              .body [class~="x_list_block"] ul,
              .body [class~="x_list_block"] ol,
              u + .body .list_block ul,
              u + .body .list_block ol {
                padding-left: 20px;
              }
        
              @media (max-width: 700px) {
                .desktop_hide table.icons-inner,
                .social_block.desktop_hide .social-table {
                  display: inline-block !important;
                }
        
                .icons-inner {
                  text-align: center;
                }
        
                .icons-inner td {
                  margin: 0 auto;
                }
        
                .mobile_hide {
                  display: none;
                }
        
                .row-content {
                  width: 100% !important;
                }
        
                .stack .column {
                  width: 100%;
                  display: block;
                }
        
                .mobile_hide {
                  min-height: 0;
                  max-height: 0;
                  max-width: 0;
                  overflow: hidden;
                  font-size: 0px;
                }
        
                .desktop_hide,
                .desktop_hide table {
                  display: table !important;
                  max-height: none !important;
                }
              }
            </style>
            <!--[if mso
              ]><style>
                sup,
                sub {
                  font-size: 100% !important;
                }
                sup {
                  mso-text-raise: 10%;
                }
                sub {
                  mso-text-raise: -10%;
                }
              </style>
            <![endif]-->
          </head>
          <body
            class="body"
            style="
              background-color: #ffffff;
              margin: 0;
              padding: 0;
              -webkit-text-size-adjust: none;
              text-size-adjust: none;
            "
          >
            <table
              border="0"
              cellpadding="0"
              cellspacing="0"
              class="nl-container"
              role="presentation"
              style="
                mso-table-lspace: 0pt;
                mso-table-rspace: 0pt;
                background-color: #ffffff;
              "
              width="100%"
            >
              <tbody>
                <tr>
                  <td>
                    <table
                      align="center"
                      border="0"
                      cellpadding="0"
                      cellspacing="0"
                      class="row row-1"
                      role="presentation"
                      style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #000000;
                      "
                      width="100%"
                    >
                      <tbody>
                        <tr>
                          <td>
                            <table
                              align="center"
                              border="0"
                              cellpadding="0"
                              cellspacing="0"
                              class="row-content stack"
                              role="presentation"
                              style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                color: #000000;
                                width: 680px;
                                margin: 0 auto;
                              "
                              width="680"
                            >
                              <tbody>
                                <tr>
                                  <td
                                    class="column column-1"
                                    style="
                                      mso-table-lspace: 0pt;
                                      mso-table-rspace: 0pt;
                                      font-weight: 400;
                                      text-align: left;
                                      padding-top: 5px;
                                      vertical-align: top;
                                      border-top: 0px;
                                      border-right: 0px;
                                      border-bottom: 0px;
                                      border-left: 0px;
                                    "
                                    width="100%"
                                  >
                                    <div
                                      class="spacer_block block-1"
                                      style="
                                        height: 70px;
                                        line-height: 70px;
                                        font-size: 1px;
                                      "
                                    >
                                       
                                    </div>
                                    <div
                                      class="spacer_block block-2"
                                      style="
                                        height: 20px;
                                        line-height: 20px;
                                        font-size: 1px;
                                      "
                                    >
                                       
                                    </div>
                                    <table
                                      border="0"
                                      cellpadding="0"
                                      cellspacing="0"
                                      class="heading_block block-3"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td
                                          class="pad"
                                          style="text-align: center; width: 100%"
                                        >
                                          <h1
                                            style="
                                              margin: 0;
                                              color: #ffffff;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 37px;
                                              font-weight: normal;
                                              line-height: 120%;
                                              text-align: center;
                                              margin-top: 0;
                                              margin-bottom: 0;
                                              mso-line-height-alt: 44.4px;
                                            "
                                          >
                                            <span
                                              class="tinyMce-placeholder"
                                              style="word-break: break-word"
                                              >¡Gracias por tu compra!</span
                                            >
                                          </h1>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="0"
                                      cellspacing="0"
                                      class="heading_block block-4"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td
                                          class="pad"
                                          style="text-align: center; width: 100%"
                                        >
                                          <h1
                                            style="
                                              margin: 0;
                                              color: #ffffff;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 71px;
                                              font-weight: normal;
                                              line-height: 120%;
                                              text-align: center;
                                              margin-top: 0;
                                              margin-bottom: 0;
                                              mso-line-height-alt: 85.2px;
                                            "
                                          >
                                            <strong>FINANZAS FELICES</strong>
                                          </h1>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="0"
                                      cellspacing="0"
                                      class="heading_block block-5"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td
                                          class="pad"
                                          style="
                                            padding-left: 20px;
                                            padding-right: 20px;
                                            text-align: center;
                                            width: 100%;
                                          "
                                        >
                                          <h3
                                            style="
                                              margin: 0;
                                              color: #ffffff;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 16px;
                                              font-weight: normal;
                                              line-height: 150%;
                                              text-align: center;
                                              margin-top: 0;
                                              margin-bottom: 0;
                                              mso-line-height-alt: 24px;
                                            "
                                          >
                                            Estamos emocionados de confirmar que has
                                            adquirido “Finanzas Felices”, un libro que
                                            no solo cambiará tu forma de ver el dinero,
                                            sino que te guiará hacia una vida financiera
                                            más plena y equilibrada.
                                          </h3>
                                        </td>
                                      </tr>
                                    </table>
                                    <div
                                      class="spacer_block block-6"
                                      style="
                                        height: 25px;
                                        line-height: 25px;
                                        font-size: 1px;
                                      "
                                    >
                                  
                                    </div>
                                    <table
                                      border="0"
                                      cellpadding="0"
                                      cellspacing="0"
                                      class="button_block block-7"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td
                                          class="pad"
                                          style="
                                            padding-bottom: 10px;
                                            padding-left: 20px;
                                            padding-right: 10px;
                                            padding-top: 10px;
                                            text-align: center;
                                          "
                                        >
                                          <div align="center" class="alignment">
                                            <a
                                              href="https://garbrix.com/silvia/api/validateBookPurchase.php?id_purchase='.$last_id.'&email='.$email.'"
                                              style="
                                                color: #251f20;
                                                text-decoration: none;
                                              "
                                              target="_blank"
                                              >><!--[if mso]>
        <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word"  href="www.example.com"  style="height:58px;width:359px;v-text-anchor:middle;" arcsize="7%" fillcolor="#ffffff">
        <v:stroke dashstyle="Solid" weight="0px" color="#251F20"/>
        <w:anchorlock/>
        <v:textbox inset="0px,0px,0px,0px">
        <center dir="false" style="color:#251f20;font-family:sans-serif;font-size:24px">
        <!
                                              [endif]--><span
                                                class="button"
                                                style="
                                                  background-color: #ffffff;
                                                  border-bottom: 0px solid #251f20;
                                                  border-left: 0px solid #251f20;
                                                  border-radius: 4px;
                                                  border-right: 0px solid #251f20;
                                                  border-top: 0px solid #251f20;
                                                  color: #251f20;
                                                  display: inline-block;
                                                  font-family: Helvetica Neue, Helvetica,
                                                    Arial, sans-serif;
                                                  font-size: 24px;
                                                  font-weight: undefined;
                                                  mso-border-alt: none;
                                                  padding-bottom: 5px;
                                                  padding-top: 5px;
                                                  padding-left: 55px;
                                                  padding-right: 55px;
                                                  text-align: center;
                                                  width: auto;
                                                  word-break: keep-all;
                                                  letter-spacing: normal;
                                                "
                                                ><span style="word-break: break-word"
                                                  ><span
                                                    data-mce-style=""
                                                    style="
                                                      word-break: break-word;
                                                      line-height: 48px;
                                                    "
                                                    ><strong
                                                      >💾 Descargar Mi Libro</strong
                                                    ></span
                                                  ></span
                                                ></span
                                              >><!--[if mso]></center></v:textbox></v:roundrect><![endif]--></a</a
                                            >
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <div
                                      class="spacer_block block-8"
                                      style="
                                        height: 60px;
                                        line-height: 60px;
                                        font-size: 1px;
                                      "
                                    >
                                    
                                    </div>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="paragraph_block block-9"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div
                                            style="
                                              color: #c8c8c8;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 16px;
                                              font-weight: 400;
                                              letter-spacing: 0px;
                                              line-height: 120%;
                                              text-align: left;
                                              mso-line-height-alt: 19.2px;
                                            "
                                          >
                                            <p style="margin: 0">
                                              <strong>Detalles de tu compra:</strong>
                                            </p>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="list_block block-10"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                        color: #c8c8c8;
                                        direction: ltr;
                                        font-family: Helvetica Neue, Helvetica, Arial,
                                          sans-serif;
                                        font-size: 16px;
                                        font-weight: 400;
                                        letter-spacing: 0px;
                                        line-height: 120%;
                                        text-align: left;
                                        mso-line-height-alt: 19.2px;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div style="margin-left: -20px">
                                            <ul
                                              style="
                                                margin-top: 0;
                                                margin-bottom: 0;
                                                list-style-type: revert;
                                              "
                                            >
                                              <li style="margin: 0 0 0 0">
                                                <strong>Libro:</strong> <em
                                                  >Finanzas Felices</em
                                                > (Versión digital)
                                              </li>
                                            </ul>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="list_block block-11"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                        color: #c8c8c8;
                                        direction: ltr;
                                        font-family: Helvetica Neue, Helvetica, Arial,
                                          sans-serif;
                                        font-size: 16px;
                                        font-weight: 400;
                                        letter-spacing: 0px;
                                        line-height: 120%;
                                        text-align: left;
                                        mso-line-height-alt: 19.2px;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div style="margin-left: -20px">
                                            <ul
                                              style="
                                                margin-top: 0;
                                                margin-bottom: 0;
                                                list-style-type: revert;
                                              "
                                            >
                                              <li style="margin: 0 0 0 0">
                                                <strong>Método de pago:</strong> Tarjeta de crédito/débito
                                              </li>
                                            </ul>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="list_block block-12"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                        color: #c8c8c8;
                                        direction: ltr;
                                        font-family: Helvetica Neue, Helvetica, Arial,
                                          sans-serif;
                                        font-size: 16px;
                                        font-weight: 400;
                                        letter-spacing: 0px;
                                        line-height: 120%;
                                        text-align: left;
                                        mso-line-height-alt: 19.2px;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div style="margin-left: -20px">
                                            <ul
                                              style="
                                                margin-top: 0;
                                                margin-bottom: 0;
                                                list-style-type: revert;
                                              "
                                            >
                                              <li style="margin: 0 0 0 0">
                                                <strong>Fecha de compra:</strong
                                                > '.$date.'
                                              </li>
                                            </ul>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="list_block block-13"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                        color: #c8c8c8;
                                        direction: ltr;
                                        font-family: Helvetica Neue, Helvetica, Arial,
                                          sans-serif;
                                        font-size: 16px;
                                        font-weight: 400;
                                        letter-spacing: 0px;
                                        line-height: 120%;
                                        text-align: left;
                                        mso-line-height-alt: 19.2px;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div style="margin-left: -20px">
                                            <ul
                                              style="
                                                margin-top: 0;
                                                margin-bottom: 0;
                                                list-style-type: revert;
                                              "
                                            >
                                              <li style="margin: 0 0 0 0">
                                                <strong>Número de pedido:</strong
                                                > '.$last_id.'
                                              </li>
                                            </ul>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="list_block block-13"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                        color: #c8c8c8;
                                        direction: ltr;
                                        font-family: Helvetica Neue, Helvetica, Arial,
                                          sans-serif;
                                        font-size: 16px;
                                        font-weight: 400;
                                        letter-spacing: 0px;
                                        line-height: 120%;
                                        text-align: left;
                                        mso-line-height-alt: 19.2px;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div style="margin-left: -20px">
                                            <ul
                                              style="
                                                margin-top: 0;
                                                margin-bottom: 0;
                                                list-style-type: revert;
                                              "
                                            >
                                              <li style="margin: 0 0 0 0">
                                                <strong>Precio</strong
                                                > $'.$price.'
                                              </li>
                                            </ul>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="paragraph_block block-14"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div
                                            style="
                                              color: #c8c8c8;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 16px;
                                              font-weight: 400;
                                              letter-spacing: 0px;
                                              line-height: 120%;
                                              text-align: left;
                                              mso-line-height-alt: 19.2px;
                                            "
                                          >
                                            <p style="margin: 0">
                                              Si requieres una factura, por favor
                                              responde a este correo.
                                            </p>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="divider_block block-15"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div align="center" class="alignment">
                                            <table
                                              border="0"
                                              cellpadding="0"
                                              cellspacing="0"
                                              role="presentation"
                                              style="
                                                mso-table-lspace: 0pt;
                                                mso-table-rspace: 0pt;
                                              "
                                              width="100%"
                                            >
                                              <tr>
                                                <td
                                                  class="divider_inner"
                                                  style="
                                                    font-size: 1px;
                                                    line-height: 1px;
                                                    border-top: 1px solid #000000;
                                                  "
                                                >
                                                  <span style="word-break: break-word"
                                                    > </span
                                                  >
                                                </td>
                                              </tr>
                                            </table>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="heading_block block-16"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <h1
                                            style="
                                              margin: 0;
                                              color: #c8c8c8;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 18px;
                                              font-weight: 700;
                                              letter-spacing: normal;
                                              line-height: 120%;
                                              text-align: left;
                                              margin-top: 0;
                                              margin-bottom: 0;
                                              mso-line-height-alt: 21.599999999999998px;
                                            "
                                          >
                                            <strong>Advertencia importante:</strong>
                                          </h1>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="paragraph_block block-17"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div
                                            style="
                                              color: #c8c8c8;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 16px;
                                              font-weight: 400;
                                              letter-spacing: 0px;
                                              line-height: 120%;
                                              text-align: left;
                                              mso-line-height-alt: 19.2px;
                                            "
                                          >
                                            <p style="margin: 0">
                                              Este libro es único y está protegido por
                                              derechos de autor. Queda estrictamente
                                              prohibida su distribución, copia o
                                              compartimiento sin autorización expresa.
                                              En caso de detectarse que el libro está
                                              siendo compartido o distribuido
                                              ilegalmente, se tomarán acciones legales
                                              conforme a las leyes mexicanas, las cuales
                                              incluyen sanciones sin previo aviso.
                                            </p>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                    <table
                                      border="0"
                                      cellpadding="0"
                                      cellspacing="0"
                                      class="image_block block-18"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td
                                          class="pad"
                                          style="
                                            width: 100%;
                                            padding-right: 0px;
                                            padding-left: 0px;
                                          "
                                        >
                                          <div
                                            align="center"
                                            class="alignment"
                                            style="line-height: 10px"
                                          >
                                            <div style="max-width: 340px">
                                              <img
                                                alt="Fat Donut"
                                                height="auto"
                                                src="https://garbrix.com/silvia/assets/images/IMG-20250117-WA0023.png"
                                                style="
                                                  display: block;
                                                  height: auto;
                                                  border: 0;
                                                  width: 100%;
                                                "
                                                title="Fat Donut"
                                                width="340"
                                              />
                                            </div>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    <table
                      align="center"
                      border="0"
                      cellpadding="0"
                      cellspacing="0"
                      class="row row-2"
                      role="presentation"
                      style="
                        mso-table-lspace: 0pt;
                        mso-table-rspace: 0pt;
                        background-color: #000000;
                      "
                      width="100%"
                    >
                      <tbody>
                        <tr>
                          <td>
                            <table
                              align="center"
                              border="0"
                              cellpadding="0"
                              cellspacing="0"
                              class="row-content stack"
                              role="presentation"
                              style="
                                mso-table-lspace: 0pt;
                                mso-table-rspace: 0pt;
                                color: #000000;
                                width: 680px;
                                margin: 0 auto;
                              "
                              width="680"
                            >
                              <tbody>
                                <tr>
                                  <td
                                    class="column column-1"
                                    style="
                                      mso-table-lspace: 0pt;
                                      mso-table-rspace: 0pt;
                                      font-weight: 400;
                                      text-align: left;
                                      padding-bottom: 5px;
                                      padding-top: 5px;
                                      vertical-align: top;
                                      border-top: 0px;
                                      border-right: 0px;
                                      border-bottom: 0px;
                                      border-left: 0px;
                                    "
                                    width="100%"
                                  >
                                    <!--<table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="social_block block-1"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div align="center" class="alignment">
                                            <table
                                              border="0"
                                              cellpadding="0"
                                              cellspacing="0"
                                              class="social-table"
                                              role="presentation"
                                              style="
                                                mso-table-lspace: 0pt;
                                                mso-table-rspace: 0pt;
                                                display: inline-block;
                                              "
                                              width="144px"
                                            >
                                              <tr>
                                                <td style="padding: 0 2px 0 2px">
                                                  <a
                                                    href="https://www.facebook.com/"
                                                    target="_blank"
                                                    ><img
                                                      alt="Facebook"
                                                      height="auto"
                                                      src="images/facebook2x.png"
                                                      style="
                                                        display: block;
                                                        height: auto;
                                                        border: 0;
                                                      "
                                                      title="facebook"
                                                      width="32"
                                                  /></a>
                                                </td>
                                                <td style="padding: 0 2px 0 2px">
                                                  <a
                                                    href="https://www.twitter.com/"
                                                    target="_blank"
                                                    ><img
                                                      alt="Twitter"
                                                      height="auto"
                                                      src="images/twitter2x.png"
                                                      style="
                                                        display: block;
                                                        height: auto;
                                                        border: 0;
                                                      "
                                                      title="twitter"
                                                      width="32"
                                                  /></a>
                                                </td>
                                                <td style="padding: 0 2px 0 2px">
                                                  <a
                                                    href="https://www.linkedin.com/"
                                                    target="_blank"
                                                    ><img
                                                      alt="Linkedin"
                                                      height="auto"
                                                      src="images/linkedin2x.png"
                                                      style="
                                                        display: block;
                                                        height: auto;
                                                        border: 0;
                                                      "
                                                      title="linkedin"
                                                      width="32"
                                                  /></a>
                                                </td>
                                                <td style="padding: 0 2px 0 2px">
                                                  <a
                                                    href="https://www.instagram.com/silviamercadofinanzas"
                                                    target="_blank"
                                                    ><img
                                                      alt="Instagram"
                                                      height="auto"
                                                      src="images/instagram2x.png"
                                                      style="
                                                        display: block;
                                                        height: auto;
                                                        border: 0;
                                                      "
                                                      title="instagram"
                                                      width="32"
                                                  /></a>
                                                </td>
                                              </tr>
                                            </table>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>-->
                                    <table
                                      border="0"
                                      cellpadding="10"
                                      cellspacing="0"
                                      class="paragraph_block block-2"
                                      role="presentation"
                                      style="
                                        mso-table-lspace: 0pt;
                                        mso-table-rspace: 0pt;
                                        word-break: break-word;
                                      "
                                      width="100%"
                                    >
                                      <tr>
                                        <td class="pad">
                                          <div
                                            style="
                                              color: #c8c8c8;
                                              direction: ltr;
                                              font-family: Helvetica Neue, Helvetica,
                                                Arial, sans-serif;
                                              font-size: 10px;
                                              font-weight: 400;
                                              letter-spacing: 0px;
                                              line-height: 120%;
                                              text-align: center;
                                              mso-line-height-alt: 12px;
                                            "
                                          >
                                            <p style="margin: 0">
                                              Si tienes alguna pregunta o necesitas
                                              asistencia, no dudes en contactarnos a
                                              dihola@silviamercadofinanzas.com
                                            </p>
                                          </div>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                    
                  </td>
                </tr>
              </tbody>
            </table>
            <!-- End -->
          </body>
        </html>
        ';

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

    if ($id_books > 0 && !empty($name) && !empty($email) && !empty($payment_type)) {
      $stripe_id = '';

      if (!empty($token)) {
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
        } catch (CardException $e) {
          echo json_encode(false);
          exit;
        } catch (ApiErrorException $e) {
          echo json_encode(false);
          exit;
        } catch (Exception $e) {
          echo json_encode(false);
          exit;
        }
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
    } else {
      echo json_encode(false);
    }
} else {
  echo json_encode(false);
}

$conn->close();
?>