<?php

// API credentials
$api_key = '0f46e587-b588-466f-86e8-d713c2a99596';
$api_secret = 'YOUR_API_SECRET';

// Construct request headers
$headers = array(
    'Content-Type: application/json',
    'Authorization: Basic ' . base64_encode($api_key . ':' . $api_secret)
);

// API endpoint for transaction list
$url = 'https://api.phonepe.com/v3/transactions';

// Example request data
$data = array(
    // Optionally, you can include parameters to filter the transaction list
    // For example:
    // 'startDate' => '2024-01-01',
    // 'endDate' => '2024-05-14'
);

// Initialize cURL session
$ch = curl_init($url);

// Set cURL options
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Execute cURL request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
    echo 'Error: ' . curl_error($ch);
}

// Close cURL session
curl_close($ch);

// Process the response
if ($response) {
    $transactions = json_decode($response, true);
    // Handle the transaction data as needed
    print_r($transactions);
} else {
    echo 'No response received.';
}

?>