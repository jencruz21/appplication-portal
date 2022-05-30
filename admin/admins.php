<?php 
    session_start();

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
        die();
    }

    if ($_SESSION["role"] != "admin") {
        header("Location: index.php");
        die();
    }
?>

<?php require "includes/admin_header.php" # d-flex flex-column flex-shrink-0 ?>
<div class="container">
    <h1 class="text-center">Admin</h1>
</div>

<div class="table-responsive">
    <table class="table">
    <thead class="table-dark">
        <tr>
            <th scope="col-1">ID</th>
            <th scope="col-1">Username</th>
            <th scope="col-1">Role</th>
            <th scope="col-1">Name</th>
            <th scope="col-1">Email</th>
            <th scope="col-1">Applied</th>
        </tr>
    </thead>
        <tbody>
            <?php 
                require "../includes/db.php";
                $query = "SELECT * FROM application_portal_admin";
                $result = mysqli_query($conn, $query);
                while($row = mysqli_fetch_assoc($result)) :
            ?>
            <tr>
                    <th>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
                            <?php echo $row["id"]; ?>
                        </a>
                    </th>
                    <td>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
                            <?php echo $row["username"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
                            <?php echo $row["role"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
                            <?php echo $row["name"]; ?>
                        </a>
                    </td>

                    <td>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
                            <?php echo $row["email"]; ?>
                        </a>
                    </td>
                    <td>
                        <a href="admin.php?id=<?php echo $row["id"]; ?>" class="w-auto" style="text-decoration: none; color: black">
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