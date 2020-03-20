<?php
    //Includes.
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();
    $CategoryViewObj = new CategoryView();
    $ArticelViewObj = new ArticleView($linkUrl);
    $articleContrObj = new ArticleContr();
    $CategoryContrObj = new CategoryContr();
    
    //Check if articleID isset.
    if (isset($_GET["articleID"])) {
        //Get article link.
        $articleID = $_GET["articleID"];
        $articleTitle = $articleContrObj->getArticleTitle($articleID);
        $articleCatID = $articleContrObj->getArticleCatID($articleID);
        $articleSubcatID = $articleContrObj->getArticleSubcatID($articleID);
        $articleSubcat = $CategoryContrObj->getSubcat($articleSubcatID);

    } else {
        header("Location: ".$linkUrl."/index");
    }
   



?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
    <meta charset="UTF-8">
        <title>Digon | Article | <?php echo $_GET["subcat"]?></title>
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
                <div class="col-md-3 col-lg-3 articles-sidebar-container">
                    
                    <!--Sidebar-->
                    <div class='list-group articles-list-group-relevant-articles'>
                        <a class='list-group-item list-group-item-action active disabled list-group-items-header'>Relevant articles</a>
                        <?php 
                            $ArticelViewObj->showRelevantArticles($articleSubcatID,$articleID);
                        ?>
                    </div>
                
                </div><!--Sidebar container-->

                <!--Article container-->
                <div class="col-md-9 col-lg-9 articles-article-overview-container">
                    <?php 
                        $ArticelViewObj->showFullArticle($articleID);
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


