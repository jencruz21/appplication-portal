<?php
error_reporting(0);
session_start();
require "includes/functions.php";
require "../includes/db.php";

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
	die();
}

$id = $_GET["id"];
$row = getApplicantById($conn, $id);
$date = $row["created_at"];
$dt = new DateTime($date);

if (isset($_POST["submit"])) {
	$name = $_POST["name"];
	$email = $_POST["email"];
	$status = $_POST["status"];
	$fow = $_POST["field_of_work"];
	$contact_no = $_POST["contact_no"];
	$school = $_POST["school"];
	$branch = $_POST["branch"];
	$course = $_POST["course"];
	$skills = $_POST["skills"];
	$resume = $_POST["resume"];
	$id = $row["id"];

	if (isFieldsEmpty($name, $email, $status, $contact_no, $school, $branch, $course, $skills, $fow, $resume)) {
		header("location: " . $_SERVER['PHP_SELF'] . "?error=Please fill all the fields!");
		exit();
	} else {
		updateApplicant($conn, $name, $status, $email, $contact_no, $school, $branch, $course, $skills, $fow, $resume, $id);
		header("location: applicant.php?id=" . $row["id"]);
	}
}
?>


<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Edit Applicant Details</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_applicant_details_edit.css">
</head>

<body>

	<div class="container">
		<?php require "includes/navbar.php"; ?>

		<section class="main">
			<div class="main-top">
				<h1>Applicant Details</h1>
			</div>
			<section class="main-table">
				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
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
									<input name="name" type="text" id="name" placeholder="Name" style="text-align: center; width: 100%;" value="<?php echo $row["name"]; ?>">
								</td>
								<td>
									<input name="email" type="email" id="name" placeholder="Email" style="text-align: center; width: 100%;" value="<?php echo $row["email"]; ?>">
								</td>
								<td>
									<select name="status" id="status">
										<option value="">select</option>
										<option value="Probation">Probation</option>
										<option value="Orientation">Orientation</option>
										<option value="Waitlisted">Waitlisted</option>
										<option value="Withdrawn">Withdrawn</option>
									</select>
								</td>
								<td>
									<input name="contact_no" type="text" id="name" placeholder="Email" style="text-align: center; width: 100%;" value="<?php echo $row["contact_no"]; ?>">
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
								<td>
									<select name="field_of_work" id="status">
										<option value="">select</option>
										<option value="Advertising">Advertising</option>
										<option value="Broadcasting">Broadcasting</option>
										<option value="Communication">Communication</option>
										<option value="Digital Design">Digital Design</option>
										<option value="English Major">English Major</option>
										<option value="Filipino Major">Filipino Major</option>
										<option value="Financial Management">Financial Management</option>
										<option value="Fine Arts">Fine Arts</option>
										<option value="Graphic Artists">Graphic Artists</option>
										<option value="Human Resources">Human Resources</option>
										<option value="Journalism">Journalism</option>
										<option value="Marketing">Marketing</option>
										<option value="Multimedia">Multimedia</option>
										<option value="Nutrition & Food Technology">Nutrition & Food Technology</option>
										<option value="Office Administration">Office Administration</option>
										<option value="Public Relations">Public Relations</option>
										<option value="Web & App Developers">Web & App Developers</option>
									</select>
								</td>
								<td>
									<input name="skills" type="text" id="name" placeholder="Technical Skills" style="text-align: center; width: 100%;" value="<?php echo $row["skills"]; ?>">
								</td>
								<td>
									<input name="school" type="text" id="name" placeholder="School" style="text-align: center; width: 100%;" value="<?php echo $row["school"]; ?>">
								</td>
								<td>
									<input name="branch" type="text" id="name" placeholder="Branch" style="text-align: center; width: 100%;" value="<?php echo $row["branch"]; ?>">
								</td>
								<td>
									<input name="course" type="text" id="name" placeholder="Course" style="text-align: center; width: 100%;" value="<?php echo $row["course"]; ?>">
								</td>
							</tr>
						</tbody>
					</table>
					<table class="table">
						<tbody>
							<tr>
								<td>Resume</td>
								<td><input name="resume" type="text" id="name" placeholder="Insert the new link for the drive link" style="text-align: center; width: 100%;" value="<?php echo $row["resume"]; ?>"></td>
							</tr>
						</tbody>
					</table>
			</section>
			<input name="submit" type="submit" class="save" value="UPDATE">
			<a class="cancel" href="index.php">CANCEL</a>
			</form>
		</section>

	</div>

</body>

</html>