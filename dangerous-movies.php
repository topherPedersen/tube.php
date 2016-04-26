<?php

$mysqli = new mysqli("localhost", "DATABASE-ADMINISTRATOR-NAME-GOES-HERE", "Milf15milf", "DATABASE-NAME-GOES-HERE");
$query = "SELECT * FROM dangerousTable;";
$result = $mysqli->query($query);
$movieCount = 0;
while ($row = $result->fetch_assoc()) {
    $movieCount++;
    $movie[$movieCount]['title'] = $row['title'];
    $movie[$movieCount]['filename'] = $row['filename'];
}

if ($movieCount >= 1) {
    echo "{";
    echo "\"movies\": [";
    for ($i = $movieCount; $i >= 1; $i--) {
        echo "{";
        echo "\"title\":\"{$movie[$i]['title']}\",";
        echo "\"filename\":\"{$movie[$i]['filename']}\"";
        echo "}";
        if ($i > 1) {
            echo ",";
        }
    }
    echo "]";
    echo "}";
}
$mysqli->close();

?>
