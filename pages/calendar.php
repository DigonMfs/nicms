<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();

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
        <main class="general-main">

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
                <div class="col-md-3 col-lg-3">
                     <div class='list-group'>
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
                <div class="col-md-9 col-lg-9 articles-article-overview-container" id="calendarArticlesContainer">

                    <!--Show amount of entries.
                    <div class="calendar-showentries-div">
                        <p>Showing 1 to 10 of 10 entries</p>
                        <p>
                            <button class="btn btn-light calendar-show-entries-buttons calendar-entries-prev-button" disabled>Prev</button>
                            <button class="btn btn-primary calendar-show-entries-buttons calendar-entries-curr-button" disabled>1</button>
                            <button class="btn btn-light calendar-show-entries-buttons calendar-entries-next-button">Next</button></p>
                    </div>-->

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
        
        <!--Bootstrap & Bootstrap related CDN's-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>


