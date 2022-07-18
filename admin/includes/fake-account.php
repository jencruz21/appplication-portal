<?php

require "../../includes/db.php";

require "functions.php";

// name, email, username, password, role
saveUser($conn, "Application Administrator", "mghs.application.portal@gmail.com", "Administrator", "mghs_application_portal12345678", "admin");
