<?php 

    //check if path is set, and convert path from array to string
    if (isset($_GET["dirPath"]) && isset($_GET["fileName"]) && isset($_GET["type"])) {
        
        //Declare and initialise variables
        $dirPath = $_GET["dirPath"];
        $fileName = $_GET["fileName"];
        $type = $_GET["type"];
        
        //See if a file or folder needs to be removed
        if (strtolower($type) == "folder") {
            
            $pathname = $dirPath . "/" . $fileName;
            if (rmdir($pathname)) {
                echo "<p class='alert alert-success' role='alert'>Folder '".$fileName."' has successfully been removed</p>";
                die(); 
            } else {
                echo "<p class='alert alert-danger' role='alert'>Failed to remove folder</p>";
                die(); 
            }
            
        } else if (strtolower($type) == "file") {
            
        } else {
            echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder type</p>";
            die(); 
        }//if file/folder
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>Incorrect file/folder data</p>";
        die();
    }//if isset

?>