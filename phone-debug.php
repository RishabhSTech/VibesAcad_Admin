<?php



        /*
        $gateway = (object) [
            'token' => 'VIBESONLINE',
            'secret_key' => '0f46e587-b588-466f-86e8-d713c2a99596',
        ];
        
        $orderId = '663f7786d8a43';
        
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
        
        echo '<Pre>'; print_r($api_response);
        
        */
        


$endpoint = 'https://mercury-uat.phonepe.com/enterprise-sandbox/v3/qr/transaction/list';

$request_data = [
    'size' => 10,
    'merchantId' => 'VIBESONLINE',
    'storeId' => NULL,
];


$json_data = json_encode($request_data);

$headers = [
    'Content-Type: application/json',
    'Accept: application/json',
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $endpoint);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

echo $response;

?>


    