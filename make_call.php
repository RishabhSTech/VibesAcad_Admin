<?php
session_start();

$from_phone = $_SESSION['login_caller_id'];

if($from_phone == '' || $from_phone == null){
    return false;
    exit;
}
if(isset($_POST['custphone'])){
    $to_phone = $_POST['custphone'];
}elseif (isset($_POST['custphone_custom'])){
    $to_phone = $_POST['custphone_custom'];
}else{
    return false;
    exit;
}

//echo $to_phone;
//exit;


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.exotel.com/v1/Accounts/thinquilab1/Calls/connect',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('From' => $from_phone,'To' => $to_phone,'CallerId' => '08047181735','CallType' => 'trans','Record' => 'true','RecordingChannels' => 'dual','RecordingFormat' => 'mp3'),
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic M2I2ZjVkYjM3OGEzNTUwYWYxMTZiOTc5YjEwNzI5MmI0MzVmZDkzZDg1MWVkNTY3OjUyM2MwZTJmZjkzYzM2NWJhMDUzNWRkZjJlYTc4ZGVlNWRhM2U5OTJmODAyNjY1NQ=='
  ),
));

$response = curl_exec($curl);

curl_close($curl);


include 'inc/function.php';
$allactions = new Actions();

$to_phone = mysqli_real_escape_string($allactions->dbConnect, $to_phone);
$from_phone = mysqli_real_escape_string($allactions->dbConnect, $from_phone);
$response = mysqli_real_escape_string($allactions->dbConnect, $response);

$sqlQuery = "INSERT INTO `call_api_log`(`to_phone`, `from_phone`, `response`) VALUES ('$to_phone', '$from_phone', '$response')";
$result = mysqli_query($allactions->dbConnect, $sqlQuery);

echo $response;
?>
