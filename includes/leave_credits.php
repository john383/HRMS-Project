<?php 
    session_start();
    include("connection.inc.php");

    $leaveid = $_POST['id'];
    $id = print_r($_SESSION["empId"], TRUE);
    $leaveid = trim($leaveid);
    
    $sql = "SELECT * FROM employees INNER JOIN schedules ON schedules.scheduleId = employees.scheduleid WHERE employees.empId = '$id'";
    $res = mysqli_query($conn, $sql);
    $res_row = mysqli_fetch_array($res);
    $date_now = date("Y-m-d");
    $startH = date('H:i', strtotime($res_row['time_inAm']));
    $endH = date('H:i', strtotime($res_row['time_outPm']));
    $combinedDT1 = date('Y-m-d H:i:s',strtotime($date_now.' '.$startH));
    $combinedDT2 = date('Y-m-d H:i:s',strtotime($date_now.'+1 day '.$endH));
    $diff = gmdate('H', floor(abs(strtotime($combinedDT1) - strtotime($combinedDT2)))-3600);

    $query1 = "SELECT remaining_hours FROM emp_annual_leave WHERE leaveId = '$leaveid' and empId = '$id' AND annual_leave_status = 'Active'";
    $results = mysqli_query($conn, $query1);
    while($rows = mysqli_fetch_array($results)){
        $remaining = floor($rows['remaining_hours']/$diff);
        echo $rows['remaining_hours'], " hours or ".$remaining, " days";
    }

    
?>