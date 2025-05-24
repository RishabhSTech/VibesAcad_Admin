<?php
// Razorpay API credentials
$api_key = "rzp_test_j0AdRTrkd74Mb8";
$api_secret = "SBN9J0ZzbZrQDNWQ7iDLhIwL";

// Extract payment/order ID from query parameter
$orderId = isset($_GET['orderId']) ? $_GET['orderId'] : '';

if ($orderId) {
    try {
        // Determine if this is a payment ID or order ID
        if (strpos($orderId, 'pay_') === 0) {
            // Fetch payment details
            $payment = fetchRazorpayPayment($orderId, $api_key, $api_secret);
            $order = $payment ? fetchRazorpayOrder($payment->order_id, $api_key, $api_secret) : null;
        } else {
            // Fetch order details
            $order = fetchRazorpayOrder($orderId, $api_key, $api_secret);
            $payments = $order ? fetchOrderPayments($orderId, $api_key, $api_secret) : null;
            $payment = $payments && count($payments->items) ? $payments->items[0] : null;
        }

        // Generate table HTML
        echo '<table border="1" class="table table-bordered w-100">';
        echo '<tr><th>Field</th><th>Value</th></tr>';
        
        if ($payment) {
            echo '<tr><td>Payment ID</td><td>' . htmlspecialchars($payment->id) . '</td></tr>';
            echo '<tr><td>Amount</td><td>₹' . ($payment->amount / 100) . '</td></tr>';
            echo '<tr><td>Status</td><td>' . htmlspecialchars($payment->status) . '</td></tr>';
            echo '<tr><td>Method</td><td>' . htmlspecialchars($payment->method) . '</td></tr>';
            echo '<tr><td>Created At</td><td>' . date('Y-m-d H:i:s', $payment->created_at) . '</td></tr>';
        }
        
        if ($order) {
            echo '<tr><td>Order ID</td><td>' . htmlspecialchars($order->id) . '</td></tr>';
            echo '<tr><td>Order Amount</td><td>₹' . ($order->amount / 100) . '</td></tr>';
            echo '<tr><td>Receipt</td><td>' . htmlspecialchars($order->receipt) . '</td></tr>';
        }
        
        // Payment method details
        if ($payment && $payment->method === 'card') {
            echo '<tr><td>Card Network</td><td>' . htmlspecialchars($payment->card->network) . '</td></tr>';
            echo '<tr><td>Card Type</td><td>' . htmlspecialchars($payment->card->type) . '</td></tr>';
            echo '<tr><td>Last 4 Digits</td><td>' . htmlspecialchars($payment->card->last4) . '</td></tr>';
        } elseif ($payment && $payment->method === 'upi') {
            echo '<tr><td>VPA</td><td>' . htmlspecialchars($payment->vpa) . '</td></tr>';
        } elseif ($payment && $payment->method === 'netbanking') {
            echo '<tr><td>Bank</td><td>' . htmlspecialchars($payment->bank) . '</td></tr>';
        }
        
        echo '</table>';

    } catch (Exception $e) {
        echo '<div class="alert alert-danger">Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
} else {
    echo '<div class="alert alert-warning">No Order ID/Payment ID provided</div>';
}

/**
 * Fetch payment details from Razorpay API
 */
function fetchRazorpayPayment($paymentId, $api_key, $api_secret) {
    $url = "https://api.razorpay.com/v1/payments/?receipt=$receiptNumber";
    return makeRazorpayRequest($url, $api_key, $api_secret);
}

/**
 * Fetch order details from Razorpay API
 */
function fetchRazorpayOrder($orderId, $api_key, $api_secret) {
    $url = "https://api.razorpay.com/v1/orders/$orderId";
    return makeRazorpayRequest($url, $api_key, $api_secret);
}

/**
 * Fetch payments for an order
 */
function fetchOrderPayments($orderId, $api_key, $api_secret) {
    $url = "https://api.razorpay.com/v1/orders/$orderId/payments";
    return makeRazorpayRequest($url, $api_key, $api_secret);
}

/**
 * Make authenticated request to Razorpay API
 */
function makeRazorpayRequest($url, $api_key, $api_secret) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_USERPWD, "$api_key:$api_secret");
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode !== 200) {
        $error = json_decode($response);
        throw new Exception($error->error->description ?? 'API request failed');
    }
    
    return json_decode($response);
}
?>