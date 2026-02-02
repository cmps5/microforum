<?php

echo <<<HTML
    <form class="form_login" method="POST" action="login_verificacao.php">

        <h3>Login</h3>
        <hr>

        <p>To enter the forum, you need to enter your username and password.<br>
        If you do not have an account, you can create a <a href="signup.php">new user account</a>.</p>

        <label for="text_user">Username:</label>
        <input type="text" id="text_user" name="text_user" placeholder="Enter your username" required>

        <label for="text_password">Password:</label>
        <input type="password" id="text_password" name="text_password" placeholder="Enter your password" required>

        <button type="submit" class="btn_login">Login</button>

    </form>
HTML;
