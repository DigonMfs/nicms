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
        <title>Digon | Admin | Write</title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
        <script>
            /*Textarea met ckeditor vervangen*/
            $(document).ready(function() {
                CKEDITOR.replace( 'ckeditor' );
            });
        </script>
    </head>
    <body>
        <?php 
            //Header.
            include_once "../includes/header.inc.php";
        ?>
        
        <!-- Main.-->
        <main class="general-main container">

            <!--Navbar for admin pages.-->
            <ul class='nav nav-pills admin-navbar'>
                <?php 
                    include_once "../includes/navbar.inc.php";
                ?>
            </ul>

            <!--Alert messages-->
            <div class="write-alert-messages"></div>
            
            <!-- Title and summary.-->
            <div class="card card-body bg-light">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="text" class="form-control" id="articleTitle" placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Summary</label>
                    <textarea class="form-control" id="articleSummary" placeholder="Enter Summary"></textarea>
                </div>
            </div>
            
            <!--CKEditor.-->
            <div class="write-ckeditor-container">
                <textarea name="ckeditor" id="ckeditor" rows="20"></textarea>
            </div>
            
            <!--Navbar for the tabs.-->
            <nav class="write-nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tabPublish" role="tab" data-toggle="tab">Publish</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabCategories" role="tab" data-toggle="tab">Category</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabFiles" role="tab" data-toggle="tab">Files</a>
                    </li>
                </ul> 
            </nav>
            
            <!--All the tabs from the navbar above.-->
            <div class="tab-content write-tabpane-container">  
                
                <!-- Tab pane publish.-->
                <div role="tabpanel" class="tab-pane fade show active" id="tabPublish">
                    <div class="write-publish-row d-lg-flex d-lg-fler-row">
                        <div class="flex-fill write-publish-extra">
                            <label for="exampleInputEmail1">Signed</label>
                            <input type="text" class="form-control" id="articleSigner" placeholder="Enter Signer..">
                        </div>
                        <div class="flex-fill write-publish-extra">
                            <label for="exampleInputEmail1">URL</label>
                            <input type="text" class="form-control" id="articleURL" placeholder="Enter URL..">
                        </div>
                    </div>
                    <div class="flex-fill write-publish-extra-button-container">
                        <button class="btn btn-primary" onclick="SaveArticle()" type="submit">Save</button>
                    </div>
                </div><!--Tab pane publish.-->
                
                <!-- Tab pane Categories.-->
                <div role="tabpanel" class="tab-pane fade" id="tabCategories"> 
                    <div class="container-fluid card card-body bg-light">
                         <div class="container"> 
                        <h3 class="write-category-title text-primary">Category</h3>
                            <?php 
                               //Show all categories.
                                $categoryObj = new CategoryView();
                                $categoryObj->showCategories();
                            ?>
                        </div>
                        <div class="container container-subcategories"></div>
                    </div>
                </div><!-- Tab pane Categories.-->

                <!-- Tab pane Files-->
                <div role="tabpanel" class="tab-pane fade files-file-directory-container card" id="tabFiles">
                    <nav aria-label="breadcrumb" class="files-breadcrumbs-directory-path card-header">
                        <ol class="breadcrumb" id="breadcrumbs">
                            <li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-0" data-value="assets" onclick="BaseDir(0,'false')">assets</a></li>
                        </ol>
                    </nav>
                    <div class="files-directory-body card-body">
                        <?php 
                            //show folders and files without admin options
                            /*$admin is true on files.php, if $admin = true, the delete icon will appear on hover, and on click of an image
                            the image won't be inserted in ckeditor, on false the image will be inserted into ckeditor and no delete icon
                            will be shown. */
                            $admin = "false";
                            $fileFolderObj = new FileView($linkUrl);
                            $fileFolderObj->showFilesFolders($admin,null);
                        ?>
                    </div>
                </div><!-- Tab pane Files.-->

            </div> 
        </main>
        
        <!--Overlay.-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody"></div>
        </div>
        <div class="card card-body bg-dark" id="overlay-quick"></div>   

        <!--Bootstrap & Bootstrap related CDN's.-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>


