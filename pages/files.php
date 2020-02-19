<?php
    //Include connection with the database
    include_once("../php/dbconn.php");
?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
        <meta charset="UTF-8">
        <title>Digon | Admin | Files</title>
        <!--//CDN to ckeditor 4-->
        <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
        <!--//Link to jquery-->
        <script src="../scripts/jquery.js"></script>
        <!--//Link to functions.js-->
        <script src="../scripts/script.js"></script>
        <script src="../scripts/functions.js"></script>
        <!--Link To CSS-->
        <link rel="stylesheet" type="text/css" href="../styles/style.css">
        <!--Link to Font Awesome-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <!--Javascript-->
        <script>
        </script>
    </head>
    <body>
        
        <!-- Navigation bar -->
        <nav class="container general-nav">
            <ul class="nav nav-pills">
                <li class="nav-item">
                 <a class="nav-link" href="articles.php">Articles</a>
                </li>
                <li class="nav-item">
                 <a class="nav-link" href="write.php">Write</a>
                </li>
                <li class="nav-item">
                 <a class="nav-link active" href="files.php">Files</a>
                </li>
                <li class="nav-item">
                 <a class="nav-link" href="categories.php">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calender.php">Calendar</a>
                </li>
             </ul> 
        </nav>
        
        <!-- Main-->
        <main class="general-main">

             <!--Directory Actions-->
            <div class="admin files-admin-div">
                <button type="button" class="btn btn-primary buttons" onclick="Toggleoverlay('open',1)">Create Folder</button>
                <button type="button" class="btn btn-primary buttons" onclick="Toggleoverlay('open',2)">Upload File</button>
            </div>
             
            <!--Alert messages-->
            <div class="files-alert-messages"></div>
              
            <!--Container of the directory window-->
            <div class="files-file-directory-container card">
                <!--Breadcrumbs-->
                <nav aria-label="breadcrumb" class="files-breadcrumbs-directory-path card-header">
                    <ol class="breadcrumb" id="breadcrumbs">
                        <li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-0" data-value="assets" onclick="BaseDir(0,'true')">assets</a></li>
                    </ol>
                </nav>
                <!--Directory body-->
                <div class="files-directory-body card-body">
                     <?php
                        //show folders and files without admin options
                        /*$admin is true on files.php, if $admin = true, the delete icon will appear on hover, and on click of an image
                        the image won't be inserted in ckeditor, on false the image will be inserted into ckeditor and no delete icon
                        will be shown */
                        $admin = "true";
                        include("../php/files-page/lookindir.php");
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


