<?php

    $fname = "";
    $lname = "";
    $email = "";
    $pass = "";
    $file = "";
    
    include 'connection.inc.php';
    if(isset($_POST['submit'])){
        $uploadOk = true;
        $file = $_FILES['img']['name'];
        $file_tmp = $_FILES['img']['tmp_name'];
        $imageFileType = $_FILES['img']['type'];

        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = $_POST['lname'];
        $email = $_POST['email'];
        $pass = $_POST['pass'];  
            
        $location = "../Uploads/";


        //Allow file formats
        if($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg"){
            echo "<script> alert('Sorry, only JPG, JPEG, & PNG files are allowed.')</script>";
            $uploadOk = false;
        }
    
        if ($uploadOk == false) {
            echo "<script> alert('Sorry, your product was not updated.')</script>";
        // if everything is ok, try to upload file
        }else{
            $sql = "INSERT INTO admin (fName, lName, email, password, photo) VALUES (?, ?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "<script>alert('SQL Error!')</script>
                header('location: asd.php?error=stmtfailed');
                exit();";
            }else{
                $hashedPwd = password_hash($pass, PASSWORD_DEFAULT);
                mysqli_stmt_bind_param($stmt, "sssss", $fname, $lname, $email, $hashedPwd, $file);
                mysqli_stmt_execute($stmt);
                move_uploaded_file($file_tmp, $location.$file);
                echo '<script>alert("Data Saved Successfully");</script>';
                echo'<script>   
                    window.location.href = "../asd.php"</script>';
            }
        }
    }      