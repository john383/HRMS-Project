<?php
	date_default_timezone_set('Asia/Manila');

    include("connection.inc.php");

    if(isset($_POST['edit_id'])){
        $id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $reason = mysqli_real_escape_string($conn, $_POST['reason']);
        $status = mysqli_real_escape_string($conn, $_POST['update_stat']);
            
        $updatesql2 = "UPDATE leave_taken SET leave_reason = ?, leave_status = ? WHERE period_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $updatesql2)){
            echo "<script>alert('SQL Error!')
            window.location.href='../Admin/manage_leaves.php?error=stmtfailed'</script>";
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "ssi", $reason, $status, $id);
            mysqli_stmt_execute($stmt);
        }
    }
?>

<?php
    if(isset($_POST['editleave_id'])){
        $id = mysqli_real_escape_string($conn, $_POST['editleave_id']);
        $update_stat = mysqli_real_escape_string($conn, $_POST['update_stat']);
        $remarks = mysqli_real_escape_string($conn, $_POST['leaveremark']);
        $leaveId = mysqli_real_escape_string($conn, $_POST['leaveId']);
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $hrs_taken = mysqli_real_escape_string($conn, $_POST['hrs_taken']);

        $sql = "SELECT * FROM emp_annual_leave WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
        $result = mysqli_query($conn, $sql);
        $update_empleave_row = mysqli_fetch_array($result);
        $remaining_hrs = $update_empleave_row['remaining_hours'] - $hrs_taken;
        $date_now = date('Y-m-d H:i:s');

        if($update_stat == 'Approved'){
            
            $updatesql1 = "UPDATE leave_taken SET leave_status = ?, remarks = ?, date_actioned = ? WHERE period_id = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $updatesql1)){
                echo "<script>alert('SQL Error!')
                window.location.href='../Admin/manage_leaves.php?error=stmtfailed'</script>";
                exit(0);
            }else{
                mysqli_stmt_bind_param($stmt, "sssi", $update_stat, $remarks, $date_now, $id);
                mysqli_stmt_execute($stmt);

                $update_emp_leave = "UPDATE emp_annual_leave SET remaining_hours = '$remaining_hrs' WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
                $update_result = mysqli_query($conn, $update_emp_leave);
                mysqli_stmt_close($stmt);
    
            }
        }else{
            $updatesql1 = "UPDATE leave_taken SET leave_status = ?, remarks = ?, date_actioned = ? WHERE period_id = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $updatesql1)){
                echo "<script>alert('SQL Error!')
                window.location.href='../Admin/manage_leaves.php?error=stmtfailed'</script>";
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "sssi", $update_stat, $remarks, $date_now, $id);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
    
            }
        }
    }
?>

<?php
    if(isset($_POST['id_leavetype'])){
        $LeaveId = mysqli_real_escape_string($conn, $_POST['id_leavetype']);
        $leaveName = mysqli_real_escape_string($conn, $_POST['leaveName']);
        $Description = mysqli_real_escape_string($conn, $_POST['Description']);
    
    
        $updatesql = "UPDATE leave_type SET  leaveCode = ?, leave_name = ?  WHERE LeaveId = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $updatesql)){
            echo "<script>alert('SQL Error!')</script>
            window.location.href = 'leave_type.php?error=stmtfailed';
            ";
        }else{
            mysqli_stmt_bind_param($stmt, "ssi", $leaveName, $Description, $LeaveId);
            mysqli_stmt_execute($stmt);
            echo "<script> alert('Data Successfully Updated');
                  window.location.href = 'leave_type.php';</script>";
        }
    }
