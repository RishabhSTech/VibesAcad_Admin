<?php

if(isset($_GET['status']) && $_GET['status'] == 'update'){
    $servername = "localhost";
    $username = "mba";
    $password = "mba@123";
    $dbname = "mba";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    //$sql = "INSERT INTO `test`(`id`, `name`) VALUES (1,2)";
    //$result = $conn->query($sql);
    
    
    include 'inc/function.php';
    $allactions = new Actions();
    
    $allattept = $allactions->getCallattept();
    
    foreach ($allattept as $row){
            
            if($row['trans_type'] == 'failed' || $row['trans_type'] == 'success'){
                $sqlQuery = "UPDATE `payments` SET `final_status`='2' WHERE id = ".$row['trans_id'];
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }else{
                $sqlQuery = "UPDATE `leads` SET `final_status`='2' WHERE id = ".$row['trans_id'];
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }
            
            $sqlQuery = "UPDATE `call_attempt` SET `final_status`='2' WHERE trans_id = ".$row['trans_id'];
            $result = mysqli_query($allactions->dbConnect, $sqlQuery);
         
    }
}



    
/*
include 'inc/function.php';
$allactions = new Actions();


$all_leads = $allactions->getallLeads();
$all_payt = $allactions->getallPayements();

$abc = array_merge($all_leads, $all_payt);

$ids = array_column($abc, 'id');

$idString = implode(',', $ids);

$sqlQuery = "DELETE FROM `call_attempt` WHERE `trans_id` NOT IN ($idString)";
$result = mysqli_query($allactions->dbConnect, $sqlQuery);

die();

*/

?>