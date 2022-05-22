<?php
	$title = "Admin | Schedule Management";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    $sql = "SELECT * FROM schedules";
    $result = mysqli_query($conn, $sql);
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Schedule Management</b></span>
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
                <button type="button" class="btn btn-primary mb-3 add_emp" data-bs-toggle="modal" data-bs-target="#add_sched"><i class="fa fa-plus"></i> Add Schedule</button>
                <div class="year-box">
                    <div class="table-responsive" id="autodata">
                        <table class="table table-bordered table-hover align-middle" width: 100%; height: 100%;>
                            <thead>
                                <tr>
                                    <th scope="col">First Session Time In</th>
                                    <th scope="col">First Session Time Out</th>
                                    <th scope="col">Second Session Time In</th>
                                    <th scope="col">Second Session Time Out</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?> 
                                <tr>
                                    <td name="name"><?php echo $row['time_inAm']?></td>
                                    <td name="deptname"><?php echo $row['time_outAm'] ?></td>
                                    <td name="posname"><?php echo $row['time_inPm'] ?></td>
                                    <td name="employeddate"><?php echo $row['time_outPm']?></td>
                                    <td>
                                        <button type="button" class="btn btn-success edit_btn" id="<?php echo $row['scheduleId'];?>" title="Update"><i class="fa fa-pencil-square-o" ></i></button>
                                    </td>
                                </tr>
                            <?php
                                    }
                                }else{
                                    echo "<tr>
                                    <td colspan='5'>No Data Found!</td>
                                    </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>

</script>
<?php  include '../includes/schedule_modal.php';?>

<?php  include 'footer.php';?> 

