<?php 
require "../../includes/db.php";
require "../../includes/email.php";
require "functions.php";

// name
// course
// date / time
// link

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
    $email = $_POST["email"];
    $name = $_POST["name"];
    $course = $_POST["course"];
    $date = $_POST["date"];
    $time = $_POST["time"];

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

    setToOrientation($conn, $id);
    header("location: ../applicant.php?id=" . $id);
}
