<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// require "vendor/autoload.php";
require_once "config.php";

include "vendor/autoload.php";

// sends an email and accepts email, name of the receipient, the subject, and the body of the email
function sendEmail($email, $name, $subject, $body) {
    $mail = new PHPMailer(true);

    // Mail code
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587;
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = "tls";
        // enable this if you want to see what is happening when you send an email to the receipient
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        $mail->Username = EMAIL_UN;
        $mail->Password = EMAIL_PWD;

        $mail->setFrom(EMAIL_UN);
        $mail->addAddress($email, $name);

        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;
        $mail->send();
        
    } catch(Exception $e) {
        echo $e->errorMessage();
    }
}