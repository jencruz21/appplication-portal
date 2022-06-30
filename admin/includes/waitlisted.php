<?php 
require "../../includes/db.php";
require "email.php";
require "functions.php";

/**
 * This is the script after submitting the waitlisted form 
 * it takes an 
 * 
 * @param id
 * @param email
 * @param name
 * 
 * from the form submitted in emailApplicant
 * this script also reads the content in templates/html-template/Waitlisted Application.html
 * replaces the {{ keyword }} with the given data from the @var details array
 * this scripts also calls the function from the admin/email.php
 * and setToWaitlisted is called from the admin/includes/function.php 
 * they will also be redirected to applicant.php
 */

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];

    $subject = "Waitlisted Application";

    $name = explode(" ", $name);

    $details = array();
    $details["name"] = $name[0];

    $body = file_get_contents("../../templates/html-template/Waitlisted Applicants.html");

    foreach($details as $key => $value) {
        $body = str_replace("{{ " . $key . " }}", $value, $body);
    }
    
    // name, email, subject, body
    sendEmail($email, $name[0], $subject, $body);

    setToWaitListed($conn, $id);
    header("location: ../applicant.php?id=" . $id);
}
