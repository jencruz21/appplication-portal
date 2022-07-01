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
	<title>MGHS-Email Applicant</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_applicant_email.css">
</head>

<body>

	<div class="container">
		<?php require "includes/navbar.php"; ?>

		<section class="main">
			<div class="main-top">
				<h1>Email Applicant</h1>
			</div>

			<div class="summary">
				<div class="cards">
					<form method="POST" action="includes/probation.php">
						<div class="card">
							<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
							<input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
							<input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
							<input type="hidden" name="course" value="<?php echo $row["course"]; ?>">
							<div class="date">
								<h5>DATE</h5>
								<input name="date" type="date" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<div class="time">
								<h5>TIME</h5>
								<input name="time" type="time" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<input name="submit" type="submit" class="probation" value="Probation">
						</div>
					</form>
					<?php if (isset($_GET["probation-error"])) : ?>
						<p style="color: red;"><?php echo $_GET["probation-error"]; ?></p>
					<?php endif; ?>
				</div>
				<div class="cards">
					<form method="POST" action="includes/orientation.php">
						<div class="card">
							<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
							<input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
							<input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
							<input type="hidden" name="course" value="<?php echo $row["course"]; ?>">
							<div class="date">
								<h5>DATE</h5>
								<input name="date" type="date" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<div class="time">
								<h5>TIME</h5>
								<input name="time" type="time" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<input name="submit" type="submit" class="orientation" value="Orientation">
						</div>
					</form>
					<?php if (isset($_GET["orientation-error"])) : ?>
						<p style="color: red;"><?php echo $_GET["orientation-error"]; ?></p>
					<?php endif; ?>
				</div>
				<div class="cards">
					<form method="POST" action="includes/followup.php">
						<div class="card">
							<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
							<input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
							<input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
							<input type="hidden" name="course" value="<?php echo $row["course"]; ?>">
							<div class="date">
								<h5>DATE</h5>
								<input name="date" type="date" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<div class="time">
								<h5>TIME</h5>
								<input name="time" type="time" style="width: 100%; padding: 5px 10px; border: 1px solid #74C738;">
							</div>
							<input name="submit" type="submit" class="remind" value="Remind">
						</div>
					</form>
					<?php if (isset($_GET["followup-error"])) : ?>
						<p style="color: red;"><?php echo $_GET["followup-error"]; ?></p>
					<?php endif; ?>
				</div>
			</div>

			<div class="buttons">
				<form method="POST" action="includes/withdrawn.php">
					<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
					<input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
					<input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
					<input name="submit" type="submit" class="withdrawn" value="Withdrawn">
				</form>
				<form method="POST" action="includes/waitlisted.php">
					<input type="hidden" name="id" value="<?php echo $row["id"]; ?>">
					<input type="hidden" name="name" value="<?php echo $row["name"]; ?>">
					<input type="hidden" name="email" value="<?php echo $row["email"]; ?>">
					<input name="submit" type="submit" class="waitlisted" value="Waitlisted">
				</form>
			</div>

		</section>

	</div>

</body>

</html>