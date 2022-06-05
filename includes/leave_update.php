<?php
	date_default_timezone_set('Asia/Manila');

    include("connection.inc.php");

    if(isset($_POST['edit_id'])){
        $id = mysqli_real_escape_string($conn, $_POST['edit_id']);
        $reason = mysqli_real_escape_string($conn, $_POST['reason']);
        $status = mysqli_real_escape_string($conn, $_POST['update_stat']);
        $leave_hrs = mysqli_real_escape_string($conn, $_POST['leave_hrs']);
        $employee_id = mysqli_real_escape_string($conn, $_POST['employee_id']);
        $leaveId = mysqli_real_escape_string($conn, $_POST['empleave_id']);

        $updatesql2 = "UPDATE leave_taken SET leave_reason = ?, leave_status = ? WHERE period_id = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $updatesql2)){
            echo "<script>alert('SQL Error!')
            window.location.href='../Admin/manage_leaves.php?error=stmtfailed'</script>";
            exit(0);
        }else{
            mysqli_stmt_bind_param($stmt, "ssi", $reason, $status, $id);
            mysqli_stmt_execute($stmt);
            if($status == "Cancelled"){
                $updatesql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
                $results = mysqli_query($conn, $updatesql1);
                $row = mysqli_fetch_array($results);
                $leavetotal = $row['remaining_hours'] + $leave_hrs;

                $updatesql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
                $results1 = mysqli_query($conn, $updatesql2);
            }
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
        $date_now = date('Y-m-d H:i:s');

        if($update_stat != 'Pending'){
            $updatesql = "UPDATE leave_taken SET leave_status = ?, remarks = ?, date_actioned = ? WHERE period_id = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $updatesql)){
                echo "<script>alert('SQL Error!')
                window.location.href='../Admin/manage_leaves.php?error=stmtfailed'</script>";
                exit(0);
            }else{
                mysqli_stmt_bind_param($stmt, "sssi", $update_stat, $remarks, $date_now, $id);
                mysqli_stmt_execute($stmt);
                
                $updatesql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
                $results = mysqli_query($conn, $updatesql1);
                $row = mysqli_fetch_array($results);
                $leavetotal = $row['remaining_hours'] + $hrs_taken;

                $updatesql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$employee_id' AND leaveId = '$leaveId'";
                $results1 = mysqli_query($conn, $updatesql2);
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
