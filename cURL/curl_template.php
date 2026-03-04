<?php

$lat = 16.01098805624789;
$lon = 120.35562716887895;
$apiKey = "689300a00e0d52fa77706b78c1b0a0de";
$url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey";

$ch = curl_init($url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

$response = curl_exec($ch);

if ($response === false) {
    echo json_encode([
        "error" => "API not responding: " . curl_error($ch)
    ]);
    curl_close($ch);
    exit;
}

$httpCode=curl_getinfo($ch,CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode != 200) {
    echo json_encode([
        "error" => "API returned status code: " . $httpCode
    ]);
    exit;
}

$data = json_decode($response, true);

// header("Content-Type: application/json");
// echo json_encode($data, JSON_PRETTY_PRINT);

echo $data['name'] . "<br>";
echo $data['weather'][0]['main'] . "<br>";
echo $data['weather'][0]['description'] . "<br>";
?>