<?php 
	date_default_timezone_set('Asia/Manila');

    include 'connection.inc.php';
	$empidErr = $firstnameErr = $lastnameErr = $middlenameErr = $addressErr = $birthdateErr = $biometricErr = $phoneErr = $emailErr = $dateemployedErr = "";
	$empid = $firstname = $lastname = $middlename = $address = $birthdate = $biometric = $phone = $email = $dateemployed = "";

	//add data
	if(isset($_POST['insertdata'])){

		$empid = mysqli_real_escape_string($conn, $_POST['empId']);
		$firstname = mysqli_real_escape_string($conn, $_POST['fname']);
		$lastname = mysqli_real_escape_string($conn, $_POST['lname']);
		$middlename = mysqli_real_escape_string($conn, $_POST['midname']);
		$address = mysqli_real_escape_string($conn, $_POST['address']);	
		$gender = mysqli_real_escape_string($conn, $_POST['genderselected']);	
		$birthdate = mysqli_real_escape_string($conn, $_POST['birthdate']);
		$biometric =  mysqli_real_escape_string($conn,$_POST['bioId']);	
		$phone =  mysqli_real_escape_string($conn,$_POST['pNumber']);	
		$email =  mysqli_real_escape_string($conn, $_POST['emailadd']);	
		$position =  mysqli_real_escape_string($conn, $_POST['selectposition']);
		$department = mysqli_real_escape_string($conn, $_POST['selectdepartment']);
		$schedule =  mysqli_real_escape_string($conn,$_POST['selectschedule']);
		$dateemployed =  mysqli_real_escape_string($conn, $_POST['dateemployed']);
		$status = mysqli_real_escape_string($conn, 'Active');
		$employment_type = mysqli_real_escape_string($conn, $_POST['employment_type']);
		$year = date("Y");
		$hashedPwd = password_hash($empid, PASSWORD_DEFAULT);
        // $imageFileType = $_FILES['file']['type'];
        

        // $location = "../Uploads/";
        // $file = $_FILES['file']['name'];
        // $file_tmp = $_FILES['file']['tmp_name'];
				
		$error = false;

		$sql = "SELECT * FROM employees WHERE emailadd='$email'";
  		$res = mysqli_query($conn, $sql);
		
		if(mysqli_num_rows($res) > 0){
			$emailErr =  "Email Already Taken!";
			$error = true;

		}else{
		
			if (empty($email)) {
				$emailErr =  "Email is required";
				$error = true;
			} else {
				// check if e-mail address is well-formed
				if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					$emailErr =  "Invalid email format";
					$error = true;
				}
			}
		}

		$sql1 = "SELECT * FROM employees WHERE empId='$empid'";
		$res1 = mysqli_query($conn, $sql1);

		if(mysqli_num_rows($res1) > 0){
			$empidErr = "Id Already Exist!";
			$error = true;

		}else{
			if (empty($empid)) {
				$empidErr = "Id is required";
				$error = true;
			} else {
				// check if name only contains letters and whitespace
				if (!preg_match("/^[1-9][0-9]*$/", $empid)) {
					$empidErr = "Only numbers are allowed";
					$error = true;
				}
			}
		}
		if (empty($firstname)) {
			$firstnameErr = "First Name is required";
			$error = true;
		} else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$firstname)) {
				$firstnameErr = "Only letters are allowed";
				$error = true;
			}
		}

		if (empty($lastname)) {
			$lastnameErr = "Surname is required";
			$error = true;
		} else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$lastname)) {
				$lastnameErr = "Only letters are allowed";
				$error = true;
			}
		}	

		// if (empty($middlename)) {
		// 	$middlenameErr = "Middle Name is required";
		// 	$error = true;
		// } else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$middlename)) {
				$middlenameErr = "Only letters are allowed";
				$error = true;
			}
		//}

		if (empty($address)) {
			$addressErr = "Address is required";
			$error = true;
		}

		$sql2 = "SELECT * FROM employees WHERE bioId='$biometric'";
		$res2 = mysqli_query($conn, $sql2);
		if(mysqli_num_rows($res2) > 0){
			$biometricErr = "Id Already Exist";
			$error = true;

		}else{
			if (empty($biometric)) {
				$biometricErr = "Id is required";
				$error = true;
			} else {
				// check if name only contains letters and whitespace
				if (!preg_match("/^[1-9][0-9]*$/", $biometric)) {
					$biometricErr = "Only numbers are allowed";
					$error = true;
				}
			}	
		}

		$sql3 = "SELECT * FROM employees WHERE pNumber='$phone'";
		$res3 = mysqli_query($conn, $sql3);

		if(mysqli_num_rows($res3) > 0){
			$phoneErr = "Number Already Exist";
			$error = true;

		}else{
			if (empty($phone)) {
				$phoneErr = "Number is required";
				$error = true;
			} else {
				// check if name only contains letters and whitespace
				if (!preg_match("/(^\+?63(?!.*-.*-)(?!.*\+.*\+)(?:\d(?:-)?){10,11}$)|(^09(?!.*-.*-)(?!.*-.*-)(?:\d(?:-)?){9}$)/", $phone)) {
					$phoneErr = "Invalid Number!";
					$error = true;
				}
			}	
		}

		if($error == true){
			echo "<script>alert('Failed To Upload!')</script>";
			?>
				<script>
					$(document).ready(function () {
						$('#addemp').modal('show');
					});
				</script>			
			<?php
		}else{
			$query1 = "INSERT INTO employees (empId, bioId, lName, fName, midName, birthdate, gender, pNumber, address, password, emailadd, employment_type, scheduleid, deptid, positionid, employedDate, status) 
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
			$stmt = mysqli_stmt_init($conn);

			if(!mysqli_stmt_prepare($stmt, $query1)){
			 	echo "SQL Statement Failed!";
			}else{

				mysqli_stmt_bind_param($stmt, "sissssssssssiiiss", $empid, $biometric, $lastname, $firstname,  $middlename, $birthdate,  $gender, $phone, $address, $hashedPwd,  $email, $employment_type, $schedule,  $department, $position, $dateemployed, $status);
				mysqli_stmt_execute($stmt);

				$query2 = "SELECT * FROM leave_type WHERE deptId = '$department' AND employment_type = '$employment_type'";
				$res_query2 = mysqli_query($conn, $query2);
				
					while($res_row = mysqli_fetch_array($res_query2)){
						$leaveid = $res_row['LeaveId'];
						$leaveHrs = $res_row['default_hours'];
						
						$query3 = "INSERT INTO emp_annual_leave (empId, leaveId, year_number, allowed_hours, remaining_hours) VALUES('$empid', '$leaveid', '$year', '$leaveHrs', '$leaveHrs')";
						$res_query3 = mysqli_query($conn, $query3);
					}


				echo "<script>alert('1 Record Added!')
				window.location.href = '../admin/personnel.php';
				</script>";
				mysqli_stmt_close($stmt);
			}
		}
		
	}

?>