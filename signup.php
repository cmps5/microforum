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
