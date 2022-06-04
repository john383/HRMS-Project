<?php
// session_start();
    include("connection.inc.php");
    include("add_leave.php");
    // include("../includes/add_leave.php");
    if(isset($_SESSION['empId'])){
        $id = print_r($_SESSION["empId"], TRUE);

    }else{
        $id = print_r($_SESSION["adminId"], TRUE);
    }

?>
<!-- Add Leave Data -->
<div class="modal" id="addemp">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Leave</h4>
            </div>
            <form action="" method="post" id="leave-form">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-1">
                        <div class="row">
							<div class="col">
                                <label for="recipient-name" class="col-form-label">Leave Type:</label>
                                <input type="hidden" name="empId" value="<?php echo $id;?>">
                                <select class="form-select" aria-label="Default select example" name="selectleave" id="selectleave" onchange="selectLeave()" required>
                                    <option value disabled selected>Select Leave Type</option>
                                    <?php
                                        $leave = "SELECT * FROM emp_annual_leave INNER JOIN leave_type ON leave_type.LeaveId = emp_annual_leave.leaveId WHERE empId = '$id' AND annual_leave_status = 'Active'";
                                        $leave_res = mysqli_query($conn, $leave);
                                        while($leave_row = mysqli_fetch_array($leave_res)){
                                            echo "<option value='".$leave_row['LeaveId'] ."'>". $leave_row['leave_name'] ."</option>";
                                        }
                                    ?>
                                </select>
                                <small><i>Available credits for selected leave type: <span id="credits" style="color: red;">0</span></i></small>
                            </div>
                        </div>
                    </div>
                    <div class="mb-1">
                        <div class="row">
                            <div class="col" id="select_session" style="display:none;">
                                <label for="recipient-name" class="col-form-label">Day Type:</label>
                                <select class="form-select" aria-label="Default select example" name="type" id="leave_time" required>
                                    <option value disabled selected>Select Day Type</option>
                                    <option value="1" <?php echo isset($type) && $type == 1 ? "selected" : '' ?>>All Day</option>
                                    <option value="2" <?php echo isset($type) && $type == 2 ? "selected" : '' ?>>Half Day</option>
                                    <option value="3" <?php echo isset($type) && $type == 3 ? "selected" : '' ?>>Hours</option>
                                </select>
                            </div>  
                            <div class="col-md-4" id="full_day" style="display:none;">
                                <label for="recipient-name" class="col-form-label">Start Date:</label>
                                <input type="date" class="form-control" name="startdate" id="startdate">
                            </div>
						    <div class="col-md-4" id="full_day1" style="display:none;">
                                <label for="recipient-name" class="col-form-label">End Date:</label>
                                <input type="date" class="form-control" name="enddate" id="enddate">
                            </div>
                            <div class="col-md-4" id="half_day" style="display:none;">
                            <?php
                                $sql = "SELECT * FROM employees INNER JOIN schedules ON schedules.scheduleId = employees.scheduleid WHERE empId = '$id'";
                                $res = mysqli_query($conn, $sql);
                                $res_row = mysqli_fetch_array($res);
                            
                                $date_now = date("Y-m-d");
                                $startH = date('H:i:s', strtotime($res_row['time_inAm']));
                                // echo "<br>";
                                $endH = date('H:i:s', strtotime($res_row['time_outPm']));
                                // echo "<br>";
                                $combinedDT1 = date('Y-m-d H:i:s',strtotime($date_now.' '.$startH));
                                // echo "<br>";
                                $combinedDT2 = date('Y-m-d H:i:s',strtotime($date_now.' '.$endH));
                                // echo "<br>";
                                $diff = gmdate('H:i', floor(abs(strtotime($combinedDT1) - strtotime($combinedDT2)))-3600);
                                // echo "<br>";
                                $diff1 = floor(date("H", strtotime($diff))/2);
                            ?>
                                <label for="recipient-name" class="col-form-label">Number of Hours:</label>
                                <input type="text" class="form-control" value="<?php echo $diff1?>" disabled>
                                <input type="hidden" class="form-control" name="half2" id="half2" value="<?php echo $diff1?>">
                            </div>                  
                            <div class="col-md-4" id="hours" style="display:none;">
                                <label for="recipient-name" class="col-form-label">Number of Hours:</label>
                                <input type="number" class="form-control" name="half1" id="leave_hour" min="0">
                            </div>
                        </div>
                        <div class="col" id="reason_area" style="display:none;">
                            <label for="recipient-name" class="col-form-label">Reason:</label> <small style="font-size: 13px; color: red;">(Note: Limited to 100 characters only.)</small>
                            <textarea class="form-control" name="reason" id="" cols="30" rows="3" maxlength="100"></textarea>
                        </div>
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="insertdata" id="insertdata" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Edit Leave Data -->
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

<!-- Admin Update Leave Data -->
<div class="modal" id="update_leave">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Leave</h4>
            </div>
            <form action="#" method="POST" id="updateleaveForm">
                <!-- Modal body -->
                <div class="modal-body displayleaveedit_emp">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateleavedata">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Leave Type Data -->
<div class="modal" id="editleavetype">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Edit Leave Type</h4>
            </div>
            <form action="#" method="POST" id="updateleavetypeForm">
                <!-- Modal body -->
                <div class="modal-body displayedit_leavetype">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateleavetypedata">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add Leave type Data -->
<div class="modal" id="addleavetype">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Add Leave Type</h4>
            </div>
            <form action="../includes/add_leave.php" method="post">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="leaveName" class="col-form-label">Leave Code:</label>
                                <input type="text" class="form-control" name="leaveName" id="leaveName">
                            </div>
							<div class="col-md-6">
                                <label for="Description" class="col-form-label">Leave Name:</label>
                                <input type="text" class="form-control" name="Description" id="Description">
                            </div>                         
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Employment Type:</label>
                                <select class="form-select department" aria-label="Default select example" name="employment_type" required>
                                    <option  value disabled selected>Select Employment Type</option>
                                    <option  value="Regular">Regular</option>
                                    <option  value="Probationary">Probationary</option>
                                </select>
                            </div>
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Department:</label>
                                <select class="form-select department" aria-label="Default select example" name="department" required>
                                    <option  value disabled selected>Select Department</option>
                                    <?php 
                                        $dept = "SELECT * FROM department";
                                        $dept_res = mysqli_query($conn, $dept);
                                        
                                        while($dept_row = mysqli_fetch_array($dept_res)){
                                            echo "<option value='".$dept_row['deptId'] ."'>". $dept_row['deptName'] ."</option>";
                                        }
                                    ?>
                                </select>
                            </div> 
                        </div>
                        <div class="col">
                            <label for="Description" class="col-form-label">Default Hours:</label>
                            <input type="number" class="form-control" name="default_hrs" id="default_hrs" min="0">
                        </div>  
                    </div>
                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="insertleavetype" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {
    
        //edit leave
        $('.edit_btn').click(function() {
            id_emp = $(this).attr('id');
            $.ajax({
                url: "../includes/leave_process.php",
                method :'post',
                data:{edit_id:id_emp},
                success: function(data){
                    $(".displayedit_emp").html(data);
                    $('#editemp').modal('show');
                }
            }); 
        });

        $(document).on('click', '#updatedata', function(){
            $.ajax({
                url: "../includes/leave_update.php",
                method :'post',
                data:$("#updateForm").serialize(),
                success: function(data){
                    alert('Data Successfully Updated');
                    $('#editemp').modal('hide');
                    location.reload();
                }
            }); 
        });

        //admin edit leave
        $('.editleave_btn').click(function() {
            id_emp = $(this).attr('id');
            $.ajax({
                url: "../includes/leave_process.php",
                method :'post',
                data:{editleave_id:id_emp},
                success: function(result){
                    $(".displayleaveedit_emp").html(result);
                    $('#update_leave').modal('show');
                }
            });
        });

        //admin update data
        $(document).on('click', '#updateleavedata', function(){
            $.ajax({
                url: "../includes/leave_update.php",
                method :'post',
                data:$("#updateleaveForm").serialize(),
                success: function(result){
                    $('#update_leave').modal('hide');
                    alert('Data Successfully Updated')
                    // window.location.href = '../Admin/leave.php';

                    location.reload();
                }
            });
        });

        //edit leave type
        $('.updateleavebtn').click(function() {
            id_leavetype = $(this).attr('id');
            $.ajax({
                url: "../includes/leave_process.php",
                method :'post',
                data:{id_leavetype:id_leavetype},
                success: function(result){
                    $(".displayedit_leavetype").html(result);
                    $('#editleavetype').modal('show');
                }
            });
        });

        //update leave type data
        $(document).on('click', '#updateleavetypedata', function(){
            $.ajax({
                url: "../includes/updateleave_type.php",
                method :'post',
                data:$("#updateleavetypeForm").serialize(),
                success: function(result){
                    $('#editleavetype').modal('hide');
                    alert('Data Successfully Updated');
                    location.reload();
                }
            });
        });
    });

    function selectLeave() {
        var leaveId = document.getElementById('selectleave').value;
        $.ajax({
            url: "../includes/leave_credits.php",
            method: "POST",
            data:{id:leaveId},
            success:function(data){
                $("#credits").html(data);
                if(data <=  1){
					$('#selectleave').closest('.col').append('<div class="alert alert-danger err-msg text-center" id="my-element">You dont have an available credits with the selected leave type.</div>')
					$('#select_session').hide()
				}else{
					$('#select_session').show()
                    document.getElementById("my-element").remove();
				}
            },
			complete:function(){
				end_load()
			}
        })
    }

    $('#leave_time').change(function() {
        sample = $(this).val();
        switch (sample) {
        case '1':
            $('#full_day').show().find(':input').attr('required', true);
            $('#full_day1').show().find(':input').attr('required', true);
            $('#reason_area').show();
            $('#half_day').hide().find(':input').attr('required', false);
            $('#hours').hide().find(':input').attr('required', false);
            $("input[id=half1]").val("");
            $("input[id=leave_hour]").val(""); 
            $("input[id=half2]").val("");
            break;

        case '2':
            $('#full_day').show().find(':input').attr('required', true);
            $('#full_day1').hide().find(':input').attr('required', false);
            $('#half_day').show();
            $('#reason_area').show();
            $('#hours').hide().find(':input').attr('required', false);
            $("input[id=leave_hour]").val("");
            $("input[id=enddate]").val("");
            break;     

        case '3':
            $('#full_day').show().find(':input').attr('required', true);
            $('#hours').show().find(':input').attr('required', true);
            $('#full_day1').hide().find(':input').attr('required', false);
            $('#reason_area').show();
            $('#half_day').hide().find(':input').attr('required', false);
            $("input[id=enddate]").val("");
            $("input[id=half2]").val("");

            break;     
        }                   
    });   

    $('#startdate, #enddate, #type').change(function(){
        var errors = false;
        if($('#startdate').val() == '' || $('#enddate').val() == ''){
            return false;
        }
        if($('.err-msg').length > 0)
            $('.err-msg').remove()
        var from = $('#startdate').val()
        var to = $('#enddate').val()
        from = new Date(from);
        to = new Date(to)
        if(from.getFullYear() != to.getFullYear()){
            $('#startdate').closest('.mb-1').append('<div class="alert alert-danger err-msg mt-3">Date From and To must be the same year.</div>')
            document.getElementById("my-element").remove();
            errors = true;
            return false;
        }

        if(from > to){
            $('#enddate').closest('.mb-1').append('<div class="alert alert-danger err-msg mt-3">Selected dates are incorrect.</div>')
            errors = false;
            return false;
        }
    })
    
    $('#leave-form').submit(function (event) {
        var errors = false;
        $(this).find('.err-msg').each(function () {
            if ($(this).val().length < 1) {
                $(this).addClass('error');
                errors = true;
            }
        });
        if (errors == true) {
            event.preventDefault();
            alert('Error');
            $('#addemp').modal('show');
        }
    });
</script>

