<nav>
    <ul>
        <?php if (isset($_SESSION["username"])) : ?>
            <?php if ($_SESSION["role"] == "admin") : ?>
                <li>
                    <a href="dashboard.php" class="logo">
                        <img src="img/logo.png">
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="index.php" class="applicant">
                        <img src="img/applicant.png">
                    </a>
                </li>
                <li>
                    <a href="admins.php" class="admin">
                        <img src="img/admin.png">
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="signout">
                        <img src="img/signout.png">
                    </a>
                </li>
            <?php else : ?>
                <li>
                    <a href="dashboard.php" class="logo">
                        <img src="img/logo.png">
                    </a>
                    <hr>
                </li>
                <li>
                    <a href="index.php" class="applicant">
                        <img src="img/applicant.png">
                    </a>
                </li>
                <li>
                    <a href="logout.php" class="signout">
                        <img src="img/signout.png">
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>