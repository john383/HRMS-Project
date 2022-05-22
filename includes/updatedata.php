<?php
    include("connection.inc.php");
    if(isset($_POST['edit_id'])){
        $id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $empid = mysqli_real_escape_string($conn, $_POST['empId']);
        $biometric =  mysqli_real_escape_string($conn,$_POST['bioId']);	
        $position = mysqli_real_escape_string($conn, $_POST['selectposition']);
        $department = mysqli_real_escape_string($conn, $_POST['selectdepartment']);
        $schedule = mysqli_real_escape_string($conn, $_POST['selectschedule']);
        $dateemployed = mysqli_real_escape_string($conn, $_POST['dateemployed']);
        $employ_type = mysqli_real_escape_string($conn, $_POST['employment_type']);
        $status = mysqli_real_escape_string($conn, $_POST['statusupdate']);
        $date = date('Y-m-d');
        $year = date('Y');
    
        $sql = "SELECT * FROM employees WHERE empId = '$empId'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($result);
        if($row['positionid'] != $position || $row['deptid'] != $department || $row['employment_type'] != $employ_type){

            $query2 = "SELECT * FROM leave_type WHERE deptId = '$department' AND employment_type = '$employ_type'";
            $res_query2 = mysqli_query($conn, $query2);
            
            $query3 = "UPDATE emp_annual_leave SET annual_leave_status = 'Inactive' WHERE empId = '$empid'";
            $res_query3 = mysqli_query($conn, $query3);

            while($res_row = mysqli_fetch_array($res_query2)){
                $leaveid = $res_row['LeaveId'];
                $leaveHrs = $res_row['default_hours'];

				$query4 = "INSERT INTO emp_annual_leave (empId, leaveId, year_number, allowed_hours, remaining_hours) VALUES('$empid', '$leaveid', '$year', '$leaveHrs', '$leaveHrs')";
				$res_query4 = mysqli_query($conn, $query4);
            }
        }

        $updatesql = "UPDATE employees SET empId = ?, bioId = ?, deptid = ?, positionid = ?, scheduleid = ?, employedDate = ?, employment_type = ?, update_action = ?, status = ? WHERE empId = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $updatesql)){
            echo "<script>alert('SQL Error!')</script>";
            header('location: personnel.php?error=stmtfailed');
            exit(0);
        }else{
            mysqli_stmt_bind_param($stmt, "siiiissssi", $empid, $biometric,  $department, $position, $schedule, $dateemployed, $employ_type, $date, $status, $id);
            mysqli_stmt_execute($stmt);
        
            echo "<script>alert('Successfully Updated!') window.location.href = '../Admin/personnel.php'</script>";
        }
    }
?>
<?php
    if(isset($_POST['employee_id'])){
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $adminemail = mysqli_real_escape_string($conn, $_POST['adminemail']);
        $resetpassword = mysqli_real_escape_string($conn, $_POST['resetpassword']);
		$hashedPwd = password_hash($employee_id, PASSWORD_DEFAULT);

        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            return false;
        }else{
            mysqli_stmt_bind_param($stmt, "s", $adminemail);
            mysqli_stmt_execute($stmt);

            $resultdata = mysqli_stmt_get_result($stmt);
            if($row = mysqli_fetch_assoc($resultdata)){
                $pwdHashed = $row["password"];
                $checkPwd = password_verify($resetpassword, $pwdHashed);

                if($checkPwd === false){
                    echo "<script>alert('Failed to Reset Password')</script>";
                    return false;
        
                }else if($checkPwd === true){

                    $sql2 = "UPDATE employees SET password = ? WHERE empId = ?";
                    $stmt1 = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt1, $sql2)){
                        return false;
                    }else{
                        mysqli_stmt_bind_param($stmt1, "ss", $hashedPwd, $employee_id);
                        mysqli_stmt_execute($stmt1);

                        mysqli_stmt_close($stmt1);
                        return true;

                    }
                }
            }else{
                return false;
            }
        }
    }
?>


