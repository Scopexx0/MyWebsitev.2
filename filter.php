<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Filter Logic

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
} elseif ($filter === 'all') {
    $sql;
} else {
// NOT RETURN ANYTHHING
    $sql = "SELECT * FROM Games WHERE game_name = :user_id";
}

$query = $dbh->prepare($sql);
$query->bindValue(':user_id', $_SESSION['user_id']);
$query->execute();
$games = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($games);


?>