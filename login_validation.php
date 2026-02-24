<?php

session_start();

if (isset($_SESSION['user'])) {
    include 'header.php';
    echo '
        <div class="message">
            You are already logged in.
            <a href="forum.php">Go to Forum</a>
        </div>
    ';
    include 'footer.php';
    exit();
}

include 'header.php';

if (empty($_POST['username']) || empty($_POST['password'])) {
    echo '
        <div class="error">
            Please fill in all fields.
            <a href="index.php">Go back to login</a>
        </div>
    ';
    include 'footer.php';
    exit();
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

include 'config.php';

try {
    $connection = new PDO(
        "mysql:host=$host;dbname=$data_base;charset=utf8",
        $user,
        $db_password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    $engine = $connection->prepare("SELECT id_user,username,password, avatar FROM users WHERE username = :username");
    $engine->bindParam(':username', $username);
    $engine->execute();

    $user_data = $engine->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo '
        <div class="error">
            Database error connecting to the database.<br>
            Go back to <a href="index.php">login</a>.
        </div>
    ';
    include 'footer.php';
    exit();
}

// Verify the password
if (!$user_data || !password_verify($password, $user_data['password'])) {
    echo '
        <div class="error">
            Invalid username or password.<br>
            Go back to <a href="index.php">login</a> and try again.
        </div>
    ';
    include 'footer.php';
    exit();
}

// Set session variables
$_SESSION['id_user'] = $user_data['id_user'];
$_SESSION['user'] = $user_data['username'];
$_SESSION['avatar'] = $user_data['avatar'];

echo '
    <div class="success">
        Welcome, <strong>' . $user_data['username'] . '.<br><br>
        <a href="forum.php">Go to Forum</a>
    </div>
';

include 'footer.php';   
