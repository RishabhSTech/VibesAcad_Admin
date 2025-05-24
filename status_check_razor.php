<?php
// Razorpay API credentials
$api_key = "rzp_test_j0AdRTrkd74Mb8";
$api_secret = "SBN9J0ZzbZrQDNWQ7iDLhIwL";

// Extract orderId (which is actually our receipt number) from query parameter
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';

if ($orderId) {
    try {
        // Initialize cURL for fetching orders by receipt number (passed as orderId)
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders?receipt=$orderId");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if ($httpCode !== 200) {
            throw new Exception("API request failed with status $httpCode");
        }
        
        $result = json_decode($response);
        
        if (empty($result->items)) {
            throw new Exception("No order found with receipt number: $orderId");
        }
        
        $order = $result->items[0];
        $razorpayOrderId = $order->id;
        
        // Now fetch payments for this order
        curl_setopt($ch, CURLOPT_URL, "https://api.razorpay.com/v1/orders/$razorpayOrderId/payments");
        $paymentsResponse = curl_exec($ch);
        $payments = json_decode($paymentsResponse);
        curl_close($ch);
        
        $payment = !empty($payments->items) ? $payments->items[0] : null;

        // Generate table HTML (maintaining same structure as PhonePe version)
        echo '<table border="1" class="table table-bordered w-100">';
        echo '<tr><th>Field</th><th>Value</th></tr>';
        
        // Order details (mapped to similar PhonePe fields)
        echo '<tr><td>Txn Number</td><td>' . htmlspecialchars($order->receipt) . '</td></tr>';
        echo '<tr><td>Razorpay Order ID</td><td>' . htmlspecialchars($order->id) . '</td></tr>';
        echo '<tr><td>Amount</td><td>₹' . ($order->amount / 100) . '</td></tr>';
        echo '<tr><td>Status</td><td>' . htmlspecialchars($order->status) . '</td></tr>';
        
        // Payment details if available
        if ($payment) {
            echo '<tr><td>Payment ID</td><td>' . htmlspecialchars($payment->id) . '</td></tr>';
            echo '<tr><td>Payment Status</td><td>' . htmlspecialchars($payment->status) . '</td></tr>';
            echo '<tr><td>Method</td><td>' . htmlspecialchars($payment->method) . '</td></tr>';
            
            // Payment method specific details
            if ($payment->method === 'card') {
                echo '<tr><td>Card Network</td><td>' . htmlspecialchars($payment->card->network) . '</td></tr>';
                echo '<tr><td>Card Type</td><td>' . htmlspecialchars($payment->card->type) . '</td></tr>';
            } elseif ($payment->method === 'upi') {
                echo '<tr><td>VPA</td><td>' . htmlspecialchars($payment->vpa) . '</td></tr>';
            }
        }
        
        echo '</table>';
        
    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No Receipt Number (orderId) provided</div>';
}
?>
