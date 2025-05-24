<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        session_start();
        $userid = $_SESSION['userid'];
        
        $trans_id = $_POST['trans_id'];
        $trans_type = $_POST['trans_type'];
        
        include 'inc/function.php';
        $allactions = new Actions();
        
        $call_outcome = $_POST['call_outcome'];
        $call_back_at = $_POST['call_back_at'];
        $call_remark = $_POST['call_remark'];
        $final_status = $_POST['final_status'];
        
        
        
        if($trans_type == 'lead'){
            
            $custname = $_POST['custname'];
            $custemail = $_POST['custemail'];
            
            $sqlQuery = "UPDATE `leads` SET `CustName`='".$custname."', `email`='".$custemail."' WHERE id = ".$trans_id;
            $result = mysqli_query($allactions->dbConnect, $sqlQuery);
        }
        
        if(isset($_POST['whtup_sent'])){
            $whtup_sent = $_POST['whtup_sent'];    
            
            $sqlQuery = "INSERT INTO `call_attempt`(`trans_id`, `call_outcome`, `call_back_at`, `call_remark`, `trans_type`,`final_status`, `whtup_sent`, `added_by`) VALUES ('$trans_id', '$call_outcome', '$call_back_at', '$call_remark', '$trans_type', '$final_status', '$whtup_sent', '$userid')";
            $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            
            if($whtup_sent == 1){
                
                if($trans_type == 'failed' || $trans_type == 'success'){
                    $sqlQuery = "UPDATE `payments` SET `in_whatspp`='0' WHERE id = ".$trans_id;
                    $result = mysqli_query($allactions->dbConnect, $sqlQuery);
                }else{
                    $sqlQuery = "UPDATE `leads` SET `in_whatspp`='0' WHERE id = ".$trans_id;
                    $result = mysqli_query($allactions->dbConnect, $sqlQuery);
                }
            }
            
        }else{
            
            $sqlQuery = "INSERT INTO `call_attempt`(`trans_id`, `call_outcome`, `call_back_at`, `call_remark`, `trans_type`,`final_status`, `added_by`) VALUES ('$trans_id', '$call_outcome', '$call_back_at', '$call_remark', '$trans_type', '$final_status', '$userid')";
            $result = mysqli_query($allactions->dbConnect, $sqlQuery);   
            
            if($trans_type == 'failed' || $trans_type == 'success'){
                $sqlQuery = "UPDATE `payments` SET `final_status`='".$final_status."' WHERE id = ".$trans_id;
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }else{
                $sqlQuery = "UPDATE `leads` SET `final_status`='".$final_status."' WHERE id = ".$trans_id;
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }
        }
        
        if($call_outcome == '9'){
            
            if($trans_type == 'failed' || $trans_type == 'success'){
                $sqlQuery = "UPDATE `payments` SET `in_whatspp`='1' WHERE id = ".$trans_id;
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }else{
                $sqlQuery = "UPDATE `leads` SET `in_whatspp`='1' WHERE id = ".$trans_id;
                $result = mysqli_query($allactions->dbConnect, $sqlQuery);
            }
        }
        
        
        
        echo true;
    } else {
        echo false;
    }

?>
