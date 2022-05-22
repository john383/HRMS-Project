<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Data</title>
</head>
<body>
    <?php
        if(isset($_SESSION['message'])){
            echo "<h4>".$_SESSION['message']."</h4>";
            unset($_SESSION['message']);
        }
    ?>
    <form action="../includes/execute_import.php" method="post" enctype="multipart/form-data">
        <input type="file" name="import_file">
        <button type="submit" name="import_file_btn">Import File</button>
    </form>
</body>
</html>