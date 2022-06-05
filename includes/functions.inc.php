<?php
    function emptyInputLogin($userEmail, $pwd){
        $result;
        if(empty($userEmail) || empty($pwd)){
            $result = true;
        }else{
            $result = false;
        }
        return $result;
    }
    //user side
    function userEmailExists($conn, $userEmail){
        $sql = "SELECT * FROM employees WHERE emailadd = ? AND status = 'Active'";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../user/login.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }else{
            $result = false;
            return $result;
        }
    
        mysqli_stmt_close($stmt);
    }
    function loginUser($conn, $userEmail, $pwd){
        $userEmailExists = userEmailExists($conn, $userEmail);
        session_start();

        if($userEmailExists === false){
            $_SESSION['attempts'] += 1;
            header("location: ../User/login.php?error=wronglogin");
            exit();
        }
    
        $pwdHashed = $userEmailExists["password"];
        $checkPwd = password_verify($pwd, $pwdHashed);
        if($checkPwd === false){
            $_SESSION['attempts'] += 1;
            header("location: ../User/login.php?error=wronglogin");
            exit();

        }else if($checkPwd === true){
            $_SESSION["email"] = $userEmailExists["emailadd"];
            $_SESSION["empId"] = $userEmailExists["empId"];
            unset($_SESSION['attempts']);
            header("location: ../User/leave.php");
            exit();
        }
    }

    //user side
    function adminEmailExists($conn, $userEmail){
        $sql = "SELECT * FROM admin WHERE email = ? ";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            header("location: ../admin/login.php?error=stmtfailed");
            exit();
        }
        mysqli_stmt_bind_param($stmt, "s", $userEmail);
        mysqli_stmt_execute($stmt);
    
        $resultData = mysqli_stmt_get_result($stmt);
    
        if($row = mysqli_fetch_assoc($resultData)){
            return $row;
        }else{
            $result = false;
            return $result;
        }
    
        mysqli_stmt_close($stmt);
    }
    function loginAdmin($conn, $userEmail, $pwd){
        $adminEmailExists = adminEmailExists($conn, $userEmail);
        session_start();
        if($adminEmailExists === false){
            $_SESSION['admin_attempts'] += 1;
            header("location: ../admin/login.php?error=wronglogin");
            exit();
        }
    
        $pwdHashed = $adminEmailExists["password"];
        $checkPwd = password_verify($pwd, $pwdHashed);
    
        if($checkPwd === false){
            $_SESSION['admin_attempts'] += 1;
            header("location: ../Admin/login.php?error=wronglogin");
            exit();

        }else if($checkPwd === true){
            $_SESSION["adminId"] = $adminEmailExists["adminId"];
            $_SESSION["adminemail"] = $adminEmailExists["email"];
            unset($_SESSION['admin_attempts']);

    
            header("location: index.php");
            exit();
        }
    }    
    