<?php
die();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once('PHPMailer/Exception.php');
require_once('PHPMailer/OAuth.php');
require_once('PHPMailer/PHPMailer.php');
require_once('PHPMailer/SMTP.php');
require_once('PHPMailer/POP3.php');
 $usermail = 'hello@thevibes.academy';
        //$usermail = 'rajeshjoshirj1994@gmail.com';
         
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->Host = "localhost";
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = '587';
        $mail->isHTML();
        $mail->Username = 'hello@thevibes.academy';
        $mail->Password = 'zhgtnzvvdemuemue';
        $mail->SetFrom('hello@thevibes.academy','The Vibes Academy');
        $mail->Subject = "New Booking Confirmation - CustName";
        $mail->addBCC("marketing@thinquilab.com", "marketing");
        $mail->addBCC("rdungawat@gmail.com", "testing");
        $mail->Body =  'ok';
        $mail->AddAddress($usermail);
        
        $mail->SMTPDebug  = 1;
    
        //$result = $mail->Send();
        //die();
        
        
$url = 'https://api.gupshup.io/wa/api/v1/template/msg';

$data = [
    'channel' => 'whatsapp',
    'source' => '919990271299',
    'destination' => '{{destination_phone_number}}',
    'src.name' => 'D0ejuvwSmquZsweDSkvQDVyS',
    'template' => json_encode([
        'id' => 'b500ce6f-e6d3-4d47-ba4b-5d61e4ab2542',
        'params' => [
            'username',
            'clicklink'
        ]
    ]),
    'message' => json_encode([
        'image' => [
            'id' => '3907961596188782'
        ],
        'type' => 'image'
    ])
];

$headers = [
    'Cache-Control: no-cache',
    'Content-Type: application/x-www-form-urlencoded',
    'apikey: spkhwwvvoxr82gkhnlneu4eskunzhhhh'
];

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
} else {
    echo 'Response:' . $response;
}

curl_close($ch);
?>
