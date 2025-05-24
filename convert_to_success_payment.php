<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        include 'inc/function.php';
        $allactions = new Actions();
        
        $trans_id = $_POST['trans_id'];
    
        $sqlQuery = "UPDATE payments SET PaymentStatus = 'PAYMENT_SUCCESS', `manual_mark`= 1 WHERE id = '".$trans_id."'";
        
        $result = mysqli_query($allactions->dbConnect, $sqlQuery);
        
        if ($result) {
            
            $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
            $sqlQuery = "SELECT * FROM `payments` WHERE id  = '".$trans_id."'";
	
        	$result = mysqli_query($conn, $sqlQuery);	
        	$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
        	
        	  
            if($row != null || !empty($row)){
                
                require_once('PHPMailer/Exception.php');
                require_once('PHPMailer/OAuth.php');
                require_once('PHPMailer/PHPMailer.php');
                require_once('PHPMailer/SMTP.php');
                require_once('PHPMailer/POP3.php');
                
                $welcome_msg = 'Dear <strong>'.$row["CustName"].'</strong>,<br><br>
                
               This email is to confirm your registration for this i-MBA course with The Vibes Academy. <br/>
                <br/>
               In case you require further details, please contact us on support@thevibes.academy <br/> <br/>
                
                Warm regards,<br>
                The Vibes Academy';
                
                
                $usermail = $row['email'];
                 
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = "localhost";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '587';
                $mail->isHTML();
                $mail->Username = 'hello@thevibes.academy';
                $mail->Password = 'zhgtnzvvdemuemue';
                $mail->SetFrom('hello@thevibes.academy','The Vibes Academy');
                $mail->Subject = "Booking Confirmation";
                $mail->Body =  $welcome_msg;
                $mail->AddAddress($usermail);
                
                //$mail->SMTPDebug  = 1;
                
                $result = $mail->Send();
                    
                
                $welcome_msg2 = '
                
                 Dear Admin<br><br/>
                
                 Below is new booking details <br/><br/>
            
                
                <table border=1>
                
                <tr>
                    <td>Name</td>
                    <td>'.$row["CustName"].'</td>
                </tr>
                 <tr>
                    <td>Email</td>
                    <td>'.$row["email"].'</td>
                </tr>
                 <tr>
                    <td>Mobile</td>
                    <td>'.$row["mobile"].'</td>
                </tr>
                 <tr>
                    <td>Payment Status</td>
                    <td>'.$row["PaymentStatus"].'</td>
                </tr>
                 <tr>
                    <td>txnID</td>
                    <td>'.$row["txnID"].'</td>
                </tr>
                 <tr>
                    <td>customer ID</td>
                    <td>'.$row["customerID"].'</td>
                </tr>
                 <tr>
                    <td>remarks </td>
                    <td>'.$row["remarks"].'</td>
                </tr>
                <tr>
                    <td>TXNdatetime</td>
                    <td>'.$row["TXNdatetime"].'</td>
                </tr>
                   <tr>
                    <td>User IP</td>
                    <td>'.$row["userIP"].'</td>
                </tr>
                
                   <tr>
                    <td>User Device</td>
                    <td>'.$row["UserDevice"].'</td>
                </tr>
                
                   <tr>
                    <td>State Name</td>
                    <td>'.$row["UserIPLocation"].'</td>
                </tr>
                  <tr>
                    <td>Amount</td>
                    <td>'.$row["Amount"].'</td>
                </tr>
                
                </table>
                
                <br/>
                
                Warm regards,<br><br/>
                The Vibes Academy';
                
                
                $usermail = 'hello@thevibes.academy';
                 
                $mail = new PHPMailer();
                $mail->isSMTP();
                $mail->Host = "localhost";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = 'tls';
                $mail->Host = 'smtp.gmail.com';
                $mail->Port = '587';
                $mail->isHTML();
                $mail->Username = 'hello@thevibes.academy';
                $mail->Password = 'zhgtnzvvdemuemue';
                $mail->SetFrom('hello@thevibes.academy','The Vibes Academy');
                $mail->Subject = "New Booking Confirmation";
                $mail->addBCC("marketing@thinquilab.com", "marketing");
                 $mail->addBCC("rdungawat@gmail.com", "testing");
                $mail->Body =  $welcome_msg2;
                $mail->AddAddress($usermail);
                
                //$mail->SMTPDebug  = 1;
                
                $result = $mail->Send();
                     
                $curl_student_reg = curl_init();
            
                curl_setopt_array($curl_student_reg, array(
                  CURLOPT_URL => 'https://thevibesacademy.edmingle.com/nuSource/api/v1/organization/students',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS => array('JSONString' => '{
                  "emails": [
                    {
                      "contact_number_country_id": 103,
                      "contact_number_dial_code": "+91",
                      "email": "'.$row["email"].'",
                      "name": "'.$row["CustName"].'",
                      "organization_id": 8423,
                      "password": "'.$row["customerID"].'",
                      "contact_number": "'.$row["mobile"].'"
                    }
                  ]
                }'),
                  CURLOPT_HTTPHEADER => array(
                    'APIKEY: 5f3dcdc314b866dfea17d3540cbfd95c',
                    'ORGID: 8423'
                  ),
                ));
            
                $response = curl_exec($curl_student_reg);
                
                curl_close($curl_student_reg);  
                 
            
                $sqlQuery = "UPDATE `payments` SET `is_sent`= 1 WHERE id  = '".$trans_id."'";
        	    $result = mysqli_query($conn, $sqlQuery);	
            
            }
            
        }
    }

?>