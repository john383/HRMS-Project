<?php
    $servername = "localhost";
    $dbUsername = "root";
    $password = "";
    $dbname = "hrms";

    $conn = mysqli_connect($servername, $dbUsername, $password, $dbname);

    if(!$conn){
        die("Connection Failed: ".mysqli_connect_error());
    }
