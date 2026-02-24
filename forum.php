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

//user data
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
 <div class="new_post">
    <a href="editor_post.php">New Post</a>
</div>
';

include 'config.php';

try {
    $connection = new PDO(
        "mysql:host=$host;dbname=$data_base;charset=utf8",
        $user,
        $db_password,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    // Fetch posts
    $sql = "SELECT
                posts.id_post,	 	 	 	 	
                posts.id_user,
                posts.title,
                posts.content,
                posts.post_date,
                users.username,
                users.avatar
            FROM posts
            INNER JOIN users ON posts.id_user = users.id_user
            ORDER BY posts.post_date DESC
    ";

    $engine = $connection->prepare($sql);
    $engine->execute();

    $posts = $engine->fetchAll(PDO::FETCH_ASSOC);

    if (!$posts) {
        echo '
            <div class="message"><p>
                No posts found.
            </div>
        ';
    }
} catch (PDOException $e) {
    
}
