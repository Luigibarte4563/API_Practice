<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rick and Morty Search</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #1f1f2e, #2c2c54);
            color: white;
            text-align: center;
            padding: 50px;
        }

        h1 {
            margin-bottom: 20px;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"] {
            padding: 10px;
            width: 250px;
            border-radius: 8px;
            border: none;
            outline: none;
        }

        input[type="submit"] {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            background: #00b894;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }

        input[type="submit"]:hover {
            background: #019875;
        }

        .card {
            background: #2f3640;
            padding: 20px;
            border-radius: 15px;
            width: 300px;
            margin: 0 auto;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
        }

        .card img {
            border-radius: 10px;
            margin-top: 10px;
        }

        .error {
            color: #ff7675;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Rick and Morty Character Search</h1>

    <form method="POST">
        <input type="text" name="character" placeholder="Enter character name">
        <input type="submit" value="Search">
    </form>

<?php

$character = $_POST['character'] ?? '';

if ($character != "") {

    $url = "https://rickandmortyapi.com/api/character/?name=" . urlencode($character);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);

    if ($response === false) {
        echo "<p class='error'>API Error: " . curl_error($ch) . "</p>";
        curl_close($ch);
        exit;
    }

    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode != 200) {
        echo "<p class='error'>Character not found!</p>";
        exit;
    }

    $data = json_decode($response, true);

    if (isset($data['results'][0])) {
        $char = $data['results'][0];

        echo "<div class='card'>";
        echo "<h2>" . $char['name'] . "</h2>";
        echo "<p>Status: " . $char['status'] . "</p>";
        echo "<p>Species: " . $char['species'] . "</p>";
        echo "<p>Gender: " . $char['gender'] . "</p>";
        echo "<p>Origin: " . $char['origin']['name'] . "</p>";
        echo "<img src='" . $char['image'] . "' width='200'>";
        echo "</div>";

    } else {
        echo "<p class='error'>Character not found!</p>";
    }
}
?>

</body>
</html>