<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
       
        $trans_id = $_POST['trans_id'];
        
        include 'inc/function.php';
        $allactions = new Actions();
        
        $sqlQuery = "UPDATE `payments` SET `info_sent`='1' WHERE id = ".$trans_id;
        $result = mysqli_query($allactions->dbConnect, $sqlQuery);
        
        echo true;
    } else {
        echo false;
    }

?>
