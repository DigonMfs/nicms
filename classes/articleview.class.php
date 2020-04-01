<?php  


    class ArticleView extends Article {

        //Make variable $linkUrl accessible in ArticleView.
        protected $linkUrl = '';
        public function __construct($linkUrl) {
            $this->linkUrl = $linkUrl;
        }

        public function showArticle($visibility,$sort,$limit) {
            $FunctionsObj = new Functions();

            //Real escape string.
            $visibility = $this->connect()->real_escape_string($visibility);
            $sort = $this->connect()->real_escape_string($sort);
            $limit = $this->connect()->real_escape_string($limit);

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
                        echo '<button class="btn btn-secondary calendar-article-publish-button" onclick="editArticle(\''.$row["a_link"].'\')" type="button">Edit</button>';
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
        
        public function showArticlesIndex($subcatID) {
            $FunctionsObj = new Functions();

            //Validation.
            if(!$FunctionsObj->isInteger($subcatID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $subcatID = $this->connect()->real_escape_string($subcatID);

            //Output data.
            $result = $this->getArticleFromSubcat($subcatID);
            
            if ($result->num_rows > 0) {
                echo "<table class='table-articles-overview'> ";
                
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>";
                    echo "<a href='".$this->linkUrl."article/".$row['a_link']."'>".$row["a_title"]."</a>";
                    echo "<div class='table-articles-admin-icons'>";
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
        
        public function showRelevantArticles($subcatID,$articleID) {
            $FunctionsObj = new Functions();
            
            //Validation.
            if(!$FunctionsObj->isInteger($subcatID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $subcatID = $this->connect()->real_escape_string($subcatID);
            $articleID = $this->connect()->real_escape_string($articleID);
            
            //Execute sql.
            $result = $this->getArticleFromSubcat($subcatID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    //Check if record is current article. If so highlight it.
                    if ($articleID == $row["a_row_id"]) {
                        echo "<a href='".$this->linkUrl."article/".$row['a_link']."' class='list-group-item list-group-item-action list-group-item-secondary'>".$row['a_title']."</a>";
                    } else {
                        echo "<a href='".$this->linkUrl."article/".$row['a_link']."' class='list-group-item list-group-item-action'>".$row['a_title']."</a>";
                    }
                }
            } else {
               echo " <a class='list-group-item list-group-item-action'>No articles found.</a>"; 
            }
        }//Method showRelevantArticles.
        
        public function showFullArticle($articleLink) {
            $FunctionsObj = new Functions();

            //Real escape string.
            $articleLink = $this->connect()->real_escape_string($articleLink);
            
            //Execute sql.
            $result = $this->getArticle($articleLink);
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
                $FunctionsObj->outcomeMessage("warning","No articles have been found");
            }
        }//Method showFullArticle.

        public function showArtchanArticlesXml($channelID) {
            $FunctionsObj = new Functions();
        
            //Validation.
            if(!$FunctionsObj->isInteger($channelID)) {
                echo $FunctionsObj->outcomeMessage("error","Invalid parameters.");
                return false;
            }

            //Real escape string.
            $channelID = $this->connect()->real_escape_string($channelID);

            //Execute sql.
            $result = $this->getArticleChannel($channelID);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<item xmlns:dc='ns:1'>" . PHP_EOL;
                    echo "<title>".$row["a_title"]."</title>" . PHP_EOL;
                    echo "<link>".$this->linkUrl."article/".$row["a_link"]."</link>" . PHP_EOL;
                    echo "<guid>".$row["c_row_id"]."</guid>" . PHP_EOL;
                    echo "<pubdate>".$row["c_published_date"]."</pubdate>" . PHP_EOL;
                    echo "<dc:creator>".$row["a_signed_by"]."</dc:creator>" . PHP_EOL;
                    echo "<description>".$row["a_abstract"]."</description>" . PHP_EOL;
                    echo "<category>".$row["cat_category"]."</category>" . PHP_EOL;
                    echo "</item>" . PHP_EOL;
                }
            }
        }//Method showArtchanArticlesXml
        
    }//ArticleContr.

?>