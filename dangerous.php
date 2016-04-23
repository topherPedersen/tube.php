 <meta name="viewport" content="initial-scale=1 user-scalable=no">
 <?php
$target_file = basename($_FILES["fileToUpload"]["name"]);
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
$uploadOk = 1;

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}

if(!($imageFileType == "mp4") && !($imageFileType == "MOV")) {
    echo "Sorry, only mp4 and mov files allowed.";
    $uploadOk = 0;
} 

// Check file size
if ($_FILES["fileToUpload"]["size"] > 536870912) { // 536870912 bytes = 0.5 gigabytes
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

if ($uploadOk != 0) {

    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    echo "FILE UPLOADED :)";
    
    $oldFileName = basename($_FILES["fileToUpload"]["name"]);
    $newFileName = substr($oldFileName, 0, strrpos($oldFileName, '.'));
    $newestFileName = $newFileName . ".html";
    $myfile = fopen("$newestFileName", "w") or die("Unable to open file!");
    $txt = "<!DOCTYPE html>
            <html>
            <video style=\"width:320; text-align:center;\" controls>
            <source src=\"$oldFileName\" type=\"video/mp4\">
            </video> 
            </html>";
    fwrite($myfile, $txt);
    fclose($myfile);
    echo "<a href=\"$newestFileName\">WATCH MOVIE!</a>";

}

?> 
