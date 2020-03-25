<?php  

    class ArticleContr extends Article {

        //Publish a saved article.
        public function publishArticle($id) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $id = $this->connect()->real_escape_string($id);
            
            //Execute sql.
            $result = $this->reSetArticle($id,1);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","The article has successfully been published.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to publish the article.");
            }//If $result.
        }//Method publishArticle.

        public function unpublishArticle($id) {
            $FunctionsObj = new Functions();

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $id = $this->connect()->real_escape_string($id);

            //Execute sql.
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

            //Check if user logged in, and thus allowed to execute this method.
            $FunctionsObj->checkUserLoggedIn();

            //Validation.
            if ($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameter, is not an integer.".$id);
                return false;
            }

            //Real escape string.
            $id = $this->connect()->real_escape_string($id);

            //Execute sql.
            $result = $this->unSetArticle($id);
            if ($result) {
                echo $FunctionsObj->outcomeMessage("success","Article has successfully been deleted.");
            } else {
                echo $FunctionsObj->outcomeMessage("error","Failed to delete article.");
            }
        }//Method deleteArticle.

        public function getArticleID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_row_id"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleTitle($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_title"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleSummary($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_abstract"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleContent($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_content"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleSigner($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["a_signed_by"];
                }
            }
        }//Method getArticleTitle.

        public function getArticleCatID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["c_row_id"];
                }
            }
        }//Method getArticleCatID.

        public function getArticleSubcatID($articleLink) {
            $result = $this->getArticle($articleLink);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    return $row["s_row_id"];
                }
            }
        }//Method getARticleSubcat.

    }//ArticleContr.


?>