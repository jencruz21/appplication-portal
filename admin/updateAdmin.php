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

$id = $_GET["id"];

$user = getUserById($conn, $id);

if (isset($_POST["submit"])) {
	$username = sanitizeInputs($conn, $_POST["username"]);
	$name = sanitizeInputs($conn, $_POST["name"]);
	$email = sanitizeInputs($conn, $_POST["email"]);
	$role = sanitizeInputs($conn, $_POST["role"]);

	if (empty($username) || empty($name) || empty($email) || empty($role)) {
		header("location: " . $_SERVER["PHP_SELF"] . "?error=Please fill all the fields");
		die();
	} else {
		$id = $user["id"];
		updateUser($conn, $name, $email, $username, $role, $id);
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
	<title>MGHS-Edit Admin</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_edit-admin.css">
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

						<input name="name" type="text" placeholder="Name" value="<?php echo $user["name"]; ?>" required>

					</div>
					<div class="form1">

						<h5>USERNAME</h5>

						<input name="username" type="text" placeholder="Username" value="<?php echo $user["username"]; ?>" required>

					</div>
					<div class="form1">

						<h5>EMAIL</h5>

						<input name="email" type="email" placeholder="Email" value="<?php echo $user["email"]; ?>" required>


					</div>
					<div class="form1">

						<h5>ROLE</h5>

						<select name="role" id="roles" style="width: 110%;">
							<option value="select">Select</option>
							<option value="admin">Administrator</option>
							<option value="moderator">Moderator</option>
						</select>

					</div>
					<input name="submit" type="submit" class="save" style="text-align: center; width: 20%" value="SAVE">
				</form>

			</section>
		</section>

	</div>

</body>

</html>