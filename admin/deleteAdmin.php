<?php
error_reporting(0);
session_start();
require "includes/functions.php";
require "../includes/db.php";

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
}


$id = sanitizeInputs($conn, $_GET["id"]);

deleteUser($conn, $id);
header("location: admins.php");
die();
