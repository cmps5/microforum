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
    } else {
        foreach ($posts as $post) {
            $id_post = $post['id_post'];
            $id_user = $post['id_user'];
            $title = htmlspecialchars($post['title']);
            $content = nl2br(htmlspecialchars($post['content']));
            $post_date = date("F j, Y, g:i a", strtotime($post['post_date']));
            $user_name = htmlspecialchars($post['username']);
            $avatar = $post['avatar'] ? $post['avatar'] : 'default_avatar.jpg';

            echo '<div class="post">';
            echo '<img src="img/avatar/' . $avatar . '" alt="Avatar">';
            echo '<div class="post_content">';
            echo '<span class="post_user">' . $user_name . '</span>';
            echo '<span class="post_title">' . $title . '</span>';
            echo '<div class="post_text">' . $content . '</div>';
            echo '<div class="post_date">' . $post_date . '</div>';
            echo '</div>';
            echo '</div>';
        }
    }
} catch (PDOException $e) {
    echo '
        <div class="error">
            Error accessing the database.
        </div>
    ';
}

include 'footer.php';
