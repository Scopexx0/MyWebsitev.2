<?php 
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Update Games Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}

require 'dataBase.php';

date_default_timezone_set('America/Chicago');
$date = date("Y-m-d H:i:s");
if(!isset($_POST['status'])){
    header("Location: backlog.php");
    exit;
}

if($_POST['status'] === 'started_at'){
    $sql = 'UPDATE `Games` SET started_at = :date, status = :sts WHERE user_id = :user_id AND game_name = :game_name';
    $query = $dbh->prepare($sql);
    $query->bindValue(':date', $date);
    $query->bindValue(':sts', 'started');
} elseif($_POST['status'] === 'completed_at'){
    $sql = 'UPDATE `Games` SET completed_at = :date, status = :sts WHERE user_id = :user_id AND game_name = :game_name';
    $query = $dbh->prepare($sql);
    $query->bindValue(':date', $date);
    $query->bindValue(':sts', 'completed');
} else {
    echo"Error Found";
}

$query->bindValue(':user_id', $_SESSION['user_id']);
$query->bindValue(':game_name', $_POST["game"]);

try{
    $succeeded = $query->execute();
} catch (\PDOException $e)
{
    echo $e->getMessage();
}

if($succeeded){
    echo "Game Updated";
} else{
    echo "Error Found";
}

header("Location: backlog.php");

?>
