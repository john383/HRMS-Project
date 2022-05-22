<?php
    // sleep(1);
    $title = "Admin | Actioned Leaves";
	require("header.php");

    include_once ('../includes/connection.inc.php');

    $month = date('m');
    $year = date('Y');

    $sql = "SELECT * FROM employees INNER JOIN leave_taken ON leave_taken.empId = employees.empId
    INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE  month(startDate) = ".$month." AND year(startDate) = ".$year." AND leave_status = 'Approved' OR leave_status = 'Rejected'";
    $result = mysqli_query($conn, $sql);   
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Employee Leave Management</b></span>
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
			   <div class="year-box">
			        <label for="months" class="selectMonth">Select Month:</label>
                    <?php
                        $selected_month = date('m'); //current month
                    ?>
                    <select id="month" name="month" onchange="getleave()">
                        <option value='01' <?php echo $selected_month == 1 ? ' selected' : ''?>>January</option>
                        <option value='02' <?php echo $selected_month == 2 ? ' selected' : ''?>>February</option>
                        <option value='03' <?php echo $selected_month == 3 ? ' selected' : ''?>>March</option>
                        <option value='04' <?php echo $selected_month == 4 ? ' selected' : ''?>>April</option>
                        <option value='05' <?php echo $selected_month == 5 ? ' selected' : ''?>>May</option>
                        <option value='06' <?php echo $selected_month == 6 ? ' selected' : ''?>>June</option>
                        <option value='07' <?php echo $selected_month == 7 ? ' selected' : ''?>>July</option>
                        <option value='08' <?php echo $selected_month == 8 ? ' selected' : ''?>>August</option>
                        <option value='09' <?php echo $selected_month == 9 ? ' selected' : ''?>>September</option>
                        <option value='10' <?php echo $selected_month == 10 ? ' selected' : ''?>>October</option>
                        <option value='11' <?php echo $selected_month == 11 ? ' selected' : ''?>>November</option>
                        <option value='12' <?php echo $selected_month == 12 ? ' selected' : ''?>>December</option>
                    </select>
                    
				    <label for="years" class="selectYr">Select Year:</label>
                    <?php 
                        echo '<select id="year" name="year" onchange="getleave()">'."\n";
                        for ($i = date('Y'); $i >= 2020; $i--){
                            $selected = (date('Y') == $i ? ' selected' : '');
                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";
                        }
                        echo '</select>'."\n";
                    ?>
				</div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="example"  style="width: 100%;">
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
					</div>
				<!-- </div> -->
			</div>
		</div>
		</div>
    </section>
<script>
    function getleave(val) {
        var month = $("#month").val();
        var year = $("#year").val();
        if(month && year) {
            $.ajax({
                url: "../includes/fetch.php",
                type: "POST",
                data: {"month":month, "year":year},
                success: function(data){
                    $(".table-responsive").html(data);
                    // alert(year)
                }
            }); 
        }
    }    
</script>

<?php  include '../includes/leave_modals.php';?>
<?php include 'footer.php';?>