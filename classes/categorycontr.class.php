<?php 

    class CategoryContr extends Category {

        public function createCatSubcat($catSubcatName,$parent_id) {
            $FunctionsObj = new Functions();

            if(!$FunctionsObj->isAlphanumeric($FunctionsObj->stripSpaces($catSubcatName))) {
                echo $FunctionsObj->outcomeMessage("error","'".$catSubcatName."' is not alphanumeric.");
                return false;
            }//If isAlphanumeric.
            if (!$FunctionsObj->validateLength($catSubcatName,3,30)) {
                echo $FunctionsObj->outcomeMessage("error","'".$catSubcatName."' is too long or short.");
                return false;
            }//If validateLength

            if($this->setCatSubcat($catSubcatName,$parent_id)) {
                echo $FunctionsObj->outcomeMessage("success","'".$catSubcatName."' has successfully been added.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to add '".$catSubcatName."'.");
                return false;
            }//If set == success.
        }//Method createCategory.

        public function deleteCatSubcat($id,$catSubcat) {
            $FunctionsObj = new Functions();

            if ($FunctionsObj->isInteger($id) && $FunctionsObj->isInteger($catSubcat)) {
                echo $FunctionsObj->outcomeMessage("error","Parameters aren't integers.");
            }//If isInteger.

            //Check if cat is cat or subcat is subcat; 0=cat;1=subcat.
            $WriteCheckCatSubcatObj = new Write();
            switch ($catSubcat) {
                case 0:
                    $result = $WriteCheckCatSubcatObj->checkCatIsCat($id);
                    break;
                case 1:
                    $result = $WriteCheckCatSubcatObj->checkSubcatIsSubcat($id);
                    break;
                default:
                    die($FunctionsObj->outcomeMessage("error","Parameter should be a boolean."));
                    break;
            }//Switch.

            if (!$result) {
                echo $FunctionsObj->outcomeMessage("error","Category/subcategory is not a catagory/subcategory..");
                return false;
            }//If $result == false.

            if ($this->unsetCatSubcat($id)) {
                echo $FunctionsObj->outcomeMessage("success","Record has succesfully been deleted.");
                return false;
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete record.");
                return false;
            }//If unsetCatSubcat == true
        }//Method deleteCategory

      
    }//CategoryContr.
?>