<?php
    //Includes.
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();
    $CategoryViewObj = new CategoryView();
    $ArticelViewObj = new ArticleView($linkUrl);
    $ArticleContrObj = new ArticleContr();
    $CategoryContrObj = new CategoryContr();
    
    //Check if link isset.
    if (isset($_GET["link"])) {
        //Get article link.
        $articleLink = $_GET["link"];

        //Check if article exists.
        if(!$ArticleContrObj->getArticleID($articleLink)) {
            header("Location: ".$linkUrl."index");
        }
        //Get other article elements.
        $articleID = $ArticleContrObj->getArticleID($articleLink);
        $articleTitle = $ArticleContrObj->getArticleTitle($articleLink);
        $articleSummary = $ArticleContrObj->getArticleSummary($articleLink);
        $articleCatID = $ArticleContrObj->getArticleCatID($articleLink);
        $articleSubcatID = $ArticleContrObj->getArticleSubcatID($articleLink);
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
        <!--Facebook share metatags-->
        <meta property="og:url"           content="https://www.your-domain.com/your-page.html" />
        <meta property="og:type"          content="Website"/>
        <meta property="og:title"         content="<?php echo $articleTitle;?>" />
        <meta property="og:description"   content="<?php echo $articleSummary;?>" />
    </head>
    <body>
        <div id="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v6.0"></script>
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

    </body>
</html>


