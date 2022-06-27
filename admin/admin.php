<?php
error_reporting(0);
session_start();
require "includes/functions.php";
require "../includes/db.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}

if ($_SESSION["role"] != "admin") {
    header("Location: index.php");
    die();
}

$id = $_GET["id"];

$row = getUserById($conn, $id);
$date = $row["created_at"];
$dt = new DateTime($date);
?>

<?php require "includes/admin_header.php"; ?>

<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="admins.php">Dashboard</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="addAdmin.php">Add admin</a>
        </li>
    </ul>
</div>
<div class="container">
    <div class="rounded shadow p-3 mb-3">
        <h2 class="text-left mb-2"><?php echo $row["name"]; ?></h2>
        <i>Role:</i>
        <h4 class="text-left mb-2">Role: <?php echo $row["role"]; ?></h4>
        <i>Username:</i>
        <h4 class="text-left mb-2">Username: <?php echo $row["username"]; ?></h4>
        <i>Email:</i>
        <h4 class="text-left mb-2"><?php echo $row["email"]; ?></h4>
        <i>Admin since:</i>
        <h4 class="text-left mb-2"><?php echo date_format($dt, "Y/m/d"); ?></h4>
    </div>
    <div class="row">
        <div class="col align-items-center justify-content-center">
            <a href="updateAdmin.php?id=<?php echo $id; ?>" class="btn btn-primary w-100">
                Update User
            </a>
        </div>
        <div class="col align-items-center justify-content-center">
            <a href="deleteAdmin.php?id=<?php echo $id; ?>" class="btn btn-danger w-100">
                Delete User
            </a>
        </div>
    </div>
</div>

<?php require "includes/admin_footer.php"; ?>