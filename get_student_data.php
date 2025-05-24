<?php

$phone = '';
if(isset($_POST['phone'])){
    $phone = $_POST['phone'];
}else{
    return false;
    exit;
}

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://thevibesacademy.edmingle.com/nuSource/api/v1/student/search?institution_id=6548&student_mobile_number='.$phone,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
));

$response = curl_exec($curl);
$res = json_decode($response);
curl_close($curl);

if($res->code == 200){
    $student_id = $res->user_details[0]->student_id;
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://thevibesacademy.edmingle.com/nuSource/api/v1/user/details?user_id='.$student_id,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'apikey: 52f586f504844f6081f9d70288f7eb3b',
        'ORGID: 8423'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    //$u_data = json_decode($response);
    //if($u_data->code == 200){
        echo $response;
    //}
}

?>
