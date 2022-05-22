<?php
	$title = "Admin | Manage Leaves";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    $month = date('m');
    $year = date('Y');

    $sql = "SELECT * FROM employees INNER JOIN leave_taken ON leave_taken.empId = employees.empId
    INNER JOIN leave_type ON leave_type.LeaveId = leave_taken.leaveId WHERE leave_status = 'Pending'";
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
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" id="example"  style="width: 100%;">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Name</th>
                                <th scope="col" class="text-center">Leave Info</th>
								<th scope="col" class="text-center">Reason</th>
								<th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
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
                                    <td class="text-center">
                                        <?php
                                            if($row['leave_status'] == "Pending"){
                                                echo "<button type='button' class='btn btn-success editleave_btn' id=".$row['period_id']." title='Update'><i class='fa fa-pencil-square-o'></i></button>";
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
			</div>
		</div>
	</div>
</section>

<?php  include '../includes/leave_modals.php';?>
<?php include 'footer.php';?>