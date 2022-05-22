<?php
    include("connection.inc.php");
    include("add_user.php");
?>

<!-- Add Employee Data -->
<div class="modal" id="addemp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h4 class="modal-title" style="text-align: center;">Add Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="addForm">
                <!-- Modal body -->
                <div class="modal-body">
                    <p class="form-message"></p>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="pass" value="<?php echo $empid;?>">
                                <label for="recipient-name" class="col-form-label">Employee Id:</label> 
                                <input type="text" class="form-control" name="empId" id="empId" value="<?php echo $empid;?>" placeholder="Employee Id">
                                <small><span class="form-error"><?php echo $empidErr;?></span></small>
                            </div>
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Biometric Id:</label>
                                <input type="text" class="form-control" name="bioId" id="bioId" value="<?php echo $biometric;?>" placeholder="Biometric Id">
                                <span class="form-error"><?php echo $biometricErr;?></span>
                            </div>
                        </div>
                    </div>   
                    <div class="mb-1">
                        <div class="row">
                           <div class="col-md-4">
                                <label for="recipient-name" class="col-form-label">Last Name:</label>
                                <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $lastname;?>" placeholder="Last Name">
                                <small><span class="form-error"><?php echo $lastnameErr;?></span></small>
                            </div>
                            <div class="col-md-4">
                                <label for="recipient-name" class="col-form-label">First Name:</label> 
                                <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $firstname;?>" placeholder="First Name">
                                <small><span class="form-error"><?php echo $firstnameErr;?></span></small>
                            </div>
                            <div class="col-md-4">
                                <label for="recipient-name" class="col-form-label">Middle Name:</label>
                                <input type="text" class="form-control" name="midname" id="midname" value="<?php echo $middlename;?>" placeholder="Middle Name">
                                <small><span class="form-error"><?php echo $middlenameErr;?></span></small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Address:</label>
                                <input type="text" class="form-control" name="address" id="address" value="<?php echo $address;?>" placeholder="Address">
                                <small><span class="form-error"><?php echo $addressErr;?></span></small>
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="col-form-label">Birth Date:</label>
                                <input type="date" class="form-control" name="birthdate" id="birthdate" value="<?php echo $birthdate;?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Gender:</label>
                                <select class="form-select" aria-label="Select" name="genderselected" id="genderselected" required>
                                    <option value disabled selected>Gender</option>
                                    <option value="Male" >Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div> 
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Phone:</label><small style=""><i>(Note: 09...)</i></small>
                                <input type="text" class="form-control" name="pNumber" id="pNumber" maxlength="11" value="<?php echo $phone;?>" placeholder="Phone Number">
                                <small><span class="form-error"><?php echo $phoneErr;?></span></small>
                            </div> 
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Email: </label>
                                <input type="text" class="form-control" name="emailadd" id="emailadd" value="<?php echo $email;?>"placeholder="Email Address">
                                <small><span class="form-error"><?php echo $emailErr;?></span></small>
                            </div> 
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Employment Type:</label>
                                <select class="form-select" aria-label="Default select example" name="employment_type" required>
                                    <option  value disabled selected>Select Employment Type</option>
                                    <option  value="Regular">Regular</option>
                                    <option  value="Probationary">Probationary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">                           
                        <div class="row">  
                            <div class="col">
                                <label for="department" class="col-form-label">Department:</label>
                                <select class="form-select department" aria-label="Default select example" name="selectdepartment" id="selectdepartment" required>
                                    <option value disabled selected>Select Department</option>
                                    <?php
                                        $dept = "SELECT * FROM department";
                                        $dept_res = mysqli_query($conn, $dept);
                                        while($dept_row = mysqli_fetch_array($dept_res)){
                                            echo "<option value='".$dept_row['deptId'] ."'>". $dept_row['deptName'] ."</option>";
                                        }	
                                    ?>
                                </select>
                            </div>                         
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Position:</label>
                                <select class="form-select position" aria-label="Default select example" name="selectposition" id="selectposition" required>
                                    <option  value disabled selected>Select Position</option>
                                    <!--?php 
                                        $pos = "SELECT * FROM position";
                                        $pos_res = mysqli_query($conn, $pos) or die("Bad Query: $pos");
                                        
                                        while($pos_row = mysqli_fetch_array($pos_res)){
                                            echo "<option value='".$pos_row['positionId'] ."'>". $pos_row['positionName'] ."</option>";
                                        }
                                    ?-->
                                </select>
                            </div>
                        </div>
                    </div> 
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Schedule:</label>
                                <select class="form-select" aria-label="Default select example" name="selectschedule" id="selectschedule" required>
                                    <option value disabled selected>Select Schedule</option>
                                <?php    
                                    $sql = "SELECT * FROM schedules";
                                    $result = mysqli_query($conn, $sql);

                                    while($row = mysqli_fetch_array($result)){
                                ?>
                                    <option value="<?php echo $row['scheduleId']?>"><?php echo date("h:i A", strtotime($row['time_inAm'])) .' - '. date("h:i A", strtotime($row['time_outPm'])) ;?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div> 
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Date Employed:</label>
                                <input type="date" class="form-control" name="dateemployed" id="dateemployed" value="<?php echo $dateemployed;?>" required>
                            </div> 
                        </div>
                    </div>                 
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="insertdata" name="insertdata" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View Employee Data -->
<div class="modal" id="viewemp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">View Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Modal body -->
            <div class="modal-body display_emp">

            </div>
            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Employee Data -->
<div class="modal" id="editemp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Employee</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="updateForm">
                <!-- Modal body -->
                <div class="modal-body displayedit_emp">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updatedata">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Update Leave Credits -->
<div class="modal fade" id="exampleModalToggle2" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalToggleLabel2">Update Leave Credits</h5>
			</div>
			<div class="modal-body">
                <div class="mb-1">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="recipient-name" class="col-form-label">Type:</label>
                            <select class="form-select position" aria-label="Default select example" name="selectposition" id="selectposition" required>
                                <option  value disabled selected>Select Leave</option>
                                <?php 
                                    $leave_query = "SELECT * FROM leave_type";
                                    $leave_result = mysqli_query($conn, $leave_query);
                                    while($leave_row = mysqli_fetch_array($leave_result)){
                                        echo "<option value='".$leave_row['LeaveId'] ."'>". $leave_row['leaveName'] ."</option>";
                                    }
                                ?>                                    
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="recipient-name" class="col-form-label">Allowed Hours:</label>
                            <span class="form-error"><?php echo $addressErr;?></span>
                            <input type="number" min="0" class="form-control" name="address" id="address" value="<?php echo $address;?>" placeholder="Allowed Hours">
                        </div>
                        <div class="col-md-3">
                            <label for="recipient-name" class="col-form-label">Hours Taken:</label>
                            <span class="form-error"><?php echo $addressErr;?></span>
                            <input type="number" min="0" class="form-control" name="address" id="address" value="<?php echo $address;?>" placeholder="Hours Taken">
                        </div>
                        <div class="col-md-3">
                            <label for="recipient-name" class="col-form-label">Remaining Hours:</label>
                            <span class="form-error"><?php echo $addressErr;?></span>
                            <input type="number" min="0" class="form-control" name="address" id="address" value="<?php echo $address;?>" placeholder="Remaining Hours">
                        </div>
                    </div>
                </div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-bs-target="#viewemp" data-bs-toggle="modal">Cancel</button>
				<button type="button" class="btn btn-primary" >Update</button>
			</div>
		</div>
	</div>
</div>

<!-- Reset Password -->
<div class="modal" id="resetpwd">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Confirm Action</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="resetpwdForm">
                <!-- Modal body -->
                <div class="modal-body resetpwd_emp">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button type="submit" class="btn btn-primary" id="resetpwddata">Proceed</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        //view employee
        $('.view_btn').click(function() {
            id_emp = $(this).attr('id');
            $.ajax({
                url: "../includes/viewdata.php",
                method :'post',
                data:{emp_id:id_emp},
                success: function(result){
                    $(".display_emp").html(result);            
                    $('#viewemp').modal('show');
                }
            });
        });

        //edit employee
        $('.edit_btn').click(function() {
            id_emp = $(this).attr('id');
            $.ajax({
                url: "../includes/editdata.php",
                method :'post',
                data:{edit_id:id_emp},
                success: function(result){
                    $(".displayedit_emp").html(result);
                    $('#editemp').modal('show');
                }
            }); 
        });

        $(document).on('click', '#updatedata', function(){
            $.ajax({
                url: "../includes/updatedata.php",
                method :'post',
                data:$("#updateForm").serialize(),
                success: function(result){
                    alert('Data Successfully Updated');
                    $('#editemp').modal('hide');
                    location.reload();
                }
            }); 
        });

        $(".department").change(function(){
            var dept_id = $(this).val();
            $.ajax({
                url: "../includes/position_dept.php",
                method: "POST",
                data: {dept_id:dept_id},
                success: function(data){
                    $(".position").html(data);
                }
            });
        });     
    });
</script>

