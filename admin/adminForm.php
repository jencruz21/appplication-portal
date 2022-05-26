<?php
    require "includes/admin_session.php";

    if (isset($_SESSION["username"])) {
        
    } else {
        header("Location: login.php");
    }
?>

<?php require "includes/admin_header.php" ?>

<div class="container">
    <div class="rounded shadow p-5">
        <h3>Intern name</h3><?php echo "<h3>".$_GET['id']."</h3>"?>
        <div class="bg-grey">
            <p>Other data</p>
        </div>
    </div>
</div>

<?php require "includes/admin_footer.php" ?>