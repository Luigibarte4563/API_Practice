<?php
if(isset($_GET['lat']) && isset($_GET['lon'])){

$apiKey = "YOUR_API_KEY";
$lat=$_GET['lat'];
$lon=$_GET['lon'];
$url = "https://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$apiKey&units=metric";

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

header("Content-Type: application/json");
// echo json_encode($data, JSON_PRETTY_PRINT);
echo "Current Weather: ".$data['name'].",";
echo $data['sys']['country'].PHP_EOL;
echo "Temparature: ".$data['main']['temp'];
echo "Weather Description: ".$data['weather'][0]['description'].PHP_EOL;
echo "Feels Like: ".$data['main']['feels_like'].PHP_EOL;
echo "Wind speed: ".$data['wind']['speed']."km/h";

    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather App</title>
</head>
<body>
    <h1>Getting to know your location.......</h1>
</body>
<script>
        if(navigator.geolocation){
            navigator.geolocation.getCurrentPosition(
            function (position){
                //Get the current location
                var lat=position.coords.latitude;
                var lon=position.coords.longitude;
                window.location.href="?lat="+lat+"&lon="+lon;
            },
            function (){
                alert("Wala kang permission");
            }

            )

        }
</script>
</html>