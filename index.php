<?php

session_start();
if (isset($_SESSION['user'])) {

    include 'header.php';

    echo '
        <div class="message">
            <strong>' . $_SESSION['user'] . '</strong>, you have successfully logged in!<br><br>
            <a href="forum.php">Go to Forum</a>
        ';

    include 'footer.php';
    exit();
}

include 'header.php';

include 'login.php';

include 'footer.php';
