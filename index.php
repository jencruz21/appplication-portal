<?php 
error_reporting(0);
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
    $fow = sanitizeData($conn, $_POST["field_of_work"]);

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

    if (isFieldsEmpty($name, $email, $contactNo, $school, $branch, $course, $skills, $fow) === true) {
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
            $date = date("Y/m/d");
            $details = array();
            $details["name"] = $name;
            $details["course"] = $course;

            $body = file_get_contents("./templates/html-template/Pre-Screening Form.html");

            foreach ($details as $key => $value) {
                $body = str_replace("{{ " . $key . " }}", $value, $body);
            }

            saveFormData($conn, $name, "pre-screening", $email, $contactNo, $school, $branch, $course, $skills, $fow, $resumeDestination, $moaDestination, $endorsementLetterDestination, $date);
            sendEmail($email, $name, "Pre-Screening Form Link", $body);
            header("location: success.php");
        } else {
            $date = date("Y/m/d");
            $details = array();
            $details["name"] = $name;
            $details["course"] = $course;

            $body = file_get_contents("./templates/html-template/Pre-Screening Form.html");

            foreach ($details as $key => $value) {
                $body = str_replace("{{ " . $key . " }}", $value, $body);
            }

            saveFormData($conn, $name, "pre-screening", $email, $contactNo, $school, $branch, $course, $skills, $fow, "", "", "", $date);
            sendEmail($email, $name, "Pre-Screening Form Link", $body);
            header("location: success.php");
        }
    }
}

?>

<?php require "includes/header.php" ?>
<h2 class="text-center mb-3">Application Form</h2>
<div class="container col">
    <form class="p-5 rounded shadow" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="mb-2 col-lg-4">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" name="name" type="text" id="name" placeholder="enter-name" /> <br>
            </div>
            <div class="mb-2 col-lg-4">
                <label for="email_address" class="form-label">Email</label>
                <input class="form-control" name="email_address" type="email" id="email_address" placeholder="enter-email" /> <br>
            </div>
            <div class="mb-2 col-lg-4">
                <label for="field_of_work" class="form-label">Field of work</label>
                <select name="field_of_work" class="form-select">
                    <option value="">select</option>
                    <option value="Advertising">Advertising</option>
                    <option value="Broadcasting">Broadcasting</option>
                    <option value="Communication">Communication</option>
                    <option value="Digital Design">Digital Design</option>
                    <option value="English Major">English Major</option>
                    <option value="Filipino Major">Filipino Major</option>
                    <option value="Financial Management">Financial Management</option>
                    <option value="Fine Arts">Fine Arts</option>
                    <option value="Graphic Artists">Graphic Artists</option>
                    <option value="Human Resources">Human Resources</option>
                    <option value="Journalism">Journalism</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Multimedia">Multimedia</option>
                    <option value="Nutrition & Food Technology">Nutrition & Food Technology</option>
                    <option value="Office Administration">Office Administration</option>
                    <option value="Public Relations">Public Relations</option>
                    <option value="Web & App Developers">Web & App Developers</option>
                </select> <br>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 col-lg-2">
                <label for="status" class="form-label">Contact Number</label>
                <input class="form-control" name="contact_number" type="text" placeholder="09xxxxxxxxx"/> <br>
            </div>
            <div class="mb-2 col-lg-5">
                <label for="school" class="form-label">School</label>
                <input class="form-control" name="school" type="text" placeholder="enter-school"/> <br>
            </div>
            <div class="mb-2 col-lg-5">
                <label for="branch" class="form-label">Branch</label>
                <input class="form-control" name="branch" type="text" placeholder="enter-branch"/> <br>
            </div>
        </div>
        <div class="row">
            <div class="mb-2 col-lg-4">
                <label for="course" class="form-label">Course</label>
                <input class="form-control" name="course" type="text" placeholder="enter-course"/> <br>
            </div>
            <div class="mb-2 col-lg-6">
                <label for="status" class="form-label">Technical Skills</label>
                <input class="form-control" name="technical_skills" type="text" /> <br>
            </div>
            <div class="mb-2 col-lg-2">
                <label for="resume" class="form-label">Resume</label>
                <input class="form-control" type="file" name="resume">
            </div>
        </div>
        <div class="row mb-3">
            <div class="mb-2 col-lg-6">
                <label for="moa" class="form-label">MOA</label>
                <input class="form-control" type="file" name="moa">
            </div>
            <div class="mb-2 col-lg-6">
                <label for="endorsement_letter" class="form-label">Endorsement Letter</label>
                <input class="form-control w-100" type="file" name="endorsement_letter">
            </div>
        </div>
        <input type="submit" class="btn btn-primary" name="submit"/>

        <?php if(isset($_GET["error"])): ?>
            <div class="alert alert-danger mt-3">
                Please fill all the fields!
            </div>
        <?php endif; ?>

    </form>
</div>
<?php require "includes/footer.php" ?>