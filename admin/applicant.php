<?php
    session_start();
    require "includes/functions.php";
    require "../includes/db.php";

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        die();
    }


    if (isset($_GET["id"])) {
        $id = $_GET["id"];

        $row = getApplicantById($conn, $id);
        $date = $row["created_at"];
        $dt = new DateTime($date);
    }
?>

<?php require "includes/admin_header.php"; ?>

<div class="container">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="applicant.php?id=<?php echo $row["id"];?>">Applicant Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="emailApplicant.php?id=<?php echo $row["id"];?>">Email Applicant</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="updateApplicant.php?id=<?php echo $row["id"];?>">Update Applicant</a>
        </li>
    </ul>
    <div class="rounded shadow p-3 mb-3">
        <h2 class="text-left mb-2"><?php echo $row["name"]; ?></h2>
        <i>Status:</i><h4 class="text-left mb-2"><?php echo $row["status"]; ?></h4>
        <i>Field of work:</i><h4 class="text-left mb-2"><?php echo $row["field_of_work"]; ?></h4>
        <i>School:</i><h4 class="text-left mb-2"><?php echo $row["school"]; ?></h4>
        <i>Branch:</i><h4 class="text-left mb-2"><?php echo $row["branch"]; ?></h4>
        <i>Course:</i><h4 class="text-left mb-2"><?php echo $row["course"]; ?></h4>
        <i>Field of work:</i><h4 class="text-left mb-2"><?php echo $row["skills"]; ?></h4>
        <i>Email:</i><h4 class="text-left mb-2"><?php echo $row["email"]; ?></h4>
        <i>Applied since:</i><h4 class="text-left mb-2"><?php echo date_format($dt, "Y/m/d"); ?></h4>
        <i>Resume:</i>
        <a href="<?php echo $row["resume"]; ?>">
            <h4 class="text-left mb-2">Link for the resume</h4>
        </a>
    </div>
</div>

<?php require "includes/admin_footer.php"; ?>