<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
        <label>Enter a keyword to joke</label>
        <input type="text" name="keyword"><br><br>
        <input type="submit" value="submit"><br><br>
    </form>
</body>
</html>

<?php

$keyword = $_POST['keyword'];

$apiKey = "YOUR API KEY";
$url = "https://v2.jokeapi.dev/joke/Any?contains=$keyword";

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

echo "Keyword: " . $keyword . "<br><br>";

if ($data["type"] == "single") {
    echo "Joke: " . $data["joke"];
} else {
    echo "Setup: " . $data["setup"] . "<br>";
    echo "Delivery: " . $data["delivery"];
}
// echo json_encode($data, JSON_PRETTY_PRINT);
?>
