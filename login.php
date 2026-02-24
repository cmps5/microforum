<?php

echo <<<HTML
    <form class="form_login" method="POST" action="login_validation.php">

        <h3>Login</h3>
        <hr>

        <p>To enter the forum, you need to enter your username and password.<br>
        If you do not have an account, you can create a <a href="signup.php">new user account</a>.</p>

        <label for="username">Username:</label>
        <input type="text" id="username" name="username" placeholder="Enter your username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>

        <button type="submit" class="btn_login">Login</button>

    </form>
HTML;
