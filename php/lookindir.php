<?php 
    //Declare and initialise variables
    $aExtensions = array("jpg","jpeg","png","pdf");
    
    //See if file is called from ajax or from page reload
    if (isset($_GET["aPath"])) {
        //Construct the path
        $aPath = $_GET["aPath"];
        $dirPath = "../";
        $dirPath .= join("/",$aPath);
        
    }//if ajax
    else {
        $dirPath = "../assets";
    }
    
    //Check is $dirPath is a directory
    if (is_dir($dirPath)) {
        
        //Create an array containing all files
        $aFiles = scandir($dirPath);
        
        
        for($i=0;$i<count($aFiles);$i++) {

            if (is_dir($dirPath . '/' . $aFiles[$i])) {

                //remove the dots from current and parent directory
                if ($aFiles[$i] == "." || $aFiles[$i] == "..") {}
                else {

                    //output on screen
                    echo '
                        <div class="files-file-container">
                            <i class="fas fa-folder text-warning dir-icon files-icon" onclick="DirClick(\''.addslashes($aFiles[$i]).'\')"></i>
                            <i class="fas fa-trash-alt files-hover-icons files-delete" onclick="Delete(\''.$dirPath.'\',\''.$aFiles[$i].'\',\'folder\')"></i>
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

                    //Output on screen
                    echo '
                        <div class="files-file-container">
                            '.$icon.'
                            <i class="fas fa-trash-alt files-hover-icons files-delete" onclick="Delete(\''.$dirPath.'\',\''.$aFiles[$i].'\',\'file\')"></i>
                            <p class="files-folder-file-name">'.$aFiles[$i].'</p>
                        </div>
                    ';

                }//if in_array

            }//else if_dir

        }//for loop through each file in dir

    }//is is_dir
?>