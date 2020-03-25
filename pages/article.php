<?php
    //Includes.
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();
    $CategoryViewObj = new CategoryView();
    $ArticelViewObj = new ArticleView($linkUrl);
    $articleContrObj = new ArticleContr();
    $CategoryContrObj = new CategoryContr();
    
    //Check if link isset.
    if (isset($_GET["link"])) {
        //Get article link.
        $articleLink = $_GET["link"];

        //Check if article exists.
        if(!$articleContrObj->getArticleID($articleLink)) {
            header("Location: ".$linkUrl."index");
        }
        //Get other article elements.
        $articleID = $articleContrObj->getArticleID($articleLink);
        $articleTitle = $articleContrObj->getArticleTitle($articleLink);
        $articleCatID = $articleContrObj->getArticleCatID($articleLink);
        $articleSubcatID = $articleContrObj->getArticleSubcatID($articleLink);
        $articleSubcat = $CategoryContrObj->getSubcat($articleSubcatID);

    } else {
        header("Location: ".$linkUrl."index");
    }
?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
    <meta charset="UTF-8">
        <title>Digon | Article | <?php echo $articleTitle; ?></title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
    </head>
    <body>
        <?php 
            //Header.
            include_once "../includes/header.inc.php";
        ?>
        
        <main class="general-main articles-main container">
 
            <!--Breadcrumbs.-->
            <nav class="container general-nav articles-article-breadcrumbs" aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">Home</li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $linkUrl; ?>index"><?php echo $CategoryViewObj->showCategory($articleCatID) ?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $linkUrl; ?>index"><?php echo $articleSubcat ?></a></li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $articleTitle ?></li>
                </ol>
            </nav>
   
            <div class="row articles-article-container">
                <!--Sidebar container-->
                <div class="col-lg-3 col-md-12 col-sm-12 articles-sidebar-container">
                    
                    <!--Sidebar-->
                    <div class='list-group articles-list-group-relevant-articles'>
                        <a class='list-group-item list-group-item-action active disabled list-group-items-header'>Relevant articles</a>
                        <?php 
                            $ArticelViewObj->showRelevantArticles($articleSubcatID,$articleID);
                        ?>
                    </div>
                </div><!--Sidebar container-->

                <!--Article container-->
                <div class="col-lg-9 col-md-12 col-sm-12 articles-article-overview-container">
                    <?php
                        $ArticelViewObj->showFullArticle($articleLink);
                    ?>
                </div><!-- Article title container-->
                
            </div><!--Row-->
            
        </main>
      
        

        
        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody"></div>
        </div>
        
        <!--Bootstrap & Bootstrap related CDN's-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>


