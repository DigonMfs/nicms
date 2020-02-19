<?php 

    //check if path is set, and convert path from array to string
    if (!isset($_POST["aPath"])) {
        echo "<p class='alert alert-danger' role='alert'>Path is not defined</p>";
        die();
    } else {
        $aPath = $_POST["aPath"];
        $aPath = str_replace(',', '/', $aPath);
        $path = "../". $aPath;
    }

    //Check if name is empty
    if($_FILES["file"]["name"] != '') {

        //Get all file data
        $name = $_FILES["file"]["name"];
        $extension = pathinfo($name, PATHINFO_EXTENSION);
        $nameWithoutExtension = pathinfo($name, PATHINFO_FILENAME);
        $fileSize = $_FILES["file"]["size"];
        $allowed = array('jpg','jpeg','png','pdf','');

        //Check if name is alphanumeric p{L} & p{N} only allow tokens from our alphabet so not from the chinese/russion/arabic alphabet
        if (preg_match('/^[a-zA-Z0-9\p{L}\p{N} ]+$/',$nameWithoutExtension)) {
            //Replace spaces with underscores
            $name = str_replace(' ','_',$name);
            $location = '../'.$path . '/'.$name;
            
            //Check if file is an image/pdf
            if (in_array(strtolower($extension), $allowed)) {

                //Check if file is not too big
                if ($fileSize < 5000000) {

                    //Check if length is greater then 30
                    if (strlen($nameWithoutExtension) <= 30) {

                        //Check if a file with that name already exists
                        if (!file_exists($location)) {

                            //Upload file
                            if (move_uploaded_file($_FILES["file"]["tmp_name"], $location)) {
                                //display success message
                                echo "<p class='alert alert-success' role='alert'>File '".$name."' has successfully been uploaded.</p>";
                                die();

                            } else {
                                echo "<p class='alert alert-danger' role='alert'>Failed to upload '".$name."'</p>";
                                die();
                            }// if move file

                        } else {
                            echo "<p class='alert alert-danger' role='alert'>A file with the name '".$name."' already exists in this directory.</p>";
                            die();
                        }//if file_exists

                    } else {
                        echo "<p class='alert alert-danger' role='alert'>The filename is too long, the maximum allowed length is 30.</p>";
                        die();
                    }//if length < 30

                }else {
                    echo "<p class='alert alert-danger' role='alert'>This file is too big. The maximum size is 5MB, your file is ".round(($fileSize / 1000000),2)."MB.</p>";
                    die();
                }//if filesize

            } else {
                echo "<p class='alert alert-danger' role='alert'>This file is not an image or a pdf file.</p>";
                die();
            }//if in_array

        } else {
            echo "<p class='alert alert-danger' role='alert'>Filename is not alphanumeric.</p>";
            die();
        }//if preg_match

    } else {
        echo "<p class='alert alert-danger' role='alert'>Filename is empty.</p>";
        die();
    }//if file_name is empty
?>