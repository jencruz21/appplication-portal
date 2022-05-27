<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>MGHS Application Portal</title>
</head>
<body>
    <nav class="navbar navbar-light bg-light mb-5 container-fluid">
      <a class="navbar-brand" href="index.php">MGHS Application Form</a>
      <?php
      if (isset($_SESSION["username"])) {
      ?>
      <?php if ($_SESSION["role"] === "admin") { ?>
        <div class="dropdown dropstart navbar-right">
          <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
            🌳
          </a>
          <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            <li><a class="dropdown-item" href="admins.php">Manage Admins</a></li>
          </ul>
        </div>
        <?php } else { ?>
          <div class="dropdown dropstart navbar-right">
            <a class="btn btn-light dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
              🌳
            </a>
            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
              <li><a class="dropdown-item" href="logout.php">Logout</a></li>
            </ul>
          </div>
        <?php } ?>
      <?php } ?>
    </nav>
