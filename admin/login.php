<?php
//error_reporting(0);
require "includes/functions.php";
require "../includes/db.php";

if (isset($_POST["submit"])) {
    $username = sanitizeInputs($conn, $_POST["username"]);
    $password = sanitizeInputs($conn, $_POST["password"]);
    $role = strtolower($_POST["role"]);

    if ($username === "" || $password === "" || $role == "role") {
        header("Location: login.php");
    } else {
        if (authorizeUser($conn, $username, $password, $role)) {
            session_start();
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            header("location: dashboard.php");
        } else {
            header("Location: login.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, inital-scale=1.0">
    <title>MGHS- Sign In</title>
    <link rel="icon" href="img/login/logo-colored.png">
    <link rel="stylesheet" href="css/login/style.css">
</head>

<body>
    <section>
        <div class="logo">
            <img src="img/login/logo.png">
        </div>

        <div class="contentBox">
            <div class="formBox">
                <img src="img/login/main.png">
                <h2>Sign in</h2>
                <form method="POST">
                    <div class="inputBox">
                        <input type="text" placeholder="Username" name="username">
                    </div>
                    <div class="inputBox">
                        <input type="password" placeholder="Password" name="password">
                    </div>
                    <div class="inputBox">
                        <select placeholder="Role" name="role">
                            <option value="role">Role</option>
                            <option value="ADMIN">Administrator</option>
                            <option value="MODERATOR">Moderator</option>
                        </select>
                    </div>
                    <div class="btn">
                        <input type="submit" value="SIGN IN" name="submit">
                    </div>
                </form>
            </div>
        </div>
    </section>
</body>

</html>