<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Select Games Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}

require 'dataBase.php';

// Display all the user's games.
$sql = "SELECT * FROM `Games` WHERE user_id = :user_id";

$query = $dbh->prepare($sql);
$query->bindValue(':user_id', $_SESSION['user_id']);

$succeeded = $query->execute();

$games = $query->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($games);

?>