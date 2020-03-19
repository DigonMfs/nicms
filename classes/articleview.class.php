<?php  

    class ArticleView extends Article {
        
        public function showArticle($visibility,$sort,$limit) {
            $FunctionsObj = new Functions();

            //Output data.
            $result = $this->getArticles($visibility,$sort,$limit);

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
                    if ($row["a_deleted"] == 0) {
                        echo '<button class="btn btn-danger calendar-article-publish-button" onclick="askDeleteArticle('.$row["a_row_id"].')" type="button">Delete</button>';
                        echo '<button class="btn btn-secondary calendar-article-publish-button" onclick="editArticle('.$row["a_row_id"].')" type="button">Edit</button>';
                        if ($row["a_published"] == 0) {
                            echo '<button class="btn btn-primary calendar-article-publish-button" onclick="askPublishArticle('.$row["a_row_id"].')" type="button">Publish</button>';
                        } else {
                            echo '<button class="btn btn-primary calendar-article-publish-button" onclick="askUnpublishArticle('.$row["a_row_id"].')" type="button">Unpublish</button>';   
                        }  
                    } else {
                        echo '<button class="btn btn-danger calendar-article-publish-button" type="button" disabled>Deleted</button>'; 
                    }
                    echo '</div>';
                    echo '</ol>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo $FunctionsObj->outcomeMessage("warning","No articles were found.");
            }//If $result > 0.
        }//Method showArticles.
        
        public function showArticlesIndex($subcat_id) {
            $FunctionsObj = new Functions();
            if($FunctionsObj->isInteger($subcat_id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }//If isInteger.

            //Output data.
            $result = $this->getArticleFromSubcat($subcat_id);
            
            if ($result->num_rows > 0) {
                echo "<table class='table-articles-overview'> ";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href='pages/article.php?articleId=".$row['a_row_id']."&articleTitle=".$row['a_title']."&catID=".$row["c_row_id"]."&subcatId=".$row['s_row_id']."&subcat=".$row['s_category']."'>".$row["a_title"]."</a>";
                    echo "<div class='table-articles-admin-icons'>";

                    //Check if admin is logged in.
                    if (isset($_SESSION["userID"])) {
                        echo "<i class='far fa-edit text-primary' onclick='editArticle(".$row["a_row_id"].")'></i>";
                        echo "<i class='far fa-trash-alt text-danger' onclick='askDeleteArticle(".$row["a_row_id"].")'></i>";
                    }

                    echo "</div>";
                    echo "</td>";
                    echo "</tr>";
                    $teller = true;
                }//While.
                echo "</table>";
                
            } else {
                 echo $FunctionsObj->outcomeMessage("warning","There are no articles for this subcategory.");
            }
        }//Method showArticlesIndex.
        
        public function showRelevantArticles($subcat_id,$articleId) {
            $FunctionsObj = new Functions();
            
            if($FunctionsObj->isInteger($subcat_id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }//If isInteger.
            
            $result = $this->getArticleFromSubcat($subcat_id);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //Check if record is current article. If so highlight it.
                    if ($articleId == $row["a_row_id"]) {
                        echo "<a href='article.php?articleId=".$row['a_row_id']."&articleTitle=".$row['a_title']."&catID=".$row["c_row_id"]."&subcatId=".$row['s_row_id']."&subcat=".$row['s_category']."' ".$row["a_title"]."' class='list-group-item list-group-item-action list-group-item-secondary'>".$row['a_title']."</a>";
                    } else {
                        echo "<a href='article.php?articleId=".$row['a_row_id']."&articleTitle=".$row['a_title']."&catID=".$row["c_row_id"]."&subcatId=".$row['s_row_id']."&subcat=".$row['s_category']."' ".$row["a_title"]."' class='list-group-item list-group-item-action'>".$row['a_title']."</a>";
                    }
                }
            } else {
               echo " <a class='list-group-item list-group-item-action'>No articles found.</a>"; 
            }
        }//Method showRelevantArticles.
        
        public function showFullArticle($article_id) {
            $FunctionsObj = new Functions();
            
            if($FunctionsObj->isInteger($article_id)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }//If isInteger.
            
            $result = $this->getArticle($article_id);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {

                    //Check if article has been deleted.
                    if ($row["a_deleted"] == 1) {
                        $FunctionsObj->outcomeMessage('error',"Article has been deleted.");
                        return false;
                    }
                    echo "<h1 class='articles-article-title'>".$row['a_title']."</h1>";
                    
                    /*echo "<article class='articles-article-summary'>";
                    echo "<strong>".$row["a_abstract"]."</strong>";
                    echo "</article>";*/
                    
                    echo " <article class='articles-article-content'>";
                    echo $row['a_content'];
                    echo "</article>";
                    
                    echo " <article class='articles-article-info'>";
                    echo "<p>".$row['a_signed_by']."</p>";
                    echo "<p>".$row['a_creation_time']."</p>";
                    echo "</article>";
                }
            } else {
               
            }
        }
        
    }//ArticleContr.

?>