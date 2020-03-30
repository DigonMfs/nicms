<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();

    //Check if user is logged in.
    if(!isset($_SESSION["userID"])) {
        header("Location: ".$linkUrl."index");
    }

?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Digon | Admin | Calendar</title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
    </head>
    <body>
        <?php 
            //Header
            include_once "../includes/header.inc.php";
        ?>
        
        <!--Main-->
        <main class="general-main container">

            <!--Navbar for admin pages-->
            <ul class='nav nav-pills admin-navbar'>
                <?php 
                    include_once "../includes/navbar.inc.php";
                ?>
            </ul>
                  
            <!--Alert messages-->
            <div class="calendar-alert-messages"></div>

            <div class="row">
                
                <!--Sidebar container-->
                <div class="col-lg-3 col-md-12 col-sm-12">
                     <div class='list-group calendar-list-group'>
                        <a class='list-group-item list-group-item-action active disabled list-group-items-header'>Filter & sort articles</a>
                        <a class='list-group-item list-group-item-action'>Show articles</a>
                        <a class='list-group-item list-group-item-action list-group-item-light' onchange="filterArticles()">
                            <select name="selectShowArticles" id="selectSortArticles">
                                <option value="all">All</option>
                                <option value="published">Published</option>
                                <option value="saved">Saved</option>
                                <option value="deleted">Deleted</option>
                            </select>
                        </a>
                        <a class='list-group-item list-group-item-action'>Sort articles</a>
                        <a class='list-group-item list-group-item-action list-group-item-light'>
                            <select name="selectFilterArticles" id="selectFilterArticles" onchange="filterArticles()">
                                <option value="DATEASC">DATE ASC</option>
                                <option value="DATEDESC">DATE DESC</option>
                            </select>
                        </a>
                    </div>
                </div>

                <!--Articles container-->
                <div class="col-lg-9 col-md-12 col-sm-12 articles-article-overview-container" id="calendarArticlesContainer">
                    <!--Show all articles-->
                    <?php 
                        $ArticleObj = new ArticleView($linkUrl);
                        $ArticleObj->showArticle('all','DATEASC',10);
                    ?>
                </div><!-- Articles container-->   

                <div class="calendar-load-more">
                    <button class="btn btn-info" onclick="calendarLoadMoreArt()">Load More</button>
                </div>
                
            </div><!--Row-->
            
        </main>

        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody">
            </div>
        </div>

    </body>
</html>


