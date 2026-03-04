<?php

$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => json_encode([
    'data' => [
        'attributes' => [
                'send_email_receipt' => false,
                'show_description' => true,
                'show_line_items' => true,
                'line_items' => [
                                [
                                                                'currency' => 'PHP',
                                                                'amount' => 100,
                                                                'description' => 'Clothes',
                                                                'name' => 'T-shirt',
                                                                'quantity' => 2
                                ]
                ],
                'payment_method_types' => [
                                'gcash',
                                'paymaya',
                                'qrph'
                ]
        ]
    ]
  ]),
  CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "accept: application/json",
    "authorization: Basic c2tfdGVzdF92NzVoakJMeWs4V3JLRVdTYkdGUGd3aVo6"
  ],
  CURLOPT_SSL_VERIFYPEER=>false
]);

$response = curl_exec($curl);
$data=json_decode($response,true);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  $url= $data['data']['attributes']['checkout_url'];
  echo '<a href="'.$url.'">Pay here</a>';
}