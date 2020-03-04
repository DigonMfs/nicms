<?php 

    class Article extends Dbh {

        protected function getArticles($visibility) {
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
            s.row_id AS s_row_id, s.category AS s_category, s.parent_id AS s_parent_id, u.row_id AS u_row_id, u.display_name AS u_displayname FROM article a
            LEFT JOIN category c ON a.category_id = c.row_id
            LEFT JOIN category s ON a.subcategory_id = s.row_id
            LEFT JOIN user u ON a.author_id = u.row_id WHERE a.published=$visibility
            ORDER BY creation_time DESC";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getArticle.

        protected function reSetArticle($id) {
            $sql = "UPDATE article SET published=1 WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetArticle.

        protected function unSetArticle($id) {
            $sql = "DELETE FROM article WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetArticle.

    }//Article.

?>