<?php
error_reporting(0);
require_once "includes/config.php";

if (!isset($_GET["pass"]) && empty($_GET["pass"])) {
    die();
}

if ($_GET["pass"] != SECRET_STRING) {
    die();
}

if (isset($_POST["next"])) {
    if (empty($_POST["name"]) || empty($_POST["email_address"]) || empty($_POST["contact_no"]) || empty($_POST["course"])) {
        header("location: index.php?pass=1991652782&error=Please fill all the fields!");
    } else {
        $name = $_POST["name"];
        $email = $_POST["email_address"];
        $contactNo = $_POST["contact_no"];
        $course = $_POST["course"];

        if (isset($_POST["spam"]) && !empty($_POST["spam"])) {
            die();
        }

        session_start();
        $_SESSION["name"] = $name;
        $_SESSION["email_address"] = $email;
        $_SESSION["contact_no"] = $contactNo;
        $_SESSION["course"] = $course;

        header("location: next.php?pass=1991652782");
    }
}

?>

<?php require "includes/header.php"; ?>
<section>
    <div class="logo">
        <img src="images/logo.png">
    </div>

    <div class="contentBox">
        <div class="formBox">
            <h2>APPLICATION FORM</h2>
            <form method="POST">
                <input type="text" name="spam" style="display: none; visibility: hidden;">
                <div class="input-div one">
                    <div class="div">
                        <h5>FULL NAME</h5>
                        <input type="text" class="input" name="name">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>EMAIL</h5>
                        <input type="email" class="input" name="email_address">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>CONTACT NUMBER</h5>
                        <input type="text" class="input" name="contact_no">
                    </div>
                </div>
                <div class="input-div one">
                    <div class="div">
                        <h5>COURSE</h5>
                        <input type="text" class="input" name="course">
                    </div>
                </div>
                <button type="submit" name="next">NEXT</button>
                <?php if (isset($_GET["error"])) : ?>
                    <p style="color:red;">*<?php echo $_GET["error"]; ?>*</p>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <div class="eclipse">
        <img src="images/eclipse.png">
    </div>
</section>
<?php require "includes/footer.php" ?>