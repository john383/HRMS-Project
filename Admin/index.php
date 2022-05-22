<?php
    include ('../includes/connection.inc.php');

	$title = "Admin | Dashboard";
	require("header.php");

	// $month = date('m');
	$year = date('Y');
	$total_lates = NULL;
		$query2 = "SELECT year(date) AS attend_year, monthname(date) AS attend_month, count(attend_status) AS total_lates FROM attendance WHERE attend_status = 'Late' AND year(date) = '$year' GROUP BY year(date), month(date) ORDER BY year(date), month(date)";
		$result1 = mysqli_query($conn, $query2);
		while($query_row1 = mysqli_fetch_array($result1)){
			$total_lates[] = $query_row1['total_lates'];
			// $month[] = $query_row1['attend_month'];
		}
		$query3 = "SELECT year(date) AS attend_year, monthname(date) AS attend_month, count(attend_status) AS total_lates FROM attendance WHERE attend_status = 'On Time' AND year(date) = '$year' GROUP BY year(date), month(date) ORDER BY year(date), month(date)";
		$result2 = mysqli_query($conn, $query3);
		while($query_row2 = mysqli_fetch_array($result2)){
			$total_ontime[] = $query_row2['total_lates'];
			$month[] = $query_row2['attend_month'];
		}

		// echo $total_lates
		// }
		// echo $total_lates;
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Dashboard</b></span>
        </div>
        <div class="time">
            <span class="date"></span>
			<br>
            <span class="hms"></span>
            <span class="ampm"></span>
        </div>
    </nav>    
	<div class="home-content">
		<div class="overview-boxes">
			<div class="box box-1">
				<div class="right-side">
					<div class="box-topic">Total Personnel</div>
					<?php
						$status = mysqli_real_escape_string($conn, "Active");
						$sql = "SELECT COUNT(status) AS count FROM employees WHERE status=?";
						$stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($stmt, $sql)){
							echo "<script>alert('SQL Error!')
							window.location.href = 'location: index.php?error=stmtfailed';</script>;";
							exit();
						}else{
							mysqli_stmt_bind_param($stmt, "s", $status);
							mysqli_stmt_execute($stmt);
							$result = mysqli_stmt_get_result($stmt);

							$row = mysqli_fetch_assoc($result);
							$count = $row['count'];
							mysqli_stmt_close($stmt);
						}
					?>
					<div class="number"><?php echo $count;?></div>
					<div class="indicator">
						<i class="fa fa-arrow-right"></i>
						<a href="personnel.php" style="text-decoration: none; color: #fff;"><span class="text">See More</span></a>
					</div>
				</div>
				<i class="fa fa-users user"></i>
			</div>
			<div class="box box-2">
				<div class="right-side">
					<div class="box-topic">On Time Today</div>
					<?php
						$att_status = mysqli_real_escape_string($conn, "On Time");
						$att_date = date("Y/m/d");
						$att_sql = "SELECT COUNT(attend_status) AS count FROM attendance WHERE attend_status = ? AND date = ?";
						$att_stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($att_stmt, $att_sql)){
							echo "<script>alert('SQL Error!')
							window.location.href = 'location: index.php?error=stmtfailed';</script>;";
							exit();
						}else{
							mysqli_stmt_bind_param($att_stmt, "ss", $status, $att_date);
							mysqli_stmt_execute($att_stmt);
							$att_res = mysqli_stmt_get_result($att_stmt);
							
							$att_row = mysqli_fetch_assoc($att_res);
							$att_count = $att_row['count'];
							mysqli_stmt_close($att_stmt);
						}
					?>					
					<div class="number"><?php echo $att_count;?></div>
					<div class="indicator">
						<i class="fa fa-arrow-right"></i>
						<a href="attendance.php" style="text-decoration: none; color: #fff;"><span class="text">See More</span></a>
					</div>
				</div>
				<i class="fa fa-clock-o user two"></i>
			</div>
			<div class="box box-3">
				<div class="right-side">
					<?php
						$late_status = mysqli_real_escape_string($conn, "Late");
						$late_date = date("Y/m/d");
						$late_sql = "SELECT COUNT(attend_status) AS count FROM attendance WHERE attend_status = ? AND date = ?";
						$late_stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($late_stmt, $late_sql)){
							echo "<script>alert('SQL Error!')
							window.location.href = 'location: index.php?error=stmtfailed';</script>;";
							exit();
						}else{
							mysqli_stmt_bind_param($late_stmt, "ss", $late_status, $late_date);
							mysqli_stmt_execute($late_stmt);
							$late_res = mysqli_stmt_get_result($late_stmt);
							
							$late_row = mysqli_fetch_assoc($late_res);
							$late_count = $late_row['count'];
							mysqli_stmt_close($late_stmt);
						}
					?>	
					<div class="box-topic">Late Today</div>
					<div class="number"><?php echo $late_count;?></div>
					<div class="indicator">
						<i class="fa fa-arrow-right"></i>
						<a href="attendance.php" style="text-decoration: none; color: #fff;"><span class="text">See More</span></a>
					</div>
				</div>
				<i class='fa fa-exclamation-triangle user three'></i>
			</div>
			<div class="box box-4">
				<div class="right-side">
					<div class="box-topic">Pending Leaves</div>
					<?php
						$emp_leave_status = mysqli_real_escape_string($conn, "Pending");
						$emp_leave_Sql = "SELECT COUNT(leave_status) AS count FROM leave_taken WHERE leave_status = ?";
						$emp_leave_stmt = mysqli_stmt_init($conn);
						if(!mysqli_stmt_prepare($emp_leave_stmt, $emp_leave_Sql)){
							echo "<script>alert('SQL Error!')
							window.location.href = 'location: index.php?error=stmtfailed';</script>;";
							exit();
						}else{
							mysqli_stmt_bind_param($emp_leave_stmt, "s", $emp_leave_status);
							mysqli_stmt_execute($emp_leave_stmt);
							$emp_leave_res = mysqli_stmt_get_result($emp_leave_stmt);
							
							$emp_leave_row = mysqli_fetch_assoc($emp_leave_res);
							$emp_leave_count = $emp_leave_row['count'];
							mysqli_stmt_close($emp_leave_stmt);
						}
					?>	
					<div class="number"><?php echo $emp_leave_count;?></div>
					<div class="indicator">
						<i class="fa fa-arrow-right"></i>
						<a href="manage_leaves.php" style="text-decoration: none; color: #fff;"><span class="text">See More</span></a>
					</div>
				</div>
				<i class="fa fa-pie-chart user four"></i>
			</div>
		</div>
		<div class="cardbox">
			<div class="graphbox">
				<div class="year-box">
					<h3 class="box-title">Monthly Attendance Statistics</h3>
					<label for="years" class="selectYr">Select Year:</label>
                    <?php 
                        echo '<select id="years" name="years" onchange="getYear()">'."\n";
                        for ($i = date('Y'); $i >= 2022; $i--){
                            $selected = (date('Y') == $i ? ' selected' : '');
                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n";
                        }
                        echo '</select>'."\n";
                    ?>
						
					<div class="myBox" style="width: 75%;">
						<canvas id="myChart1"></canvas>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>	
        const data1 = {
            labels: <?php echo json_encode($month)?>,
            datasets: [
                {
                    label: "On Time",
                    data: <?php echo json_encode($total_ontime)?>,
                    backgroundColor: "rgb(34,139,34)",
                    borderColor: "rgb(34,139,34)",
                    borderWidth: 1,
                },                     
				{
                    label: "Late",
                    data: <?php echo json_encode($total_lates)?>,
                    backgroundColor: "rgb(15,107,255)",       
                    borderColor: "rgb(15,107,255)",
                    borderWidth: 1,
                }
        	],
        };

        const config1 = {
            type: "bar",
            data: data1,
            options: {
                scales: {
					x: {
						title: {
							display: true,
							text: 'Month'
						}
                    },
                },
            },
        };

        const myChart1 = new Chart(document.getElementById("myChart1"), config1);

    function getYear(val) {
        var stat_year = $("#years").val();
        if(stat_year) {
            $.ajax({
                url: "../includes/fetch.php",
                type: "POST",
                data: {"stat_year":stat_year},
                success: function(data){
                    $(".myBox").html(data);
                    // alert(year)
                }
            }); 
        }
    } 		
	</script>
</section>

<?php include ('footer.php');?>

