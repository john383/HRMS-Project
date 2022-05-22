<?php
    // sleep(1);
	$title = "Leave Management";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    $month = date('m');
    $year = date('Y');

    $check_year = "SELECT * FROM emp_annual_leave";
    $year_res = mysqli_query($conn, $check_year);
    while($year_row = mysqli_fetch_array($year_res)){
        // $current_year = date('Y');
        $current_year = $year_row['year_number'];
        $default = $year_row['allowed_hours'];

        if($current_year != $year){
            $update_value = "UPDATE emp_annual_leave SET year_number = ?, remaining_hours = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $update_value)){
                echo "<script>alert('SQL Error!')
                </script>";
            }else{
                mysqli_stmt_bind_param($stmt, "ss", $year, $default);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }  


    $id = print_r($_SESSION["empId"], TRUE);
    $sql = "SELECT * FROM leave_taken INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE 
            empId=".$id." AND month(startDate) = ".$month." AND year(startDate) = ".$year." AND leave_status = 'Pending'";
    $result = mysqli_query($conn, $sql);  
?>
    <nav>
        <div class="sidebar-button">
            <!-- <i class='fa fa-bars sidebarBtn'></i> -->
            <span class="dashboard"><b>Leave Management</b></span>
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

                    
				    <label for="years" class="selectYr mb-3">Select Year:</label>
                    <?php 
                        echo '<select id="year" name="year" onchange="getleave()">'."\n";
                        for ($i = date('Y'); $i >= 2020; $i--){
                            $selected = (date('Y') == $i ? ' selected' : '');
                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";
                        }
                        echo '</select>'."\n";
                    ?>
				</div>
                <button type="button" class="btn btn-primary mb-3 add_btn" data-bs-toggle="modal" data-bs-target="#addemp">Add Leave</button>
                <!-- <div class="year-box"> -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="example"  style="width: 100%;">
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
                                        <!-- <td name="remainingdays" class="text-center"><?php echo $row['remarks']?></td>
                                        <td name="remainingdays" class="text-center"><?php echo $row['date_actioned']?></td> -->
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
                data: {"usermonth":month, "useryear":year},
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