<?php 
    //Category Class.
    class WriteContr extends Write {

        //Properties
        public $date;

        public function createArticle($articleTitle,$articleSummary,$articleBody, $articleCategory, $articleSubcategory, $articleSigner, $articleURL) {
            $FunctionsObj = new Functions();
            $this->date = date('Y-m-d H:i:s');

            //Validation
            if (empty($articleTitle) || empty($articleSummary) || empty($articleBody) || empty($articleCategory) || empty($articleSubcategory) || empty($articleSigner || empty($articleURL))) {
                echo $FunctionsObj->outcomeMessage("error","Not all variables contain a value.");
                return false;
            }//If empty.
            if (is_int($articleCategory) || is_int($articleSubcategory)) { 
                echo $FunctionsObj->outcomeMessage("error","Please select a category and subcategory.");
                return false;
            }//If is_int.
            $result = $this->checkCatIsCat($articleCategory);
            if ($result->num_rows <= 0) {
                echo $FunctionsObj->outcomeMessage("error","Selected category is not a valid category.");
                return false;
            }//If cat is a cat.
            $result = $this->checkSubcatIsSubcat($articleSubcategory);
            if ($result->num_rows <= 0) {
                echo $FunctionsObj->outcomeMessage("error","Selected subcategory is not a valid category.");
                return false;
            }//If subcat is a subcat.

            //Remove spaces, check if alphanumeric
            if (!$FunctionsObj->isAlphanumeric($FunctionsObj->stripSpaces($articleURL))) {
                echo $FunctionsObj->outcomeMessage("error","URL is not alphanumeric.");
                return false;
            }

            //Article saved.
            if($this->setArticle($articleTitle,$this->date,$articleSummary,$articleBody, $articleCategory, $articleSubcategory, $articleSigner, $FunctionsObj->stripSpaces($articleURL))) {
                echo "succes";
            } else {
                echo "fail";
            }
        }//Method createArticle.

    }//Class WriteContr.

?>