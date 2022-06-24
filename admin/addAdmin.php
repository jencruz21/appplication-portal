<?php
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

if (isset($_POST["submit"])) {
	$username = sanitizeInputs($conn, $_POST["username"]);
	$password = sanitizeInputs($conn, $_POST["password"]);
	$name = sanitizeInputs($conn, $_POST["name"]);
	$email = sanitizeInputs($conn, $_POST["email"]);
	$role = sanitizeInputs($conn, $_POST["role"]);

	if (empty($username) || empty($password) || empty($name) || empty($email) || empty($role)) {
		header("location: " . $_SERVER["PHP_SELF"] . "?error=Please fill all the fields");
	} else {
		saveUser($conn, $name, $email, $username, $password, $role);
		header("location: admins.php");
	}
}
?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Add Admin</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_add-admin.css">
</head>

<body>

	<div class="container">
		<?php require "includes/navbar.php"; ?>

		<section class="main">
			<div class="main-top">
				<h1>Admin Panel</h1>
			</div>
			<section class="adminFrm">

				<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
					<div class="form1">

						<h5>NAME</h5>

						<input name="name" type="text" placeholder="Full Name" required>

					</div>
					<div class="form1">

						<h5>USERNAME</h5>

						<input name="username" type="text" placeholder="Username" required>

					</div>

					<div class="form1">

						<h5>Password</h5>

						<input name="password" type="password" placeholder="Password" required>

					</div>

					<div class="form1">

						<h5>EMAIL</h5>

						<input name="email" type="email" placeholder="Email" required>

					</div>
					<div class="form1">

						<h5>ROLE</h5>

						<select name="role" id="roles" style="width: 110%;">
							<option>Select</option>
							<option value="admin">Administrator</option>
							<option value="moderator">Moderator</option>
						</select>

					</div>
					<input name="submit" type="submit" class="save" style="text-align: center; width: 20%" value="ADD">
				</form>
				<?php if (isset($_GET["error"])) : ?>
					<p style="color: red; margin-top: 20px; text-align: end;">
						*Please fill all the fields!*
					</p>
				<?php endif; ?>
			</section>

		</section>

	</div>

</body>

</html>