<?php
    include("connection.inc.php");
    if(isset($_POST['id_leavetype'])){
        echo "<script>alert('Posted')</script>";
            $LeaveId = mysqli_real_escape_string($conn, $_POST['id_leavetype']);
            $leaveName = mysqli_real_escape_string($conn, $_POST['leaveName']);
            $Description = mysqli_real_escape_string($conn, $_POST['Description']);
            $def_hrs = mysqli_real_escape_string($conn, $_POST['default_hrs']);
        
            $updatesql = "UPDATE leave_type SET  leaveCode = ?, leave_name = ?, default_hours = ?  WHERE LeaveId = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $updatesql)){
                echo "<script>alert('SQL Error!');
                header('location: leave_type.php?error=stmtfailed');</script>";
            }else{
                mysqli_stmt_bind_param($stmt, "ssii", $leaveName, $Description, $def_hrs, $LeaveId);
                mysqli_stmt_execute($stmt);

                $updatesql = "UPDATE emp_annual_leave SET  allowed_hours = ".$def_hrs."  WHERE leaveId = ".$LeaveId." AND annual_leave_status = 'Active'";
                $res_update = mysqli_query($conn, $updatesql);
                echo "<script> alert('Data Successfully Updated');
                      window.location.href = 'leave_type.php';</script>";
            }
    }else{
        echo "<script>alert('Failed')</script>";
    }