<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require "vendor/autoload.php";

require_once "includes/config.php";

function sendEmail($email, $name, $subject, $body) {
    $mail = new PHPMailer(true);

    // Mail code
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Username = EMAIL_UN;
        $mail->Password = EMAIL_PWD;

        $mail->setFrom(EMAIL_UN);
        $mail->addAddress($email, $name);

        $mail->Subject = 'Invitation for Orientation';
        $mail->isHTML(true);
        $mail->msgHTML(file_get_contents('templates/html-template/index.html'), IMG_DIR);
        // $mail->Body = buildOrientationTemplate($name, $sched, $zoom_link, $zoom_pwd);
        $mail->send();
        
    } catch(Exception $e) {
        echo $e->errorMessage();
    }
}