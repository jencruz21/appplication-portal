<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}
?>

<?php require "includes/admin_header.php"; ?>



<?php require "includes/admin_footer.php"; ?>