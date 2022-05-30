<?php 
    require "../includes/db.php";
    require "includes/functions.php";
    session_start();
    
    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        die();
    }
?>

<?php require "includes/admin_header.php"?>
<div class="container mb-2">
    <h1 class="text-center">Applicants</h1>
</div>

<div class="table-responsive">
    <table class="table">
    <thead class="table-dark">
        <tr>
            <th scope="col-1">ID</th>
            <th scope="col-1">Name</th>
            <th scope="col-1">Status</th>
            <th scope="col-1">Email</th>
            <th scope="col-1">Contact No.</th>
            <th scope="col-1">School</th>
            <th scope="col-1">Field of Work</th>
            <th scope="col-1">Applied</th>
        </tr>
    </thead>
        <tbody>
            <?php 
                $query = "SELECT * FROM application_portal";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) :
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
                            <?php echo $row["contact_no"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="applicant.php?id=<?php echo $row["id"]; ?>" style="text-decoration: none; color: black">
                            <?php echo $row["school"]; ?>
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

<?php require "includes/admin_footer.php" ?>
