<?php 
//error_reporting(0);
require "includes/db.php";
require "includes/email.php";
require "includes/functions.php";
require_once "includes/config.php";

if(!isset($_GET["pass"]) && empty($_GET["pass"])) {
    die();
}

if ($_GET["pass"] != SECRET_STRING) {
    die();
}

if (isset($_POST["submit"])) {

    $name = sanitizeData($conn, $_POST["name"]);
    $email = sanitizeData($conn, $_POST["email_address"]);
    $contactNo = sanitizeData($conn, $_POST["contact_number"]);
    $school = sanitizeData($conn, $_POST["school"]);
    $branch = sanitizeData($conn, $_POST["branch"]);
    $course = sanitizeData($conn, $_POST["course"]);
    $skills = sanitizeData($conn, $_POST["technical_skills"]);
    $fow = sanitizeData($conn, $_POST["field_of_work"]);
    $resume = sanitizeData($conn, $_POST["gdrive_link"]);

    if (isFieldsEmpty($name, $email, $contactNo, $school, $branch, $course, $skills, $fow, $resume)) {
        header("location: " . $_SERVER['PHP_SELF'] . "?error=Please fill all the fields!");
    } 

    if (isset($_POST["spam"]) && !empty($_POST["spam"])) {
        die();
    }
        $date = date("Y/m/d");
        $newName = explode(" ", $name);
        $details = array();
        $details["name"] = $newName[0];
        $details["link"] = "https://forms.gle/4DbQWSz4SL5LMj2D9";
        $details["surname"] = end($newName);
        $details["course"] = $course;

        $body = file_get_contents("./templates/html-template/Pre-Screening Form.html");

        foreach ($details as $key => $value) {
            $body = str_replace("{{ " . $key . " }}", $value, $body);
        }

        saveFormData($conn, $name, "Pre-screening", $email, $contactNo, $school, $branch, $course, $skills, $fow, $resume, $date);
        sendEmail($email, $name, "Pre-Screening Form Link", $body);
        header("location: success.php");
    
}

?>

<?php require "includes/header.php" ?>
<h2 class="text-center mb-3">Application Form</h2>
<div class="container col">
    <form class="p-5 rounded shadow" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="spam" />
        <div class="row">
            <div class="mb-2 col-lg-4">
                <input type="text" name="spam" style="display: none; visibility: hidden;">
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
                <input class="form-control" name="technical_skills" type="text" placeholder="enter-skills" /> <br>
            </div>
            <div class="mb-2 col-lg-2">
                <label for="resume" class="form-label">Link for resume<span style="color: red;"> *needed*</span></label>
                <input class="form-control" type="text" name="gdrive_link" placeholder="enter-gdrive-link">
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