<?php 
require "../../includes/db.php";
require "../../includes/email.php";
require "functions.php";

// name
// course
// date / time
// link

if (isset($_POST["submit"])) {

    if (empty($_POST["date"]) || empty($_POST["time"])) {
        header("location: ../applicant.php?id=" . $id . "&error=Please fill all fields");
    }

    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $course = $_POST["course"];
    $date = $_POST["date"];
    $time = $_POST["time"];
    $dateTimeString = $date . " " . $time;
    $subject = "Invite for an Interview";
    $name = explode(" ", $name);

    $details = array();
    $details["logo"] = "./images/logo.png";
    $details["envelope"] = "./images/Envelope.png";
    $details["name"] = $name[0];
    $details["surname"] = end($name);
    $details["course"] = $course;
    $details["date"] = $date;
    $details["time"] = $time;
    $details["link"] = "https://meet.google.com/ron-htvc-zzm";

    $body = file_get_contents("../../templates/html-template/Applicants' Status Upcoming Orientation Schedule.html");

    foreach($details as $key => $value) {
        $body = str_replace("{{ " . $key . " }}", $value, $body);
    }
    
    // name, email, subject, body
    sendEmail($email, $name[0], $subject, $body);

    setToProbation($conn, $id);
    header("location: ../applicant.php?id=" . $id);
}
