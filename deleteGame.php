<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Delete Game Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}

session_start();
require 'dataBase.php';

$sql = "DELETE FROM `Games` WHERE user_id = :user_id AND game_name = :game_name";

$query = $dbh->prepare($sql);
$query->bindValue(':user_id', $_SESSION['user_id']);
$query->bindValue(':game_name', $_POST['game']);

$succeeded = $query->execute();

if($succeeded){
    header('Location: backlog.php');
} else{
    echo "Error Found";
    exit;
}

?>