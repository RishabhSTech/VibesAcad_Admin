<?php

// API endpoint
$url = 'https://api.gupshup.io/wa/api/v1/template/msg';

// Data to be sent in the request body
$data = array(
    'channel' => 'whatsapp',
    'source' => '919990271399',
    'destination' => '9828848399',
    'src.name' => 'a2st4ZlbaUM57nRN6bsWCXNo',
    'template' => '{"id":"56af301b-0ddc-4adf-94aa-6c787df05266","params":[]}',
    'message' => '{"image":{"id":"471257955414572"},"type":"image"}'
);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'apikey: spkhwwvvoxr82gkhnlneu4eskunzhhhh',
    'Content-Type: application/x-www-form-urlencoded',
    'Cache-Control: no-cache'
));

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if(curl_errno($ch)){
    echo 'Curl error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Output response
echo $response;
?>
