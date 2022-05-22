<?php
	$title = "Admin | Accumulated Leaves and Tardiness";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    function fetch_data(){

        $month = date('m');
        $year = date('Y');
        $conn = mysqli_connect("localhost", "root", "", "hrms");

        $sql = "SELECT * FROM employees";
        $result = mysqli_query($conn, $sql); 
        
        while($row = mysqli_fetch_array($result)){
            $bio = $row['bioId'];
            $schedule = $row['scheduleid'];
?>
        <tr>
            <td><?php echo $row['lName'] .', '.$row['fName']  ?></td>
            <td class="text-center" style="white-space:normal;">
                <?php 
                    $sql1 = "SELECT * FROM leave_taken INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE leave_status = 'Approved' AND empId = ".$row['empId']." AND month(startDate) = '$month' AND year(startDate) = '$year'";
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
                                                    
                        $sql5 = "SELECT * FROM attendance WHERE bioId = '$bio' AND month(date) = ".$month." AND year(date) = ".$year."";
                        $result4 = mysqli_query($conn, $sql5);
                        while($row5 = mysqli_fetch_array($result4)){
                            $total1 = 0;
                            $total2 = 0;
                            $total3 = 0;
                            $date = '';
                            $date1 = '';
                            $date2 = '';

                            if(!empty($row5['time_outAM']) && date("D", strtotime($row5['date'])) != 'Sat'){
                                $attend_timeoutfirst = date("H:i:s", strtotime($row5['time_outAM'])); //attendance
                                if($sched_timeoutfirst > $attend_timeoutfirst ){
                                    $start = strtotime($attend_timeoutfirst);
                                    $stop = strtotime($sched_timeoutfirst);
                                    $diff = ($stop - $start);
                                    $total1 = abs($diff/60);
                                    $date = "(".date('m-d-Y', strtotime($row5['date'])).")";
                                }
                            }
                            if(!empty($row5['time_outAM']) && date("D", strtotime($row5['date'])) == 'Sat'){
                                $attend_timeoutfirst = date("H:i:s", strtotime($row5['time_outAM'])); //attendance
                                if("11:00:00" > $attend_timeoutfirst ){
                                    $start = strtotime($attend_timeoutfirst);
                                    $stop = strtotime("11:00:00");
                                    $diff = ($stop - $start);
                                    $total3 = abs($diff/60);
                                    $date2 = "(".date('m-d-Y', strtotime($row5['date'])).")";
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
                            if($date == $date1 && $date1 == $date2 && $total1 != 0 && $total2 != 0 && $total3 != 0){
                                $sum = $total1 + $total2 + $total3;
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

                            }else if($total3 != 0){                                                      
                                // echo $total2;  
                                $hours = floor($total3 / 60);  
                                $minutes = $total3 % 60; 
                                printf ("%d:%02d <br>", $hours, $minutes); 
                                // echo "<br>";
                                echo $date2, "<br>";
                                // echo "<br>";

                            }
                        }
                        $total = NULL;
                    }
                ?> 
            </td>
            <td class="text-center">
                <?php
                    $sql2 = "SELECT COUNT(attend_status) as total FROM attendance WHERE bioId = '$bio' AND attend_status='Late'  AND month(date) = ".$month." AND year(date) = ".$year."";
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
                                                
                        $sql3 = "SELECT * FROM attendance WHERE attend_status = 'Late' AND bioId = '$bio' AND month(date) = ".$month." AND year(date) = ".$year."";
                        $result2 = mysqli_query($conn, $sql3);
                        while($row3 = mysqli_fetch_array($result2)){
                                                
                            $attend_timeinfirst = date("H:i:s", strtotime($row3['time_inAM'])); //attendance
                            $attend_timeinsec = date("H:i:s", strtotime($row3['time_inPM'])); //attendance
                                                    
                                if($sched_timeinfirst < $attend_timeinfirst && date("D", strtotime($row3['date'])) != 'Sat'){
                                    $start = strtotime($attend_timeinfirst);
                                    $stop = strtotime($sched_timeinfirst);
                                    $diff = ($stop - $start);
                                    $total1 = abs($diff/60);  
                                    $total = $total + $total1;  
                                }
                                if("08:00:00" < $attend_timeinfirst && date("D", strtotime($row3['date'])) == 'Sat'){
                                    $start = strtotime($attend_timeinfirst);
                                    $stop = strtotime("08:00:00");
                                    $diff = ($stop - $start);
                                    $total3 = abs($diff/60);  
                                    $total = $total + $total3;  
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
    }
?>
    <nav>
        <div class="sidebar-button">
            <!-- <i class='fa fa-bars sidebarBtn'></i> -->
            <span class="dashboard"><b>Accumulated Leaves and Tardiness</b></span>
        </div>
        <div class="time">
            <span class="date"></span>
            <br />
            <span class="hms"></span>
            <span class="ampm"></span>
        </div>
    </nav>  

    <div class="home-content">
        <div class="cardbox">
            <div class="graphbox">
                <div class="mb-2">
                    <div class="row">
                        <div class="col text-center">
                            <label for="recipient-name" class="col-form-label">Start Date:</label>
                            <input type="date" name="startdate" id="startdate" onchange="getreport()">	
                            <label for="recipient-name" class="col-form-label" style="padding-left: 10px;">End Date:</label>
                            <input type="date" name="enddate" id="enddate" onchange="getreport()">	
                        </div>
                    </div>		
				</div>      
                    <div class="table-responsive"> 
                        <table class="table table-bordered table-hover align-middle table" id="example1"  style="width: 100%;">
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
                                    $month[] = strtoupper(date('M'));
                                    $year[] = strtoupper(date('Y'));
                                    
                                    echo fetch_data();
                                ?>
                            </tbody>
                        </table>                
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    function getreport(val) {
        var startdate = $("#startdate").val();
        var enddate = $("#enddate").val();
        if(startdate && enddate) {
            $.ajax({
                url: "../includes/fetch.php",
                type: "POST",
                data: {"startdate":startdate, "enddate":enddate},
                success: function(data){
                    $(".table-responsive").html(data);
                    // alert(year)
                }
            }); 
        }
    }    
    $(document).ready(function() {
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
                    title: 'LA CONSOLACION COLLEGE - LILOAN, CEBU, INC.\n POBLACION, LILOAN, CEBU 6002\n HUMAN RESOURCE OFFICE\n LEAVES AND ABSENCES\n for\n (MONTH of <?php echo str_replace(array("[", "]", '"'), "", json_encode($month))?> - <?php echo str_replace(array("[", "]", '"'), "", json_encode($year))?>)',
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
<?php  include '../includes/attendance_modals.php';?>
<?php
	include 'footer.php';
?>