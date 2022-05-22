<?php
    include("connection.inc.php");

    if(isset($_POST['dept_id'])){
        $dept_id = $_POST['dept_id'];
        $position = "SELECT * FROM position WHERE deptId = '$dept_id'";
        $position_res = mysqli_query($conn, $position);

?>
    <select class="form-select position" aria-label="Default select example" name="selectposition" required>
        <option  value disabled selected>Select Position</option>
        <?php
            while($position_row = mysqli_fetch_array($position_res)){
                echo "<option value='".$position_row['positionId'] ."'>". $position_row['positionName'] ."</option>";
            }	
        ?>
    </select>
<?php
    }

    if(isset($_POST['e_dept_id'])){
        $department = $_POST['e_dept_id'];
        $position1 = "SELECT * FROM position WHERE deptId = '$department'";
        $position_res1 = mysqli_query($conn, $position1);
?>
    <select class="form-select position" aria-label="Default select example" name="selectposition" required>
        <?php
            while($position_row1 = mysqli_fetch_array($position_res1)){
                echo "<option value='".$position_row1['positionId'] ."'>". $position_row1['positionName'] ."</option>";
            }	
        ?>
    </select>
<?php
    }
?>