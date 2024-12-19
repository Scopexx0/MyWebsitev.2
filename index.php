<?php 
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Index Logic (Validate Log in)

session_start();
require "userManager.php";

$auth = new UserManager();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LogIn</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="container">
        <div id="vertical">
            <div id="col">
                <?php if($auth->isNotLoggedIn()): ?>
                    <form action="login.php" method="post">
                        <input type="email" name="email" placeholder="Email" />
                        <input type="password" name="password" placeholder="Password" />
                        <button type="submit">Log In</button>
                    </form>
                    <p>New User? <a href="create.php">Register now</a></p>
            </div>
            <div id="col">
                <?php else: ?>
                    <h1>Main Page</h1>
                    <p>
                        <a href="backlog.php"><button>My Games</button></a>
                    </p>
                    <p>
                        <a href="logOut.php"><button>Logout</button></a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <input hidden type="checkbox" id="animation" />
    <label hidden style="color:#fff" for="animation">Show animation</label>
    <div class="matchOff" role="img" aria-label="A drawing of a match burning"></div>
</body>
</html>