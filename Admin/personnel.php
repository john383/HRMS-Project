<?php
	$title = "Admin | Personnel Management";
	require("header.php");

    include_once ('../includes/connection.inc.php');

    $sql = "SELECT *, employees.empId FROM employees LEFT JOIN position ON position.positionId=employees.positionid LEFT JOIN schedules ON schedules.scheduleId=employees.scheduleid 
       LEFT JOIN department ON department.deptId=employees.deptid ORDER BY employees.fName";
    $result = mysqli_query($conn, $sql);

?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Personnel Management</b></span>
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
                <button type="button" class="btn btn-primary mb-3 add_emp" data-bs-toggle="modal" data-bs-target="#addemp"><i class="fa fa-plus"></i> Add Employee</button>
                        <table class="table table-bordered table-hover align-middle" id="example"  style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Employee Name</th>
                                    <th scope="col" class="text-center">Position</th>
                                    <th scope="col" class="text-center">Employment Type</th>
                                    <th scope="col" class="text-center">Member Since</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_array($result)){
                                ?> 
                                    <input type="hidden" name="empid" value="<?php echo $row['empId'];?>">
                                    <tr>
                                        <td name="name"><?php echo ucwords($row['lName']).', '.ucwords($row['fName'])?></td>
                                        <td name="posname" class="text-center"><?php echo $row['positionName']; ?></td>
                                        <td name="posname" class="text-center"><?php echo $row['employment_type']; ?></td>
                                        <td name="employeddate" class="text-center"><?php echo date('M d, Y', strtotime($row['employedDate'])) ?></td>
                                        <td class="text-center">
                                            <?php if(($row["status"] == "Active")){ ?>
                                                <button type="button" class="btn btn-primary view_btn" id="<?php echo $row['empId'];?>" title="View"><i class="fa fa-eye"></i></button>
                                                <button type="button" class="btn btn-success edit_btn" id="<?php echo $row['empId'];?>" title="Update"><i class="fa fa-pencil-square-o"></i></button>
                                            <?php }else{?>
                                                <button type="button" class="btn btn-danger view_btn" id="<?php echo $row['empId'];?>" title="View"><i class="fa fa-eye"></i></button>
                                            <?php }?>
                                        </td>
                                    </tr>
                                <?php                                                                       
                                    }
                                ?>   
                            </tbody>
                        </table>  
            </div>
        </div>
    </div>
</section>
<?php  include '../includes/personnel_modals.php';?>

<?php  include 'footer.php';?> 

