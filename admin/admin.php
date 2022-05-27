<?php
    session_start();
    require "includes/functions.php";
    require "../includes/db.php";

    $id = htmlspecialchars($_GET["id"]);

    $row = getUserById($conn, $id);
    $date = $row["created_at"];
    $dt = new DateTime($date);
?>

<?php require "includes/admin_header.php"; ?>

<div class="container">
    <div class="rounded shadow p-3 mb-3">
        <h2 class="text-left mb-2"><?php echo $row["name"]; ?></h2>
        <i>Role:</i><h4 class="text-left mb-2">Role: <?php echo $row["role"]; ?></h4>
        <i>Username:</i><h4 class="text-left mb-2">Username: <?php echo $row["username"]; ?></h4>
        <i>Email:</i><h4 class="text-left mb-2"><?php echo $row["email"]; ?></h4>
        <i>Admin since:</i><h4 class="text-left mb-2"><?php echo date_format($dt, "Y/m/d"); ?></h4>
    </div>
    <div class="row">
        <div class="col align-items-center justify-content-center">
            <button class="btn btn-primary w-100">Update</button>
        </div>
        <div class="col align-items-center justify-content-center">
            <button class="btn btn-danger w-100">Delete</button>
        </div>
    </div>
</div>

<?php require "includes/admin_footer.php"; ?>