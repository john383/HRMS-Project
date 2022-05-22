<?php
    session_start();
    include_once ('connection.inc.php');
    if(isset($_POST['month'], $_POST['year'])){
        $month = $_POST['month'];
        $year = $_POST['year'];

        $sql = "SELECT * FROM employees INNER JOIN leave_taken on leave_taken.empId=employees.empId
        INNER JOIN leave_type on leave_type.LeaveId=leave_taken.leaveId WHERE  month(startDate) = ".$month." AND year(startDate) = ".$year." AND leave_status = 'Approved' OR leave_status = 'Rejected'";
        $result = mysqli_query($conn, $sql);  
?>
        <table class="table table-bordered table-hover" id="example2"  style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Leave Info</th>
					<th scope="col" class="text-center">Reason</th>
					<th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Remarks</th>
                    <th scope="col" class="text-center">Date Actioned</th>
                </tr>
            </thead>
            <tbody class="leave_display">
<?php
                while($row = mysqli_fetch_array($result)){
                    $day = $row['day_type'];
?> 
                    <tr>
                        <td name="" class="text-center"><?php echo ucwords($row['lName']).', '.ucwords($row['fName']) ?></td>
                        <td>
                            Type: <b><?php echo ucwords($row['leave_name']);?></b><br>
                            Day Type: <b><?php echo $day?></b><br> 
                            <?php   
                                if($day != "Full Day"){
                                    echo "Date: <b>".date('M d, Y', strtotime($row['startDate']))."</b>";
                                }else{
                                    echo "Date: <b>".date('M d, Y', strtotime($row['startDate']))."</b> to <b>".date('M d, Y', strtotime($row['endDate']))."</b>";
                                } 
                            ?>
                            <br> Hours: <b><?php echo $row['total_leavehrs'];?></b><br>
                        </td>
                        <td name="remainingdays" class="text-center"><?php echo  ucfirst($row['leave_reason']); ?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['leave_status']; ?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['remarks']?></td>
                        <td name="remainingdays" class="text-center"><?php 
                        if($row['date_actioned'] == ""){
                            echo $row['date_actioned'];
                        }else{
                            echo date("M d, Y h:i A", strtotime($row['date_actioned']));
                        }?></td>
                    </tr>
<?php                                                                      
                }
?>   
            </tbody>
        </table>  
<?php
    }
?>
<?php
        if(isset($_POST['usermonth'], $_POST['useryear'])){
        $month = $_POST['usermonth'];
        $year = $_POST['useryear'];
        $id = print_r($_SESSION["empId"], TRUE);

        $sql = "SELECT * FROM leave_taken INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE empId=".$id." AND month(startDate) = ".$month." AND year(startDate) = ".$year." AND leave_status = 'Pending'";
        $result = mysqli_query($conn, $sql);  
        ?>
        <table class="table table-bordered table-hover align-middle" id="example2"  style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Leave Info</th>
					<th scope="col" class="text-center">Reason</th>
					<th scope="col" class="text-center">Status</th>
                    <!-- <th scope="col" class="text-center">Remarks</th>
                    <th scope="col" class="text-center">Date Actioned</th> -->
                    <th scope="col" class="text-center">Action</th>
                </tr>
            </thead>
            <tbody class="leave_display">
            <?php
                while($row = mysqli_fetch_array($result)){
                    $day = $row['day_type'];
            ?> 
                    <tr>
                        <td>
                            Leave Type: <b><?php echo $row['leave_name'];?></b><br>
                            Day Type: <b><?php echo $day?></b><br> 
                            <?php   
                                if($day != "Full Day"){
                                    echo "Date: <b>".date('m/d/Y', strtotime($row['startDate']))."</b>";
                                }else{
                                    echo "Date: <b>".date('m/d/Y', strtotime($row['startDate']))."</b> to <b>".date('m/d/Y', strtotime($row['endDate']))."</b>";
                                } 
                            ?>
                            <br> Hours: <b><?php echo $row['total_leavehrs'];?></b><br>
                        </td>
                        <td name="remainingdays" class="text-center"><?php echo $row['leave_reason']?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['leave_status']?></td>
                        <!-- <td name="remainingdays" class="text-center"><1?php echo $row['remarks']?></td>
                        <td name="remainingdays" class="text-center"><1?php echo $row['date_actioned']?></td> -->
                        <td class="text-center">
                            <?php
                                if($row['leave_status'] != "Cancelled"){
                                    echo "<button type='button' class='btn btn-success edit_btn' id=".$row['period_id']." title='Update'><i class='fa fa-pencil-square-o'></i></button>";
                                }else{
                                    echo "<button type='button' class='btn btn-danger edit_btn' disabled id=".$row['period_id']." title='Cancelled'><i class='fa fa-pencil-square-o'></i></button>";
                                }
                            ?>
                        </td>
                    </tr>
                <?php                                                                      
                    }
                ?>   
            </tbody>
        </table>  
<?php
        
    }
?>

<?php
    if(isset($_POST['actionedmonth'], $_POST['actionedyear'])){
        $month = $_POST['actionedmonth'];
        $year = $_POST['actionedyear'];
        $id = print_r($_SESSION["empId"], TRUE);

        $sql = "SELECT * FROM leave_taken INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE 
                empId=".$id." AND month(startDate) = ".$month." AND year(startDate) = ".$year." AND leave_status = 'Approved' OR leave_status = 'Rejected'";
        $result = mysqli_query($conn, $sql);  
?>
        <table class="table table-bordered table-hover align-middle" id="example2"  style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Leave Info</th>
					<th scope="col" class="text-center">Reason</th>
					<th scope="col" class="text-center">Status</th>
                    <th scope="col" class="text-center">Remarks</th>
                    <th scope="col" class="text-center">Date Actioned</th>
                    <!-- <th scope="col" class="text-center">Action</th> -->
                </tr>
            </thead>
            <tbody class="leave_display">
            <?php
                while($row = mysqli_fetch_array($result)){
                    $day = $row['day_type'];
            ?> 
                    <tr>
                        <td>
                            Leave Type: <b><?php echo $row['leave_name'];?></b><br>
                            Day Type: <b><?php echo $day?></b><br> 
                            <?php   
                                if($day != "Full Day"){
                                    echo "Date: <b>".date('m/d/Y', strtotime($row['startDate']))."</b>";
                                }else{
                                    echo "Date: <b>".date('m/d/Y', strtotime($row['startDate']))."</b> to <b>".date('m/d/Y', strtotime($row['endDate']))."</b>";
                                } 
                            ?>
                            <br> Hours: <b><?php echo $row['total_leavehrs'];?></b><br>
                        </td>
                        <td name="remainingdays" class="text-center"><?php echo $row['leave_reason']?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['leave_status']?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['remarks']?></td>
                        <td name="remainingdays" class="text-center"><?php echo $row['date_actioned']?></td>
                        <!-- <td class="text-center">
                            <1?php
                                if($row['leave_status'] != "Cancelled"){
                                    echo "<button type='button' class='btn btn-success edit_btn' id=".$row['period_id']." title='Update'><i class='fa fa-pencil-square-o'></i></button>";
                                }else{
                                    echo "<button type='button' class='btn btn-danger edit_btn' disabled id=".$row['period_id']." title='Cancelled'><i class='fa fa-pencil-square-o'></i></button>";
                                }
                            ?>
                        </td> -->
                    </tr>
<?php                                                                      
                }
?>   
            </tbody>
        </table>  
<?php
        
    }
?>

<?php
    if(isset($_POST['attend_month'], $_POST['attend_year'])){
        $month = $_POST['attend_month'];
        $year = $_POST['attend_year'];

        $sql = "SELECT * FROM attendance INNER JOIN employees ON attendance.bioId = employees.bioId 
            WHERE month(date) = ".$month." AND year(date) = ".$year." ORDER BY attendId ASC";
        $result = mysqli_query($conn, $sql);        
?>
    <table class="table table-bordered table-hover year-box" id="example2"  style="width: 100%;">
        <thead>
            <tr>
                <!-- <th scope="col">Date</th> -->
                <th scope="col" >Name</th>
                <th scope="col" >Date</th>
                <th scope="col">Time In(AM)</th>
                <th scope="col">Time Out(AM)</th>
                <th scope="col">Time In(PM)</th>
                <th scope="col">Time Out(PM)</th> 
                <th scope="col">Status</th> 
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
                while($row = mysqli_fetch_array($result)){
            ?> 

                <tr>
                    <td scope="row" name="empid"><?php echo ucwords($row['lName']).', '.ucwords($row['fName']); ?></td>
                    <td name="name"><?php echo date("D-M j, Y", strtotime($row['date'])) ?></td>
                    <td scope="row" name="empid"><?php if($row['time_inAM'] == ""){echo $row['time_inAM'];}else{echo date("h:i A", strtotime($row['time_inAM']));}?></td>
                    <td scope="row" name="empid"><?php if($row['time_outAM'] == ""){echo $row['time_outAM'];}else{echo date("h:i A", strtotime($row['time_outAM']));}?></td>
                    <td scope="row" name="empid"><?php if($row['time_inPM'] == ""){echo $row['time_inPM'];}else{echo date("h:i A", strtotime($row['time_inPM']));}?></td>
                    <td scope="row" name="empid"><?php if($row['time_outPM'] == ""){echo $row['time_outPM'];}else{echo date("h:i A", strtotime($row['time_outPM']));}?></td>
                    <td scope="row" name="empid"><?php echo $row['attend_status']; ?></td>
                    <td>
                        <button type="button" class="btn btn-success attend_updt_btn" id="<?php echo $row['attendId']; ?>" title="Update"><i class="fa fa-pencil-square-o" ></i></button>
                    </td>
                </tr>
            <?php                                                                     
                }
            ?>   
        </tbody>
    </table>
<?php
    }
?>  
<?php
    if(isset($_POST['startdate'], $_POST['enddate'])){
        $month = $_POST['startdate'];
        $year = $_POST['enddate'];

        $sql = "SELECT * FROM employees";
        $result = mysqli_query($conn, $sql); 
  
?>
        <table class="table table-bordered table-hover year-box" id="example1"  style="width: 100%;">
            <thead>
                <tr>
                    <th scope="col" class="text-center">Name</th>
                    <th scope="col" class="text-center">Applied Leaves</th>
                    <th scope="col" class="text-center">Undertime</th>
                    <th scope="col" class="text-center">No. of Late(s)</th>
                    <th scope="col" class="text-center">Total Lates in Minutes</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $months[] = strtoupper(date("M d, Y", strtotime($_POST['startdate'])));
                    $years[] = strtoupper(date("M d, Y", strtotime($_POST['enddate'])));

                    while($row = mysqli_fetch_array($result)){
                        $bio = $row['bioId'];
                        $schedule = $row['scheduleid']; 
                ?> 
            <tr>
                <td><?php echo $row['lName'] .', '.$row['fName']  ?></td>
                <td class="text-center" style="white-space:normal;">
                    <?php 
                        $sql1 = "SELECT * FROM leave_taken INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE leave_status = 'Approved' AND empId = ".$row['empId']." AND startDate BETWEEN '$month' AND '$year'";
                        $results = mysqli_query($conn, $sql1); 
                        while($row1 = mysqli_fetch_array($results)){
                            echo $row1['leave_name']." <br>(".date("M d, Y", strtotime($row1['startDate'])).")<br>"; 
                        }
                    ?>
                </td>
                <td class="text-center" id="content1" style="white-space:normal;">
                    <?php
                        $total = NULL;

                        $sql4 = "SELECT * FROM schedules WHERE scheduleId='$schedule'";
                        $result3 = mysqli_query($conn, $sql4);
                        while($row4 = mysqli_fetch_array($result3)){

                            $sched_timeoutfirst = date("H:i:s", strtotime($row4['time_outAm'])); //schedule
                            $sched_timeoutsec = date("H:i:s", strtotime($row4['time_outPm'])); //schedule
                                                        
                            $sql5 = "SELECT * FROM attendance WHERE bioId = '$bio' AND Date BETWEEN '$month' AND '$year'";
                            $result4 = mysqli_query($conn, $sql5);
                            while($row5 = mysqli_fetch_array($result4)){
                                $total1 = 0;
                                $total2 = 0;
                                $date = '';
                                $date1 = '';
                                if(!empty($row5['time_outAM'])){
                                    $attend_timeoutfirst = date("H:i:s", strtotime($row5['time_outAM'])); //attendance
                                    if($sched_timeoutfirst > $attend_timeoutfirst ){
                                        $start = strtotime($attend_timeoutfirst);
                                        $stop = strtotime($sched_timeoutfirst);
                                        $diff = ($stop - $start);
                                        $total1 = abs($diff/60);
                                        $date = "(".date('m-d-Y', strtotime($row5['date'])).")";
                                    }
                                }
                                if(!empty($row5['time_outPM'])){
                                    $attend_timeoutsec = date("H:i:s", strtotime($row5['time_outPM'])); //attendance
                                    if($sched_timeoutsec > $attend_timeoutsec){
                                        $start = strtotime($attend_timeoutsec);
                                        $stop = strtotime($sched_timeoutsec);
                                        $diff = ($stop - $start);
                                        $total2 = abs($diff/60);
                                        $date1 = "(".date('m-d-Y', strtotime($row5['date'])).")";
                                    }
                                }
                                if($date == $date1 && $total1 != 0 && $total2 != 0){
                                    $sum = $total1 + $total2;
                                    $hours = floor($sum / 60);  
                                    $minutes = $sum % 60; 
                                    printf ("%d:%02d <br>", $hours, $minutes);
                                    
                                    // echo "<br>";
                                    echo $date, "<br>";
                                    // echo "<br>";

                                }else if($total1 != 0){
                                        // echo $total1; 
                                        $hours = floor($total1 / 60);  
                                        $minutes = $total1 % 60; 
                                        printf ("%d:%02d <br>", $hours, $minutes); 
                                        // echo "<br>";
                                        echo $date, "<br>";
                                        // echo $date;
                                        // echo "<br>";

                                }else if($total2 != 0){                                                      
                                    // echo $total2;  
                                    $hours = floor($total2 / 60);  
                                    $minutes = $total2 % 60; 
                                    printf ("%d:%02d <br>", $hours, $minutes); 
                                    // echo "<br>";
                                    echo $date1, "<br>";
                                    // echo "<br>";

                                }
                            }
                            $total = NULL;
                        }
                    ?> 
                </td>
                <td class="text-center">
                    <?php
                        $sql2 = "SELECT COUNT(attend_status) as total FROM attendance WHERE bioId = '$bio' AND attend_status='Late'  AND Date BETWEEN '$month' AND '$year'";
                        $result1 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_array($result1);
                        echo $row2['total'];
                    ?>
                </td>
                <td class="text-center" id="content1">
                    <?php
                        $total = NULL;

                        $sql2 = "SELECT * FROM schedules WHERE scheduleId='$schedule'";
                        $result1 = mysqli_query($conn, $sql2);
                        while($row2 = mysqli_fetch_array($result1)){
                            // $employee = $row2['empId'];
                            // $bio = $row2['bioId'];
                            $sched_timeinfirst = date("H:i:s", strtotime($row2['time_inAm'])); //schedule
                            $sched_timeinsec = date("H:i:s", strtotime($row2['time_inPm'])); //schedule
                                                    
                            $sql3 = "SELECT * FROM attendance WHERE attend_status = 'Late' AND bioId = '$bio' AND Date BETWEEN '$month' AND '$year'";
                            $result2 = mysqli_query($conn, $sql3);
                            while($row3 = mysqli_fetch_array($result2)){
                                                    
                                $attend_timeinfirst = date("H:i:s", strtotime($row3['time_inAM'])); //attendance
                                $attend_timeinsec = date("H:i:s", strtotime($row3['time_inPM'])); //attendance
                                                        
                                if($sched_timeinfirst < $attend_timeinfirst){
                                    $start = strtotime($attend_timeinfirst);
                                    $stop = strtotime($sched_timeinfirst);
                                    $diff = ($stop - $start);
                                    $total1 = abs($diff/60);  
                                    $total = $total + $total1;  
                                }
                                if($sched_timeinsec < $attend_timeinsec){
                                    $start = strtotime($attend_timeinsec);
                                    $stop = strtotime($sched_timeinsec);
                                    $diff = ($stop - $start);
                                    $total2 = abs($diff/60);  
                                    $total = $total + $total2;
                                }
                            
                            }
                            echo $total;
                        }
                    ?>                
                </td>
            </tr>
                <?php                                                                     
                    }
                ?>   
            </tbody>
        </table>
<?php
    }
?>  
<?php
    if(isset($_POST['stat_year'])){
        $years = $_POST['stat_year'];

		$query2 = "SELECT year(date) AS attend_year, monthname(date) AS attend_month, count(attend_status) AS total_lates FROM attendance WHERE attend_status = 'Late' AND year(date) = '$years' GROUP BY year(date), month(date) ORDER BY year(date), month(date)";
		$result1 = mysqli_query($conn, $query2);
		while($query_row1 = mysqli_fetch_array($result1)){
			$total_lates[] = $query_row1['total_lates'];
			// $month[] = $query_row1['attend_month'];
		}
		$query3 = "SELECT year(date) AS attend_year, monthname(date) AS attend_month, count(attend_status) AS total_lates FROM attendance WHERE attend_status = 'On Time' AND year(date) = '$years' GROUP BY year(date), month(date) ORDER BY year(date), month(date)";
		$result2 = mysqli_query($conn, $query3);
		while($query_row2 = mysqli_fetch_array($result2)){
			$total_ontime[] = $query_row2['total_lates'];
			$month2[] = $query_row2['attend_month'];
		}
?>
		<canvas id="myChart"></canvas>

<?php
    }
?>
<script>
    const labels = <?php echo json_encode($month2)?>;
    const data = {
        labels: labels,
        datasets: [
            {
                label: "On Time",
                data: <?php echo json_encode($total_ontime)?>,
                backgroundColor: "rgb(34,139,34)",
                borderColor: "rgb(34,139,34)",
                borderWidth: 1,
            },                     
            {
                label: "Late",
                data: <?php echo json_encode($total_lates)?>,
                backgroundColor: "rgb(15,107,255)",       
                borderColor: "rgb(15,107,255)",
                borderWidth: 1,
            }                

        ],
    };
    const config = {
        type: "bar",
        data: data,
        options: {
            scales: {
				x: {
					title: {
						display: true,
						text: 'Month'
					}
                },
            },
        },
    };

    const myChart = new Chart(document.getElementById("myChart"), config);
</script>
<script>
    $(document).ready(function() {
        $('#example2').DataTable({
            "pagingType": "full_numbers"
        }); 
        $('#example1').DataTable({
            "pagingType": "full_numbers",
            dom: 'Bfrtip',
            buttons: [
                {
                    filename: 'LCCL-HR_Report',
                    extend: 'pdfHtml5',
                    text: '<i class="fa fa-file-pdf-o" aria-hidden="true"></i> &nbsp Generate PDF',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    className: 'btn btn-primary add_emp',
                    title: 'LA CONSOLACION COLLEGE - LILOAN, CEBU, INC.\n POBLACION, LILOAN, CEBU 6002\n HUMAN RESOURCE OFFICE\n LEAVES AND ABSENCES\n for\n (MONTH of <?php echo str_replace(array("[", "]", '"'), "", json_encode($months))?> - <?php echo str_replace(array("[", "]", '"'), "", json_encode($years))?>)',
                    exportOptions: {
                        columns: ':visible',
                    },
                    customize: function (doc) {
                        doc.defaultStyle.alignment = 'center';
                        doc.defaultStyle.fontSize = 15;
                        doc.styles.tableHeader.fontSize = 15;  
                        doc.content[1].table.widths = [ '28%',  '30%', '12%', '10%', '20%'];
                   }
                    
                }                
            ]
        }); 
    });
</script>
<?php  include 'attendance_modals.php';?>
<?php  include 'leave_modals.php';?>

