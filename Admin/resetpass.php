<?php
    include '../includes/connection.inc.php';
    $email="";
	$emailErr = "";
    if(isset($_POST['submit'])){
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $pass = 'Lccladmin';
        $hash = password_hash($pass, PASSWORD_DEFAULT);
		$error = false;

        if (empty($email)) {
            $emailErr = "Email is required";
            $error = true;
        }else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $emailErr = "Invalid email format";
            $error = true;
        }else{
            $sql = "SELECT * FROM admin WHERE email='$email'";
            $res = mysqli_query($conn, $sql);
          
            if(mysqli_num_rows($res) > 0){
                $email_sql = "UPDATE admin SET password = '$hash' WHERE email='$email'"; 
                    $admin_res = mysqli_query($conn, $email_sql);
                echo "<script>alert('Password Reset Successfully')
                        window.location.href='login.php'</script>";
                exit();
            }else{
                echo "<script>alert('Email Address not found!')
                window.location.href='resetpass.php?error=true'</script>";
            }
        }
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../Css/loginstyle.css" />
        <link rel="stylesheet" href="../Css/font-awesome.min.css" />
        <title>Reset Password</title>
    </head>
    <body>
        <div class="container">
            <form action="" method="POST" class="login active">
                <h1 class="title">Reset Password</h1>
                <?php
                    if(isset($_GET["error"])){
                        if($_GET["error"] == "emptyinput"){
                            echo "<div class='alert alert-danger text-center'><p> Fill in all fields!</p></div>";
                        }else if ($_GET["error"] == "wronglogin") {
                            echo "<div class='alert alert-danger text-center'><p> Incorrect Information!</p></div>";
                        }      
                    }
                ?>                
                <div class="form-group">
                    <label for="email">Email: </label>
                    <div class="input-group" >
                        <input type="email" name="email" placeholder="Email address" value="<?php echo $email?>"/>
                        <i class="fa fa-envelope"></i>
                    </div>
                    <span class="form-error" style="color: red;"><?php echo $emailErr;?></span>
                </div>
                <button type="submit" name="submit" class="btn-submit" style="margin-top: 20px; font-size: 15px;">Reset Password</button>
                <a href="login.php" style="text-decoration: none; color: black; ">Back</a>
            </form>
        </div>

        <!-- <script src="Js/script.js"></script> -->
        <script>
            function myFunction() {
                var x = document.getElementById("myInput");
                var y = document.getElementById("hide1");
                var z = document.getElementById("hide2");
                
                if (x.type === "password") {
                    x.type = "text";
                    y.style.display = "block";
                    z.style.display = "none";
                } else {
                    x.type = "password";
                    y.style.display = "none";
                    z.style.display = "block";
                }
            }
        </script>
    </body>
</html>
