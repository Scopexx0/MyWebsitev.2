<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Backlog Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}

require 'dataBase.php';

// Filter the games.
$filter = $_POST['filter'] ?? 'all'; // Default to 'all'
$sql = "SELECT * FROM Games WHERE user_id = :user_id";

if ($filter === 'started') {
    $sql .= " AND status = 'started'";
} elseif ($filter === 'completed') {
    $sql .= " AND status = 'completed'";
}

$query = $dbh->prepare($sql);
$query->bindValue(':user_id', $_SESSION['user_id']);
$query->execute();
$games = $query->fetchAll(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Games</title>
    <link rel="stylesheet" href="style.css">
    <script src="addGame.js"></script>
</head>
<body>
    <div id="container">
        <div id="col">
            <div id="top_backlog">
                <h2>Game Backlog</h2>
                <!-- Form to filter -->
                <form id="filter_form" method="" action="">
                    <select id="filterSelect" name="filter">
                        <option value="all" <?php if ($filter === 'all') echo 'selected'; ?>>All Games</option>
                        <option value="started" <?php if ($filter === 'started') echo 'selected'; ?>>Started Games</option>
                        <option value="completed" <?php if ($filter === 'completed') echo 'selected'; ?>>Completed Games</option>
                    </select>
                </form>
            </div>

            <div id="cards">
                <div id="gamesContainer">
                <!-- Games here from JS -->
                </div>
            </div>

        </div>

        <div id="col" class="sticky-col">
            <div id="creategame_box">
                <div id="create_game">
                    <h3>Create Game</h3>
                    <!-- Form to Create Game -->
                    <form id="createGameForm" action="" method="">
                        <input id="createInput" type="text" name="gameName" placeholder="Enter Game Name" />
                        <p>
                            <input id='radio_input' type="radio" name="gamePlat" value="PC" /> PC<br>
                            <input id='radio_input' type="radio" name="gamePlat" value="PS" /> PS<br>
                            <input id='radio_input' type="radio" name="gamePlat" value="Xbox" /> Xbox<br>
                            <input id='radio_input' type="radio" name="gamePlat" value="Switch" /> Switch<br>
                            <input id='radio_input' type="radio" name="gamePlat" value="VR" /> VR<br>
                        </p>
                    </form>
                </div>
                <p>
                    <button id="createGameBtn" type="">Create game</button>
                </p>
                <p>
                    <a href="index.php"><button>Menu</button></a>
                </p>
            </div>
        </div>
    </div>
    <input hidden type="checkbox" id="animation" />
    <label hidden style="color:#fff" for="animation">Show animation</label>
    <div class="match" role="img" aria-label="A drawing of a match burning"></div>
</body>
</html>