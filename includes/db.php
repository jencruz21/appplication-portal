<?php

$host = "localhost";
$user = "root";
$pass = "123456";
$database = "application_portal_test";

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$conn = mysqli_connect($host, $user, $pass, $database);

if (!$conn) {
    die("Connection unsuccessful " . mysqli_error());
}

/**
 * application portal table
 * 
 * id int pkey auto_increment not null
 * name varchar(255) not null default ""
 * status varchar(255)not null default 
 * email address(255)
 * contact_no varchar(16)
 * school varchar(255)
 * branch varchar(255)
 * course varchar(255)
 * grdrive_link varcher(255)
 * skills varchar(255)
 */