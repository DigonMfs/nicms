<?php 

    //Includes
    include_once("../functions.php");
    include_once("../dbconn.php");

    //check if path is set, and convert path from array to string
    if (isset($_GET["dirPath"]) && isset($_GET["fileName"]) && isset($_GET["type"])) {
        
        //Declare and initialise variables, and escape them
        $dirPath = $conn -> real_escape_string($_GET["dirPath"]);
        $fileName = $conn -> real_escape_string($_GET["fileName"]);
        $type = $conn -> real_escape_string($_GET["type"]);

        //strip . and / from dirpath and filename 
        $dirPathStrip = StripAlphaNumeric($dirPath);
        $fileNameStrip = StripAlphaNumeric($fileName);

        //check if parameters are alphanumeric
        if (IsAlphaNumeric($dirPathStrip) && IsAlphaNumeric($fileNameStrip) && IsAlphaNumeric($type)) {

            //See if a file or folder needs to be removed
            if (strtolower($type) == "folder") {

                //get pathname and foldername in 1var
                $pathname = $dirPath . "/" . $fileName;

                //check if dir is a dir
                if(is_dir($pathname )) {

                    //Check if folder is empty
                    if (!$testing = glob($pathname . "/*")) {

                        //Remove folder
                        if (rmdir($pathname)) {
                            echo "<p class='alert alert-success' role='alert'>Folder '".$fileName."' has successfully been removed</p>";
                            die(); 
            
                        } else {
                            echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'</p>";
                            die(); 
                        }//if rmdir
                    
                    } else {
                        echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'. The folder is not empty!</p>";
                        die();
                    }//if folder == empty

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'. The path is not valid!</p>";
                    die();
                }//if is_dir




            //if type = folder
            } else if (strtolower($type) == "file") {

                //join path + file
                $fileRemove = $dirPath . "/" . $fileName;

                //Check if file exists
                if (file_exists($fileRemove)) {
                    //Remove file
                    if (unlink($fileRemove)) {
                        echo "<p class='alert alert-success' role='alert'>File '".$fileName."' has successfully been removed</p>";
                        die(); 

                    } else {
                        echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'. The path is not valid!</p>";
                        die();
                    }//if unlink

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'</p>";
                    die();
                }//if file_exists

            } else {
                echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder type</p>";
                die(); 
            }//if file/folder

        } else {
            echo "<p class='alert alert-danger' role='alert'>Parameters contain forbidden characters</p>";
            die(); 
        }//if isAlphanumeric
         
    } else {
        echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder data</p>";
        die();
    }//if isset

?>