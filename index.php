<?php 
require "includes/db.php";
require "includes/email.php";
require "includes/functions.php";

if (isset($_POST["submit"])) {
    // need ko ng query sa database ✅
    // need ko ng dummy account to test the automated email ✅
    // lastly validation and sanitization ✅
    // rearrange ang code ✅
    // pag gagawing to page form submission isstore ko nlng ung data ng form1 sa session tas issubmit ko nlng yun sa db pag ok na nsa form 2 na sila
    // ilagay ang name sa template

    $name = sanitizeData($conn, $_POST["name"]);
    $email = sanitizeData($conn, $_POST["email_address"]);
    $contactNo = sanitizeData($conn, $_POST["contact_number"]);
    $school = sanitizeData($conn, $_POST["school"]);
    $branch = sanitizeData($conn, $_POST["branch"]);
    $course = sanitizeData($conn, $_POST["course"]);
    $skills = sanitizeData($conn, $_POST["technical_skills"]);
    $fov = sanitizeData($conn, $_POST["field_of_work"]);

    // FIle functions
    // Resume
    $resumeName = $_FILES["resume"]["name"];
    $tmpResumeName = $_FILES["resume"]["tmp_name"];
    $resumeSize = $_FILES["resume"]["size"];

    // Moa
    $moaName = $_FILES["moa"]["name"];
    $tmpMoaName = $_FILES["moa"]["tmp_name"];
    $moaSize = $_FILES["moa"]["size"];

    // Endorsement Letter
    $endorsementLetterName = $_FILES["endorsement_letter"]["name"];
    $tmpEndorsementLetterName = $_FILES["endorsement_letter"]["tmp_name"];
    $endorsementLetterSize = $_FILES["endorsement_letter"]["size"];

    $destination = "uploads/" . $email;

    $sizeLimit = 50_000_000;

    if (isFieldsEmpty($name, $email, $contactNo, $school, $branch, $course, $skills) === true) {
        header("location: " . $_SERVER['PHP_SELF'] . "?error=Please fill all the fields!");
        exit();
    } 

    if (($resumeSize > $sizeLimit) || ($moaSize > $sizeLimit) || ($endorsementLetterSize > $sizeLimit)) {
        header("location: ");
        die();
    }

    if (mkdir($destination)) {
        $resumeDestination = "uploads/" .$email . "/" . $resumeName;
        $moaDestination = "uploads/" .$email . "/" . $moaName;
        $endorsementLetterDestination = "uploads/" . $email . "/" . $endorsementLetterName;
        if (move_uploaded_file($tmpResumeName, $resumeDestination) && move_uploaded_file($tmpMoaName, $moaDestination) && move_uploaded_file($tmpEndorsementLetterName, $endorsementLetterDestination)) {
            //$date = date("Y/m/d");
            //saveFormData($conn, $name, "pre-screening", $email, $contactNo, $school, $branch, $course, $skills, $fov, $date);
            //header("location: success.php");
        } else {
            die();
        }
    }
}

?>

<?php require "index.view.php"; ?>