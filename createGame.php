<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Create Games Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();

if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}

if ($_SESSION['user_id'] === NULL){
    echo "the user id is null";
    exit;
}

require "dataBase.php";

date_default_timezone_set('America/Chicago');
$date = date("Y-m-d H:i:s");

if($_POST['gameName'] == NULL){
    echo "Cannot Add Game (Invalid Name)";
    exit;
}

// Create a new game.
$sql = "INSERT INTO `Games` (user_id, game_name, game_platform, status, date_created) VALUES (:user_id, :game_name, :game_plat, :status, :created_at)";

$query = $dbh->prepare($sql);
$query->bindValue(':user_id', $_SESSION['user_id']);
$query->bindValue(':game_name', $_POST['gameName']);
$query->bindValue(':game_plat', $_POST['gamePlat'] ?? 'PC');
$query->bindValue(':status', $_POST['status'] ?? 'pending');
$query->bindValue(':created_at', $date);

try{
    $succeeded = $query->execute();
} catch (\PDOException $e)
{ 
    echo $e->getMessage();
}

// Retrieve the same inserted data using a SELECT query
$selectSql = "SELECT * FROM Games WHERE user_id = :user_id ORDER BY id DESC LIMIT 1";
$selectQuery = $dbh->prepare($selectSql);
$selectQuery->bindValue(':user_id', $_SESSION['user_id']);
$selectQuery->execute();

// Fetch the last inserted game
$newGame = $selectQuery->fetch(PDO::FETCH_ASSOC);

// Return the new game as JSON (for AJAX to handle)
header('Content-Type: application/json');
echo json_encode($newGame);
?>