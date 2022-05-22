<?php 
    if(isset($_POST["submit"])){
        $userEmail = $_POST["email"];
        $pwd = $_POST["pwd"];

        require_once '../includes/connection.inc.php';
        require_once '../includes/functions.inc.php';

        if(emptyInputLogin($userEmail, $pwd) !==false){
            header("location: login.php?error=emptyinput");
            exit(0);
        }

        loginAdmin($conn, $userEmail, $pwd);
    }else{
        header("location: login.php");
        exit(0);
    }