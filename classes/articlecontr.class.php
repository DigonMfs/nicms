<?php  

    class ArticleContr extends Article {

        //Publish a saved article.
        public function publishArticle($id) {
            $FunctionsObj = new Functions();

            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }
            
            $result = $this->reSetArticle($id,1);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","The article has successfully been published.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to publish the article.");
            }//If $result.
        }//Method publishArticle.

        public function unpublishArticle($id) {
            $FunctionsObj = new Functions();

            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            $result = $this->reSetArticle($id,0);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","The article has successfully been unpublished.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to unpublish the article.");
            }//If $result.
        }//Method unpublishArticle.
        
        //Delete Article.
        public function deleteArticle($id) {
            $FunctionsObj = new Functions();

            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameter, is not an integer.".$id);
                return false;
            }

            $result = $this->unSetArticle($id);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","Article has successfully been deleted.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete article.");
            }
        }//Method deleteArticle.

    }//ArticleContr.


?>