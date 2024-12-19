<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Create User (View)
session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if (!$auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
        <div id="vertical">
            <div id="col">
                <form action="register.php" method="post">
                    <input type="text" name="user" placeholder="User Name" />
                    <input type="email" name="email" placeholder="Email" />
                    <input type="password" name="password" placeholder="Password" />
                    <button type="submit">Register</button>
                </form>
                <p>Already Registered? <a href="index.php">Log In</a></p>
            </div>
        </div>
    </div>
    <input hidden type="checkbox" id="animation" />
    <label hidden style="color:#fff" for="animation">Show animation</label>
    <div class="matchOff" role="img" aria-label="A drawing of a match burning"></div>
</body>
</html>