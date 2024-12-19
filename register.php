<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Register User Logic

session_start();
require "userManager.php";

// Create an instance of the UserAuthenticator
$auth = new UserManager();
// Validate Credentials
if ($auth->isNotLoggedIn()) {
    $auth->redirectLogin();
}
require_once "userManager.php";

$auth = new UserManager();
$auth->createUserCredentials();
?>