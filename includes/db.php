<?php

require_once "config.php";

// mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB);

if (!$conn) {
    die("Connection unsuccessful " . mysqli_error());
}