<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// Log Out Logic

session_start();
require "userManager.php";

$auth = new UserManager();

$auth->logOut();
$auth->redirectLogin();

?>