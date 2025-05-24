<?php
// Check if API key is provided
$apiKey = $_GET['api_key'] ?? '';
if ($apiKey !== '3a5c236a-97c7-43d6-9674-d2db38777c9a') {
    http_response_code(401);
    echo json_encode(array("error" => "Unauthorized"));
    exit;
}


// Connect to the database
$mysqli = new mysqli("localhost", "mba", "mba@123", "mba");

// Check connection
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode(array("error" => "Database connection failed: " . $mysqli->connect_error));
    exit;
}

// Define API endpoints
$endpoint = $_GET['endpoint'] ?? '';

// Execute SQL query based on endpoint
header('Content-Type: application/json');
switch ($endpoint) {
    case 'txns':
        $result = $mysqli->query("SELECT * FROM payments");
        if ($result) {
            
           $data = $result->fetch_all(MYSQLI_ASSOC);
            
            echo json_encode($data, JSON_PRETTY_PRINT);
           
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to fetch TXNs"));
        }
        break;
    case 'leads':
        $result = $mysqli->query("SELECT * FROM leads");
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to fetch leads"));
        }
        break;
         case 'call_api_log':
        $result = $mysqli->query("SELECT * FROM call_api_log");
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to fetch call_api_log"));
        }
        break;
         case 'call_attempt':
        $result = $mysqli->query("SELECT * FROM call_attempt");
        if ($result) {
            $data = $result->fetch_all(MYSQLI_ASSOC);
            echo json_encode($data, JSON_PRETTY_PRINT);
        } else {
            http_response_code(500);
            echo json_encode(array("error" => "Failed to fetch call attempt"));
        }
        break;
    default:
        http_response_code(400);
        echo json_encode(array("error" => "Invalid endpoint"));
        break;
}

// Close database connection
$mysqli->close();
?>
