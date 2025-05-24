<?php
// Define PhonePe gateway information
$gateway = (object) [
    'token' => 'VIBESONLINE',
    'secret_key' => '0f46e587-b588-466f-86e8-d713c2a99596',
];

// Extract transaction ID from query parameter
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';

if ($orderId) {
    // Construct X-VERIFY header for status check
    $encodeIn265 = hash('sha256', '/pg/v1/status/' . $gateway->token . '/' . $orderId . $gateway->secret_key) . '###1';

    // Set headers for the status check request
    $headers = [
        'Content-Type: application/json',
        'X-MERCHANT-ID: ' . $gateway->token,
        'X-VERIFY: ' . $encodeIn265,
        'Accept: application/json',
    ];

    // Define PhonePe status check URL
    $phonePeStatusUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Development
    // $phonePeStatusUrl = 'https://api.phonepe.com/apis/hermes/pg/v1/status/' . $gateway->token . '/' . $orderId; // For Production

    // Initialize cURL for status check
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $phonePeStatusUrl);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    curl_close($ch);

    // Decode the status check response
    $api_response = json_decode($response, true);

    // Check if the response is successful
    if ($api_response['success']) {
        // Extract data from the response
        $data = $api_response['data'];

        // Generate table HTML
        echo '<table border="1" class="table table-bordered w-100">';
        echo '<tr><th>Field</th><th>Value</th></tr>';
        echo '<tr><td>Merchant ID</td><td>' . $data['merchantId'] . '</td></tr>';
        echo '<tr><td>Merchant Transaction ID</td><td>' . $data['merchantTransactionId'] . '</td></tr>';
        echo '<tr><td>Transaction ID</td><td>' . $data['transactionId'] . '</td></tr>';
        echo '<tr><td>Amount</td><td>' . $data['amount'] . '</td></tr>';
        echo '<tr><td>State</td><td>' . $data['state'] . '</td></tr>';
        echo '<tr><td>Response Code</td><td>' . $data['responseCode'] . '</td></tr>';
        echo '<tr><td>Payment Instrument Type</td><td>' . $data['paymentInstrument']['type'] . '</td></tr>';
        echo '<tr><td>UTR</td><td>' . $data['paymentInstrument']['utr'] . '</td></tr>';
        echo '<tr><td>Account Type</td><td>' . $data['paymentInstrument']['accountType'] . '</td></tr>';
        echo '<tr><td>Fees Context Amount</td><td>' . $data['feesContext']['amount'] . '</td></tr>';
        echo '</table>';
    } else {
        // If the response is not successful, display an error message
        echo 'Error: ' . $response;
    }
} else {
    // No order ID provided
    echo "No Order ID provided";
}
?>
