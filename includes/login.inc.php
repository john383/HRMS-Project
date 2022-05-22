<?php 
    if(isset($_POST["submit"])){
        $userEmail = $_POST["email"];
        $pwd = $_POST["pwd"];

        require_once 'connection.inc.php';
        require_once 'functions.inc.php';

        if(emptyInputLogin($userEmail, $pwd) !==false){
            header("location: ../user/login.php?error=emptyinput");
            exit();
        }

        loginUser($conn, $userEmail, $pwd);
    }else{
        header("location: ../user/login.php");
        exit();
    }