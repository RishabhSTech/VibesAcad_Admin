<?php


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
          
    }
    
     function sendWhatsapp($CustName, $destination,$id, $enrollPageLink){
        
        /*$url = 'https://api.gupshup.io/wa/api/v1/template/msg';

        $data = [
            'channel' => 'whatsapp',
            'source' => '919990271299',
            'destination' => $destination,
            'src.name' => 'D0ejuvwSmquZsweDSkvQDVyS',
            'template' => json_encode([
                'id' => 'cd5be689-cf6b-4b8c-a64c-b91536b8086c',
                'params' => [
                    $CustName,
                    $enrollPageLink
                ]
            ]),
            'message' => json_encode([
                'image' => [
                    'id' => '619933043689815'
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
          
        curl_close($ch); 
             
        
        $res = json_decode($response);
        */
        
        
        $url = 'https://live-mt-server.wati.io/307345/api/v1/sendTemplateMessage?whatsappNumber=91'.$destination;
        $authorization = 'Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJqdGkiOiI1OWJiNmZhMC1lNTQzLTQxNWItOThlNS1kN2ExNmVmOWVhMGIiLCJ1bmlxdWVfbmFtZSI6InJkdW5nYXdhdEBnbWFpbC5jb20iLCJuYW1laWQiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiZW1haWwiOiJyZHVuZ2F3YXRAZ21haWwuY29tIiwiYXV0aF90aW1lIjoiMDEvMjIvMjAyNSAxNDowOTo0NyIsInRlbmFudF9pZCI6IjMwNzM0NSIsImRiX25hbWUiOiJtdC1wcm9kLVRlbmFudHMiLCJodHRwOi8vc2NoZW1hcy5taWNyb3NvZnQuY29tL3dzLzIwMDgvMDYvaWRlbnRpdHkvY2xhaW1zL3JvbGUiOiJBRE1JTklTVFJBVE9SIiwiZXhwIjoyNTM0MDIzMDA4MDAsImlzcyI6IkNsYXJlX0FJIiwiYXVkIjoiQ2xhcmVfQUkifQ.HpBRChPZCw_nCnkM_A_4E6OH3SIjCHxXFSInBv8pRls';
        
        $data = [
            "template_name" => "failed_to_custmer",
            "broadcast_name" => "failed_to_custmer",
            "parameters" => [
                [
                    "name" => "name",
                    "value" => $CustName
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
            //echo 'Response:' . $response;
        }
        
        $res = json_decode($response);
        curl_close($ch);
        
        
        
        $conn = new mysqli('localhost', 'mba', 'mba@123', 'mba');
        if($res->result){
        
            $sqlQuery2 = "UPDATE `payments` SET whatsapp_response= '".$response."', failed_sent = '1' WHERE `id` = '".$id."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);	
        }else{
            
            $sqlQuery2 = "UPDATE `payments` SET whatsapp_response= '".$response."' WHERE `id` = '".$id."'";
    	    $result2 = mysqli_query($conn, $sqlQuery2);	
        }
    }
    
    
    include 'inc/function.php';
    $allactions = new Actions();
    
    $allfailed = $allactions->getLastDayfailed();
    
    $setting_data = $allactions->getSettingdata();
    $enrollPageLink = $setting_data['enrollPageLink'];
    foreach ($allfailed as $row){
        
        $res = check_status($row['txnID']);
        
        $code = $res->code;
        
        if($code == 'PAYMENT_SUCCESS'){
          
            
        }else{
            if($row['mobile'] != ''){
                sendWhatsapp($row['CustName'],$row['mobile'],$row['id'],$enrollPageLink);
                
            }
        }
    }
}



?>