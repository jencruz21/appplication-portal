<?php
    session_start();
    require "includes/functions.php";
    require "../includes/db.php";

    $id = htmlspecialchars($_GET["id"]);

    $row = getApplicantById($conn, $id);
    $date = $row["created_at"];
    $dt = new DateTime($date);
?>

<?php require "includes/admin_header.php"; ?>

<div class="container">
    <div class="rounded shadow p-3 mb-3">
        <h2 class="text-left mb-2"><?php echo $row["name"]; ?></h2>
        <i>Status:</i><h4 class="text-left mb-2"><?php echo $row["status"]; ?></h4>
        <i>School:</i><h4 class="text-left mb-2"><?php echo $row["school"]; ?></h4>
        <i>Branch:</i><h4 class="text-left mb-2"><?php echo $row["branch"]; ?></h4>
        <i>Course:</i><h4 class="text-left mb-2"><?php echo $row["course"]; ?></h4>
        <i>Field of work:</i><h4 class="text-left mb-2"><?php echo $row["skills"]; ?></h4>
        <i>Email:</i><h4 class="text-left mb-2"><?php echo $row["email"]; ?></h4>
        <i>Applied since:</i><h4 class="text-left mb-2"><?php echo date_format($dt, "Y/m/d"); ?></h4>
        <i>Resume:</i>
        <a href="<?php echo $row["gdrive_link"];?>">
            <h4 class="text-left mb-2"><?php echo $row["gdrive_link"]; ?></h4>
        </a>
    </div>
    <div class="row">
        <div class="col-lg-4 align-items-center justify-content-center">
            <button class="btn btn-primary w-100">Update</button>
        </div>
        <div class="col-lg-4 align-items-center justify-content-center">
            <button class="btn btn-success w-100">Probation</button>
        </div>
        <div class="col-lg-4 align-items-center justify-content-center">
            <button class="btn btn-danger w-100">Delete</button>
        </div>
    </div>
</div>

<?php require "includes/admin_footer.php"; ?>