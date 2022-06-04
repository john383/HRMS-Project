<?php
	$title = "Admin | Leave Type Management";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    $sql = "SELECT * FROM leave_type INNER JOIN department ON department.deptId = leave_type.deptId ORDER BY department.deptId ASC";
    $result = mysqli_query($conn, $sql);
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Leave Type Management</b></span>
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
            <div class="graphbox">
                <button type="button" class="btn btn-primary mb-3 add_emp" data-bs-toggle="modal" data-bs-target="#addleavetype">Add Leave Type</button>
                <!-- <div class="year-box"> -->
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-middle" id="example" width: 100%; height: 100%;>
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Leave Code</th>
                                    <th scope="col" class="text-center">Leave Name</th>
                                    <th scope="col" class="text-center">Default Hours</th>
                                    <th scope="col" class="text-center">Department</th>
                                    <th scope="col" class="text-center">Employment Type</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?>
                                <tr>
									<input type="hidden" id="LeaveId" name="LeaveId" value="LeaveId">
                                    <td name="leaveName" class="text-center"><?php echo $row['leaveCode']; ?></td>
                                    <td name="Description" class="text-center"><?php echo $row['leave_name']; ?></td>
                                    <td name="default_hrs" class="text-center"><?php echo $row['default_hours']; ?></td>
                                    <td name="dept" class="text-center"><?php echo $row['deptName']; ?></td>
                                    <td name="dept" class="text-center"><?php echo $row['employment_type']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-success updateleavebtn" id="<?php echo $row['LeaveId'];?>" title="Update"><i class="fa fa-pencil-square-o" ></i></button>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }else{
                                    echo '
                                    <tr>
                                    <td scope="row" colspan="8">No Data Found!</td>
                                </tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                <!-- </div> -->
            </div>
        </div>
    </div>
</section>
<?php  include '../includes/leave_modals.php';?>

<?php  include 'footer.php';?>