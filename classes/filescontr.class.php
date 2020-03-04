<?php 

    class FileContr {

        //Properties
        public $dirPath;

        public function createDir($aPath,$dirName) {
            $this->dirPath = "../" . join("/",$aPath);
            $FunctionsObj = new Functions();

            //Validation.
            if (count($aPath) > 11) {
                echo $FunctionsObj->outcomeMessage("error","Failed to create folder, the maximum amount of 10 sub dirs has been reached.");
                return false;
            }//If level subdirs.
            if(!$FunctionsObj->validateLength($dirName,3,30)) {
                echo $FunctionsObj->outcomeMessage("error","The length of '".$dirName."' is too long/short.");
                return false;
            }//If validateLength.
            if(!$FunctionsObj->isAlphanumeric(str_replace(' ','',$dirName))) {
                echo $FunctionsObj->outcomeMessage("error","Folder '".$dirName."' is not alphanumeric.");
                return false;
            }//If alphanumeric.
            if (file_exists($this->dirPath."/".$dirName)) {
                echo $FunctionsObj->outcomeMessage("error","Folder '".$dirName."' already exists.");
                return false;
            }//If file_exists.

            //Create new Directory.
            if(mkdir($this->dirPath ."/". str_replace(' ','_',$dirName), 0777))
                $FunctionsObj->outcomeMessage("success","Folder '".$dirName."' created successfully.");
            else
                $FunctionsObj->outcomeMessage("error","Failed to create folder '".$this->dirPath ."/".$dirName."'.");                

        }//Method createDir.

        public function uploadFile($file, $aPath) {
            $FunctionsObj = new Functions();
            $path = $FunctionsObj->path($aPath);
            $name = $_FILES["file"]["name"];
            $extension = pathinfo($name, PATHINFO_EXTENSION);
            $nameWithoutExtension = pathinfo($name, PATHINFO_FILENAME);
            $fileSize = $_FILES["file"]["size"];
            $allowed = array('jpg','jpeg','png','pdf','');
            $name = str_replace(' ','_',$name);
            $location = $path . '/'.$name;

            if(!$FunctionsObj->isAlphanumeric(str_replace(' ','',$nameWithoutExtension))) {
                echo $FunctionsObj->outcomeMessage("error","Filename is not alphanumeric.");
                return false;
            }//If isAlphanumeric.
            if (!in_array(strtolower($extension), $allowed)) {
                echo $FunctionsObj->outcomeMessage("error","This file is not an image or a pdf file.");
                return false;
            }//If in_array.
            if ($fileSize > 5000000) {
                echo $FunctionsObj->outcomeMessage("error","This file is too big. The maximum size is 5MB, your file is ".round(($fileSize / 1000000),2)."MB.");
                return false;
            }//If filesize.
            if(!$FunctionsObj->validateLength($nameWithoutExtension,3,30)) {
                echo $FunctionsObj->outcomeMessage("error","The filename is too long/short, the length should be between 3 and 30.");
                return false;
            }//If validateLength.
            if (file_exists($location)) {
                echo $FunctionsObj->outcomeMessage("error","A file with the name '".$name."' already exists in this directory.");
                return false;
            }//If file_exists.

            //Upload file
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $location)) {
                $FunctionsObj->outcomeMessage("success","File '".$name."' has successfully been uploaded.");
            } else {
                $FunctionsObj->outcomeMessage("error","Failed to upload '".$name."'. dsafa");
            }// if move file.

        }//Method uploadFile.

        public function deleteFileFolder($dirPath,$fileName,$type) {
            $FileFolderObj = new Filecontr();
            $FunctionsObj = new Functions();

            //check if parameters are alphanumeric
            if ($FunctionsObj->isAlphanumeric($FunctionsObj->stripUnderscores($dirPath)) && $FunctionsObj->isAlphanumeric($FunctionsObj->stripUnderscores($fileName))) {
                echo $FunctionsObj->outcomeMessage("error","Parameters contain forbidden characters.");
                return false;
            }//If isAlphanumeric.

            //Remove folder or file.
            switch ($type) {
                case 'folder':
                    $FileFolderObj->deleteFolder($dirPath,$fileName);
                    break;
                case 'file':
                    $FileFolderObj->deleteFile($dirPath,$fileName);
                    break;
                default:
                    $FunctionsObj->outcomeMessage("error","Unknown file type, in switch.");
                    break;
            }//Switch $type.

        }//Method deleteFileFolder.

        public function deleteFolder($dirPath,$fileName) {
            $pathname = $dirPath . "/" . $fileName;
            $FunctionsObj = new Functions();

            //Check if directory.
            if(!is_dir($pathname )) {
                echo $FunctionsObj->outcomeMessage("error","Failed to remove folder '".$fileName."'. The path is not valid.");
                return false;
            }//If is_dir.
            //Check if empty.
            if ($testing = glob($pathname . "/*")) {
                echo $FunctionsObj->outcomeMessage("error","Failed to remove folder '".$fileName."'. The folder is not empty.");
                return false;
            }//If empty.

            //Remove folder.
            if (rmdir($pathname)) {
                echo $FunctionsObj->outcomeMessage("success","Folder '".$fileName."' has successfully been removed."); 
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to remove folder '".$fileName."'.");
                return false;
            }//if rmdir
            
        }//Method deleteFolder.
        
        public function deleteFile($dirPath,$fileName) {
             $fileRemove = $dirPath . "/" . $fileName;
             $FunctionsObj = new Functions();

             //Check if file exists.
             if (!file_exists($fileRemove)) {
                echo $FunctionsObj->outcomeMessage("error","Failed to remove folder '".$fileName."'. File does not exist.");
                return false;
            }//If file_exists.

            //Remove file.
            if (unlink($fileRemove)) {
                echo $FunctionsObj->outcomeMessage("success","File '".$fileName."' has successfully been removed.");
                return false;
            } else {;
                echo $FunctionsObj->outcomeMessage("error","Failed to remove folder '".$fileName."'.");
                return false;
            }//If unlink.

        }//Method deleteFile.

    }//Class FilesContr.
?>