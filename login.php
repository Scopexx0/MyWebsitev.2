<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Log In Logic

require "userManager.php";

$auth = new UserManager();
$auth->validateUserCredentials();
$auth->redirectLogin();
?>