<?php 

    //check if path is set, and convert path from array to string
    if (isset($_GET["dirPath"]) && isset($_GET["fileName"]) && isset($_GET["type"])) {
        
        //Declare and initialise variables
        $dirPath = $_GET["dirPath"];
        $fileName = $_GET["fileName"];
        $type = $_GET["type"];
        
        //See if a file or folder needs to be removed
        if (strtolower($type) == "folder") {

            //get pathname and foldername in 1var
            $pathname = $dirPath . "/" . $fileName;

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
            
        } else if (strtolower($type) == "file") {

            //Remove file
            $fileRemove = $dirPath . "/" . $fileName;
            if (unlink($fileRemove)) {
                echo "<p class='alert alert-success' role='alert'>File '".$fileName."' has successfully been removed</p>";
                die(); 

            } else {
                echo "<p class='alert alert-danger' role='alert'>Failed to remove folder '".$fileName."'</p>";
                die();
            }//if unlink
            
        } else {
            echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder type</p>";
            die(); 
        }//if file/folder
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder data</p>";
        die();
    }//if isset

?>