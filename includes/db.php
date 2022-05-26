<?php

// Server: sql6.freemysqlhosting.net
// Name: sql6495374
// Username: sql6495374
// Password: qNNZ6vhVvn
// Port number: 3306

$host = "sql6.freemysqlhosting.net";
$user = "sql6495374";
$pass = "qNNZ6vhVvn";
$database = "sql6495374";

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