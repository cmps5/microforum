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

$id_user = $_SESSION['id_user'];
$id_post = isset($_POST['id_post']) ? (int)$_POST['id_post'] : -1;
$title =  trim($_POST['text_title']);
$content = trim($_POST['text_content']);

if ($title === "" || $content === "") {
    echo '
        <div class="error">
            All fields are required. Please fill in all fields.<br>
            <a href="editor_post.php">Try again</a>
        </div>
    ';
    include 'footer.php';
    exit();
}

include 'config.php';

$connection = new PDO("mysql:host=$host;dbname=$data_base;charset=utf8", $user, $db_password);

$date = date('Y-m-d H:i:s');

if ($id_post == -1) { // New post
    $sql = "INSERT INTO posts (id_user, title, content, post_date) VALUES (?, ?, ?, ?)";
    $engine = $connection->prepare($sql);
    $engine->execute([$id_user, $title, $content, $date]);
} else { // Edit post
    $sql = "SELECT id_user FROM posts WHERE id_post = ?";
    $engine = $connection->prepare($sql);
    $engine->execute([$id_post]);
    $post = $engine->fetch(PDO::FETCH_ASSOC);

    if (!$post || $post['id_user'] != $id_user) {
        echo '
            <div class="error">
                Permission denied.<br>
                <a href="forum.php">Go back to forum</a>
            </div>
        ';
        include 'footer.php';
        exit();
    }

    $sql = "UPDATE posts SET title = ?, content = ?, post_date = ? WHERE id_post = ?";
    $engine = $connection->prepare($sql);
    $engine->execute([$title, $content, $date, $id_post]);
}

$connection = null;

echo '
        <div class="success">
            Post saved successfully.<br>
            <a href="forum.php">Go back to forum</a>
        </div>
    ';

include 'footer.php';
