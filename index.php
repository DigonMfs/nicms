<?php
    include_once("includes/autoload.inc.php"); 
    $object = new AutoLoad();

    if(isset($_SESSION["userID"])) {
        //header("Location: pages/write.php");
    }
?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Digon | Articles | Home</title>
        <!--//CDN to ckeditor 4-->
        <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
        <!--//Link to jquery-->
        <script src="scripts/jquery.js"></script>
        <!--//Link to functions.js-->
        <script src="scripts/script.js"></script>
        <script src="scripts/functions.js"></script>
        <!--Link To CSS-->
        <link rel="stylesheet" type="text/css" href="styles/style.css">
        <!--Link to Font Awesome-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <!--Javascript-->
        <script>
        </script>
    </head>
    <body onload="openLogindialog()">
        <?php 
            //Header
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
                  <li class="breadcrumb-item active" aria-current="page"><a href="index.php">Category Name</a></li>
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
                        $CategoryViewObj = new CategoryView();

                        //Check if subcatID isset (should normally always be so)
                        if (isset($_GET["subcatID"])) {
                            $CategoryViewObj->ArticlesShowSubcats($_GET["subcatID"]);
                        } else {
                            $CategoryViewObj->ArticlesShowSubcats(1);
                        }
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


