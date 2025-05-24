<?php
// Set your secret API key
$valid_api_key = 'ACTHEBVIBES111';

// Function to send WhatsApp message using Gupshup
function sendWhatsapp($source, $destination, $template_id, $params = [], $image_id = null) {
    $url = 'https://api.gupshup.io/wa/api/v1/template/msg';

    // Prepare data
    $data = array(
          'channel' => 'whatsapp',
    'source' => $source,  // Your WhatsApp source number
    'destination' => $destination,  // Destination phone number
    'src.name' => 'D0ejuvwSmquZsweDSkvQDVyS',  // Your Gupshup source name
    'template' => json_encode(array(
        'id' => '3afbf7eb-7dfc-4100-8db2-f89a39f98706',  // Template ID
        'params' => array()  // Params for the template
    ))
    
    );

    if ($image_id) {
        $data['message'] = json_encode(['image' => ['id' => $image_id], 'type' => 'image']);
    }

    // Initialize cURL session
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Cache-Control: no-cache',
    'Content-Type: application/x-www-form-urlencoded',
    'apikey: spkhwwvvoxr82gkhnlneu4eskunzhhhh'  // Your Gupshup API key
    ));

    $response = curl_exec($ch);

    if (curl_errno($ch)) {
        return 'Curl error: ' . curl_error($ch);
    }

    curl_close($ch);
    return $response;
}

// Get query parameters from the URL
$api_key = $_GET['api_key'] ?? null;
$source = $_GET['source'] ?? null;  // Get source from the URL
$destination = $_GET['destination'] ?? null;
$template_id = $_GET['template'] ?? null;
$params = isset($_GET['params']) ? json_decode($_GET['params'], true) : [];
$image_id = $_GET['image_id'] ?? null;

// Validate the API key and required parameters
if ($api_key === $valid_api_key) {
    if ($source && $destination && $template_id) {
        // Send WhatsApp message
        $response = sendWhatsapp($source, $destination, $template_id, $params, $image_id);

        // Respond with the API result
        echo json_encode([
            'status' => 'success',
            'response' => json_decode($response, true)
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing source, destination, or template ID'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid API key'
    ]);
}
?>
