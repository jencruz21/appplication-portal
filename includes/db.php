<?php
/*
 *  First we need to import the configuration file for the database 
 * 
 */
require_once "config.php";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Initializing the database connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PWD, DB);

//If connection is unsuccessful then we print the error
if (!$conn) {
    die("Connection unsuccessful");
}