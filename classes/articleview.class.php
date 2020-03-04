<?php  

    class ArticleView extends Article {

        //Properties
        public $visibility;

        public function showArticle() {
            $FunctionsObj = new Functions();

            //Output data.
            $this->visibility = 0;
            $result = $this->getArticles($this->visibility);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="card calendar-article-container">';
                    echo '<div class="card-header">';
                    echo '<p class="calendar-article-header-title text-primary">'.$row["a_title"].'</p>';
                    echo '</div>';
                    echo '<div class="card-body calendar-article-card-body">';
                    echo '<p class="card-text">'.$row["a_abstract"].'</p>';
                    echo '<div class="calendar-article-card-inner-body">';
                    echo '<p class="calendar-article-card-inner-body-text text-primary">'.$row["u_displayname"].'</p>';
                    echo '<p class="calendar-article-card-inner-body-text text-secondary">'.$row["a_creation_time"].'</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="card-footer calendar-article-card-footer bg-white">';
                    echo '<ol class="breadcrumb calendar-article-breadcrumb-category bg-white">';
                    echo '<li class="breadcrumb-item">'.$row["c_category"].'</li>';
                    echo '<li class="breadcrumb-item text-secondary">'.$row["s_category"].'</li>';
                    echo '<div class="testerr">';
                    echo '<button class="btn btn-danger calendar-article-publish-button" onclick="askDeleteArticle('.$row["a_row_id"].')" type="button">Delete</button>';
                    echo '<button class="btn btn-secondary calendar-article-publish-button" onclick="editArticle('.$row["a_row_id"].')" type="button">Edit</button>';
                    echo '<button class="btn btn-primary calendar-article-publish-button" onclick="askPublishArticle('.$row["a_row_id"].')" type="button">Publish</button>';
                    echo '</div>';
                    echo '</ol>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo $FunctionsObj->outcomeMessage("warning","No articles to publish.");
            }//If $result > 0.
        }//Method showArticles.
        
        public function showArticlesIndex($id) {
            $FunctionsObj = new Functions();
            if($FunctionsObj->isInteger($id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }//If isInteger.
            
            //Output data.
            $teller = false;
            $this->visibility = 1;
            $result = $this->getArticles($this->visibility);
            
            if ($result->num_rows > 0) {
                echo "<table class='table-articles-overview'> ";
                
                while($row = $result->fetch_assoc()) {
                    if ($row["s_row_id"] == $id) {
                        echo "<tr>";
                        echo "<td>";
                        echo "<a href='article.php?articleId=".$row['a_row_id']."&subcatId=".$row['s_row_id']."'>".$row["a_title"]."</a>";
                        echo "<div class='table-articles-admin-icons'>";
                        echo "<i class='far fa-edit text-primary' onclick='editArticle(".$row["a_row_id"].")'></i>";
                        echo "<i class='far fa-trash-alt text-danger' onclick='askDeleteArticle(".$row["a_row_id"].")'></i>";
                        echo "</div>";
                        echo "</td>";
                        echo "</tr>";
                        $teller = true;
                    }//If.
                }//While.
                echo "</table>";
                if (!$teller) {
                    echo $FunctionsObj->outcomeMessage("warning","There are no articles for this subcategory.");
                }
            }//If.
        }//Method showArticlesIndex.
        
    }//ArticleContr.

?>