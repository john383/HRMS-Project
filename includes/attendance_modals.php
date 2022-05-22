<?php
    include("connection.inc.php");    
?>
<!-- Update Attendance -->
<div class="modal" id="update_attend">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Update Attendance</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" id="update_attend_Form">
                <!-- Modal body -->
                <div class="modal-body displayupdate_attend">

                </div>
                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="updateattend">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('.attend_updt_btn').click(function() {
            attend_id = $(this).attr('id');
            $.ajax({
                url: "../includes/update_sched.php",
                method :'post',
                data:{attend_id:attend_id},
                success: function(result){
                    $(".displayupdate_attend").html(result);
                    $('#update_attend').modal('show');
                }
            }); 
        });

        $(document).on('click', '#updateattend', function(){
            $.ajax({
                url: "../includes/update_data.php",
                method :'post',
                data:$("#update_attend_Form").serialize(),
                success: function(result){
                        $('#update_attend').modal('hide');
                        alert('Data Successfully Updated');
                        window.location = "../admin/attendance.php";
                }
            }); 
        });
    });
</script>