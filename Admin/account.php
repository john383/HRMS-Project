<?php
	$title = "Admin | My Account";
	require("header.php");

    $email = $_SESSION['adminemail'];
    $sql = "SELECT * FROM admin WHERE email = '$email'";
    $res = mysqli_query($conn, $sql);

    if(isset($_POST['update_profile'])){
        $adminid = mysqli_real_escape_string($conn, $_POST['adminId']);
        $fname = mysqli_real_escape_string($conn, $_POST['fname']);
        $lname = mysqli_real_escape_string($conn, $_POST['lname']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $location = "../Uploads/";

        //Fetch user details
        $query = "SELECT photo FROM admin WHERE adminId=" . $adminid;
        $result = mysqli_query($conn, $query);
        $photo_row = false;
        if (mysqli_num_rows($result) > 0) {
            $photo_row = mysqli_fetch_assoc($result);
        }
        $name=$_FILES['pphoto']['name'];
        $temp_name=$_FILES['pphoto']['tmp_name'];
        $imageFileType = $_FILES['pphoto']['type'];

        if (!is_uploaded_file($_FILES['pphoto']['tmp_name'])) { //User did not upload image
            $update_profile = "UPDATE admin SET fName = ?, lName = ?, email = ? WHERE adminId = ?";
            $stmt = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($stmt, $update_profile)){
                echo "<script>alert('SQL Error!')</script>";
                header('location: account.php?error=stmtfailed');
                exit();
            }else{
                mysqli_stmt_bind_param($stmt, "sssi", $fname, $lname, $email, $adminid); 
                mysqli_stmt_execute($stmt);
                $_SESSION['adminemail'] = $email;
                move_uploaded_file($temp_name,$location.$name);
                echo"<script>alert('Update Successful')</script>";
                echo "<script>window.location.href = 'account.php'</script>";
            }     
        } else { //User uploaded new image         

            if($imageFileType != "image/jpg" && $imageFileType != "image/png" && $imageFileType != "image/jpeg"){
                echo "<script> alert('Sorry, only JPG, JPEG, & PNG files are allowed.')</script>"; 
            }else{
                if ($_FILES["pphoto"]["size"] > 500000) { //500kb
                    echo "<script> alert('File too large.')</script>"; 
                }else{
                    $new_filename = uniqid('', true)."$name";
                    $update_profile = "UPDATE admin SET fName = ?, lName = ?, email = ?, photo = ? WHERE adminId = ?";
                    $stmt = mysqli_stmt_init($conn);
                    if(!mysqli_stmt_prepare($stmt, $update_profile)){
                        echo "<script>alert('SQL Error!')</script>";
                        header('location: account.php?error=stmtfailed');
                        exit();
                    }else{
                        mysqli_stmt_bind_param($stmt, "ssssi", $fname, $lname, $email, $new_filename, $adminid); 
                        mysqli_stmt_execute($stmt);
                        $_SESSION["email"] = $email;

                        if ($photo_row) {
                            unlink($location . $photo_row['photo']); //Delete old pic
                        }
                        move_uploaded_file($temp_name,$location.$new_filename);
                        echo"<script>alert('Update Successful')</script>";
                        echo "<script>window.location.href = 'account.php'</script>";
                    }    
                }            
            }
        }      
    }
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Your Profile</b></span>
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
            <div class="graphbox" id="graph_box">
                    <div class="update-profile">
                        <form action="" method="post" enctype="multipart/form-data">
                            <?php
                                while($row = mysqli_fetch_array($res)){
                                    $image = $row['photo'];
                                    if (empty($image)) {
                                        echo "<img src='../images/default-profile.jpg' class='center'>";
                                    }else{
                                        echo "<img src='../Uploads/".$image."' class='center'>";
                                    }
                            ?>
                            <h1 class="text-center"><?php echo $row['fName'].' '.$row['lName'];?></h1>
                            <div class="mb-1">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" name="adminId" value="<?php echo $row['adminId']?>">
                                        <label for="recipient-name" class="col-form-label">First Name:</label>
                                        <input type="text" class="form-control" name="fname" id="fname" value="<?php echo $row['fName']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Last Name:</label>
                                        <input type="text" class="form-control" name="lname" id="lname" value="<?php echo $row['lName'];?>">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Email:</label>
                                        <input type="text" class="form-control" name="email" id="email" value="<?php echo $row['email']?>">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="recipient-name" class="col-form-label">Profile Photo:</label> <small style="font-size: 13px; color: #fff;"><i>Note: Only JPEG, JPG and PNG</i></small>
                                        <input type="file" class="form-control" name="pphoto" id="pphoto">
                                        <small style="font-size: 13px; color: #fff;"><i>Additional: Maximum of 5 mb allowed!</i></small>
                                    </div>                                    
                                </div>                
                            </div>                   
                                <input type="submit" value="Update Profile" name="update_profile" class="btn btn-success form-control" >
                                <?php
                                    }
                                ?>
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>
<?php
	include 'footer.php';
?>