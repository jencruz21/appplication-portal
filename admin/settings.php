<?php 
    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        die();
    }

    if ($_SESSION["role"] != "admin") {
        header("Location: index.php");
        die();
    }
?>

<?php require "includes/admin_header.php" # d-flex flex-column flex-shrink-0 ?>
<div class="container">
    <h1 class="text-center">Admin</h1>
    <div class="rounded shadow p-5 mb-2">
        <a href="adminForm.php?id=1" style="text-decoration: none; color: black">
            <h3>Intern name</h3>
            <div class="bg-grey">
                <p>Other data</p>
            </div>
        </a>
    </div>
</div>

<?php require "includes/admin_footer.php" ?>