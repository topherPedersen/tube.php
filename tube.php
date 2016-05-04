<?php
    $databaseName = "DATABASE-NAME-GOES-HERE";
    $admin = "ADMIN-NAME-GOES-HERE";
    $password = "PASSWORD-GOES-HERE";
    function echoJSON($databaseName, $admin, $password) {
        $mysqli = new mysqli("localhost", $admin, $password, $databaseName);
        $query = "SELECT * FROM tubeTable;";
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
    }
    function uploadFile($databaseName, $admin, $password) {
        $fileTitle = $_POST['file2'];
        $fileName= $_FILES["file1"]["name"];
        $fileTmpLoc = $_FILES["file1"]["tmp_name"];
        $fileType = $_FILES["file1"]["type"];
        $fileSize = $_FILES["file1"]["size"];
        $fileErrorMsg = $_FILES["file1"]["error"];
        if (!$fileTmpLoc) {
            echo "PC LOAD LETTER"; // no file selected before submitting AJAX POST Request
            exit();
        }
        if(move_uploaded_file($fileTmpLoc, "$fileName")) { // the second parameter can include a path to specify a location. example: "movies/$fileName"
            // ------------------------------------------------------------------------------------------------
            echo "UPLOAD COMPLETE: $fileName uploaded successfully"; // $fileName uploaded successfully
            mysql_connect('localhost', $admin, $password);
            mysql_select_db($databaseName) or die("Unable to select database");
            $query = "INSERT INTO tubeTable VALUES (\"$fileTitle\", \"$fileName\");";
            mysql_query($query);
            mysql_close($databaseName);
            // ------------------------------------------------------------------------------------------------
            $oldFileName = basename($_FILES["file1"]["name"]);
            $newFileName = substr($oldFileName, 0, strrpos($oldFileName, '.'));
            $newestFileName = $newFileName . ".html";
            $myfile = fopen("$newestFileName", "w") or die("Unable to open file!");
            $txt = "<center><video class=\"videoClass\" src=\"$oldFileName\" controls></video></center>";
            fwrite($myfile, $txt);
            fclose($myfile);
            // ------------------------------------------------------------------------------------------------
        } else {
            echo "PC LOAD LETTER"; // move_uploaded_file function failed
        }
    }
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        echoJSON($databaseName, $admin, $password);
    } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        uploadFile($databaseName, $admin, $password);
    }
?>
