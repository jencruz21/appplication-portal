<?php
error_reporting(0);
session_start();
session_unset();
session_destroy();
header("Location: login.php");

?>

<div class="spinner-border" role="status">
  <span class="visually-hidden">Loading...</span>
</div>