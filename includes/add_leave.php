<?php
	date_default_timezone_set('Asia/Manila');
    include 'connection.inc.php';

	//add data
	if(isset($_POST['insertdata'])){

		$empid = mysqli_real_escape_string($conn, $_POST['empId']);
		$leave = mysqli_real_escape_string($conn, $_POST['selectleave']);
		$start = mysqli_real_escape_string($conn, $_POST['startdate']);
		$end = mysqli_real_escape_string($conn, $_POST['enddate']);
		$day_type = mysqli_real_escape_string($conn, $_POST['type']);
		$reason = mysqli_real_escape_string($conn, $_POST['reason']);
		$totalhrs = mysqli_real_escape_string($conn, $_POST['half1']);
		$totalhrs1 = mysqli_real_escape_string($conn, $_POST['half2']);
		$status = mysqli_real_escape_string($conn, "Pending");
		$end1 = date("Y-m-d", strtotime($end.'+1 day'));

		if($day_type == 1){
			$day_type = 'Full Day';
		}else if($day_type == 2){
			$day_type = 'Half Day';
		}else{
			$day_type = 'Hours';
		}


		$sql = "SELECT * FROM employees INNER JOIN schedules ON schedules.scheduleId = employees.scheduleid INNER JOIN department ON department.deptId = employees.deptid WHERE empId = '$empid'";
		$res = mysqli_query($conn, $sql);
		$res_row = mysqli_fetch_array($res);
		$department = $res_row['deptId'];
		$date_now = date("Y-m-d");
		$startH = date('H:i', strtotime($res_row['time_inAm']));
		$endH = date('H:i', strtotime($res_row['time_outPm']));
		$combinedDT1 = date('Y-m-d H:i:s',strtotime($date_now.' '.$startH));
		$combinedDT2 = date('Y-m-d H:i:s',strtotime($date_now.'+1 day '.$endH));
		$diff = gmdate('H:i', floor(abs(strtotime($combinedDT1) - strtotime($combinedDT2)))-3600);
		$diff1 = floor(date("H", strtotime($diff)));
		$diff_half = floor(date("H", strtotime($diff))/2);
		$cwh = new CountWorkingHours();

		if($department == 1){
			$cwh->hours = ['Mon' => $diff1, 'Tue' => $diff1, 'Wed' => $diff1, 'Thu' => $diff1, 'Fri' => $diff1, 'Sat' => 0, 'Sun' => 0];
			$hours = $cwh->get_hours_for_period($start, $end1);
	
			$error = false;
	
			$check_query = "SELECT * FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
			$check_result = mysqli_query($conn, $check_query);
			$check_row = mysqli_fetch_array($check_result);
			$leave_remaining = $check_row['remaining_hours'];
	
			if($day_type == 'Full Day'){
				if($hours > $leave_remaining){
					echo "<script>alert('Selected Date is greater than remaining hours. Please try again.')</script>";
					?>
						<script>
							$(document).ready(function () {
								$('#addemp').modal('show');
							});
						</script>			
					<?php
				}else{
					$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, endDate, leave_reason, total_leavehrs, leave_status)
					VALUES('$empid','$leave', '$day_type', '$start','$end', '$reason', '$hours', '$status')";
					$result = mysqli_query($conn, $sql);
				
					if($result){
						$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
						$results = mysqli_query($conn, $sql1);
						$row = mysqli_fetch_array($results);
						$leavetotal = $row['remaining_hours'] - $hours;

						$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
						$results1 = mysqli_query($conn, $sql2);
						echo '<script>alert("1 Record Added");</script>';
						echo"<script>window.location.href = 'leave.php';</script>";
				
					}else{
						echo '<script>alert("Data Not Saved");</script>';
						echo"<script>
						history.go(-1)</script>";
					}
				}
			}else if($day_type == 'Hours'){
				if($totalhrs >= $diff1){
					echo "<script>alert('Selected hour is not applicable for $day_type type. Please try again.')</script>";
					?>
						<script>
							$(document).ready(function () {
								$('#addemp').modal('show');
							});
						</script>			
					<?php
				}else{
					$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, leave_reason, total_leavehrs, leave_status)
					VALUES('$empid','$leave', '$day_type', '$start','$reason', '$totalhrs', '$status')";
					$result = mysqli_query($conn, $sql);
				
					if($result){
						$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
						$results = mysqli_query($conn, $sql1);
						$row = mysqli_fetch_array($results);
						$leavetotal = $row['remaining_hours'] - $totalhrs;
						$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
						$results1 = mysqli_query($conn, $sql2);
						echo '<script>alert("1 Record Added");</script>';
						echo"<script>window.location.href = 'leave.php';</script>";
				
					}else{
						echo '<script>alert("Data Not Saved");</script>';
						echo"<script>
						history.go(-1)</script>";
					}
				}
			}else{
				$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, leave_reason, total_leavehrs, leave_status)
				VALUES('$empid','$leave', '$day_type', '$start','$reason', '$totalhrs1', '$status')";
				$result = mysqli_query($conn, $sql);
			
				if($result){
					$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
					$results = mysqli_query($conn, $sql1);
					$row = mysqli_fetch_array($results);
					$leavetotal = $row['remaining_hours'] - $totalhrs1;

					$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
					$results1 = mysqli_query($conn, $sql2);
					echo '<script>alert("1 Record Added");</script>';
					echo"<script>window.location.href = 'leave.php';</script>";
			
				}else{
					echo '<script>alert("Data Not Saved");</script>';
					echo"<script>
					history.go(-1)</script>";
				}
			}
		}else{
			$cwh->hours = ['Mon' => $diff1, 'Tue' => $diff1, 'Wed' => $diff1, 'Thu' => $diff1, 'Fri' => $diff1, 'Sat' => 3, 'Sun' => 0];
			$hours = $cwh->get_hours_for_period($start, $end1);
	
			$error = false;
	
			$check_query = "SELECT * FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
			$check_result = mysqli_query($conn, $check_query);
			$check_row = mysqli_fetch_array($check_result);
			$leave_remaining = $check_row['remaining_hours'];
	
			if($day_type == 'Full Day'){
				if($hours > $leave_remaining){
					echo "<script>alert('Selected Date is greater than remaining hours. Please try again.')</script>";
					?>
						<script>
							$(document).ready(function () {
								$('#addemp').modal('show');
							});
						</script>			
					<?php
				}else{
					$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, endDate, leave_reason, total_leavehrs, leave_status)
					VALUES('$empid','$leave', '$day_type', '$start','$end', '$reason', '$hours', '$status')";
					$result = mysqli_query($conn, $sql);
				
					if($result){
						$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
						$results = mysqli_query($conn, $sql1);
						$row = mysqli_fetch_array($results);
						$leavetotal = $row['remaining_hours'] - $hours;
						$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
						$results1 = mysqli_query($conn, $sql2);
						echo '<script>alert("1 Record Added");</script>';
						echo"<script>window.location.href = 'leave.php';</script>";
				
					}else{
						echo '<script>alert("Data Not Saved");</script>';
						echo"<script>
						history.go(-1)</script>";
					}
				}
			}else if($day_type == 'Half Day'){
				if($totalhrs > $diff_half){
					echo "<script>alert('Selected hour is not applicable for $day_type type. Please try again.')</script>";
					?>
						<script>
							$(document).ready(function () {
								$('#addemp').modal('show');
							});
						</script>			
					<?php
				}else{
					$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, endDate, leave_reason, total_leavehrs, leave_status)
					VALUES('$empid','$leave', '$day_type', '$start','$end', '$reason', '$totalhrs1', '$status')";
					$result = mysqli_query($conn, $sql);
				
					if($result){
						$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
						$results = mysqli_query($conn, $sql1);
						$row = mysqli_fetch_array($results);
						$leavetotal = $row['remaining_hours'] - $totalhrs1;
						$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
						$results1 = mysqli_query($conn, $sql2);
						echo '<script>alert("1 Record Added");</script>';
						echo"<script>window.location.href = 'leave.php';</script>";
				
					}else{
						echo '<script>alert("Data Not Saved");</script>';
						echo"<script>
						history.go(-1)</script>";
					}
				}
			}else if($day_type == 'Hours'){
				if($totalhrs >= $diff1){
					echo "<script>alert('Selected hour is not applicable for $day_type type. Please try again.')</script>";
					?>
						<script>
							$(document).ready(function () {
								$('#addemp').modal('show');
							});
						</script>			
					<?php
				}else{
					$sql = "INSERT INTO leave_taken (empId, leaveId, day_type, startDate, leave_reason, total_leavehrs, leave_status)
					VALUES('$empid','$leave', '$day_type', '$start','$reason', '$totalhrs', '$status')";
					$result = mysqli_query($conn, $sql);
				
					if($result){
						$sql1 = "SELECT remaining_hours FROM emp_annual_leave WHERE empId = '$empid' AND leaveId = '$leave'";
						$results = mysqli_query($conn, $sql1);
						$row = mysqli_fetch_array($results);
						$leavetotal = $row['remaining_hours'] - $totalhrs;
						$sql2 = "UPDATE emp_annual_leave SET remaining_hours = '$leavetotal' WHERE empId = '$empid' AND leaveId = '$leave'";
						$results1 = mysqli_query($conn, $sql2);
						echo '<script>alert("1 Record Added");</script>';
						echo"<script>window.location.href = 'leave.php';</script>";
				
					}else{
						echo '<script>alert("Data Not Saved");</script>';
						echo"<script>
						history.go(-1)</script>";
					}
				}
			}			
		}

	}
	
	class CountWorkingHours{
        // Define hours counted for each day:
        public array $hours = [];

        // Method for counting the hours:
        public function get_hours_for_period(string $start, string $end1): int
        {
            // Create DatePeriod with requested Start/End dates:
            $period = new DatePeriod(
                new DateTime($start), 
                new DateInterval('P1D'), 
                new DateTime($end1)
            );
            
            $hours = [];

            // Loop over DateTime objects in the DatePeriod:
            foreach($period as $date) {
                // Get name of day and add matching hours:
                $day = $date->format('D');
                $hours[] = $this->hours[$day];
            }
            // Return sum of hours:
            return array_sum($hours);
        }
    }
?>

<?php
	if(isset($_POST['insertleavetype'])){

		$name = mysqli_real_escape_string($conn, $_POST['leaveName']);
		$desc = mysqli_real_escape_string($conn, $_POST['Description']);
		$default_hrs = mysqli_real_escape_string($conn, $_POST['default_hrs']);
		$department = mysqli_real_escape_string($conn, $_POST['department']);
		$employment_type = mysqli_real_escape_string($conn, $_POST['employment_type']);

		$sql = "SELECT * FROM leave_type WHERE leaveCode = '$name' AND leave_name = '$desc' AND deptId='$department' AND employment_type='$employment_type'";
		$result0 = mysqli_query($conn, $sql);
		if(mysqli_num_rows($result0) > 0){
			echo "<script>alert('Leave Type Already Exist!')</script>";
			echo"<script>window.location.href = '../admin/leave_type.php';</script>";

		}else{
			$query = "INSERT INTO leave_type (leaveCode, leave_name, default_hours, employment_type, deptId) VALUES('$name', '$desc', '$default_hrs', '$employment_type', '$department')";
			$result = mysqli_query($conn, $query);
	
			if($result){
				$leavetype_id = mysqli_insert_id($conn);	
				$year = date('Y');
				$query1 = "SELECT * FROM employees WHERE employment_type = '$employment_type' AND deptid = '$department'";
				$query1_res = mysqli_query($conn, $query1);
				while($row = mysqli_fetch_array($query1_res)){
					$empid = $row['empId'];
					
					$query2 = "INSERT INTO emp_annual_leave (empId, year_number, leaveId, allowed_hours, remaining_hours) VALUES ('$empid', '$year', '$leavetype_id', '$default_hrs', '$default_hrs')";
					$res = mysqli_query($conn, $query2);
				}
	
				echo '<script>alert("1 Record Added");</script>';
				echo"<script>window.location.href = '../admin/leave_type.php';</script>";
	
			}else{
				echo '<script>alert("Data Not Saved");</script>';
				echo"<script>
				history.go(-1)</script>";
			}
		}
	}
?>
