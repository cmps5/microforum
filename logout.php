<?php

session_start();

include 'header.php';

if (isset($_SESSION['user'])) {
    $message = "You have been logged out successfully.";
} else {
    $message = "page not available.";
}

// Clear all session data
$_SESSION = [];

//Clear the session cookie
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Destroy the session
session_destroy();


echo '
    <div class="success">
        ' . $message . '<br>
        <a href="index.php">Go back to login</a>
    </div>
';

include 'footer.php';
