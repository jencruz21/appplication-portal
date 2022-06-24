<?php

require "../../includes/db.php";
require "email.php";
require "functions.php";

// name
// course
// date / time
// link

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];

    $subject = "Withdrawn Application";

    $name = explode(" ", $name);

    $details = array();
    $details["name"] = $name[0];
    $details["surname"] = end($name);

    $body = file_get_contents("../../templates/html-template/Withdrawn Application.html");

    foreach($details as $key => $value) {
        $body = str_replace("{{ " . $key . " }}", $value, $body);
    }
    
    // name, email, subject, body
    sendEmail($email, $name[0], $subject, $body);
    setToWithdrawn($conn, $id);
    header("location: ../applicant.php?id=" . $id);
}
