<?php
    //Check if variables have been set
    if(!isset($_GET["aPath"]) && !isset($_GET["dirName"])) {
        echo "<p class='alert alert-danger' role='alert'>Unknown variables</p>";
        die();
    }

    //get array containing the path, and convert it to string
    $aPath = $_GET["aPath"];
    //Construct the path
    $dirPath = "..";
    for ($e=0;$e<count($aPath);$e++) {
        $dirPath = $dirPath . "/" . $aPath[$e];
    }

    //Get dirname
    $dirName = $_GET["dirName"];

    //Check if length is < 50 || > 1
    if (strlen($dirName) < 30 && $dirName != "") {

         //Check if dirname is alphanumeric
        if (preg_match('/^[a-zA-Z0-9\p{L}\p{N} ]+$/',$dirName)) {

            //replace spaces with underscores
            $dirName = str_replace(' ','_',$dirName);

            //Check if filename already exists
            if (!file_exists($dirPath."/".$dirName)) {

                //Create new Directory
                if(mkdir($dirPath ."/". $dirName, 0777))
                    echo "<p class='alert alert-success' role='alert'>Folder '".$dirName."' created successfully</p>";
                else 
                    echo "<p class='alert alert-danger' role='alert'>Failed to create folder '".$dirPath ."/".$dirName."'</p>";

            }else {
                //Output on screen
                echo "<p class='alert alert-danger' role='alert'>Folder '".$dirName."' already exists</p>";
                die();
            }//if file_exists

        } else {
            //Output on screen
            echo "<p class='alert alert-danger' role='alert'>Folder '".$dirName."' is not alphanumeric</p>";
            die();
        }//if alphanumeric

    }else {
        echo "<p class='alert alert-danger' role='alert'>The length of '".$dirName."' is too long/short</p>";
        die();
    }//if length

?>