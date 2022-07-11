<?php

/**
 * 
 * Sorry ah kung ganito kagulo ang code ng application please bare with me kasi isa lng nagcode ng backend nato HAHAHAH
 * we are a member of three pwede niyo iparequest na ire write ang code app nato and sana ma approve. Gumamit kayo ng framework eg. Laravel, Node.js(Express), or Django
 * 
 */

// url: index.php?page="$param"&sortBy="$param"&query="$param"
//error_reporting(0);
require "../includes/db.php";
require "includes/functions.php";
require_once "../includes/config.php";
session_start();

if (!isset($_SESSION["username"])) {
	header("Location: login.php");
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
	$totalRows = fetchNumRows($conn, "application_portal");
	$offset = RESULT_PER_PAGE * ($page - 1);

	$numberOfPages = ceil($totalRows / RESULT_PER_PAGE);
	$result = fetchPaginatedResult($conn, "application_portal", RESULT_PER_PAGE, $offset, $column);
} else {
	if (isset($_POST["query"])) {
		$query = sanitizeInputs($conn, $_POST["query"]);
		$totalRows = fetchNumRows($conn, "application_portal");
		$offset = RESULT_PER_PAGE * ($page - 1);

		$numberOfPages = ceil($totalRows / RESULT_PER_PAGE);
		$result = fetchPaginatedSearchResult($conn, "application_portal", RESULT_PER_PAGE, $offset, $column, $query);
	}
}

?>

<!DOCTYPE html>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MGHS-Applicant Panel</title>
	<link rel="icon" href="img/logo.png">
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>

	<section class="container">
		<?php require "includes/navbar.php"; ?>

		<section class="main">
			<div class="main-top">
				<h1>Applicant Panel</h1>
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
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=name">NAME ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=status">STATUS ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=email">EMAIL ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=school">SCHOOL ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=branch">BRANCH ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=field_of_work">FIELD OF WORK ↓↑</a></th>
							<th><a href="index.php?page=<?php echo $page; ?>&sortBy=created_at">APPLIED ↓↑</a></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($row = mysqli_fetch_assoc($result)) : ?>
							<tr>
								<td><?php echo $row["name"]; ?></td>
								<td><?php echo $row["status"]; ?></td>
								<td><?php echo $row["email"]; ?></td>
								<td><?php echo $row["school"]; ?></td>
								<td><?php echo $row["branch"]; ?></td>
								<td><?php echo $row["field_of_work"]; ?></td>
								<td><?php echo $row["created_at"]; ?></td>
								<td><a href="applicant.php?id=<?php echo $row["id"]; ?>"><img src="img/options.png"></a>
								</td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>

				<!-- Last Page -->
				<?php if ($page > 1) : ?>
					<a class="button" href="index.php?page=<?php echo ($page - 1); ?>&sortBy=<?php echo $column; ?>">Previous</a>
				<?php else : ?>
					<a class="button" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Previous</a>
				<?php endif; ?>

				<!-- This page -->
				<a class="button active" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>"><?php echo $page; ?></a>

				<!-- Next page -->
				<?php if ($page < $numberOfPages) : ?>
					<a class="button" href="index.php?page=<?php echo ($page + 1); ?>&sortBy=<?php echo $column; ?>">Next</a>
				<?php else : ?>
					<a class="button" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Next</a>
				<?php endif; ?>

				<!-- Last Page -->
				<a class="button" href="index.php?page=<?php echo $numberOfPages; ?>&sortBy=<?php echo $column; ?>">Last Page</a>

			</section>
		</section>

	</section>

</body>

</html>