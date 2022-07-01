<?php 
require "../../includes/db.php";
require "email.php";
require "functions.php";


/**
 * This is the script after submitting the orientation form just to follow up the details and update the meeting time for the orientation
 * it takes an 
 * 
 * @param id - url params
 * @param email
 * @param name
 * @param course
 * @param date - the scheduled date
 * @param time - the scheduled time
 * 
 * from the form submitted in emailApplicant.php
 * this script also reads the content in templates/html-template/Orientation Reminder.html
 * replaces the {{ keyword }} with the given data from the @var details array
 * this scripts also calls the function from the admin/includes/email.php
 * and setToProbation function is called from the admin/includes/function.php 
 * they will also be redirected to applicant.php
 */

if (isset($_POST["submit"])) {

    if (empty($_POST["date"]) || empty($_POST["time"])) {
        header("location: ../emailApplicant.php?id=" . $id . "&followup-error=Please fill all fields");
        die();
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

    remindApplicant($conn, $id, $dateTimeString);
    header("location: ../applicant.php?id=" . $id);
}
