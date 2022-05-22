<?php 
	session_start();

    include 'connection.inc.php';

	//edit data
	if(isset($_POST['edit_id'])){

		$id = mysqli_real_escape_string($conn, $_POST['edit_id']);

		$sqlget = "SELECT *, employees.empId FROM employees LEFT JOIN position ON position.positionId=employees.positionid LEFT JOIN schedules ON schedules.scheduleId=employees.scheduleid LEFT JOIN department ON department.deptId=employees.deptid WHERE employees.empId = $id";
		$res = mysqli_query($conn, $sqlget);

		while($row = mysqli_fetch_assoc($res)){
			$gender = $row["gender"];
			$scheduleid = $row["scheduleid"];
			$positionid = $row["positionid"];
			$deptid = $row["deptid"];
			$employ_type = $row["employment_type"];
			$status = $row["status"];
?>			
		<input type="hidden" name="edit_id" id="edit_id" class="form-control" value="<?php echo $row['empId']?>">             
		<!-- <input type="hidden" name="update_action" id="update_action" class="form-control" value="<1?php echo $row['update_action']?>">              -->
		<div class="mb-1">
			<div class="row">
				<div class="col">
					<label for="recipient-name" class="col-form-label">Employee Id:</label>
					<input type="text" class="form-control" name="empId" id="empId" Value="<?php echo $row['empId']?>">
				</div>
				<div class="col">
					<label for="recipient-name" class="col-form-label">Biometric Id:</label>
					<input type="text" class="form-control" name="bioId" id="bioId" value="<?php echo $row['bioId']?>" required>
				</div>
			</div>
			<div class="mb-1">
				<div class="row">
					<div class="col">
						<label for="recipient-name" class="col-form-label">First Name:</label>
						<input type="text" class="form-control" name="fname" id="fname" Value="<?php echo $row['fName']?>" disabled>
					</div>
					<div class="col">
						<label for="recipient-name" class="col-form-label">Last Name:</label>
						<input type="text" class="form-control" name="lname" id="lname" Value="<?php echo $row['lName']?>" disabled>
					</div>                            
					<div class="col">
						<label for="recipient-name" class="col-form-label">Middle Name:</label>
						<input type="text" class="form-control" name="midname" id="midname" Value="<?php echo $row['midName']?>" disabled>
					</div>
				</div>
			</div>
			<div class="mb-1">
				<div class="row">
					<div class="col">
						<label for="recipient-name" class="col-form-label">Department:</label>
						<select class="form-select department" aria-label="Default select example" name="selectdepartment" required>
							<?php
								$dept = "SELECT * FROM department";
								$dept_res = mysqli_query($conn, $dept);
								while($dept_row = mysqli_fetch_array($dept_res)){
									echo "<option value='".$dept_row['deptId'] ."' ".(($dept_row['deptId'] == $deptid) ? 'selected' : "").">". $dept_row['deptName'] ."</option>";
								}	
							?>
						</select>
					</div>  
					<div class="col">
						<label for="recipient-name" class="col-form-label">Position:</label>
						<select class="form-select position" aria-label="Default select example" name="selectposition" required>
							<?php 
								$pos = "SELECT * FROM position WHERE deptId = $deptid";
								$pos_res = mysqli_query($conn, $pos);

								while($pos_row = mysqli_fetch_array($pos_res)){
									echo "<option value='".$pos_row['positionId'] ."' ".(($pos_row['positionId'] == $positionid) ? 'selected' : "").">". $pos_row['positionName'] ."</option>";
								}
							?>
						</select>
					</div>
				</div>             
			</div>
			<div class="mb-1">
				<div class="row">
					<div class="col">
						<label for="recipient-name" class="col-form-label">Schedule:</label>
						<select class="form-select" aria-label="Default select example" name="selectschedule" required>   
							<?php
								$schedules = "SELECT * FROM schedules";
								$sched_res = mysqli_query($conn, $schedules) ;

								while($sched_row = mysqli_fetch_array($sched_res)){
									echo "<option value='".$sched_row['scheduleId']."' ".(($sched_row['scheduleId'] == $scheduleid) ? 'selected' : "").">". date("h:i A", strtotime($sched_row['time_inAm'])) ." - ". date("h:i A", strtotime($sched_row['time_outPm'])) ."</option>";
								}
							?>
						</select>
					</div> 
					<div class="col">
						<label for="recipient-name" class="col-form-label">Employment Type:</label>
						<select name="employment_type" id="employment_type" class="form-select">
							<option value="Regular" <?php echo $employ_type == "Regular" ? "selected" : '' ?>>Regular</option>
							<option value="Probationary" <?php echo $employ_type == "Probationary" ? "selected" : '' ?>>Probationary</option>
						</select>
					</div>   
				</div>
				<div class="mb-1">
					<div class="row">
						<div class="col">
							<label for="recipient-name" class="col-form-label">Date Employed: dd/mm/yyyy</label>
							<input type="date" class="form-control" name="dateemployed" id="dateemployed" value="<?php echo $row['employedDate']?>">
						</div> 
						<div class="col">
							<label for="recipient-name" class="col-form-label">Status:</label>
							<select name="statusupdate" id="status" class="form-select">
								<option value="Active" <?php echo $status == "Active" ? "selected" : '' ?>>Active</option>
								<option value="Retired" <?php echo $status == "Retired" ? "selected" : '' ?>>Retired</option>
								<option value="Resigned" <?php echo $status == "Resigned" ? "selected" : '' ?>>Resigned</option>
							</select>
						</div>  
					</div> 
				</div>
			</div>
		</div>
<?php				
		}	
	}

	if(isset($_POST['resetpass_id'])){
		$emailadd = print_r($_SESSION['adminemail'], TRUE);

?>
		<div class="col">
			<label for="resetemp_pass">Admin Password: </label>
			<input type="password" class="form-control" autocomplete="off" name="resetpassword" placeholder="Enter Admin Password" />
			<input type="hidden" name="employee_id" value="<?php echo $_POST['resetpass_id']?>">
			<input type="hidden" name="adminemail" value="<?php echo $emailadd?>">
		</div>
<?php
	}
?>


	<script>
		$(document).ready(function() {
			$(".department").change(function(){
				var e_dept_id = $(this).val();
				$.ajax({
					url: "../includes/position_dept.php",
					method: "POST",
					data: {e_dept_id:e_dept_id},
					success: function(data){
						$(".position").html(data);
					}
				});
			});
		});
	</script>

