<?php 
    //Declare and initialise variables
    $aExtensions = array("jpg","jpeg","png","pdf");
    
    //See if file is called from ajax or from page reload
    if (isset($_GET["aPath"])) {
        //Construct the path
        $aPath = $_GET["aPath"];

        //Check if path starts with "assets"
        if ($aPath[0] != "assets") {
            echo "<p class='alert alert-danger' role='alert'>This path is not allowed!!!</p>";
            die();
        } else {

            //Construct the path
            $dirPath = "../../";
            $dirPathImages = "../";
            $dirPath .= join("/",$aPath);
            $dirPathImages .= join("/",$aPath);
            $dirPathDel = $dirPath;

            //The only reason aPath can be defined and admin not is from the files.php pages, this means admin == true
            if (isset($_GET["admin"]))
                $admin = $_GET["admin"];
            else 
                $admin = "true";

        }//if == assets

    }//if ajax
    else {
        //$dirpath = ../assets, because function is included in files.php => $dirPath = base directory
        $dirPath = "../assets";
        $dirpathImage = $dirPath; 
        //the path to delete a file is never includes and thus the path has and extra ../
        $dirPathDel = "../../assets";
    }//if isset(aPath)
    
    //Check is $dirPath is a directory
    if (is_dir($dirPath)) {
        
        //Create an array containing all files
        $aFiles = scandir($dirPath);
        
        //go trough all folder/files in dir
        for($i=0;$i<count($aFiles);$i++) {

            //See if file is folder or file
            if (is_dir($dirPath . '/' . $aFiles[$i])) {

                //remove the dots from current and parent directory
                if ($aFiles[$i] == "." || $aFiles[$i] == "..") {}
                else {

                    //See if admin == true/false
                    if ($admin == "true") 
                        $text = '<i class="fas fa-trash-alt files-hover-icons files-delete" onclick="AskDelete(\''.$dirPathDel.'\',\''.$aFiles[$i].'\',\'folder\')"></i>';
                    else 
                        $text = '';

                    //output on screen
                    echo '
                        <div class="files-file-container">
                            <i class="fas fa-folder text-warning dir-icon files-icon" onclick="DirClick(\''.addslashes($aFiles[$i]).'\',\''.$admin.'\')"></i>
                            '.$text.'
                            <p class="files-folder-file-name">'.$aFiles[$i].'</p>
                        </div>
                    ';
                }//else
                    
            }
            else {

                //Get filename and extension
                $file = pathinfo($aFiles[$i]);
                $extension = $file['extension'];

                //check extension of the file
                if(in_array(strtolower($extension), $aExtensions)) {

                    //Look if file is image/pdf to change icon
                    if (strtolower($extension) == "pdf") 
                        $icon = '<i class="far fa-file-pdf pdf-icon files-icon text-danger"></i>';
                    else 
                        $icon = '<i class="fas fa-image img-icon files-icon text-primary"></i>';

                    //Look if admin function should be enabled
                    if ($admin == "true") {
                        $container = '<div class="files-file-container">';
                        $text = '<i class="fas fa-trash-alt files-hover-icons files-delete" onclick="AskDelete(\''.$dirPath.'\',\''.$aFiles[$i].'\',\'file\')"></i>';
                    } else {
                        //type is extension, images need to be inserted as an <img>, pdf files not
                        $container = '<div class="files-file-container" onclick="InsertFile(\''.$dirPathImages.'\',\''.$aFiles[$i].'\',\''.$extension.'\')">';
                        $text = '';
                    }//if $admin ==true

                    //Output on screen
                    echo $container, $icon, $text.'
                            <p class="files-folder-file-name">'.$aFiles[$i].'</p>
                        </div>
                    ';

                }//if in_array

            }//else if_dir

        }//for loop through each file in dir

    }//is is_dir
?>