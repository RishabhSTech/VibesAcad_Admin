<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_GET['status']) && $_GET['status'] == 'justtest'){
    function getActiveWhatsAppGroup2() {
        $dbConnect = new mysqli('localhost', 'mba', 'mba@123', 'mba');
        $currentDate = date('Y-m-d');
        $sql2 = "SELECT WhatsAppGroup,BatchStartDate 
                FROM session_details 
                WHERE BatchStartDate <= '$currentDate' AND BatchEndDate >= '$currentDate' 
                LIMIT 1";
        $sql = "SELECT BatchStartDate, WhatsAppGroup 
            FROM session_details 
            WHERE BatchStartDate > '$currentDate' 
            ORDER BY BatchStartDate ASC 
            LIMIT 1";
    
        $result = mysqli_query($dbConnect, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['WhatsAppGroup'];
        }
        return null;
    }
    
    function testmsg(){
        
        $activeGroup = getActiveWhatsAppGroup2();
         
        if ($activeGroup) {
            /*$url = 'https://api.gupshup.io/wa/api/v1/template/msg';
        
            $data = [
                'channel' => 'whatsapp',
                'source' => '919990271299',
                'destination' => '919772846161',
                'src.name' => 'D0ejuvwSmquZsweDSkvQDVyS',
                'template' => json_encode([
                    'id' => '50ecc2e3-3bc5-4386-be50-76cf01957e21',
                    'params' => [
                        'rahul',
                        $activeGroup,
                    ]
                ]),
                'message' => json_encode([
                    'image' => [
                        'id' => '1452051525756378'
                    ],
                    'type' => 'image'
                ])
            ];
        
            
            $headers = [
                'Cache-Control: no-cache',
                'Content-Type: application/x-www-form-urlencoded',
                'apikey: spkhwwvvoxr82gkhnlneu4eskunzhhhh'
            ];
            
            $ch = curl_init($url);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            } else {
                echo 'Response:' . $response;
            }
            
            curl_close($ch);
                 
            die();*/
            
            
            
            $url = 'https://live-mt-server.wati.io/307345/api/v1/sendTemplateMessage?whatsappNumber=919828848399';
            $authorization = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1OWJiNmZhMC1lNTQzLTQxNWItOThlNS1kN2ExNmVmOWVhMGIiLCJ1bmlxdWVfbmFtZSI6InJkdW5nYXdhdEBnbWFpbC5jb20iLCJuYW1laWQiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiZW1haWwiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiYXV0aF90aW1lIjoiMDEvMjIvMjAyNSAxNDowOTo0NyIsInRlbmFudF9pZCI6IjMwNzM0NSIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.HpBRChPZCw_nCnkM_A_4E6OH3SIjCHxXFSInBv8pRls';
            
            $data = [
                "template_name" => "failed_to_custmer",
                "broadcast_name" => "failed_to_custmer",
                "parameters" => [
                    [
                        "name" => "name",
                        "value" => "yogi"
                    ]
                ]
            ];
            
            $ch = curl_init($url);
            
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'accept: /',
                'Authorization: ' . $authorization,
                'Content-Type: application/json-patch+json',
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            
            $response = curl_exec($ch);
            
            if (curl_errno($ch)) {
                echo 'Error:' . curl_error($ch);
            } else {
                echo 'Response:' . $response;
            }
            
            curl_close($ch);
            die();
            
        }
    }
    testmsg();
}

if(isset($_GET['status']) && $_GET['status'] == 'update'){
    
    function check_status($orderId){
        
        $gateway = (object) [
            'token' => 'VIBESONLINE',
            'secret_key' => '0f46e587-b588-466f-86e8-d713c2a99596',
        ];
        
        //$orderId = '662a721bde58d';
        
        $encodeIn265 = hash('sha256', '/pg/v1/status/' . $gateway->token . '/' . $orderId . $gateway->secret_key) . '###1';
        
        $headers = [
            'Content-Type: application/json',
            'X-MERCHANT-ID: ' . $gateway->token,
            'X-VERIFY: ' . $encodeIn265,
            'Accept: application/json',
        ];
        
        $phonePeStatusUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $gateway->token . '/' . $orderId;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $phonePeStatusUrl);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $api_response = json_decode($response);
        
        return $api_response;
        
        /*
        if ($api_response->code == "PAYMENT_SUCCESS") {
            
           echo '<Pre/>'; print_r($api_response);
           
           
        } else {
            
            echo "Transaction Failed";
        }
        */
        
    }
       
    function sendConfirmMail($row){
        
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
        //$usermail = 'rajeshjoshirj1994@gmail.com';
         
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
        $mail->Subject = "New Booking Confirmation - ".$row["CustName"];
        $mail->addBCC("marketing@thinquilab.com", "marketing");
        $mail->addBCC("rdungawat@gmail.com", "testing");
        $mail->Body =  $welcome_msg2;
        $mail->AddAddress($usermail);
        
        //$mail->SMTPDebug  = 1;
    
        $result = $mail->Send();
             
        $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
        $sqlQuery = "UPDATE `payments` SET `is_sent`= 1 WHERE `id` = '".$row["id"]."'";
	    $result = mysqli_query($conn, $sqlQuery);	
        
    }
    
    function sendWhatsapp($CustName, $destination,$id, $WhatsAppGroup){
        
        /*$url = 'https://api.gupshup.io/wa/api/v1/template/msg';

        $data = [
            'channel' => 'whatsapp',
            'source' => '919990271299',
            'destination' => $destination,
            'src.name' => 'D0ejuvwSmquZsweDSkvQDVyS',
            'template' => json_encode([
                'id' => '50ecc2e3-3bc5-4386-be50-76cf01957e21',
                'params' => [
                    $CustName,
                    $WhatsAppGroup,
                ]
            ]),
            'message' => json_encode([
                'image' => [
                    'id' => '1452051525756378'
                ],
                'type' => 'image'
            ])
        ];

        
        $headers = [
            'Cache-Control: no-cache',
            'Content-Type: application/x-www-form-urlencoded',
            'apikey: spkhwwvvoxr82gkhnlneu4eskunzhhhh'
        ];
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        } else {
            //echo 'Response:' . $response;
        }
        
        curl_close($ch);
             
        
        $res = json_decode($response);*/
        
        
        $url = 'https://live-mt-server.wati.io/307345/api/v1/sendTemplateMessages';
        $authorization = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1OWJiNmZhMC1lNTQzLTQxNWItOThlNS1kN2ExNmVmOWVhMGIiLCJ1bmlxdWVfbmFtZSI6InJkdW5nYXdhdEBnbWFpbC5jb20iLCJuYW1laWQiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiZW1haWwiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiYXV0aF90aW1lIjoiMDEvMjIvMjAyNSAxNDowOTo0NyIsInRlbmFudF9pZCI6IjMwNzM0NSIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.HpBRChPZCw_nCnkM_A_4E6OH3SIjCHxXFSInBv8pRls';
        
        $data = [
            "template_name" => "welcome2",
            "broadcast_name" => "welcome2",
            "receivers" => [
                [
                    "whatsappNumber" => $destination,//"9772846161",
                    "customParams" => [
                        [
                            "name" => "name",
                            "value" => $CustName,
                        ],
                        [
                            "name" => "activeGroup",
                            "value" => $WhatsAppGroup,
                        ]
                    ]
                ]
            ]
        ];
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'accept: /',
            'Authorization: ' . $authorization,
            'Content-Type: application/json-patch+json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            //echo 'Error:' . curl_error($ch);
        } else {
           // echo 'Response:' . $response;
        }
        
        $res = json_decode($response);
        
        curl_close($ch);
        
        
        $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
        if($res->result){
        
            $sqlQuery2 = "UPDATE `payments` SET whatsapp_response= '".$response."', congratulations_sent = '1' WHERE `id` = '".$id."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);	
        }else{
            
            $sqlQuery2 = "UPDATE `payments` SET whatsapp_response= '".$response."' WHERE `id` = '".$id."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);	
        }
    }
    
    function student_registration($row){
        
        $url = 'https://thevibes.institute/api/v1/student-registration';

        $headers = [
            'thevibestoken: eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxIiwibmFtZSI6InRoZXZpYmVzdG9rZW4iLCJpYXQiOjE1MTYyMzkwMjJ9.AbXcEd8FpLq1gqpXbWFdSV9mDLQ0OYy8JNTnWj6POmM',
            'Content-Type: application/json'
        ];
        
        $data = [
            'phoneNumber' => $row['mobile'], 
            'courseId' => $row['CourseID'],          
            'customerId' => $row['customerID']       
        ];
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, 1); 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        
        $response = curl_exec($ch);
        
        if (curl_errno($ch)) {
            //echo 'Curl error: ' . curl_error($ch);
        } else {
           
            //echo 'Response: ' . $response;
        }
        
        curl_close($ch);
        
        $res = json_decode($response);
        
        
        if($res->status){
            if(isset($res->data->id)){
                $std_id = $res->data->id;
            }else{
                $std_id = '000';
            }
            
            $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
            $sqlQuery2 = "UPDATE `payments` SET student_id = '".$std_id."', admi_response = '".$response."', is_student_registration = '1', `is_edmingle_std`= 1 WHERE `id` = '".$row["id"]."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);
        }else{
            $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
            $sqlQuery2 = "UPDATE `payments` SET admi_response = '".$response."' WHERE `id` = '".$row["id"]."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);
        }
        
    }
    
    function extractLast10Digits($number) {
        
        $digitsOnly = preg_replace('/[^0-9]/', '', $number);
        
        return substr($digitsOnly, -10);
    }
    
    function getActiveWhatsAppGroup() {
        $dbConnect = new mysqli('localhost', 'mba', 'mba@123', 'mba');
        $currentDate = date('Y-m-d');
        /*$sql = "SELECT WhatsAppGroup 
                FROM session_details 
                WHERE BatchStartDate <= '$currentDate' AND BatchEndDate >= '$currentDate' 
                LIMIT 1";*/
                
        $sql = "SELECT WhatsAppGroup 
            FROM session_details 
            WHERE BatchStartDate > '$currentDate' 
            ORDER BY BatchStartDate ASC 
            LIMIT 1";
    
        $result = mysqli_query($dbConnect, $sql);
        if ($row = mysqli_fetch_assoc($result)) {
            return $row['WhatsAppGroup'];
        }
        return null;
    }
      
    $servername = "localhost";
    $username = "mba";
    $password = "mba@123";
    $dbname = "mba";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    include 'inc/function.php';
    $allactions = new Actions();
    
    $allfailed = $allactions->getTodayfailed();
    
    foreach ($allfailed as $row){
        
        $res = check_status($row['txnID']);
        
        //echo '<br>'. $code = $res->code;
        
        $code = $res->code;
        
        if($code == 'PAYMENT_SUCCESS'){
            //echo '<pre>';print_r($res);
            
            
            $remarkid = $res->data->transactionId;
            $txnID = $res->data->merchantTransactionId;
            
            $sql = "UPDATE payments SET PaymentStatus = '".$code."', remarks = '".$remarkid."', final_status = '1' WHERE txnID = '".$txnID."'";
            $conn->query($sql);
            //die();
            
        }
    }
    
    
    
    //--- send confirmation mail
    
    $allnotsent = $allactions->getFailedMail();
    
    foreach ($allnotsent as $row){
        
        sendConfirmMail($row);
        
    }
    
    
    $allsuccesswhatapp = $allactions->getTodaywhatsapp();
    
    $setting_data = $allactions->getSettingdata();
    $WhatsAppGroup = $setting_data['WhatsAppGroup'];
    
    
    
    $activeGroup = getActiveWhatsAppGroup();
    if ($activeGroup) {
        $WhatsAppGroup = $activeGroup;
    } else {
        //echo "No active WhatsApp Group found.";
    }
    
    //$WhatsAppGroup = getActiveWhatsAppGroup();
    
    if ($activeGroup) {
        
        foreach ($allsuccesswhatapp as $row){
        
            if($row['mobile'] != ''){
                sendWhatsapp($row['CustName'],$row['mobile'],$row['id'], $WhatsAppGroup);
                //sendWhatsapp('00000222213123',$row['id']);
            }
        }
    }
    
    
    //--------- user registration institute -----------
    $allsuccess = $allactions->getUnregisteredStudent();
    
    foreach ($allsuccess as $row){
        
        student_registration($row); 
    }
    
    
}
 
   
?>