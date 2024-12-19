<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// DataBase Logic
// Directly connected to the database.
$databaseName = 'fa24_390_jfr';
$host = '127.0.0.1';
$dsn = "mysql:dbname=$databaseName;host=$host";
$user = 'fa24_390_jfr';
$password = 'wsM5ZP4x';
// Making an instance of a PDO object is how you connect to a database
try {
    $dbh = new PDO($dsn, $user, $password);
    
} catch (\PDOException $e) {
    echo "Unable to connect to database! Error: " . $e->getMessage();
    exit;
}