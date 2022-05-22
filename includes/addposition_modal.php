<?php
    include("connection.inc.php");

    if(isset($_POST['insertdata'])){
        $deptName = mysqli_real_escape_string($conn, $_POST['selectdepartment']);
        $positionName = mysqli_real_escape_string($conn, $_POST['positionName']);

        $sql = "INSERT INTO position (deptId, positionName) VALUES(?, ?)";
        $stmt = mysqli_stmt_init($conn);
        //check if it fails
        if(!mysqli_stmt_prepare($stmt, $sql)){
            echo "SQL Statement Failed!";
            exit();
        }else{
            mysqli_stmt_bind_param($stmt, "ss", $deptName, $positionName);
            mysqli_stmt_execute($stmt);
            echo "<script>alert('Successfuly Added!')
            window.location.href = '../admin/position.php';</script>";
            exit();
        }
    }
?>
<!-- Add Position -->
<div class="modal" id="addposition">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header text-center">
                <h4 class="modal-title" style="text-align: center;">Add Position</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../includes/addposition_modal.php" method="POST" id="addForm">
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="mb-1">
                        <div class="row">
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Position</label>
                                <input type="positionName" class="form-control" name="positionName" id="positionName">
                            </div>
                            <div class="col">
                                <label for="recipient-name" class="col-form-label">Department:</label>
                                <select class="form-select department" aria-label="Default select example" name="selectdepartment" id="selectdepartment" required>
                                    <option  value disabled selected>Select Department</option>
                                    <?php
                                        $dept = "SELECT * FROM department";
                                        $dept_res = mysqli_query($conn, $dept) or die("Bad Query: $dept");
                                        while($dept_row = mysqli_fetch_array($dept_res)){
                                            echo "<option value='".$dept_row['deptId'] ."'>". $dept_row['deptName'] ."</option>";
                                        }
                                    ?>
                                </select>
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

<!-- Update Position -->
<div class="modal" id="editposition">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Position</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="updateForm">
                <!-- Modal body -->
                <div class="modal-body displayedit_pos">

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
        //update position
        $('.edit_posbtn').click(function() {
            pos_id = $(this).attr('id');
            $.ajax({
                url: "../includes/update_position.php",
                method :'post',
                data:{pos_id:pos_id},
                success: function(result){
                    $(".displayedit_pos").html(result);
                    $('#editposition').modal('show');
                }
            });
        });

        $(document).on('click', '#updatedata', function(){
            $.ajax({
                url: "../includes/update_posdata.php",
                method :'post',
                data:$("#updateForm").serialize(),
                success: function(result){
                    $('#editposition').modal('hide');
                    alert('Data Successfully Updated')
                    window.location.href = '../admin/position.php';
                }
            });
        });
    });
</script>