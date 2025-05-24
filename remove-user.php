<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    include 'inc/function.php';
    $allactions = new Actions();
    
    if($_POST['uid'] && $_POST['uid'] != ''){
        $uid = $_POST['uid'];
        $sqlQuery = "DELETE FROM `admin_users` WHERE `id` = '".$uid."'";
        $result = mysqli_query($allactions->dbConnect, $sqlQuery);
        exit;
    }
    
}

?>