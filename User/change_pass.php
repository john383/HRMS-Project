<?php
	$title = "Update Password";
	require("header.php");

    if(isset($_POST['update_password'])){
        $current = mysqli_real_escape_string($conn, $_POST['cur_pass']);
        $new = mysqli_real_escape_string($conn, $_POST['new_pass']);
        $confirm = mysqli_real_escape_string($conn, $_POST['cpass']);

        $id = print_r($_SESSION["empId"], TRUE);
        $sql = "SELECT password FROM employees WHERE empId = '$id'";
        $res = mysqli_query($conn, $sql);
        $pass_row = mysqli_fetch_array($res);
        $pwdHashed = $pass_row["password"];
        $checkPwd = password_verify($current, $pwdHashed);

        if($checkPwd === false){
            header("location: change_pass.php?error=wrongpass");
            exit();
        }else  if($checkPwd === true){
            if($new == $confirm){
                $hash = password_hash($new, PASSWORD_DEFAULT);

                $upd_pass = "UPDATE employees SET password = ? WHERE empId = ?";
                $stmt = mysqli_stmt_init($conn);
                if(!mysqli_stmt_prepare($stmt, $upd_pass)){
                    echo "<script>alert('SQL Error!')</script>";
                    header('location: account.php?error=stmtfailed');
                    exit();
                }else{
                    mysqli_stmt_bind_param($stmt, "ss", $hash, $id); 
                    mysqli_stmt_execute($stmt);

                    echo"<script>alert('Password Updated Successfully')</script>";
                    echo "<script>window.location.href = 'change_pass.php'</script>";
                }    
            }else{
                echo "<script>alert('Password not Match')</script>";
            }
        }
    }
?>
    <nav>
        <div class="sidebar-button">
            <span class="dashboard"><b>Update Password</b></span>
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
                    <h3 class="box-title text-center mt-5"><b>Change Password</b></h3>
                        <form action="" method="post">
                            <div class="mb-5">
                                <div class="col">
                                    <label for="recipient-name" class="col-form-label">Current Password:</label>
                                    <input type="password" class="form-control" name="cur_pass" id="cur_pass" autocomplete="off" placeholder="Current Password" required>
                                </div>
                                <div class="col">
                                    <label for="recipient-name" class="col-form-label">New Password:</label>
                                    <input type="password" class="form-control" name="new_pass" id="new_pass" autocomplete="off" placeholder="New Password" required>
                                </div>
                                <div class="col">
                                    <label for="recipient-name" class="col-form-label">Confirm Password:</label>
                                    <input type="password" class="form-control" name="cpass" id="cpass" autocomplete="off" placeholder="Confirm Password" required>
                                </div>
                            </div>  
                            <input type="submit" value="Update Password" name="update_password" class="btn btn-success form-control">                              
                        </form>
                    </div>
            </div>
        </div>
    </div>
</section>

<?php
	include 'footer.php';
?>