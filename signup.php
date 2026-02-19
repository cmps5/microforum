<?php

session_start();

include "header.php";

if (!isset($_POST['btn_signup'])) {
    DisplayForm();
} else {
    ResgisterUser();
}

function DisplayForm()
{
    echo <<<HTML
    <form class="form_signup" method="POST" action="signup.php" enctype="multipart/form-data">

        <h3>Sign Up</h3>
        <hr>

        <p>To create a new account, please fill in the form below.</p>

        <label>Username:</label>
        <input type="text" id="text_user" name="text_user" required>

        <label>Password:</label>
        <input type="password" id="text_password" name="text_password" required>

        <label>Confirm Password:</label>
        <input type="password" id="text_password_confirm" name="text_password_confirm" required>

        <label> Avaatar (optional):</label>
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
    $avatarPath = null;

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
}
