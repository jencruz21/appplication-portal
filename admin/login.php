<?php

require "includes/functions.php";
require "../includes/db.php";

if(isset($_POST["submit"])) {
    $username = sanitizeInputs($conn, $_POST["username"]);
    $password = sanitizeInputs($conn, $_POST["password"]);
    $role = strtolower($_POST["role"]);
    
    if ($username === "" || $password === "" || $role == "SELECT") {
        header("Location: login.php");
    } else {
        if (login($conn, $username, $password, $role)) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;
            header("location: index.php");
        } else {
            header("Location: login.php");
        }
    }
}

?>

<?php require "includes/admin_header.php" ?>
    <div class="container d-flex flex-column justify-content-center align-items-center">
    <form class="p-5 rounded shadow col-lg-4 col-sm-12" method="post">
        <div class="mb-2">
                <label for="username" class="form-label">Username</label>
                <input class="form-control" name="username" type="text" id="username" placeholder="enter-username" /> <br>
            </div>
            <div class="mb-2">
                <label for="passowrd" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="enter-password" /> <br>
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
                <input type="submit" class="btn btn-primary w-100 py-2" name="submit" value="Login"/>
            </div>
        </div>
    </form>
</div>
<?php require "includes/admin_footer.php" ?>