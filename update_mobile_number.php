<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'inc/function.php';
    $allactions = new Actions();
    
    $trans_id = $_POST['trans_id'];
    $custmobileNumber = $_POST['custmobileNumber'];

    $sqlQuery = "UPDATE payments SET mobile = $custmobileNumber WHERE id = '".$trans_id."'";
    
    $result = mysqli_query($allactions->dbConnect, $sqlQuery);
    exit;
}

?>