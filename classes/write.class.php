<?php 
    //Category Class.
    class Write extends Dbh {

        //Get all media channels.
        protected function getMediaChannels() {
            $sql = "SELECT row_id, name FROM channel";
            $result = $this->connect()->query($sql);
            return $result;
        }//GetMediaChannels.

        protected function setArticle($articleTitle,$date,$articleSummary,$articleBody, $articleCategory, $articleSubcategory, $articleSigner) {
            $sql = "INSERT INTO article (author_id, creation_time, published, title, content, abstract, category_id, subcategory_id, signed_by)
            VALUES ('1', '$date', '0','$articleTitle','$articleBody','$articleSummary','$articleCategory','$articleSubcategory','$articleSigner')";
            return $this->connect()->query($sql);;
        }//Method setArticle.

        public function checkCatIsCat($articleCategory) {
            $sql = "SELECT * FROM category WHERE row_id= $articleCategory AND parent_id = 0";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method checkCatIsCat.

        public function checkSubcatIsSubcat($articleSubcategory) {
            $sql = "SELECT * FROM category WHERE row_id= $articleSubcategory AND parent_id != 0";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method checkSubcatIsSubcat.

    }//Class Write.

?>