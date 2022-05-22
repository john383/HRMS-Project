<?php
	session_start();

    if(isset($_SESSION['admin_locked'])){
        $diff = time() - $_SESSION['admin_locked'];
        if($diff > 10){
            unset($_SESSION['admin_locked']);
            unset($_SESSION['admin_attempts']);
            header('Location: login.php');
        }
    }
    if(!isset($_SESSION['admin_attempts'])){
        $_SESSION['admin_attempts'] = '0';
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel = "icon" href ="../images/Logo1.png" type = "image/x-icon">
        <link rel="stylesheet" href="../Css/loginstyle.css" />
        <link rel="stylesheet" href="../Css/font-awesome.min.css" />
        <title>Admin Login</title>
    </head>
    <body>
        <div class="container">
            <form action="login.inc.php" method="POST" class="login active">
                <h1 class="title">Admin Login</h1>
                <?php
                    if(isset($_GET["error"])){
                        if($_GET["error"] == "emptyinput"){
                            echo "<div class='alert alert-danger text-center'><p> Fill in all fields! \n Login attempts: ".$_SESSION['admin_attempts']."/3</p></div>";
                        }else if ($_GET["error"] == "wronglogin") {
                            echo "<div class='alert alert-danger text-center'><p> Incorrect Information! \n Login attempts: ".$_SESSION['admin_attempts']."/3</p></div>";
                        }      
                    }
                ?>                
                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <input type="email" name="email" placeholder="Email address" />
                        <i class="fa fa-envelope"></i>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-group">
                        <input type="password" placeholder="Your Password" id="myInput" name="pwd" />
                        <span class="eye" onclick="myFunction()">
                            <i class="fa fa-eye" id="hide1"></i>
                            <i class="fa fa-eye-slash" id="hide2"></i>
                        </span>
                    </div>
                </div>
                <?php 
                    if($_SESSION['admin_attempts'] > 2){
                        $_SESSION['admin_locked'] = time();
                ?>
                    <p id="time_int" style="text-align: justify;" class='alert alert-danger'></p>
                <?php
                    }else{
                ?>  
                <button type="submit" name="submit" class="btn-submit" style="font-size: 20px;">Login</button>
                <a href="resetpass.php" style="margin-left: 35%; text-decoration: none; color: #000;">Forgot password?</a>
                <?php
                    }
                ?>
            </form>
        </div>

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
                var timeLeft = 10;
                var elem = document.getElementById('time_int');
                var timerId = setInterval(countdown, 1000);
                
                countdown()
            }
            function countdown() {
                if (timeLeft == -1) {
                    clearInterval(timerId);
                            
                    window.location.href='login.php';
                } else {
                    elem.innerHTML = 'Reached Login Attempts Limit! The username or password you typed is incorrect. Wait for ' + timeLeft + ' seconds.';
                    timeLeft--;
                    // localStorage.setItem('count_timer', timeLeft);
                }
            }
        </script>
    </body>
</html>
