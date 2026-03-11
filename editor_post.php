<?php

session_start();

if (!isset($_SESSION['user'])) {
    include 'header.php';
    echo '
        <div class="error">
            Permission denied.<br>
            <a href="index.php">Go back to login</a>
        </div>
    ';
    include 'footer.php';
    exit();
}

include 'header.php';

$pid = -1;
$editor = false;
$title = "";
$content = "";

if (isset($_GET['pid']) && is_numeric($_GET['pid'])) {
    $pid = (int)$_GET['pid'];
    $editor = true;

    include 'config.php';

    $connection = new PDO("mysql:host=$host;dbname=$data_base;charset=utf8", $user, $db_password);

    $sql = "SELECT id_user, title, content FROM posts WHERE id_post = ?";

    $engine = $connection->prepare($sql);

    $engine->execute([$pid]);

    $data = $engine->fetch(PDO::FETCH_ASSOC);

    if (!$data) {
        echo '
            <div class="error">
                Post not found.<br>
            </div>
        ';
        include 'footer.php';
        exit();
    }

    if ($data['id_user'] != $_SESSION['id_user']) {
        echo '
            <div class="error">
                Permission denied.<br>
            </div>
        ';
        include 'footer.php';
        exit();
    }

    $title = $data['title'];
    $content = $data['content'];

    $connection = null;
}

// user data
$sessionAvatar = $_SESSION['avatar'] ? $_SESSION['avatar'] : 'default_avatar.jpg';
$sessionUser = htmlspecialchars($_SESSION['user']);

echo '
    <div class="user_data">
        <img src="img/avatar/' . $sessionAvatar . '" alt="Avatar">
        <span class="username">' . $sessionUser . '</span> | 
        <a href="logout.php">Logout</a>
    </div>
';

echo '
    <form class="post_form" action="add_post.php" method="POST">
        <h3>Post</h3><hr><br>

        <input type="hidden" name="pid" value="' . $pid . '">
        
        <label for="title">Title:</label><br>
        <input type="text"  name="text_title" value="' . htmlspecialchars($title) . '" size="80" required><br><br>
        
        <label for="content">Content:</label><br>
        <textarea name="text_content" rows="10"  cols="80" required>' . htmlspecialchars($content) . '</textarea><br><br>

        <input type="submit" value="Save Post"><br><br>

        <a href="forum.php">Cancel</a>
    </form>
';

include 'config.php';
