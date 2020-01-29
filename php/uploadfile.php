<?php 

    //check if path is set, and convert path from array to string
    if (!isset($_POST["aPath"])) {
        echo "<p class='alert alert-danger' role='alert'>Path is not defined</p>";
        die();
    } else {
        $path = $_POST["aPath"];
        $path = str_replace(',', '/', $path);
    }

    //Check if name is not empty
    if($_FILES["file"]["name"] != '') {

        //Get all file data
        $test = explode(".", $_FILES["file"]["name"]);
        $extension = strtolower(end($test));
        $name = $_FILES["file"]["name"];
        $fileSize = $_FILES["file"]["size"];
        $location = '../'.$path . '/'.$name;
        $allowed = array('jpg','jpeg','png','pdf','');

        //Check if file is an image/pdf
        if (in_array($extension, $allowed)) {

            //Check if file is not too big
            if ($fileSize < 5000000) {

                //Upload file
                move_uploaded_file($_FILES["file"]["tmp_name"], $location);
                //display success message
                echo "<p class='alert alert-success' role='alert'>File '".$name."' has successfully been uploaded</p>";

            }else {
                echo "<p class='alert alert-danger' role='alert'>This file is too big. The maximum size is 5MB, your file is ".round(($fileSize / 1000000),2)."MB</p>";
                die();
            }//if filesize

        } else {
            echo "<p class='alert alert-danger' role='alert'>This file is not an image or a pdf file</p>";
            die();
        }//if in_array

    } else {
        echo "<p class='alert alert-danger' role='alert'>Filename is empty</p>";
        die();
    }//if file_name is empty
?>