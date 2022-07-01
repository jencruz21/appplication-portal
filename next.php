<?php
error_reporting(0);
require "includes/db.php";
require "includes/email.php";
require "includes/functions.php";
require_once "includes/config.php";
require "admin/includes/functions.php";

// Continuation of index.php

// if pass is empty and not set, page will die (to avoid spam) 
if (!isset($_GET["pass"]) && empty($_GET["pass"])) {
    die();
}

// if pass is not equals to secret_string 
if ($_GET["pass"] != SECRET_STRING) {
    die();
}

if (isset($_POST["submit"])) {
    session_start();
    $name = $_SESSION["name"];
    $email = $_SESSION["email_address"];
    $contactNo = $_SESSION["contact_no"];
    $course = $_SESSION["course"];

    $school = sanitizeData($conn, $_POST["school"]);
    $branch = sanitizeData($conn, $_POST["branch"]);
    $skills = sanitizeData($conn, $_POST["technical_skills"]);
    $fow = sanitizeData($conn, $_POST["field_of_work"]);
    $resume = sanitizeData($conn, $_POST["resume"]);

    if (empty($_POST["school"]) || empty($_POST["school"]) || empty($_POST["school"]) || empty($_POST["school"]) || empty($_POST["school"])) {
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

    // virtual internship program
    // https://drive.google.com/file/d/1Gs8DOxRT8uXeBgtE363AF0fTsGm-ocqS/view

    // business profile
    // https://drive.google.com/file/d/1cNJSDWfnjf8pLSX96_rBtXeRMdKFtsPy/view
    sendEmail($email, $name, "Pre-Screening Form Link", $body);
    saveFormData($conn, $name, "Pre-screening", $email, $contactNo, $school, $branch, $course, $skills, $fow, $resume, $date);
    unset($_SESSION["name"]);
    unset($_SESSION["email_address"]);
    unset($_SESSION["contact_no"]);
    unset($_SESSION["course"]);
    header("location: index.php?pass=1991652782");
}

?>
<?php require "includes/header.php" ?>

<section>
    <div class="logo" onclick="location.href='index.php?pass=1991652782'">
        <img src="images/back.png">
    </div>

    <div class="contentBox">
        <div class="formBox">
            <h2>APPLICATION FORM</h2>
            <form method="POST">
                <input type="text" name="spam" style="display: none; visibility: hidden;">
                <div class="input-div one">
                    <div class="div">
                        <h5>SCHOOL</h5>
                        <input type="text" class="input" name="school">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>BRANCH</h5>
                        <input type="text" class="input" name="branch">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>TECHNICAL SKILLS</h5>
                        <input type="text" class="input" name="technical_skills">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>CV / RESUME (GDRIVE LINK)</h5>
                        <input type="text" class="input" name="resume">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <label for="area"></label>
                        <select id="area" name="field_of_work">
                            <option value="area">AREA OF FIELD APPLYING</option>
                            <option value="Advertising">Advertising</option>
                            <option value="Broadcasting">Broadcasting</option>
                            <option value="Communication">Communication</option>
                            <option value="Digital Design">Digital Design</option>
                            <option value="English Major">English Major</option>
                            <option value="Filipino Major">Filipino Major</option>
                            <option value="Financial Management">Financial Management</option>
                            <option value="Fine Arts">Fine Arts</option>
                            <option value="Graphic Artists">Graphic Artists</option>
                            <option value="Human Resources">AHuman Resources</option>
                            <option value="Journalism">Journalism</option>
                            <option value="Marketing">AMarketing</option>
                            <option value="Multimedia">Multimedia</option>
                            <option value="Nutrition & Food Technology">Nutrition & Food Technology</option>
                            <option value="Office Administration">Office Administration</option>
                            <option value="Public Relations">Public Relations</option>
                            <option value="Web & App Developers">Web & App Developers</option>
                        </select>
                    </div>
                </div>

                <p class="btn" style="cursor: pointer" id="modalbtn">SUBMIT</p>

                <?php if (isset($_GET["error"])) : ?>
                    <p style="color:red;">*<?php echo $_GET["error"]; ?>*</p>
                <?php endif; ?>

                <div id="modalbox" class="modal">
                    <div class="popup">
                        <img src="images/chk.png">
                        <h2>SUCCESS</h2>
                        <p>Please check your email for your <br>confirmation link.</p>
                        <input type="submit" name="submit" class="btn_modal" value="DONE" id="submit">
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="eclipse">
        <img src="images/eclipse.png">
    </div>
</section>
<script type="text/javascript" src="js/modal.js"></script>
<?php require "includes/footer.php" ?>