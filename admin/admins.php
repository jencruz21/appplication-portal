<?php
error_reporting(0);
require "includes/functions.php";
require "../includes/db.php";
session_start();

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
	die();
}

if ($_SESSION["role"] != "admin") {
	header("Location: index.php");
	die();
}

if (isset($_GET["page"])) {
	$page = sanitizeInputs($conn, $_GET["page"]);
	$column = sanitizeInputs($conn, $_GET["sortBy"]);
} else {
	$page = 1;
	$column = "id";
}

if (!isset($_POST["query"]) && empty($_POST["query"])) {
	$totalRows = fetchNumRows($conn, "application_portal_admin");
	$offset = RESULT_PER_PAGE * ($page - 1);

	$numberOfPages = ceil($totalRows / RESULT_PER_PAGE);
	$result = fetchPaginatedResult($conn, "application_portal_admin", RESULT_PER_PAGE, $offset, $column);
} else {
	if (isset($_POST["query"])) {
		$query = sanitizeInputs($conn, $_POST["query"]);
		$totalRows = fetchNumRows($conn, "application_portal_admin");
		$offset = RESULT_PER_PAGE * ($page - 1);

		$numberOfPages = ceil($totalRows / RESULT_PER_PAGE);
		$result = fetchPaginatedAdminsSearchResult(
			$conn,
			"application_portal_admin",
			RESULT_PER_PAGE,
			$offset,
			$column,
			$query
		);
	}
}

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Admin Panel</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style_admin.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>

	<div class="container">
		<?php require "includes/navbar.php"; ?>

		<section class="main">
			<div class="main-top">
				<h1>Admin Panel</h1>
				<div class="search_box">
					<form method="POST">
						<input name="query" type="text" placeholder="Search here...">
						<i class="fas fa-search"></i>
					</form>
				</div>
			</div>
			<section class="main-table">
				<table class="table">
					<thead>
						<tr>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=id">ID</a></th>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=username">USERNAME ↓↑</a></th>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=role">ROLE ↓↑</a></th>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=name">NAME</a></th>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=email">EMAIL ↓↑</a></th>
							<th><a href="admins.php?page=<?php echo $page; ?>&sortBy=created_at">DATE APPLIED ↓↑</a></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_assoc($result)) : ?>
							<tr>
								<td><?php echo $row["id"]; ?></td>
								<td><?php echo $row["username"]; ?></td>
								<td><?php echo $row["role"]; ?></td>
								<td><?php echo $row["name"]; ?></td>
								<td><?php echo $row["email"]; ?></td>
								<td><?php echo $row["created_at"]; ?></td>
								<td><a href="deleteAdmin.php?id=<?php echo $row["id"]; ?>">delete</a></td>
								<td><a href="updateAdmin.php?id=<?php echo $row["id"]; ?>">edit</a></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>

				<!-- Last Page -->
				<?php if ($page > 1) : ?>
					<a class="button" href="admins.php?page=<?php echo ($page - 1); ?>&sortBy=<?php echo $column; ?>">Previous</a>
				<?php else : ?>
					<a class="button" href="admins.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Previous</a>
				<?php endif; ?>

				<!-- This page -->
				<a class="button active" href="admins.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>"><?php echo $page; ?></a>

				<!-- Next page -->
				<?php if ($page < $numberOfPages) : ?>
					<a class="button" href="admins.php?page=<?php echo ($page + 1); ?>&sortBy=<?php echo $column; ?>">Next</a>
				<?php else : ?>
					<a class="button" href="admins.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Next</a>
				<?php endif; ?>

				<!-- Last Page -->
				<a class="button" href="admins.php?page=<?php echo $numberOfPages; ?>&sortBy=<?php echo $column; ?>">Last Page</a>
			</section>
			<a class="cancel" href="addAdmin.php">+ ADMIN</a>
		</section>

	</div>

</body>

</html>