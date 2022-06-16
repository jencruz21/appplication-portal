<?php

/**
 * 
 * Sorry ah kung ganito kagulo ang code ng application please bare with me kasi isa lng nagcode ng backend nato HAHAHAH
 * we are a member of three pwede niyo iparequest na ire write ang code app nato and sana ma approve. Gumamit kayo ng framework eg. Laravel, Node.js(Express), or Django
 * 
 */

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


$totalRows = fetchNumRows($conn, "application_portal");
$offset = RESULT_PER_PAGE * ($page - 1);

$numberOfPages = ceil($totalRows / RESULT_PER_PAGE);
$result = fetchPaginatedResult($conn, "application_portal", RESULT_PER_PAGE, $offset, $column);

?>

<?php require "includes/admin_header.php" ?>
<div class="container mb-2">
    <h1 class="text-center">Applicants</h1>
</div>

<div class="table-responsive">
    <table class="table">
        <thead class="table-dark">
            <tr>
                <!-- Lagyan eto ng link for sorting -->
                <th scope="col-1">#</th>
                <th scope="col-1">Name</th>
                <th scope="col-1">Status</th>
                <th scope="col-1">Email</th>
                <th scope="col-1">School</th>
                <th scope="col-1">Branch</th>
                <th scope="col-1">Field of Work</th>
                <th scope="col-1">Applied</th>
            </tr>
        </thead>
        <tbody>
            <?php

            while ($row = mysqli_fetch_assoc($result)) :
            ?>
                <tr>
                    <th>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["id"]; ?>
                        </a>
                    </th>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["name"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["status"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["email"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["school"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["branch"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["skills"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["created_at"]; ?>
                        </a>
                    </td>
                </tr>
            <?php
            endwhile;
            ?>
        </tbody>
    </table>
</div>
<div class="container">
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <div>
                <?php if ($page > 1) : ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo ($page - 1); ?>&sortBy=<?php echo $column; ?>">Previous</a></li>
                <?php else : ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Previous</a></li>
                <?php endif; ?>
            </div>
            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>"><?php echo $page; ?></a></li>
            <div>
                <?php if ($page < $numberOfPages) : ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo ($page + 1); ?>&sortBy=<?php echo $column; ?>">Next</a></li>
                <?php else : ?>
                    <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $page; ?>&sortBy=<?php echo $column; ?>">Next</a></li>
                <?php endif; ?>
            </div>
            <li class="page-item"><a class="page-link" href="index.php?page=<?php echo $numberOfPages; ?>&sortBy=<?php echo $column; ?>">Last page</a></li>
        </ul>
    </nav>
</div>

<?php require "includes/admin_footer.php" ?>