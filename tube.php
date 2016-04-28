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
        mysql_connect('localhost', 'dangerousAdmin5', 'Milf15milf');
        mysql_select_db('dangerousDatabase5') or die("Unable to select database");
        $query = "INSERT INTO dangerousTable VALUES (\"$fileTitle\", \"$fileName\");";
        mysql_query($query);
        mysql_close('dangerousDatabase5');

        $oldFileName = basename($_FILES["file1"]["name"]);
        $newFileName = substr($oldFileName, 0, strrpos($oldFileName, '.'));
        $newestFileName = $newFileName . ".html";
        $myfile = fopen("$newestFileName", "w") or die("Unable to open file!");
        $txt = "<center><video class=\"videoClass\" src=\"$oldFileName\" controls></video></center>";
        fwrite($myfile, $txt);
        fclose($myfile);

    } else {
        echo "PC LOAD LETTER"; // move_uploaded_file function failed
    }

?>
