<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://thevibesacademy.edmingle.com/nuSource/api/v1/invoices/payments',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('JSONString' => '{
  "payment_date": 1652985000,
  "mode": 1,
  "ref_no": "Demo",
  "payments": [
    {
      "invoice_id": 1314471,
      "amount": 499,
      "credits_applied": 0
    }
  ],
  "total_payment": 499,
  "cheque_date": null
}'),
  CURLOPT_HTTPHEADER => array(
    'apikey: a44d14e9f1795349cb0282e740c8f4a7',
    'ORGID: 8423'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
