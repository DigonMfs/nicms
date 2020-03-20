<?php
    //Include all php files
    include_once("includes/autoload.inc.php"); 

    //Create objects
    $object = new AutoLoad();
    $CategoryViewObj = new CategoryView();

    /*if(isset($_SESSION["userID"])) {
        header("Location: pages/write.php");
    }*/

    //Make sure cat_id exists.
    if (isset($_GET["catID"])) {
        $cat_id = $_GET["catID"];
    } else {
        $cat_id = 1;
    }

?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
        <title>Digon | Articles | Home</title>
        <?php 
            //Head tags.
            include "includes/head.inc.php";
        ?>
    </head>
    <body onload="openLogindialog()">
        <?php 
            //Header.
            include_once "includes/header.inc.php";
        ?>
        
       
        <main class="general-main container">

            <!--Navbar for admin pages-->
            <ul class='nav nav-pills admin-navbar'>
                <?php 
                    include_once "includes/navbar.inc.php";
                ?>
            </ul>

            <!--Breadcrumbs-->
            <nav class="container general-nav nav-index" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumbs-index">
                  <li class="breadcrumb-item">Home</li>
                  <li class="breadcrumb-item active" aria-current="page"><a href="<?php echo $linkUrl; ?>index"><?php echo $CategoryViewObj->showCategory($cat_id) ?></a></li>
                </ol>
            </nav>

             <!--Alert messages-->
             <div class="index-alert-messages">
            </div>
           
            <!--Sidebar container-->
            <div class="row">
                <div class="col-md-3 col-lg-3">
                    <!--Sidebar-->
                    <?php
                        //show subcategories.
                        $CategoryViewObj->ArticlesShowSubcats($cat_id);
                    ?>
                </div>

                <!--Article titles container-->
                <div class="col-md-9 col-lg-9 articles-article-overview-container">
                    <p class="alert alert-warning" role="alert">Click on a subcategory to view the articles.</p>
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


