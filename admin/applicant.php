<?php
error_reporting(0);
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

<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Applicant Details</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_applicant_details.css">
</head>

<body>

	<div class="container">

		<?php require "includes/navbar.php"; ?>

		</nav>

		<section class="main">
			<div class="main-top">
				<h1>Applicant Details</h1>
			</div>
			<section class="main-table">
				<table class="table">
					<thead>
						<tr>
							<th>NAME</th>
							<th>EMAIL</th>
							<th>STATUS</th>
							<th>CONTACT NO.</th>
							<th>DATE APPLIED</th>
							<th>MEETING SCHED</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<?php echo $row["name"]; ?>
							</td>
							<td>
								<?php echo $row["email"]; ?>
							</td>
							<td>
								<?php echo $row["status"]; ?>
							</td>
							<td>
								<?php echo $row["contact_no"]; ?>
							</td>
							<td>
								<?php echo date_format($dt, "Y/m/d"); ?>
							</td>
							<td>
								<?php echo $row["meeting_sched"]; ?>
							</td>
						</tr>
					</tbody>
				</table>
				<table class="table">
					<thead>
						<tr>
							<th>FIELD OF WORK</th>
							<th>TECHNICAL SKILLS</th>
							<th>SCHOOL</th>
							<th>BRANCH</th>
							<th>COURSE</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $row["field_of_work"]; ?></td>
							<td><?php echo $row["skills"]; ?></td>
							<td><?php echo $row["school"]; ?></td>
							<td><?php echo $row["branch"]; ?></td>
							<td><?php echo $row["course"]; ?></td>
						</tr>
					</tbody>
				</table>
				<table class="table">
					<tbody>
						<tr>
							<td>Resume</td>
							<td><a href="<?php echo $row["resume"]; ?>" target="_blank">GDrive link for the resume of <?php echo $row["name"]; ?></a></td>
						</tr>
					</tbody>
				</table>
			</section>
			<a class="save" href="updateApplicant.php?id=<?php echo $row["id"]; ?>">EDIT</a>
			<a class="cancel" href="emailApplicant.php?id=<?php echo $row["id"]; ?>">EMAIL</a>

		</section>

	</div>

</body>

</html>