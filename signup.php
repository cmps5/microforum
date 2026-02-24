<?php

session_start();

include "header.php";

if (!isset($_POST['btn_signup'])) {
    DisplayForm();
} else {
    ResgisterUser();
}

include 'footer.php';

function DisplayForm()
{
    echo <<<HTML
    <form class="form_signup" method="POST" action="signup.php" enctype="multipart/form-data">

        <h3>Sign Up</h3>
        <hr>

        <p>To create a new account, please fill in the form below.</p>

        <label>Username:</label>
        <input type="text" id="text_user" name="text_user" placeholder="Enter your username" required>

        <label>Password:</label>
        <input type="password" id="text_password" name="text_password" placeholder="Enter your password" required>

        <label>Confirm Password:</label>
        <input type="password" id="text_password_confirm" name="text_password_confirm" placeholder="Confirm your password" required>

        <label> Avatar (optional):</label>
        <input type="file" id="file_avatar" name="file_avatar" accept=".jpg, .jpeg">

        <button type="submit" name="btn_signup" class="btn_signup">Sign Up</button>
        <a href="index.php">Back to Home</a>

    </form>
HTML;
}

function ResgisterUser()
{
    $username = trim($_POST['text_user']);
    $password = $_POST['text_password'];
    $password_confirm = $_POST['text_password_confirm'];
    $avatar = $_FILES['file_avatar'];

    $error = false;
    $maxSize = 50000;
    $avatarName = null;

    // Validate input fields
    if ($username === "" || $password === "" || $password_confirm === "") {
        echo "
            <div class='error'>
                All fields are required. Please fill in all fields.
            </div>
        ";
        $error = true;
    }
    // Validate password confirmation 
    else if ($password !== $password_confirm) {
        echo "
            <div class='error'>
                Passwords do not match. Please try again.
            </div>
        ";
        $error = true;
    }

    // Validate avatar file if provided
    if ($avatar['name'] != "") {
        $ext = strtolower(pathinfo($avatar['name'], PATHINFO_EXTENSION));

        if ($ext !== "jpg" && $ext !== "jpeg") {
            echo "
                <div class='error'>
                    Invalid avatar format. Only JPG and JPEG are allowed.
                </div>
            ";
            $error = true;
        } else if ($avatar['size'] > $maxSize) {
            echo "
                <div class='error'>
                    Avatar file size exceeds the maximum limit of 50KB.
                </div>
            ";
            $error = true;
        }
    }

    if ($error) {
        DisplayForm();
        return;
    }

    include "config.php";

    try {
        $connection = new PDO(
            "mysql:host=$host;dbname=$data_base;charset=utf8",
            $user,
            $db_password,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );

        // Check if username already exists
        $engine = $connection->prepare("SELECT * FROM users WHERE username = :username");
        $engine->bindParam(':username', $username);
        $engine->execute();

        if ($engine->rowCount() > 0) {
            echo "
            <div class='error'>
                Username already exists. Please choose a different username.
            </div>
        ";
            DisplayForm();
            return;
        }

        // Handle avatar upload if provided

        $dir = 'img/avatar/';

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        if ($avatar['name'] != "") {
            $avatarName = uniqid() . ".jpg";
            move_uploaded_file($avatar['tmp_name'], 'img/avatar/' . $avatarName);
        }

        // Hash the password before storing it in the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $sql = "INSERT INTO users (username, password, avatar) VALUES (:username, :password, :avatar)";
        $engine = $connection->prepare($sql);
        $engine->bindParam(':username', $username);
        $engine->bindParam(':password', $hashedPassword);
        $engine->bindParam(':avatar', $avatarName);
        $engine->execute();

        $connection = null;

        echo "
        <div class='success'>
            Welcome to the forum, <strong>'$username'</strong>!<br><br>
            You can now <a href='index.php'>log in</a> to your account.
        </div>
        ";
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
}
