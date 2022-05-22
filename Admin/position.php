<?php
	$title = "Admin | Position Management";
	require("header.php");
    include_once ('../includes/connection.inc.php');

    $sql = "SELECT * FROM position inner JOIN department ON department.deptId=position.deptId";
    $result = mysqli_query($conn, $sql);
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Position Management</b></span>
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
                <button type="button" class="btn btn-primary mb-3 add_emp" data-bs-toggle="modal" data-bs-target="#addposition">Add Position</button>
                <div class="year-box">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover align-middle" width: 100%; height: 100%;>
                            <thead>
                                <tr>
									<th scope="col">Position Name</th>
                                    <th scope="col">Department</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                while($row = mysqli_fetch_array($result)){
                            ?>
                                <tr>
									<td name="positionName"><?php echo $row['positionName']; ?></td>
                                    <td name="deptName"><?php echo $row['deptName']; ?></td>
                                </tr>
                            <?php
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
<?php  include '../includes/addposition_modal.php';?>

<?php  include 'footer.php';?>