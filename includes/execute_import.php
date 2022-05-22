<?php
    session_start();
    include("connection.inc.php");

    require '../phpspreadsheet/vendor/autoload.php';

    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    $status = "";
    $total = "";
    $total1 = "";
    $total2 = "";
    if(isset($_POST['import_file_btn'])){
        $allowed_ext = ['xls', 'csv', 'xlsx'];

        $fileName = $_FILES['import_file']['name'];
        $checking = explode(".", $fileName);
        $file_ext = end($checking);

        if(in_array($file_ext, $allowed_ext)){
            $targetPath = $_FILES['import_file']['tmp_name'];
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($targetPath);
            $data = $spreadsheet->getActiveSheet()->toArray();
    
            $count = "0";
            $last_value = NULL;
            foreach($data as $row){
                if($count > 0){
                    $bioId = $row['1'];
                    if($bioId > 0){
                        $last_value = $bioId;
                    }else{
                        $bioId = $last_value;
                    }
                    // echo "<pre>";
                    // echo $empId;
                    // echo "</pre>";

                    // $empployeeId = mysqli_real_escape_string($conn, $empId);
                    // $date = mysqli_real_escape_string($conn, date('Y-m-d', strtotime($row['3'])));
                    $results = array();

                    preg_match_all('#\d{4}-\d{2}-\d{2}#', $row['3'], $results);

                    $date1 = $results[0][0];
                    unset($results);
                    $date = date("Y-m-d", strtotime($date1));
                    $timeinAm = mysqli_real_escape_string($conn, $row['4']);
                    $timeoutAm = mysqli_real_escape_string($conn, $row['5']);
                    $timeinPm = mysqli_real_escape_string($conn, $row['6']);
                    $timeoutPm = mysqli_real_escape_string($conn, $row['7']);

                    $schedule = "SELECT * FROM employees INNER JOIN schedules ON schedules.scheduleId = employees.scheduleid WHERE employees.bioId = '$bioId'";
                    $results = mysqli_query($conn, $schedule);
                    $schedule_row = mysqli_fetch_array($results);
                    $firstsessionTimein = $schedule_row['time_inAm'];
                    $secondsessionTimein = $schedule_row['time_inPm'];


                    if(strtotime($timeinAm) > strtotime($timeoutPm)){ //night shift
                        if(strtotime($timeinAm) > strtotime($firstsessionTimein)){
                            $status = "Late";
                        }else if(strtotime($timeinAm) == NULL && strtotime($timeoutPm) == NULL){
                            $status = "No Work";                        
                        }else{
                            $status = "On Time";
                        }
                    }else{ //day shift
                        if (date("D", strtotime($date)) == 'Sat'){
                            if(strtotime($timeinAm) <= strtotime("08:00:00")){
                                $status = "On Time";
                            }else if(strtotime($timeinAm) == NULL && strtotime($timeoutAm) == NULL){
                                $status = "No Work";                                                        
                            }else{
                                $status = "Late";
                            }
                        }else{
                            if(strtotime($timeinAm) > strtotime($firstsessionTimein) || strtotime($timeinPm) > strtotime($secondsessionTimein)){
                                $status = "Late";
                            }else if(strtotime($timeinAm) == NULL && strtotime($timeoutPm) == NULL){
                                $status = "No Work";                        
                            }else{
                                $status = "On Time";
                            }
                        }
                    }

                    $sql = "INSERT INTO attendance(bioId, date, time_inAm, time_outAm, time_inPm, time_outPm, attend_status) VALUES (?, ?, ?, ?, ?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    //check if it fails
                    if(!mysqli_stmt_prepare($stmt, $sql)){
                        echo "SQL Statement Failed!";
                    }else{
                        mysqli_stmt_bind_param($stmt, "sssssss", $bioId, $date, $timeinAm, $timeoutAm, $timeinPm, $timeoutPm, $status);
                        mysqli_stmt_execute($stmt);
                        echo '<script>alert("Data Saved Successfully");</script>';
                        echo'<script>   
                            window.location.href = "../Admin/attendance.php"</script>';
                    }
                    $msg = true;
                }else{
                    $count = "1";
                }
            }
    
            if(isset($msg)){
                $_SESSION['message'] = "Successfully Imported";
                header('Location: ../Admin/attendance.php');
                exit(0);
            }else{
                $_SESSION['message'] = "Not Imported";
                header('Location: ../Admin/attendance.php');
                exit(0);
            }
        }else{
            $_SESSION['status'] = "Invalid File";
            header("Location: ../Admin/attendance.php");
            exit(0);
        }
    }
?>