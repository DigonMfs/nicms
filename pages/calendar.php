<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <title>Digon | Admin | Calendar</title>
        <!--//CDN to ckeditor 5-->
        <script src="https://cdn.ckeditor.com/ckeditor5/16.0.0/classic/ckeditor.js"></script>
        <!--//Link to jquery-->
        <script src="../scripts/jquery.js"></script>
         <!--//Link to functions.js-->
         <script src="../scripts/functions.js"></script>
        <script src="../scripts/script.js"></script>
        <!--Link To CSS-->
        <link rel="stylesheet" type="text/css" href="../styles/style.css">
         <!--Link to Font Awesome-->
         <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    </head>
    <body>

        <?php 
            //Header
            include_once "../includes/header.inc.php";
        ?>
        
        
        <!--Main-->
        <main class="general-main">
            
            <!-- Navigation bar -->  
            <nav class="container general-nav">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                     <a class="nav-link" href="write.php">Write</a>
                    </li>
                    <li class="nav-item">
                     <a class="nav-link" href="files.php">Files</a>
                    </li>
                    <li class="nav-item">
                     <a class="nav-link" href="categories.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="calendar.php">Calendar</a>
                    </li>
                 </ul> 
        </nav>
                 
            <!--Alert messages-->
            <div class="calendar-alert-messages">
                -->Later delete with join on other published media.
                -->Add to articlechannel table.
            </div>
            
            <!--Container of the directory window-->
            <div class="calendar-topublish-articles-directory-container">
                <div class="calendar-topublish-articles-container  d-flex flex-column">
                    <?php 
                        $ArticleObj = new ArticleView();
                        $ArticleObj->showArticle();
                    ?>
                </div>
            </div>
            
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


