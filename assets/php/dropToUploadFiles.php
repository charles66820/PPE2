<?php
if (isset($_POST["upload"])) {
  $path = "../img/imagesupload/";
  $name = basename($_FILES["image"]["name"]);
  $actual_name = pathinfo($name,PATHINFO_FILENAME);
  $extension = pathinfo($name, PATHINFO_EXTENSION);
  $imageFileType = strtolower($extension);
  $uploadOk = 1;
  $causeerreur = 'inconue';

  $i = 1;
  while(file_exists($path.$actual_name.".".$extension)){
    $actual_name = (string)$actual_name.$i;
    $name = $actual_name.".".$extension;
    $i++;
  }

  if ($_FILES["file"]["size"] > 50000) {
    $uploadOk = 0;
    $causeerreur = 'image trops lourd';
  }

  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
    $uploadOk = 0;
    $causeerreur = 'ce fichier n\'ai pas une image';
  }

  if ($uploadOk && @move_uploaded_file($_FILES["image"]["tmp_name"], $path.$name)) {
      echo basename($name);
  } else {
    header('HTTP/1.1 500 Internal Server Error');
    print $causeerreur;
    die();
  }
}
?>
