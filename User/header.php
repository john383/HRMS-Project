<?php
	session_start();
    include '../includes/connection.inc.php';

    if(!isset($_SESSION['email'])){
		echo "<script>
                alert('You are not authorized to access this feature!')
                history.go(-1)
            </script>";
            exit;
	}

    $emailadd = print_r($_SESSION['email'], TRUE);
    $query = "SELECT * FROM employees WHERE emailadd = '$emailadd'";
    $res = mysqli_query($conn, $query);
    $rows = mysqli_fetch_array($res);
    $image = $rows['pPhoto'];
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../Css/style.css">
        <link rel = "icon" href ="../images/Logo1.png" type = "image/x-icon">
		<script src="../Js/chart.js"></script>
        <link href="../Plugins/Bootstrap/bootstrap.min.css" rel="stylesheet">
        <script src="../Js/bootstrap.bundle.min.js"></script>
        <script src="../Js/jquery-3.6.0.min.js"></script>
        <link rel="stylesheet" href="../Plugins/Bootstrap/dataTables.bootstrap5.min.css">
        <!-- <script src="Js/jquery-3.5.1.js"></script> -->
        <script src="../Js/jquery.dataTables.min.js"></script>
        <script src="../Js/dataTables.bootstrap5.min.js"></script>
        <link rel="stylesheet" href="../Css/font-awesome.min.css" />
        <meta http-equiv="Cache-control" content="no-cache">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <title><?php echo $title?></title>

        <script>
            if(window.history.replaceState){
                window.history.replaceState(null, null, window.location.href);
            }
        </script>
	</head>
    <body>
        <div class="sidebar">
            <div class="logo-details">
                <img src="../images/Logo.png" class="img1" id="hide1">
            </div>
            <ul class="nav-links">
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='fa fa-bed'></i>
                            <span class="link_name">Leaves</span>
                        </a>
                        <i class="fa fa-caret-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <!-- <li><a class="link_name" href="#">Add Leave Type</a></li> -->
                        <li><a href="leave.php">Apply Leave</a></li>
                        <li><a href="actioned.php">Actioned Leaves</a></li>
                    </ul>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='fa fa-user'></i>
                            <span class="link_name">Account</span>
                        </a>
                        <i class="fa fa-caret-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="account.php">Update Profile</a></li>
                        <li><a href="change_pass.php">Change Password</a></li>
                    </ul>
                </li>
                <li>
                    <div class="profile-details">
                        <div class="profile-content">
                            <?php
                                if (empty($image)) {
                                    echo "<img src='../images/default-profile.jpg' alt='Profile'>";
                                }else{
                                    echo "<img src='../Uploads/".$image."' alt='Profile'>";

                                }
                            ?>
                        </div>
                        <div class="name-job">
                            <?php 
                                $id = print_r($_SESSION["empId"], TRUE);
                                $sql = "SELECT * FROM employees INNER JOIN position ON position.positionId = employees.positionid WHERE empId = $id";
                                $result = mysqli_query($conn, $sql);
                                if(mysqli_num_rows($result) > 0){
                                    while($row = mysqli_fetch_array($result)){
                            ?>
                                <div class="profile_name" title="<?php echo ucwords($row['fName'])." ". ucwords($row['lName']); ?>"><?php echo substr(ucwords($row['fName']), 0, 1).". ". ucwords($row['lName']); ?></div><!--F. Bantillan-->
                                <div class="job"><?php echo ucwords($row['positionName'])?></div>
                            <?php 
                                    } 
                                }
                            ?>
                        </div>
                        <?php
                            echo "<a onClick=\"javascript: return confirm('Do you want to proceed?');\" href='../includes/logout.inc.php'>
                        <i class='fa fa-sign-out out' title='Log Out'></i>
                        </a>";
                        ?>
                    </div>
                </li>
            </ul>
        </div>
        <section class="home-section">
        <!-- <script>
            let arrow = document.querySelectorAll(".arrow");
            for (var i = 0; i < arrow.length; i++) {
                arrow[i].addEventListener("click", (e) => {
                    let arrowParent = e.target.parentElement.parentElement; //selecting main parent of arrow
                    arrowParent.classList.toggle("showMenu");
                    // arrowParent.classList.toggle("active");

                    // arrowParent.classList.className = " ";
                });
            }
        </script> -->
            