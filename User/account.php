<?php
	$title = "My Account";
	require("header.php");
    $email = $_SESSION['email'];
    $sql = "SELECT * FROM employees WHERE emailadd = '$email'";
    $res = mysqli_query($conn, $sql);

	$firstnameErr = $lastnameErr = $middlenameErr = $addressErr = $phoneErr = $emailErr = $SSSErr = 
    $PAGIBIGErr = $PHILHEALTHErr = $TINErr = $GSISErr = $contactpersonErr = $contactpersonnoErr = "";

    if(isset($_POST['update_profile'])){
        $empid = mysqli_real_escape_string($conn, $_POST['empId']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $midname = mysqli_real_escape_string($conn, $_POST['midname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $PHILHEALTH = mysqli_real_escape_string($conn, $_POST['PHILHEALTH']);
        $GSIS = mysqli_real_escape_string($conn, $_POST['GSIS']);
        $SSS = mysqli_real_escape_string($conn, $_POST['SSS']);
        $TIN = mysqli_real_escape_string($conn, $_POST['TIN']);
        $PAGIBIG = mysqli_real_escape_string($conn, $_POST['PAGIBIG']);
        $address = mysqli_real_escape_string($conn, $_POST['address']);
        $emailadd = mysqli_real_escape_string($conn, $_POST['email']);
        $pnumber = mysqli_real_escape_string($conn, $_POST['pnumber']);
        $contactperson = mysqli_real_escape_string($conn, $_POST['contactperson']);
        $contactpersonno = mysqli_real_escape_string($conn, $_POST['contactpersonno']);
        $location = "../Uploads/";

        $error = false;

		if (empty($emailadd)) {
			$emailErr = "Email is required";
			$error = true;
		} else {
			// check if e-mail address is well-formed
			if (!filter_var($emailadd, FILTER_VALIDATE_EMAIL)) {
				$emailErr = "Invalid email format";
		    	$error = true;
			}
		}

        if (empty($fname)) {
			$firstnameErr = "First Name is required";
			$error = true;
		} else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$fname)) {
				$firstnameErr = "Only letters are allowed";
				$error = true;
			}
		}

		if (empty($lname)) {
			$lastnameErr = "Surname is required";
			$error = true;
		} else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$lname)) {
				$lastnameErr = "Only letters are allowed";
				$error = true;
			}
		}	

		// if (empty($midname)) {
		// 	$middlenameErr = "Middle Name is required";
		// 	$error = true;
		// } else {
			// check if name only contains letters and whitespace
			if (!preg_match("/^[a-zA-Z-.'ñ-Ñ ]*$/",$midname)) {
				$middlenameErr = "Only letters are allowed";
				$error = true;
			}
		// }

		if (empty($address)) {
			$addressErr = "Address is required";
			$error = true;
		}

        $sql3 = "SELECT * FROM employees WHERE pNumber='$pnumber'";
		$res3 = mysqli_query($conn, $sql3);

		if (empty($pnumber)) {
			$phoneErr = "Number is required";
			$error = true;
		} else {
				// check if name only contains letters and whitespace
			if (!preg_match("/(^\+?63(?!.*-.*-)(?!.*\+.*\+)(?:\d(?:-)?){10,11}$)|(^09(?!.*-.*-)(?!.*-.*-)(?:\d(?:-)?){9}$)/", $pnumber)) {
				$phoneErr = "Invalid Number!";
				$error = true;
			}
		}	
        $sql4 = "SELECT * FROM employees WHERE contactpersonno='$contactpersonno'";
		$res4 = mysqli_query($conn, $sql4);

		if (empty($contactpersonno)) {
			$contactpersonnoErr = "Number is required";
			$error = true;
		} else {
				// check if name only contains letters and whitespace
			if (!preg_match("/(^\+?63(?!.*-.*-)(?!.*\+.*\+)(?:\d(?:-)?){10,11}$)|(^09(?!.*-.*-)(?!.*-.*-)(?:\d(?:-)?){9}$)/", $contactpersonno)) {
				$contactpersonnoErr = "Invalid Number!";
				$error = true;
			}
		}
        
        if($error == true){
			echo "<script>alert('Failed To Update!')</script>";
		}else{
            //Fetch user details
            $query = "SELECT pPhoto FROM employees WHERE empId=" . $empid;
            $result = mysqli_query($conn, $query);
            $photo_row = false;
            if (mysqli_num_rows($result) > 0) {
                $photo_row = mysqli_fetch_assoc($result);
            }
            $name=$_FILES['pphoto']['name'];
            $temp_name=$_FILES['pphoto']['tmp_name'];
            $imageFileType = $_FILES['pphoto']['type'];

            if (!is_uploaded_file($_FILES['pphoto']['tmp_name'])) { //User did not upload image
                $update_profile = "UPDATE employees SET fName = ?, lName = ?, midName = ?, philhealth = ?, gsis = ?, sss = ?, tin = ?, pagibig = ?, address = ?, emailadd = ?, pNumber = ?, contactperson = ?, contactpersonno = ? WHERE empId = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $update_profile)){
                    echo "<script>alert('SQL Error!')</script>";
                    header('location: account.php?error=stmtfailed');
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ssssssssssssss", $fname, $lname, $midname, $PHILHEALTH, $GSIS, $SSS, $TIN, $PAGIBIG, $address, $emailadd, $pnumber, $contactperson, $contactpersonno, $empid); 
                    mysqli_stmt_execute($stmt);
                    $_SESSION["email"] = $emailadd;
            
                    move_uploaded_file($temp_name,$location.$name);
                    echo"<script>alert('Update Successful')</script>";
                    echo "<script>window.location.href = 'account.php'</script>";
                }     
            } else { //User uploaded new image         

                if($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg"){
                    echo "<script> alert('Sorry, only JPG, JPEG, & PNG files are allowed.')</script>"; 
                }else{
                    if ($_FILES["pphoto"]["size"] > 500000) { //500kb
                        echo "<script> alert('File too large.')</script>"; 
                    }else{
                        $update_profile = "UPDATE employees SET fName = ?, lName = ?, midName = ?, philhealth = ?, gsis = ?, sss = ?, tin = ?, pagibig = ?, address = ?, emailadd = ?, pNumber = ?, contactperson = ?, contactpersonno = ?, pPhoto = ? where empId = ?";
                        $stmt = mysqli_stmt_init($conn);
                        if(!mysqli_stmt_prepare($stmt, $update_profile)){
                            echo "<script>alert('SQL Error!')</script>";
                            header('location: account.php?error=stmtfailed');
                            exit();
                        }else{
                            mysqli_stmt_bind_param($stmt, "sssssssssssssss", $fname, $lname, $midname, $PHILHEALTH, $GSIS, $SSS, $TIN, $PAGIBIG, $address, $emailadd, $pnumber,  $contactperson, $contactpersonno, $name, $empid); 
                            mysqli_stmt_execute($stmt);
                            $_SESSION["email"] = $emailadd;

                            if ($photo_row) {
                                unlink($location . $photo_row['pPhoto']); //Delete old pic
                            }
                            move_uploaded_file($temp_name,$location.$name);
                            echo"<script>alert('Update Successful')</script>";
                            echo "<script>window.location.href = 'account.php'</script>";
                        }    
                    }            
                }
            }      
        }   
    }
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Your Profile</b></span>
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
            <div class="graphbox" id="graph_box">
                    <div class="update-profile" >
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php
                                while($row = mysqli_fetch_array($res)){
                                    $image = $row['pPhoto'];
                                    if (empty($image)) {
                                        echo "<img src='../images/default-profile.jpg' class='center'>";
                                    }else{
                                        echo "<img src='../Uploads/".$image."' class='center'>";
                                    }
                            ?>

                            <h1 class="text-center"><?php echo $row['fName'].' '.$row['lName'];?></h1>
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-4">
                                        <input type="hidden" name="empId" value="<?php echo $row['empId']?>">
                                        <label for="recipient-name" class="col-form-label">First Name:</label>
                                        <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $row['fName']?>">
                                        <span class="form-error"><?php echo $firstnameErr;?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="recipient-name" class="col-form-label">Middle Name:</label>
                                        <input type="text" class="form-control" name="midname" id="midname" value="<?php echo $row['midName'];?>">
                                        <span class="form-error"><?php echo $middlenameErr;?></span>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="recipient-name" class="col-form-label">Last Name:</label>
                                        <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $row['lName'];?>">
                                        <span class="form-error"><?php echo $lastnameErr;?></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-1">
				                <div class="row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Email:</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['emailadd']?>">
                                        <span class="form-error"><?php echo $emailErr;?></span>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Phone Number:</label>
                                        <input type="text" class="form-control" name="pnumber" id="pnumber" maxlength="11" value="<?php echo $row['pNumber']?>">
                                        <span class="form-error"><?php echo $phoneErr;?></span>
                                    </div>
								</div>
							</div>
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Address:</label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $row['address']?>">
                                        <span class="form-error"><?php echo $addressErr;?></span>
                                    </div>
                                    <div class="col">
				                        <label for="recipient-name" class="col-form-label">PhilHealth No.:</label>
				                        <input type="text" class="form-control" name="PHILHEALTH" id="PHILHEALTH" value="<?php echo $row['philhealth'];?>">
                                        <span class="form-error"><?php echo $PHILHEALTHErr;?></span>
				                    </div>
                                </div>                
                            </div>
                            <div class="mb-1">
				                <div class="row">
									<div class="col">
										<label for="recipient-name" class="col-form-label">GSIS No.:</label>
										<input type="text" class="form-control" name="GSIS" id="GSIS" value="<?php echo $row['gsis'];?>">
										<span class="form-error"><?php echo $GSISErr;?></span>
									</div>
				                    <div class="col">
				                        <label for="recipient-name" class="col-form-label">SSS No.:</label>
				                        <input type="text" class="form-control" name="SSS" id="SSS" value="<?php echo $row['sss'];?>">
                                        <span class="form-error"><?php echo $SSSErr;?></span>
				                    </div>
				                </div>
				            </div>
                            <div class="mb-1">
				                <div class="row">
									<div class="col-md-6">
										<label for="recipient-name" class="col-form-label">TIN No.:</label>
										<input type="text" class="form-control" name="TIN" id="TIN" value="<?php echo $row['tin'];?>">
										<span class="form-error"><?php echo $TINErr;?></span>
									</div>
				                    <div class="col-md-6">
				                        <label for="recipient-name" class="col-form-label">PagIbig No.:</label>
				                        <input type="text" class="form-control" name="PAGIBIG" id="PAGIBIG" value="<?php echo$row['pagibig'];?>">
                                        <span class="form-error"><?php echo $PAGIBIGErr;?></span>
				                    </div>
								</div>
							</div>
                            <div class="mb-1">
			 				    <div class="row">
									<div class="col-md-6">
				 						<label for="recipient-name" class="col-form-label">Contact Person:</label>
			 							<input type="text" class="form-control" name="contactperson" id="contactperson" value="<?php echo ucwords($row['contactperson']);?>">
				 						<span class="form-error"><?php echo $contactpersonErr;?></span>
				 					</div>
									<div class="col-md-6">
										<label for="recipient-name" class="col-form-label">Contact Person's Phone Number:</label>
										<input type="text" class="form-control" name="contactpersonno" id="contactpersonno" maxlength="11" value="<?php echo $row['contactpersonno']?>">
										<span class="form-error"><?php echo $contactpersonnoErr;?></span>
									</div>
								</div>
							</div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="recipient-name" class="col-form-label">Profile Photo:</label> <small style="font-size: 11px; color: #fff;"><i>(Note: Only JPEG, JPG and PNG)</i></small>
                                        <input type="file" class="form-control" name="pphoto" id="pphoto">
                                        <small style="font-size: 11px; color: #fff;"><i>(Additional: Maximum of 5 mb allowed!)</i></small>
                                    </div>
                                </div>
                            </div>                        
                                <input type="submit" value="Update Profile" name="update_profile" class="btn btn-success form-control">
                            <?php
                                }
                            ?>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>

<?php
	include 'footer.php';
?>