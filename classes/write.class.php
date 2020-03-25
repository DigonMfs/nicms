<?php 
    //Category Class.
    class Write extends Dbh {

        //Get all media channels.
        protected function getMediaChannels() {
            $sql = "SELECT row_id, name FROM channel";
            $result = $this->connect()->query($sql);
            return $result;
        }//GetMediaChannels.

        protected function setArticle($articleTitle,$date,$articleSummary,$articleBody,$articleCategory,$articleSubcategory,$articleSigner,$articleURL) {
            $user = $_SESSION["userID"];
            $sql = "INSERT INTO article (author_id, creation_time, published, deleted, title, content, abstract, category_id, subcategory_id, signed_by, link)
            VALUES ('$user', '$date', '0','0','$articleTitle','$articleBody','$articleSummary','$articleCategory','$articleSubcategory','$articleSigner','$articleURL')";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method setArticle.

        protected function reSetArticle($articleTitle,$articleSummary,$articleBody,$articleSigner,$articleURL,$link) {
            $sql = "UPDATE article SET title='$articleTitle',content='$articleBody',abstract='$articleSummary',signed_by='$articleSigner',link='$articleURL' 
            WHERE link='$link'";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetArticle.

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