<?php
// CSC 390 Final Project
// Jeronimo Augurusa Franco
// UserManager Logic
// session_start();
// namespace UserManagement;
// User manager with functions to create, edit, and log in users

class UserManager {
    public $userId;
    private $userName;
    private $userEmail;
    private $userPassword;

    public function isNotLoggedIn(){
        if(empty($_SESSION['name'])){
            return TRUE;
        } else{
            return $_SESSION['name'] === $this->userEmail;
        }
    }

    public function validateUserCredentials(){
        require "dataBase.php";
        $this->userEmail = $_POST['email'];
        var_dump($this->userEmail);
        $this->userPassword = $_POST['password'];
        var_dump($this->userPassword);
        // Validate email and passwords and later save the user id.
        $sql = "SELECT id, password FROM `Users` WHERE email = :userEmail";

        // Set the values for the placeholders
        $query = $dbh->prepare($sql);
        $query->bindValue(':userEmail', $this->userEmail);
        $succeeded = $query->execute();

        // Validation of the credentials
        if($succeeded && $row = $query->fetch(PDO::FETCH_ASSOC)){
            $db_pswd = $row['password'];
            $this->userId = $row['id'];

            if(password_verify($this->userPassword, $db_pswd)){
                session_start();
                $_SESSION['name'] = $this->userEmail;
                $_SESSION['user_id'] = $this->userId;
                var_dump($_SESSION);
                var_dump($this->userEmail);
                echo 'Loged in';
                return true;
            } else {
                echo 'Incorrect';
                return false;
            }
        } else {
            echo 'User not found';
            return false;
        }
    }

    public function createUserCredentials(){
        require "dataBase.php";
        $this->userName = $_POST['user'];
        $this->userEmail = $_POST['email'];
        $this->userPassword = $_POST['password'];
        // Check if user already exists.
        try{
            if($this->checkifAlreadyExists()){
                echo "User or email already in use";
                return;
            }
        } catch(\PDOException $e){
            echo $e->getMessage();
        }
    
        // Hash the password
        $userPassword = password_hash($this->userPassword, PASSWORD_DEFAULT);
    
        // Create a new user
        $sql = " INSERT INTO `Users` (username, email, password) VALUES (:username, :email, :userpassword)";
    
        // Set the values for the placeholders
        $query = $dbh->prepare($sql);
        $query->bindValue(':username', $this->userName);
        $query->bindValue(':email', $this->userEmail);
        $query->bindValue(':userpassword', $userPassword);
    
        try{
            // // Actually run the query
            $succeeded = $query->execute();
    
        } catch(\PDOException $e){
            echo $e->getMessage();
        }
    
        if ($succeeded) {
            header("Location: index.php");
        } else {
            echo "Sorry, there was an error, please try again";
        }
    
    }

    public function updateUserCredentials(){
        require "dataBase.php";
        $this->userName = $_POST['user'];
        $this->userEmail = $_POST['email'];
        $this->userPassword = $_POST['password'];
        // Hash the password
        $userPassword = password_hash($userPassword, PASSWORD_DEFAULT);
    
        // Update the user password
        $sql = "UPDATE `Users` SET password = :password WHERE email = :email";
    
        // Set the values for the placeholders
        $query = $dbh->prepare($sql);
        $query->bindValue(':email', $userEmail);
        $query->bindValue(':password', $userPassword);
    
        // Actually run the query
        $succeeded = $query->execute();
    
        if ($succeeded) {
            echo "Done! Updated to: $userName!";
        } else {
            echo "Sorry, there was an error, please try again";
        }
    }

    private function checkifAlreadyExists(){
        require "dataBase.php";
        $this->userName = $_POST['user'];
        $this->userEmail = $_POST['email'];
        $this->userPassword = $_POST['password'];
        // Select values from the table
        $sql = "SELECT username, email FROM `Users` WHERE username = :name OR email = :email";
    
        // Set the values for the placeholders
        $query = $dbh->prepare($sql);
        $query->bindValue(':name', $this->userName);
        $query->bindValue(':email', $this->userEmail);
    
        $succeeded = $query->execute();
    
        if($succeeded) {
            if ($query->rowCount() > 0) {
                return true;
            } else{
                return false;
            }
        } else {
            return false;
        }
    }

    public function redirectLogin(){
        header("Location: index.php");
        return;
    }

    public function logOut(){
        unset($_SESSION['name']);
        unset($_SESSION['user_id']);
        session_destroy();
        session_regenerate_id(true);
        return;
    }
}
?>