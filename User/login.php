<?php
	session_start();

    if(isset($_SESSION['locked'])){
        $diff = time() - $_SESSION['locked'];
        if($diff > 10){
            unset($_SESSION['locked']);
            unset($_SESSION['attempts']);
            header('Location: login.php');
        }
    }
    if(!isset($_SESSION['attempts'])){
        $_SESSION['attempts'] = '0';
    }
    // echo "<script>alert(".$_SESSION['attempts'].")</script>";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <link rel = "icon" href ="../images/Logo1.png" type = "image/x-icon">
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="../Css/loginstyle.css" />
        <link rel="stylesheet" href="../Css/font-awesome.min.css" />
        <title>User Login</title>
    </head>
    <body>
        <div class="container">
            <form action="../includes/login.inc.php" method="POST" enctype="multipart/form-data" class="login active" id="form">
                <h1 class="title">User Login</h1>
                <?php
                    if(isset($_GET["error"])){
                        if($_GET["error"] == "emptyinput"){
                            echo "<div class='alert alert-danger text-center'><p> Fill in all fields!\n Login attempts: ".$_SESSION['attempts']."/3</p></div>";
                        }else if ($_GET["error"] == "wronglogin") {
                            echo "<div class='alert alert-danger text-center'><p> Incorrect Information! \n Login attempts: ".$_SESSION['attempts']."/3</p></div>";
                        }      
                    }
                ?>                
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email address" required/>
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" placeholder="Your Password" autocomplete="off" id="myInput" name="pwd" required/>
                        <span class="eye" onclick="myFunction()">
                            <i class="fa fa-eye" id="hide1"></i>
                            <i class="fa fa-eye-slash" id="hide2"></i>
                        </span>
                    </div>
                    <!-- <span class="help-text">At least 8 characters</span> -->
                </div>
                <?php 
                    if($_SESSION['attempts'] > 2){
                        $_SESSION['locked'] = time();
                ?>
                    <p id="time_int" style="text-align: justify;" class='alert alert-danger'></p>
                <?php
                    }else{
                ?>  
                <button type="submit" name="submit" class="btn-submit" style="font-size: 20px;">Login</button>
                <!-- <a href="#" style="margin-left: 35%">Forgot password?</a> -->
                <?php
                    }
                ?>
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
            
            var elem = document.getElementById('time_int');

            if(typeof(elem) != 'undefined' && elem != null){
                var counter = localStorage.getItem("time_left");
                counter = counter ? counter : 31 ;

                window.onbeforeunload = function() {
                    if (counter > 0) {
                        localStorage.setItem("time_left", counter);
                    }
                };
                var interval = setInterval(function() {
                    counter--;
                    if (counter != -1 && counter != null) {
                        document.getElementById("time_int").innerHTML = "Reached Login Attempts Limit! The email or password you typed is incorrect. Please contact the administrator for help . Wait for "+ counter + " seconds.";
                    } else{
                        localStorage.removeItem("time_left");
                        clearInterval(interval);
                        window.location.href = "login.php";                        
                    };
                }, 1000);
            }
        </script>
    </body>
</html>
