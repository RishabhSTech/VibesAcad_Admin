<?php
header('Content-Type: application/json');

$apiKey = 'DFFSS-SS554S-15SSS'; // Replace with your actual API key
$inputApiKey = $_GET['api_key'] ?? '';

if ($apiKey !== $inputApiKey) {
    echo json_encode(['success' => false, 'error' => 'Unauthorized access']);
    http_response_code(401);
    exit;
}

$mobileNumber = $_GET['mobile_number'] ?? '';

if (empty($mobileNumber)) {
    echo json_encode(['success' => false, 'error' => 'Mobile number is required']);
    http_response_code(400);
    exit;
}

$servername = "localhost"; // Update with your server details
$username = "mba"; // Update with your database username
$password = "mba@123"; // Update with your database password
$dbname = "mba"; // Update with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => 'Database connection failed: ' . $conn->connect_error]);
    http_response_code(500);
    exit;
}

$sql = "SELECT id, CustName, IFNULL(CourseID, '60_Days_Course') as CourseID, email, customerID, PaymentStatus, CourseName, TXNdatetime, SelfPaced FROM payments WHERE mobile = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    echo json_encode(['success' => false, 'error' => 'Prepare failed: ' . $conn->error]);
    http_response_code(500);
    exit;
}

$stmt->bind_param("s", $mobileNumber);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode(['success' => true, 'data' => $data]);
    http_response_code(200);
} else {
    echo json_encode(['success' => false, 'data' => false, 'message' => 'Data not found']);
    http_response_code(404);
}

$stmt->close();
$conn->close();
?>
