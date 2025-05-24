<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $inbound_CustName = $_POST['inbound_CustName'];
        $inbound_email = $_POST['inbound_email'];
        $inbound_mobile = $_POST['inbound_mobile'];
        $inbound_UserIPLocation = $_POST['inbound_UserIPLocation'];
        $inbound_UserDevice = $_POST['inbound_UserDevice'];
        $currentDatetime = date('Y-m-d H:i:s');
        
        include 'inc/function.php';
        $allactions = new Actions();
        
        $sqlQuery = "INSERT INTO `leads`(`CustName`, `email`, `mobile`, `UserIPLocation`, `UserDevice`, `lead_type`, `TXNdatetime`) VALUES ('$inbound_CustName', '$inbound_email', '$inbound_mobile', '$inbound_UserIPLocation', '$inbound_UserDevice', 'inbound', '$currentDatetime')";
        $result = mysqli_query($allactions->dbConnect, $sqlQuery);
        
        echo true;
    } else {
        echo false;
    }

?>
