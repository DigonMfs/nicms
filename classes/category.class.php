<?php 
    //Category Class.
    class Category extends Dbh {

        protected function getCategories() {
            $sql = "SELECT * FROM category WHERE parent_id= 0";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getCategories.

        protected function getCategory($categoryID) {
            $sql = "SELECT * FROM category WHERE row_id=$categoryID";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getCategory.

        protected function getSubcatsFromParentCat($parent_id) {
            $sql = "SELECT * FROM category WHERE parent_id= $parent_id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getCategories.

        protected function getCatsAndSubcats() {
            $sql = "SELECT p.row_id AS p_row_id, p.category AS p_category, p.parent_id AS p_parent_id, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id 
            FROM category p LEFT JOIN category c
            ON p.row_id = c.parent_id WHERE p.parent_id = 0 ORDER BY p.row_id ASC, c.row_id ASC";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getCatsAndSubcats.

        protected function setCatSubcat($categoryName,$parent_id) {
            $sql = "INSERT INTO category (category, parent_id)
            VALUES ('$categoryName', '$parent_id')";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method setCategory.

        protected function unsetCatSubcat($id) {
            $sql = "DELETE p FROM category p LEFT JOIN category c ON p.row_id = c.parent_id WHERE p.row_id=$id OR p.parent_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unsetCatSubcat.

       
    }//Class Category.

?>