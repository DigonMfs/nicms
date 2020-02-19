<?php
    //includes
    include_once("../functions.php");

    //Check if variables have been set
    if(isset($_GET["aPath"]) && isset($_GET["dirName"])) {

        //Construct the path
        $aPath = $_GET["aPath"];
        $dirPath = "../../";
        $dirPath .= join("/",$aPath);

        //Get dirname
        $dirName = $_GET["dirName"];

        //Check if max level of sub dirs is reached (11 - 1home dir = 10levels of sub dirs)
        if (count($aPath) < 11) {

            //Check if length is < 50 || > 1
            if (strlen($dirName) < 30 && $dirName != "") {

                //replace spaces with underscores,
                //Then make new temp var, delete underscores and test for alphanumeric
                $dirName = str_replace(' ','_',$dirName);
                $dirNameStrip = str_replace('_','',$dirName);

                //Check if dirname is alphanumeric
                if (IsAlphaNumeric($dirNameStrip)) {

                    //Check if filename already exists
                    if (!file_exists($dirPath."/".$dirName)) {

                        //Create new Directory
                        if(mkdir($dirPath ."/". $dirName, 0777))
                            echo "<p class='alert alert-success' role='alert'>Folder '".$dirName."' created successfully</p>";
                        else 
                            echo "<p class='alert alert-danger' role='alert'>Failed to create folder '".$dirPath ."/".$dirName."'</p>";

                    }else {
                        echo "<p class='alert alert-danger' role='alert'>Folder '".$dirName."' already exists</p>";
                        die();
                    }//if file_exists

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Folder '".$dirName."' is not alphanumeric</p>";
                    die();
                }//if alphanumeric

            }else {
                echo "<p class='alert alert-danger' role='alert'>The length of '".$dirName."' is too long/short</p>";
                die();
            }//if length

        } else {
            echo "<p class='alert alert-danger' role='alert'>Failed to create folder, the maximum amount of 10 sub dirs has been reached</p>";
            die();
        }//if max level sub dirs reached
 
    } else {
        echo "<p class='alert alert-danger' role='alert'>Unknown variables</p>";
        die();
    }//if isset 


?>