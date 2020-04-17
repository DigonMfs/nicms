<?php 

    class Article extends Dbh implements LinkUrl {

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
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, a.link AS a_link, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
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
        
        protected function getArticle($article_link) {
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, a.link AS a_link, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
            s.row_id AS s_row_id, s.category AS s_category, s.parent_id AS s_parent_id, u.row_id AS u_row_id, u.display_name AS u_displayname FROM article a
            LEFT JOIN category c ON a.category_id = c.row_id
            LEFT JOIN category s ON a.subcategory_id = s.row_id
            LEFT JOIN user u ON a.author_id = u.row_id 
            WHERE a.link='$article_link'";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method getArticle.

        protected function getArticleFromSubcat($subcat_id) {
            $sql = "SELECT a.row_id AS a_row_id, a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract 
            AS a_abstract, a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, a.link AS a_link, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id,
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

        protected function getArticleChannel($channelID) {
            $sql = "SELECT c.row_id AS c_row_id, c.article_id AS c_article_id, c.channel_id AS c_channel_id,
            c.published_date AS c_published_date, a.row_id AS a_row_id, 
            a.author_id AS a_author_id, a.creation_time AS a_creation_time, a.published AS a_published, 
            a.deleted AS a_deleted, a.title AS a_title, a.content AS a_content, a.abstract AS a_abstract, 
            a.category_id AS a_category_id, a.subcategory_id AS a_subcategory_id, a.signed_by AS a_signed_by, 
            a.link AS a_link, cat.category AS cat_category, ch.type AS ch_type
            FROM articlechannel c 
            INNER JOIN article a ON c.article_id=a.row_id
            INNER JOIN category cat ON a.category_id=cat.row_id
            INNER JOIN channel ch ON c.channel_id=ch.row_id
            WHERE c.channel_id=$channelID AND ch.type=2
            ORDER BY published_date DESC
            LIMIT 40";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetArticle.

        protected function setArticleChannel($articleID,$channelID) {
            $data = date('Y-m-d H:i:s');
            $sql = "INSERT INTO articlechannel (article_id, channel_id, published_date)
            VALUES ('$articleID', '$channelID', '$data')";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method setArticleChannel.

        protected function unSetArticleChannel($articleID,$channelID) {
            $sql = "DELETE FROM articlechannel WHERE article_id=$articleID AND channel_id=$channelID";
            $result = $this->connect()->query($sql);
            return $result;
        }//Method unSetArticleChannel.

    }//Article.

?>