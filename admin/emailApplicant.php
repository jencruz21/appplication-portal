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
            <a class="nav-link" aria-current="page" href="applicant.php?id=<?php echo $row["id"];?>">Applicant Details</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="emailApplicant.php?id=<?php echo $row["id"];?>">Email Applicant</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" aria-current="page" href="updateApplicant.php?id=<?php echo $row["id"];?>">Update Applicant</a>
        </li>
    </ul>
    <div class="row row-cols-2">
        <div class="col-lg-6">
            <form class="mb-3 shadow rounded p-3" method="POST" action="includes/probation.php">
                <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                <input type="hidden" name="name" value="<?php echo $row["name"];?>">
                <input type="hidden" name="email" value="<?php echo $row["email"];?>">
                <input type="hidden" name="course" value="<?php echo $row["course"];?>">
                <div class="mb-3">
                    <label for="date">Date</label>
                    <input class="form-control" type="date" name="date" id="date">
                </div>
                <div class="mb-3">
                    <label for="time">Time</label>
                    <input class="form-control" type="time" name="time" id="time" value="00:00:00" step="1">
                </div>
                <button class="btn btn-success w-100" name="submit">Probation</button>
            </form>
            <form class="mb-3 rounded shadow p-3"  method="POST" action="includes/waitlisted.php">
                <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                <input type="hidden" name="name" value="<?php echo $row["name"];?>">
                <input type="hidden" name="email" value="<?php echo $row["email"];?>">
                <button class="btn btn-danger w-100" name="submit">Waitlisted</button>
            </form>
        </div>

        <div class="col-lg-6">
            <form class="mb-3 rounded shadow p-3" method="POST" action="includes/followup.php">
                <div class="mb-3">
                    <label for="date">Date</label>
                    <input class="form-control" type="date" name="date" id="date">
                </div>
                <div class="mb-3">
                    <label for="time">Time</label>
                    <input class="form-control" type="time" name="time" id="time" value="00:00:00" step="1">
                </div>
                <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                <input type="hidden" name="name" value="<?php echo $row["name"];?>">
                <input type="hidden" name="email" value="<?php echo $row["email"];?>">
                <button class="btn btn-info w-100" name="submit">Remind applicant</button>
            </form>
            <form class="mb-3 rounded shadow p-3" method="POST" action="includes/withdrawn.php">
                <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                <input type="hidden" name="name" value="<?php echo $row["name"];?>">
                <input type="hidden" name="email" value="<?php echo $row["email"];?>">
                <button class="btn btn-warning w-100" name="submit">Withdrawn</button>
            </form>  
        </div>
    </div>
</div>

<?php require "includes/admin_footer.php"; ?>