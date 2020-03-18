<?php 

    class Article extends Dbh {

        protected function getArticles($visibility,$sort,$limit) {
            $aFilter = array();

            //Change the visibility.
            switch ($visibility) {
                case "published":
                    $where = 'a.published=1';
                    break;
                case "saved":
                    $where = 'a.published=0 and a.deleted=0';
                    break;
                case "deleted":
                    $where = 'a.deleted=1';
                    break;
                default:
                    $where = 'a.published=1 OR a.published=0';
                    break;
            }
            
            //Change the order.
            switch ($sort) {
                case "DATEDESC":
                    $order = "a.creation_time DESC";
                    break;
                default:
                    $order = "a.creation_time ASC";
                    break;
            }
             
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
            s.row_id AS s_row_id, s.category AS s_category, s.parent_id AS s_parent_id, u.row_id AS u_row_id, u.display_name AS u_displayname FROM article a
            LEFT JOIN category c ON a.category_id = c.row_id
            LEFT JOIN category s ON a.subcategory_id = s.row_id
            LEFT JOIN user u ON a.author_id = u.row_id 
            WHERE $where
            ORDER BY $order
            LIMIT $limit";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getArticles.
        
        protected function getArticle($article_id) {
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
            s.row_id AS s_row_id, s.category AS s_category, s.parent_id AS s_parent_id, u.row_id AS u_row_id, u.display_name AS u_displayname FROM article a
            LEFT JOIN category c ON a.category_id = c.row_id
            LEFT JOIN category s ON a.subcategory_id = s.row_id
            LEFT JOIN user u ON a.author_id = u.row_id 
            WHERE a.row_id=$article_id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getArticle.

        protected function getArticleFromSubcat($subcat_id) {
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
            s.row_id AS s_row_id, s.category AS s_category, s.parent_id AS s_parent_id, u.row_id AS u_row_id, u.display_name AS u_displayname FROM article a
            LEFT JOIN category c ON a.category_id = c.row_id
            LEFT JOIN category s ON a.subcategory_id = s.row_id
            LEFT JOIN user u ON a.author_id = u.row_id 
            WHERE a.subcategory_id=$subcat_id AND a.deleted=0 AND a.published=1
            ORDER BY a.row_id ASC";
            $result = $this->connect()->query($sql);
            return $result;
        }

        protected function reSetArticle($id,$visibility) {
            $sql = "UPDATE article SET published=$visibility WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method reSetArticle.

        protected function unSetArticle($id) {
            $sql = "UPDATE article SET deleted=1 WHERE row_id=$id";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetArticle.

    }//Article.

?>