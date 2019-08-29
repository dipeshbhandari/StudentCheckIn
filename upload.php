<?php

  $target_dir = "new_files/";

  $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

  $uploadOk = 1;

  $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  echo $target_dir . $_FILES["fileToUpload"]["name"];
  if(isset($_POST["submit"])){

    // Check if file is the right format
    if($fileType != "csv") {
      echo "Sorry, only .csv files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
      if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
      } else {
        echo $target_file;
        echo "\nSorry, there was an error uploading your file.";
      }
    }
  }
?>
