<?php 
require "../../includes/db.php";
require "../../includes/email.php";
require "functions.php";

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
    $subject = "Follow-Up on Requirements";
    $name = explode(" ", $name);

    $details = array();
    $details["name"] = $name[0];
    $details["course"] = $course;
    $details["date"] = $date;
    $details["time"] = $time;
    $details["link"] = "https://meet.google.com/swd-nrcm-fzm";

    $body = file_get_contents("../../templates/html-template/Orientation Reminder.html");

    foreach($details as $key => $value) {
        $body = str_replace("{{ " . $key . " }}", $value, $body);
    }
    
    // name, email, subject, body
    sendEmail($email, $name[0], $subject, $body);

    setToOrientation($conn, $id, $dateTimeString);
    header("location: ../applicant.php?id=" . $id);
}
