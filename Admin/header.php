<?php
	session_start();
    include '../includes/connection.inc.php';

    if(!isset($_SESSION['adminemail'])){
		echo "<script>
                alert('You are not authorized to access this feature!')
                history.go(-1)
            </script>";
            exit;
	}

    $emailadd = print_r($_SESSION['adminemail'], TRUE);
    $query = "SELECT * FROM admin WHERE email = '$emailadd'";
    $res = mysqli_query($conn, $query);
    $rows = mysqli_fetch_array($res);
    $image = $rows['photo'];
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
                    <a href="index.php">
                        <i class="fa fa-dashboard"></i>
                        <span class="link_name">Dashboard</span>
                    </a>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='fa fa-users'></i>
                            <span class="link_name">Employees</span>
                        </a>
                        <i class="fa fa-caret-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="personnel.php">Employee List</a></li>
                        <li><a href="schedules.php">Schedule</a></li>
                        <li><a href="position.php">Position</a></li>
                    </ul>
                </li>
                <li>
                    <a href="attendance.php">
                        <i class='fa fa-calendar'></i>
                        <span class="link_name">Attendance</span>
                    </a>
                </li>
                <li>
                    <div class="iocn-link">
                        <a href="#">
                            <i class='fa fa-bed'></i>
                            <span class="link_name">Leaves</span>
                        </a>
                        <i class="fa fa-caret-down arrow"></i>
                    </div>
                    <ul class="sub-menu">
                        <li><a href="leave_type.php">Add Leave Type</a></li>
                        <li><a href="manage_leaves.php">Pending Leaves</a></li>
                        <li><a href="actioned.php">Actioned Leaves</a></li>
                    </ul>
                </li>
                <li>
                    <a href="report.php">
                        <i class="fa fa-print"></i>
                        <span class="link_name">Reports</span>
                    </a>
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
                            <div class="profile_name" title="<?php echo ucwords($rows['fName'])." ". ucwords($rows['lName']); ?>"><?php echo substr(ucwords($rows['fName']), 0, 1).". ". ucwords($rows['lName']); ?></div>
                            <div class="job">Administrator</div>
                        </div>
                        <?php
                            echo "<a onClick=\"javascript: return confirm('Do you want to proceed?');\" href='logout.inc.php'>
                        <i class='fa fa-sign-out out' title='Log Out'></i>
                        </a>";
                        ?>
                    </div>
                </li>
            </ul>
        </div>
        <section class="home-section">
            