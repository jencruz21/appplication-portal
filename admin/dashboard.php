<?php
error_reporting(0);
require "includes/functions.php";
require "../includes/db.php";
session_start();

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
	die();
}

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Dashboard</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_dashboard.css">
</head>

<body>

	<div class="container">

		<?php require "includes/navbar.php"; ?>

		<section class="content">

			<div class="main">
				<div class="dashboard">
					<div class="title">
						<h2>Welcome, <?php echo $_SESSION["username"] ?>!</h2>
						<p>Be Goal Driven Today</p>
					</div>
					<div class="total">
						<div class="roles">
							<img src="img/applicants.png">
							<div class="texts">
								<h3>Applicants</h3>
								<span><?php echo getApplicantsCount($conn); ?></span>
							</div>
						</div>
						<div class="roles">
							<img src="img/moderators.png">
							<div class="texts">
								<h3>Moderators</h3>
								<span><?php echo getModCount($conn); ?></span>
							</div>
						</div>
						<div class="roles">
							<img src="img/administrators.png">
							<div class="texts">
								<h3>Administrators</h3>
								<span><?php echo getAdminsCount($conn); ?></span>
							</div>
						</div>
					</div>
					<div class="hero">
						<img src="img/hero.png">
					</div>
				</div>
			</div>

			<div class="title">
				<h1>Applicant Summary</h1>
			</div>
			<div class="summary">
				<div class="cards">
					<div class="card1">
						<h3>Probation</h3>
						<p>This Week</p>
						<h1><?php echo getProbationCount($conn); ?></h1>
						<img src="img/approved.png">
					</div>
				</div>
				<div class="cards">
					<div class="card2">
						<h3>Pre-Screening</h3>
						<p>This Week</p>
						<h1><?php echo getPreScreeningCount($conn); ?></h1>
						<img src="img/probation.png">
					</div>
				</div>
				<div class="cards">
					<div class="card3">
						<h3>Waitlisted</h3>
						<p>This Week</p>
						<h1><?php echo getWaitlistedCount($conn); ?></h1>
						<img src="img/rejected.png">
					</div>
				</div>
				<div class="cards">
					<div class="card4">
						<h3 id="_month"></h3>
						<h4 id="_date"></h4>
						<h2 id="_year"></h2>
						<img src="img/date.png">
					</div>
				</div>
			</div>

		</section>

	</div>
	<script src="js/script.js"></script>
</body>

</html>