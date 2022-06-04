<?php
	$title = "Admin | Attendance Management";
	require("header.php");

    include_once ('../includes/connection.inc.php');

    $month = date('m');
    $year = date('Y');

    $sql = "SELECT * FROM attendance INNER JOIN employees ON attendance.bioId = employees.bioId WHERE month(date) = ".$month." AND year(date) = ".$year." ORDER BY attendance.attendId";
    $result = mysqli_query($conn, $sql);
?>
    <nav>
        <div class="sidebar-button">
            <a href="../admin/attendance.php" style="text-decoration: none; color: #000"><span class="dashboard"><b>Attendance Management</b></span></a>
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
                    <div class="col text-center mb-2">
                        <label for="months" class="selectMonth">Select Month:</label>
                        <?php
                        $selected_month = date('m'); //current month
                    ?>
                    <select id="month" name="month" onchange="getattendance()">
                        <option value='01' <?php echo $selected_month == 1 ? ' selected' : ''?>>January</option>
                        <option value='02' <?php echo $selected_month == 2 ? ' selected' : ''?>>February</option>
                        <option value='03' <?php echo $selected_month == 3 ? ' selected' : ''?>>March</option>
                        <option value='04' <?php echo $selected_month == 4 ? ' selected' : ''?>>April</option>
                        <option value='05' <?php echo $selected_month == 5 ? ' selected' : ''?>>May</option>
                        <option value='06' <?php echo $selected_month == 6 ? ' selected' : ''?>>June</option>
                        <option value='07' <?php echo $selected_month == 7 ? ' selected' : ''?>>July</option>
                        <option value='08' <?php echo $selected_month == 8 ? ' selected' : ''?>>August</option>
                        <option value='09' <?php echo $selected_month == 9 ? ' selected' : ''?>>September</option>
                        <option value='10' <?php echo $selected_month == 10 ? ' selected' : ''?>>October</option>
                        <option value='11' <?php echo $selected_month == 11 ? ' selected' : ''?>>November</option>
                        <option value='12' <?php echo $selected_month == 12 ? ' selected' : ''?>>December</option>
                    </select>
                        
                        <label for="years" class="selectYr">Select Year:</label>
                        <?php 
                            echo '<select id="year" name="year" onchange="getattendance()">'."\n";
                            for ($i = date('Y'); $i >= 2020; $i--){
                                $selected = (date('Y') == $i ? ' selected' : '');
                                echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";
                            }
                            echo '</select>'."\n";
                        ?>   
                    </div>   
                    <div class="form mb-1">
                        <form action="../includes/execute_import.php" method="post" enctype="multipart/form-data" class="form">
                            <div class="row">
                                <div class="col-md-3">
                                    <input type="file" class="form-control form-control-md mb-2" name="import_file" id="import_file" size="60"> 
                                </div>
                                <div class="col-md-3">
                                    <button type="submit" class="btn btn-primary add_files" name="import_file_btn">Upload</button>  
                                </div>
                            </div>
                        </form>
                    </div>                            
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle" id="example"  style="width: 100%;">
                            <thead>
                                <tr>
                                    <th scope="col" class="text-center">Name</th>
                                    <th scope="col" class="text-center">Date</th>
                                    <th scope="col" class="text-center">Time In(AM)</th>
                                    <th scope="col" class="text-center">Time Out(AM)</th>
                                    <th scope="col" class="text-center">Time In(PM)</th>
                                    <th scope="col" class="text-center">Time Out(PM)</th> 
                                    <th scope="col" class="text-center">Status</th> 
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    while($row = mysqli_fetch_array($result)){
                                ?> 
                                    <tr>
                                        <td scope="row" name="empid" ><?php echo ucwords($row['lName']).', '.ucwords($row['fName']); ?></td>
                                        <td name="name" class="text-center"><?php echo date("D-M j, Y", strtotime($row['date'])) ?></td>
                                        <td scope="row" name="empid" class="text-center"><?php if($row['time_inAM'] == ""){echo $row['time_inAM'];}else{echo date("h:i A", strtotime($row['time_inAM']));}?></td>
                                        <td scope="row" name="empid" class="text-center"><?php if($row['time_outAM'] == ""){echo $row['time_outAM'];}else{echo date("h:i A", strtotime($row['time_outAM']));}?></td>
                                        <td scope="row" name="empid" class="text-center"><?php if($row['time_inPM'] == ""){echo $row['time_inPM'];}else{echo date("h:i A", strtotime($row['time_inPM']));}?></td>
                                        <td scope="row" name="empid" class="text-center"><?php if($row['time_outPM'] == ""){echo $row['time_outPM'];}else{echo date("h:i A", strtotime($row['time_outPM']));}?></td>
                                        <td scope="row" name="empid" class="text-center"><?php echo $row['attend_status']; ?></td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-success attend_updt_btn" id="<?php echo $row['attendId']; ?>"title="Update"><i class="fa fa-pencil-square-o"></i></button>
                                        </td>
                                    </tr>
                                <?php                                                                     
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
<script>
    function getattendance(val) {
        var attend_month = $("#month").val();
        var attend_year = $("#year").val();
        if(attend_month && attend_year) {
            $.ajax({
                url: "../includes/fetch.php",
                type: "POST",
                data: {"attend_month":attend_month, "attend_year":attend_year},
                success: function(result){
                    $(".table-responsive").html(result);
                    // alert(year)
                }
            }); 
        }
    }        
</script>
<?php  include '../includes/attendance_modals.php';?>
<?php
	include 'footer.php';
?>