<?php 
    include 'connection.inc.php';

	//edit data
	if(isset($_POST['sched_id'])){

		$sched_id = mysqli_real_escape_string($conn, $_POST['sched_id']);

        $sql = "SELECT * FROM schedules WHERE scheduleId = ?";

        $stmt = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "<script>alert('SQL Error!')</script>
            header('location: schedules.php?error=stmtfailed');";
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "i", $sched_id);
            mysqli_stmt_execute($stmt);
			$result = mysqli_stmt_get_result($stmt);

        }
		while($row = mysqli_fetch_assoc($result)){
?>		
<div class="mb-1">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="sched_id" id="sched_id" class="form-control" value="<?php echo $row['scheduleId']?>"> 
            <label for="recipient-name" class="col-form-label">First Session Time In:</label>
            <input type="time" class="form-control" name="firsttime_in" id="firsttime_in" value="<?php echo $row['time_inAm'];?>">
            <!-- <span class="form-error"><1?php echo $empidErr;?></span> -->
        </div>
        <div class="col-md-6">
            <label for="recipient-name" class="col-form-label">First Session Time Out:</label>
            <input type="time" class="form-control" name="firsttime_out" id="firsttime_out" value="<?php echo $row['time_outAm'];?>">
            <!-- <span class="form-error"><1?php echo $firstnameErr;?></span> -->
        </div>
    </div>
</div>
<div class="mb-1">
    <div class="row">
        <div class="col-md-6">
            <label for="recipient-name" class="col-form-label">Second Session Time In:</label>
            <input type="time" class="form-control" name="secondtime_in" id="secondtime_in" value="<?php echo $row['time_inPm'];?>">
            <!-- <span class="form-error"><1?php echo $empidErr;?></span> -->
        </div>
        <div class="col-md-6">
            <label for="recipient-name" class="col-form-label">Second Session Time Out:</label>
            <input type="time" class="form-control" name="secondtime_out" id="secondtime_out" value="<?php echo $row['time_outPm'];?>">
            <!-- <span class="form-error"><1?php echo $firstnameErr;?></span> -->
        </div>
    </div>
</div>  
<?php				
		}	
	}
?>
<?php
    if(isset($_POST['attend_id'])){
        $attend_id = mysqli_real_escape_string($conn, $_POST['attend_id']);

        $sql1 = "SELECT * FROM attendance WHERE attendId = ?";

        $stmt1 = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($stmt1, $sql1)){
            echo "<script>alert('SQL Error!')</script>";
            exit(0);
        }else{
            mysqli_stmt_bind_param($stmt1, "i", $attend_id);
            mysqli_stmt_execute($stmt1);
			$result1 = mysqli_stmt_get_result($stmt1);

        }
		while($row = mysqli_fetch_assoc($result1)){
?>
    <input type="hidden" name="attend_id" id="attend_id" class="form-control" value="<?php echo $row['attendId']?>"> 
    <input type="hidden" name="bioId" id="bioId" class="form-control" value="<?php echo $row['bioId']?>"> 
    <input type="hidden" name="attend_date" id="attend_date" class="form-control" value="<?php echo $row['date']?>"> 
    <div class="mb-1">
        <div class="row">
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">First Session Time In:</label>
                <input type="time" class="form-control" name="firsttime_in" id="firsttime_in" value="<?php echo $row['time_inAM'];?>">
            </div>
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">First Session Time Out:</label>
                <input type="time" class="form-control" name="firsttime_out" id="firsttime_out" value="<?php echo $row['time_outAM'];?>">
            </div>
        </div>
    </div>
    <div class="mb-1">
        <div class="row">
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">Second Session Time In:</label>
                <input type="time" class="form-control" name="secondtime_in" id="secondtime_in" value="<?php echo $row['time_inPM'];?>">
            </div>
            <div class="col-md-6">
                <label for="recipient-name" class="col-form-label">Second Session Time Out:</label>
                <input type="time" class="form-control" name="secondtime_out" id="secondtime_out" value="<?php echo $row['time_outPM'];?>">
            </div>
        </div>
    </div> 
<?php
        }
    }
?>