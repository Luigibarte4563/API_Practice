<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="color_palette.php" method="POST">
        <label>color</label>
        <input type="text" name="color"><br><br>
        <input type="submit" value="submit">
    </form>
</body>
</html>

<?php

$color_palette = $_POST['color'];

$apiKey = "YOUR API KEY";
$url = "https://colormagic.app/api/palette/search?q=$color_palette";

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

foreach ($data as $palette) {
    foreach ($palette['colors'] as $color) {
        echo $color . "<br>";

        echo "<div style='
                    width: 100%;
                    height: 100px;
                    background-color: $color;'>
                </div>";
    }
}
?>