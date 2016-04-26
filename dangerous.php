<?php
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

        echo "UPLOAD COMPLETE: $fileName uploaded successfully"; // $fileName uploaded successfully
        mysql_connect('localhost', 'DATABASE-ADMINISTRATOR-NAME-GOES-HERE', 'DATABASE-PASSWORD-GOES-HERE');
        mysql_select_db('DATABASE-NAME-GOES-HERE') or die("Unable to select database");
        $query = "INSERT INTO dangerousTable VALUES (\"$fileTitle\", \"$fileName\");";
        mysql_query($query);
        mysql_close('DATABASE-NAME-GOES-HERE');

        $oldFileName = basename($_FILES["file1"]["name"]);
        $newFileName = substr($oldFileName, 0, strrpos($oldFileName, '.'));
        $newestFileName = $newFileName . ".html";
        $myfile = fopen("$newestFileName", "w") or die("Unable to open file!");
        $txt = "<center><video src=\"$oldFileName\" style=\"width:66.67%;\" controls></video></center>";
        fwrite($myfile, $txt);
        fclose($myfile);

    } else {
        echo "PC LOAD LETTER"; // move_uploaded_file function failed
    }

?>
