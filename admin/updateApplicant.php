<?php
    session_start();
    require "includes/functions.php";
    require "../includes/db.php";

    if (!isset($_SESSION["username"])) {
        header("Location: login.php");
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
            header("location: index.php");
        }
    }
?>

<?php require "includes/admin_header.php"; ?>

<div class="container col align-self-center">
    <h2 class="text-center">Edit Applicant</h2>
    <form class="p-5 rounded shadow" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="mb-2">
                <label for="username" class="form-label">Username</label>
                <input class="form-control" name="username" type="text" id="username" placeholder="enter-username" /> <br>
            </div>
            <div class="mb-2">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="enter-password" /> <br>
            </div>
            <div class="mb-2">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="enter-name" /> <br>
            </div>
            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="enter-email" /> <br>
            </div>
        <div class="row">
            <div class="mb-2 col-lg-6" id="link_section">
                <label for="status" class="form-label">Role</label>
                <select name="role" class="form-select" id="link_choices">
                    <option value="SELECT">SELECT</option>
                    <option value="moderator">MODERATOR</option>
                    <option value="admin">ADMIN</option>
                </select> <br>
            </div>
            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                <input type="submit" class="btn btn-primary w-100 py-2" name="submit" value="Add admin"/>
            </div>
        </div>
        <?php if(isset($_GET["error"])): ?>
            <div class="alert alert-danger mt-3">
                Please fill all the fields!
            </div>
        <?php endif; ?>
    </form>
</div>

<?php require "includes/admin_footer.php"; ?>
