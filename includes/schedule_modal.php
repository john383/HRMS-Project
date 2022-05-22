<?php
    include("connection.inc.php");

    if(isset($_POST['insertdata'])){
        $firsttime_in = mysqli_real_escape_string($conn, $_POST['firsttime_in']);
        $firsttime_out = mysqli_real_escape_string($conn, $_POST['firsttime_out']);
        $secondtime_in = mysqli_real_escape_string($conn, $_POST['secondtime_in']);
        $secondtime_out = mysqli_real_escape_string($conn, $_POST['secondtime_out']);
        if($firsttime_in != NULL){
            $firsttime_in = date("H:i:s", strtotime($firsttime_in));
        }
        if($firsttime_out != NULL){
            $firsttime_out = date("H:i:s", strtotime($firsttime_out));
        }
        if($secondtime_in != NULL){
            $secondtime_in = date("H:i:s", strtotime($secondtime_in));
        }
        if($secondtime_out != NULL){
            $secondtime_out = date("H:i:s", strtotime($secondtime_out));
        }
        $sql = "SELECT * FROM schedules WHERE time_inAm = '$firsttime_in' AND time_outAm = '$firsttime_out' AND time_inPm= '$secondtime_in' AND time_outPm = '$secondtime_out'";
        $res = mysqli_query($conn, $sql);
        if(mysqli_num_rows($res) > 0){
            echo "<script>alert('Schedule Already Exist!')</script>";
            return false;
        }else{
            $sql = "INSERT INTO schedules(time_inAm, time_outAm, time_inPm, time_outPm) VALUES(?, ?, ?, ?)";
            $stmt = mysqli_stmt_init($conn);
            //check if it fails
            if(!mysqli_stmt_prepare($stmt, $sql)){
                echo "SQL Statement Failed!";
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "ssss", $firsttime_in, $firsttime_out, $secondtime_in, $secondtime_out);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                echo "<script>alert('Successfuly Added!')
                window.location.href = '../admin/schedules.php';</script>";
                exit(0);
            }
        }
    }
?>
<!-- Add Schedule -->
<div class="modal" id="add_sched">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h4 class="modal-title" style="text-align: center;">Add Schedule</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="addForm">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="col-form-label">First Session Time In:</label>
                                <input type="time" class="form-control" name="firsttime_in" id="firsttime_in">
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="col-form-label">First Session Time Out:</label>
                                <input type="time" class="form-control" name="firsttime_out" id="firsttime_out">
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="recipient-name" class="col-form-label">Second Session Time In:</label>
                                <input type="time" class="form-control" name="secondtime_in" id="secondtime_in">
                            </div>
                            <div class="col-md-6">
                                <label for="recipient-name" class="col-form-label">Second Session Time Out:</label>
                                <input type="time" class="form-control" name="secondtime_out" id="secondtime_out">
                            </div>
                        </div>
                    </div>                    
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="insertdata" name="insertdata" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Schedule -->
<div class="modal" id="editsched">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Schedule</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="updateForm">
                <!-- Modal body -->
                <div class="modal-body displayedit_sched">

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

<script>
    $(document).ready(function() {
        //update schedule
        $('.edit_btn').click(function() {
            sched_id = $(this).attr('id');
            $.ajax({
                url: "../includes/update_sched.php",
                method :'post',
                data:{sched_id:sched_id},
                success: function(result){
                    $(".displayedit_sched").html(result);
                    $('#editsched').modal('show');
                }
            }); 
        });

        $(document).on('click', '#updatedata', function(){
            $.ajax({
                url: "../includes/update_data.php",
                method :'post',
                data:$("#updateForm").serialize(),
                success: function(result){
                    if (result == '1') {
                        $('#editsched').modal('hide');
                        alert('Data Successfully Updated');
                        window.location.href = '../admin/schedules.php';
                    }else{
                        $('#editsched').modal('show');
                        alert('Schedule Already Exist! Failed to Update.');
                    }
                }
            }); 
        });
    });
</script>