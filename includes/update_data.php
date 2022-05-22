<?php
    include("connection.inc.php");

    if(isset($_POST['sched_id'])){
        $sched_id = mysqli_real_escape_string($conn, $_POST['sched_id']);
        $firsttime_in = mysqli_real_escape_string($conn, $_POST['firsttime_in']);
        $firsttime_out = mysqli_real_escape_string($conn, $_POST['firsttime_out']);
        $secondtime_in = mysqli_real_escape_string($conn, $_POST['secondtime_in']);
        $secondtime_out = mysqli_real_escape_string($conn, $_POST['secondtime_out']);
        
        if($firsttime_in != NULL){
            $firsttime_in = date("H:i:s", strtotime($firsttime_in));
        }
        if($firsttime_out != NULL){
            $firsttime_out = date("H:i:s", strtotime($firsttime_out));
        }
        if($secondtime_in != NULL){
            $secondtime_in = date("H:i:s", strtotime($secondtime_in));
        }
        if($secondtime_out != NULL){
            $secondtime_out = date("H:i:s", strtotime($secondtime_out));
        }

        $sql = "SELECT * FROM schedules WHERE time_inAm = '$firsttime_in' AND time_outAm = '$firsttime_out' AND time_inPm= '$secondtime_in' AND time_outPm = '$secondtime_out'";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){
            return false;
        }else{
            $updatesql = "UPDATE schedules SET time_inAm = ?, time_outAm = ?, time_inPm= ?, time_outPm = ? WHERE scheduleId = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $updatesql)){
                echo "<script>alert('SQL Error!')</script>";
                header('location: personnel.php?error=stmtfailed');
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "ssssi", $firsttime_in, $firsttime_out, $secondtime_in, $secondtime_out, $sched_id);
                mysqli_stmt_execute($stmt);
            }
        }
    }

    if(isset($_POST['attend_id'])){
        $attend_id = mysqli_real_escape_string($conn, $_POST['attend_id']);
        $bioId = mysqli_real_escape_string($conn, $_POST['bioId']);
        $attend_date = mysqli_real_escape_string($conn, $_POST['attend_date']);

        if($_POST['firsttime_in'] == NULL){
            $firsttime_in = mysqli_real_escape_string($conn, $_POST['firsttime_in']);
        }else{
            $firsttime_in = mysqli_real_escape_string($conn, date("H:i:s", strtotime($_POST['firsttime_in'])));
        }

        if($_POST['firsttime_out'] == NULL){
            $firsttime_out = mysqli_real_escape_string($conn, $_POST['firsttime_out']);
        }else{
            $firsttime_out = mysqli_real_escape_string($conn, date("H:i:s", strtotime($_POST['firsttime_out'])));
        }

        if($_POST['secondtime_in'] == NULL){
            $secondtime_in = mysqli_real_escape_string($conn, $_POST['secondtime_in']);
        }else{
            $secondtime_in = mysqli_real_escape_string($conn, date("H:i:s", strtotime($_POST['secondtime_in'])));
        }

        if($_POST['secondtime_in'] == NULL){
            $secondtime_out = mysqli_real_escape_string($conn, $_POST['secondtime_out']);
        }else{
            $secondtime_out = mysqli_real_escape_string($conn, date("H:i:s", strtotime($_POST['secondtime_out'])));
        }
        
        $status = "";

        $schedule = "SELECT * FROM employees LEFT JOIN schedules ON schedules.scheduleId = employees.scheduleid WHERE employees.bioId = '$bioId'";
        $results = mysqli_query($conn, $schedule);
        $schedule_row = mysqli_fetch_array($results);
        $firstsessionTimein = $schedule_row['time_inAm'];
        $secondsessionTimein = $schedule_row['time_inPm'];

        if (date("D", strtotime($attend_date)) == 'Sat'){
            if(strtotime($firsttime_in) <= strtotime("08:00:00")){
                $status = "On Time";
            }else if(strtotime($firsttime_in) == NULL && strtotime($firsttime_out) == NULL){
                $status = "No Work";                                                        
            }else{
                $status = "Late";
            }
        }else{
            if(strtotime($firsttime_in) > strtotime($secondtime_out)){ //night shift
                if(strtotime($firsttime_in) > strtotime($firstsessionTimein)){
                    $status = "Late";
                }else if(strtotime($firsttime_in) == NULL && strtotime($secondtime_out) == NULL){
                    $status = "No Work";                        
                }else{
                    $status = "On Time";
                }
            }else{ //day shift
    
                if(strtotime($firsttime_in) > strtotime($firstsessionTimein) || strtotime($secondtime_in) > strtotime($secondsessionTimein)){
                    $status = "Late";
                }else if(strtotime($firsttime_in) == NULL && strtotime($secondtime_out) == NULL){
                    $status = "No Work";                        
                }else{
                    $status = "On Time";
                } 
            }
        }
    
        $updatesql = "UPDATE attendance SET time_inAM = ?, time_outAM = ?, time_inPM = ?, time_outPM = ?, attend_status = ? WHERE attendId = ? AND bioId = ?";
        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $updatesql)){
            // echo "<script>alert('SQL Error!')</script>";
            return false;
        }else{
            mysqli_stmt_bind_param($stmt, "sssssii", $firsttime_in, $firsttime_out, $secondtime_in, $secondtime_out, $status, $attend_id, $bioId);
            mysqli_stmt_execute($stmt);
            exit(0);
        }
    }
