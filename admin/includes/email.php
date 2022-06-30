<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Require the configuration files from the vendor package and configuration for the email address
require_once "../../includes/config.php";
include "../../vendor/autoload.php";

/**
 * 
 * This function takes an 
 *  @param email - email of the receipient
 *  @param name - name of the receipient (This is optional)
 *  @param subject - the subject of the email
 *  @param body - the typical message that you send to the receipient
 *  
 *  this function just serves as an utility script
 * 
 *  @return void 
 */
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

        $mail->Subject = $subject;
        $mail->isHTML(true);
        $mail->Body = $body;
        $mail->send();
        
    } catch(Exception $e) {
        echo $e->errorMessage();
    }
}