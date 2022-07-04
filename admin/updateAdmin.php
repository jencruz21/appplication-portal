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
			<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $id; ?>">
				<div class="main-top">
					<h1>Admin Panel</h1>
				</div>
				<section class="main-table">
					<table class="table">
						<thead>
							<tr>
								<th><a href="#">NAME</a></th>
								<th><a href="#">USERNAME</a></th>
								<th>EMAIL</th>
								<th><a href="#">ROLE</a></th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td><input name="name" type="text" id="name" placeholder="Name" style="width: 80%" value="<?php echo $user["name"]; ?>""></td>
								<td><input name=" username" type="text" id="username" placeholder="Username" style="width: 80%" value="<?php echo $user["username"]; ?>""></td>
								<td><input name=" email" type="email" id="email" placeholder="Email" style="width: 80%" value="<?php echo $user["email"]; ?>""></td>
								</td>
								<td>
									<select name=" role" id="roles" style="width: 80%">
									<option value="select">Role</option>
									<option value="admin">Administrator</option>
									<option value="moderator">Moderator</option>
								</td>
							</tr>

						</tbody>
					</table>
				</section>
				<input name="submit" type="submit" class="save" value="SAVE">
				<a class="cancel" href="admins.php">CANCEL</a>
			</form>
		</section>

	</div>

</body>

</html>