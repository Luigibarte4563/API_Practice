<form method="GET">
    <input type="text" name="city" placeholder="Enter city name" required> 
    <button type="submit">Search</button>
</form>

<hr>

<?php
if(isset($_GET['city']) && !empty($_GET['city'])) {

    $city = urlencode($_GET['city']);

    // Get Latitude & Longitude
    $geoUrl = "https://geocoding-api.open-meteo.com/v1/search?name=$city&count=1";

    $geoResponse = file_get_contents($geoUrl);
    $geoData = json_decode($geoResponse, true);

    if(!empty($geoData['results'][0])) {

        $latitude = $geoData['results'][0]['latitude'];
        $longitude = $geoData['results'][0]['longitude'];
        $locationName = $geoData['results'][0]['name'];
        $country = $geoData['results'][0]['country'];

        // Get Weather
        $weatherUrl = "https://api.open-meteo.com/v1/forecast?latitude=$latitude&longitude=$longitude&current_weather=true";

        $weatherResponse = file_get_contents($weatherUrl);
        $weatherData = json_decode($weatherResponse, true);

        if(isset($weatherData['current_weather'])) {

            $current = $weatherData['current_weather'];

            echo "<h3>Weather in $locationName, $country</h3>";
            echo "Temperature: " . $current['temperature'] . " °C<br>";
            echo "Wind Speed: " . $current['windspeed'] . " km/h<br>";
            echo "Wind Direction: " . $current['winddirection'] . "°<br>";
            echo "Time: " . $current['time'];

        } else {
            echo "Weather data not available.";
        }

    } else {
        echo "City not found.";
    }  
}
?>
