<?php 
    include 'connection.inc.php';

	//view data
	if(isset($_POST['emp_id'])){
		$empId = mysqli_real_escape_string($conn, $_POST["emp_id"]);

		$sql = "SELECT *, employees.empId FROM employees LEFT JOIN position ON position.positionId=employees.positionId LEFT JOIN schedules ON schedules.scheduleId=employees.scheduleid LEFT JOIN department ON department.deptId=employees.deptid WHERE employees.empId = ?";
		$stmt = mysqli_stmt_init($conn);

		$leavesql = "SELECT * FROM emp_annual_leave INNER JOIN leave_type ON leave_type.LeaveId = emp_annual_leave.leaveId WHERE empId = '$empId'";
		$leave_res = mysqli_query($conn, $leavesql);

		if(!mysqli_stmt_prepare($stmt, $sql)){
			echo "<script>alert('SQL Error!')
					window.location.href='personnel.php?error=stmtfailed</script>'";
			exit(0);
		}else{
			mysqli_stmt_bind_param($stmt, "i", $empId);
			mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);
		}
		
		while($row = mysqli_fetch_assoc($result)){
			$birthDate = $row['birthdate'];
			$render = $row['employedDate'];
			$currentDate = date("d-m-Y");
			$age = date_diff(date_create($birthDate), date_create($currentDate));
			$renderDate = date_diff(date_create($render), date_create($currentDate));
			$rendered_date = date_diff(date_create($row['update_action']), date_create($render));
?>               
	<table>
		<tr>
			<td>
				<p><b>Employee Id:</b> <?php echo $row['empId']?></p>
				<p><b>Biometric Id:</b> <?php echo $row['bioId']?></p>
				<p><b>Employee Name:</b> <?php echo ucwords($row['fName'])." ".ucwords($row["midName"])." ".ucwords($row["lName"])?></p>
				<p><b>Birth Date:</b> <?php echo date("M d, Y", strtotime($row['birthdate']))?></p>
				<p><b>Age:</b> <?php echo $age->format("%y");?></p>
				<p><b>Gender:</b> <?php echo $row['gender']?></p>
				<p><b>Employee's Phone No:</b> <?php echo $row['pNumber']?></p>
				<p><b>Address:</b> <?php echo $row['address']?></p>
				<p><b>Email Address:</b> <?php echo $row['emailadd']?></p>
				<p><b>PhilHealth Number:</b> <?php echo $row['philhealth']?></p>
				<p><b>GSIS Number:</b> <?php echo $row['gsis']?></p>
				<p><b>SSS Number:</b> <?php echo $row['sss']?></p>
				<p><b>TIN Number:</b> <?php echo $row['tin']?></p>
				<p><b>Pag-IBIG Number:</b> <?php echo $row['pagibig']?></p>
				<p><b>Contact Person:</b> <?php echo ucwords($row['contactperson'])?></p>
        		<p><b>Contact Person's Phone Number:</b> <?php echo $row['contactpersonno']?></p>
				<p><b>Department:</b> <?php echo $row['deptName']?></p>
				<p><b>Position:</b> <?php echo $row['positionName']?></p> 
				<p><b>Schedule:</b> <?php echo date("h:i A", strtotime($row['time_inAm']))." - ". date("h:i A", strtotime($row['time_outPm']))?></p>
				<p><b>Employment Type:</b> <?php echo $row['employment_type']?></p>
				<p><b>Date Employed:</b> <?php echo date("M d, Y", strtotime($row['employedDate']));?> <?php if($row['status'] == "Active"){ echo "(".$renderDate->format('%y years, %m months, %d days').")";} ?></p>
				<p><b>Status:</b> <?php echo $row['status']?> 												
				<?php if($row['status'] != "Active"){
					echo "(".date("M d, Y", strtotime($row['update_action'])).")";
				}?></p>
															
				<?php if($row['status'] != "Active"){
					echo "<p><b>Service Rendered: </b>".$rendered_date->format('%y years, %m months, %d days')."</p>";
					echo '<a class="btn btn-primary add_emp activate_emp" id="'.$row['empId'].'">Activate</a>';
				}else{
					echo '<a class="btn btn-primary add_emp resetpass" id="'.$row['empId'].'">Reset Password</a>';
				} ?>
			</td>
		</tr>
	</table>
	<?php
		if($row['status'] == "Active"){

	?>
	<hr />
	<div class="mb-1">
		<table class="table table-bordered table-hover year-box">
			<thead>
				<tr>
					<th>Leave Type</th>
					<th>Allowed Hours</th>
					<th>Remaining Hours</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$leavesql = "SELECT * FROM emp_annual_leave INNER JOIN leave_type ON leave_type.LeaveId = emp_annual_leave.leaveId WHERE empId = ".$row['empId']." AND annual_leave_status = 'Active'";
					$leave_res = mysqli_query($conn, $leavesql);
					
					if(mysqli_num_rows($leave_res) > 0){
						while($leave_row = mysqli_fetch_array($leave_res)){
				?>
					<tr>
						<td><?php echo $leave_row['leave_name']?></td>
						<td><?php echo $leave_row['allowed_hours']?></td>
						<td><?php echo $leave_row['remaining_hours']?></td>
					</tr>
				<?php
						}
					}else{
						echo "<td colspan=3>No data found!</td>";
					}
				?>
		
			</tbody>
		</table>
	</div>		
<?php
		}
		}
	}
?>
<!-- Reset Password -->
<div class="modal" id="resetpwd">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Action</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="resetpwd_Form">
                <!-- Modal body -->
                <div class="modal-body resetpwd_emp">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" id="resetpwd_data">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Activate Employee -->
<div class="modal" id="activate_emp_status">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Action</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="activate_Form">
                <!-- Modal body -->
                <div class="modal-body active_emp">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="button" class="btn btn-primary" id="activate_data">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.resetpass').click(function() {
            resetpass_id = $(this).attr('id');
            $.ajax({
                url: "../includes/editdata.php",
                method :'post',
                data:{resetpass_id:resetpass_id},
                success: function(result){
                    $(".resetpwd_emp").html(result);
                    $('#resetpwd').modal('show');
                }
            });
        });	
		$(document).on('click', '#resetpwd_data', function(){
			$.ajax({
				url: "../includes/updatedata.php",
				method :'post',
				data:$("#resetpwd_Form").serialize(),
				success: function(data){
					if (data == 0) {
                        $('#resetpwd').modal('hide');
                        alert('Password Successfully Reset');
                        window.location.href="personnel.php";
					} else {
                        alert('Failed to Update');
						window.location.href="personnel.php";
					}
				}
			}); 
		});		

		$('.activate_emp').click(function() {
            active_id = $(this).attr('id');
            $.ajax({
                url: "../includes/editdata.php",
                method :'post',
                data:{active_id:active_id},
                success: function(result){
                    $(".active_emp").html(result);
                    $('#activate_emp_status').modal('show');
                }
            });
        });	
		$(document).on('click', '#activate_data', function(){
			$.ajax({
				url: "../includes/updatedata.php",
				method :'post',
				data:$("#activate_Form").serialize(),
				success: function(data){
					if (data == 0) {
                        $('#activate_emp_status').modal('hide');
                        alert('Employee Successfully Activated');
                        window.location.href="personnel.php";
					} else {
                        alert('Failed to Activate Employee');
						window.location.href="personnel.php";
					}
				}
			}); 
		});	
    });	
</script>
