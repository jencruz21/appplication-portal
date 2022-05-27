<?php 
require "includes/db.php";
require "includes/email.php";
require "includes/functions.php";
// require "includes/mail.php";

if (isset($_POST["submit"])) {
    // need ko ng query sa database ✅
    // need ko ng dummy account to test the automated email ✅
    // lastly validation and sanitization ✅
    // rearrange ang code ✅
    // pag gagawing to page form submission isstore ko nlng ung data ng form1 sa session tas issubmit ko nlng yun sa db pag ok na nsa form 2 na sila
    // ilagay ang name sa template

	// $start_date = date("Y/m/d");  
	// $date = strtotime($start_date);
	// $date = strtotime("+3 day", $date);
	// echo date('Y/m/d', $date);

    $name = sanitizeData($conn, $_POST["name"]);
    $email = sanitizeData($conn, $_POST["email_address"]);
    $contactNo = sanitizeData($conn, $_POST["contact_number"]);
    $school = sanitizeData($conn, $_POST["school"]);
    $branch = sanitizeData($conn, $_POST["branch"]);
    $course = sanitizeData($conn, $_POST["course"]);
    $skills = sanitizeData($conn, $_POST["technical_skills"]);
    $gdrive_link = sanitizeData($conn, $_POST["link_input"]);

    if (isFieldsEmpty($name, $email, $contactNo, $school, $branch, $course, $skills, $gdrive_link) === true) {
        header("location: " . $_SERVER['PHP_SELF'] . "?error=Please fill all the fields!");
        die();
    } else {
        sendEmail($email, $name);
        saveFormData(
            $conn, $name, "pre-screening", $email, $contactNo, $school, $branch, $course, $gdrive_link);
        header("location: success.php");
    }
}
?>

<?php require "includes/header.php" ?>
<h2 class="text-center mb-3">Application Form</h2>
<div class="container col">
    <form class="p-5 rounded shadow" action="<?php htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="row">
            <div class="mb-2 col-lg-6">
                <label for="name" class="form-label">Name</label>
                <input class="form-control" name="name" type="text" id="name" placeholder="enter-name" /> <br>
            </div>
            <div class="mb-2 col-lg-6">
                <label for="email_address" class="form-label">Email</label>
                <input class="form-control" name="email_address" type="email" id="email_address" placeholder="enter-email" /> <br>
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
            <div class="mb-2 col-lg-2" id="link_section">
                <label for="status" class="form-label">GDrive</label>
                <select name="gdrive_link" class="form-select" id="link_choices">
                    <option value="">select</option>
                    <option value="yes">YES</option>
                    <option value="no">NO</option>
                </select> <br>
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