<?php 
    include 'connection.inc.php';

	//edit data
	if(isset($_POST['edit_id'])){

		$id = $_POST['edit_id'];

		$sqlget = "SELECT * FROM employees INNER JOIN leave_taken on leave_taken.empId=employees.empId
		INNER JOIN leave_type on leave_type.LeaveId=leave_taken.leaveId WHERE leave_taken.period_id = $id";
		$res = mysqli_query($conn, $sqlget);

		while($row = mysqli_fetch_assoc($res)){
			$status = $row["leave_status"];
            $day = $row['day_type'];
?>			
		<input type="hidden" name="edit_id" id="edit_id" class="form-control" value="<?php echo $id?>">             
		<input type="hidden" name="employee_id" class="form-control" value="<?php echo $row['empId']?>">             
        <input type='hidden' name='leave_hrs' value="<?php echo $row['total_leavehrs']?>">
        <input type='hidden' name='empleave_id' value="<?php echo $row['leaveId']?>">
        <div class="mb-1">
            <div class="row">
                <div class="col">
                    <label for="leave_type" class="col-form-label">Leave Type:</label>
                    <input type="text" name="leave_type" id="leave_type" class="form-control" value="<?php echo $row['leave_name']?>" disabled> 
                </div>        
            </div>
            <?php
                if($day != "Full Day"){
                    echo "    
                        <div class='row'>            
                            <div class='col'>
                                <label for='day_type' class='col-form-label'>Day Type:</label>
                                <input type='text' name='day_type' id='day_type' class='form-control' value='".$day."' disabled> 
                            </div>
                            <div class='col'>
                                <label for='day_type' class='col-form-label'>Date:</label>
                                <input type='text' name='day_type' id='day_type' class='form-control' value='".$row['startDate']."' disabled> 
                            </div>
                        </div>
                    ";
                }else{
                    echo "    
                        <div class='col'>
                            <label for='day_type' class='col-form-label'>Day Type:</label>
                            <input type='text' name='day_type' id='day_type' class='form-control' value='".$day."' disabled> 
                        </div>
                        <div class='row'> 
                            <div class='col'>
                                <label for='day_type' class='col-form-label'>Start Date:</label>
                                <input type='text' name='day_type' id='day_type' class='form-control' value='".$row['startDate']."' disabled> 
                            </div>
                            <div class='col'>
                                <label for='day_type' class='col-form-label'>End Date:</label>
                                <input type='text' name='day_type' id='day_type' class='form-control' value='".$row['endDate']."' disabled> 
                            </div>
                        </div>
                    ";  
                }   
            ?>
            <div class="col">
                <label for="reason" class="col-form-label">Reason:</label>
                <?php
                    if($status != "Cancelled"){
                        echo "<textarea name='reason' id='reason' class='form-control'>".$row['leave_reason']."</textarea>";
                    }else{
                        echo "<textarea name='reason' id='reason' class='form-control' disabled>".$row['leave_reason']."</textarea>";
                    }
                ?>
            </div>
            <div class="col">
                <label for="reason" class="col-form-label">Status:</label>
                <select name="update_stat" id="update_stat" class="form-select">
                    <option value="Pending" disabled<?php echo $status == "Pending" ? "selected" : '' ?>>Pending</option>
                    <option value="Cancelled" <?php echo $status == "Cancelled" ? "selected" : '' ?>>Cancel</option>                        
                </select>
            </div>            
        </div>
<?php				
		}	
	}
?>

    <?php
        if(isset($_POST['id_leavetype'])){

            $id = $_POST['id_leavetype'];
        
            $sqlget = "SELECT * FROM leave_type INNER JOIN department ON department.deptId = leave_type.deptId WHERE leave_type.LeaveId = $id ";
            $res = mysqli_query($conn, $sqlget);
        
            while($row = mysqli_fetch_assoc($res)){
    ?>
        <div class="mb-1">
            <div class="row">
                <div class="col-md-6">
                    <input type="hidden" name="id_leavetype" value="<?php echo $row['LeaveId']?>">

                    <label for="leaveName" class="col-form-label">Leave Code:</label>
                    <input type="text" class="form-control" value="<?php echo $row['leaveCode'] ?>" name="leaveName" id="leaveName">
                </div>
                <div class="col-md-6">
                    <label for="Description" class="col-form-label">Leave Name:</label>
                    <input type="text" class="form-control" value="<?php echo $row['leave_name'] ?>" name="Description" id="Description">
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <label for="Description" class="col-form-label">Default Hours:</label>
                    <input type="number" class="form-control" min="0" value="<?php echo $row['default_hours'] ?>" name="default_hrs" id="default_hrs">
                </div>
                <div class="col-md-6">
                    <label for="Description" class="col-form-label">Department:</label>
                    <input type="text" class="form-control" value="<?php echo $row['deptName'] ?>" disabled>
                </div>
            </div>
        </div>
    <?php
        }
    }        
    ?>

    <?php
        if(isset($_POST['editleave_id'])){

            $id = $_POST['editleave_id'];
        
            $sqlget = "SELECT * FROM employees INNER JOIN leave_taken on leave_taken.empId=employees.empId
            INNER JOIN leave_type on leave_type.LeaveId=leave_taken.leaveId WHERE leave_taken.period_id = $id";
            $res = mysqli_query($conn, $sqlget);
    
            while($row = mysqli_fetch_assoc($res)){
            $leaveId = $row['LeaveId'];
            $status = $row['leave_status'];
    ?>
        <input type="hidden" name="editleave_id" value="<?php echo $row['period_id']?>">
        <input type="hidden" name="leaveId" value="<?php echo $row['leaveId']?>">              
        <input type="hidden" name="hrs_taken" value="<?php echo $row['total_leavehrs']?>">              
        <input type="hidden" name="employee_id" value="<?php echo $row['empId']?>">                          
        <div class="mb-1">
			<div class="row">
                <div class="col">
                    <label for="recipient-name" class="col-form-label">Employee Name:</label>
                    <input type="text" class="form-control" value="<?php echo $row['fName'].' '.$row['lName']; ?>" disabled>              
                </div>
            </div>
        </div>
		<div class="mb-1">
			<div class="row">
                <div class="col">
                    <label for="recipient-name" class="col-form-label">Leave Type:</label>
                    <input type="text" class="form-control" value="<?php echo $row['leave_name']?>" disabled>              
                </div>
            </div>
        </div>
		<div class="mb-1">
            <div class="row">
                <div class="col-md-6">
                    <label for="recipient-name" class="col-form-label">Start Date:</label>
                    <input type="text" class="form-control" value="<?php echo $row['startDate']?>" disabled>
                </div>
                <div class="col-md-6">
                    <label for="recipient-name" class="col-form-label">End Date:</label>
                    <input type="text" class="form-control" value="<?php echo $row['endDate']?>" disabled>
                </div>             
			</div>
            <div class="row">
                <div class="col">
                    <label for="recipient-name" class="col-form-label">Reason:</label>
                    <textarea name="leavereason" cols="30" rows="3" maxlength="100" class="form-control" disabled><?php echo $row['leave_reason']?></textarea>
                </div>  
            </div>
            <div class="row">
                <div class="col">
                    <label for="recipient-name" class="col-form-label">Remarks:</label>
                    <textarea name="leaveremark" cols="30" rows="3" maxlength="100" class="form-control">N/A</textarea>
                </div>  
            </div>
            <div class="col">
                <label for="recipient-name" class="col-form-label">Status:</label>
                <select name="update_stat" id="update_stat" class="form-select">
                        <option value="Pending" <?php echo $status == "Pending" ? " disabled selected" : '' ?>>Pending</option>
                        <option value="Approved" <?php echo $status == "Approved" ? "selected" : '' ?>>Approve</option>
                        <option value="Rejected" <?php echo $status == "Rejected" ? "selected" : '' ?>>Reject</option>
                </select>
            </div>
		</div>
    <?php
        }
    }        
    ?>    