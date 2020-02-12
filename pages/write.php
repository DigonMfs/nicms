<?php
    include_once("../php/dbconn.php");
?>
<!DOCTYPE html>
<html lnag="nl">
    <head>
        <meta charset="UTF-8">
        <title>Digon | Admin | Write</title>
        <!--//CDN to ckeditor 4-->
        <script src="//cdn.ckeditor.com/4.13.1/full/ckeditor.js"></script>
        <!--//Link to jquery-->
        <script src="../scripts/jquery.js"></script>
        <!--//Link to functions.js-->
        <script src="../scripts/functions.js"></script>
        <!--Link To CSS-->
        <link rel="stylesheet" type="text/css" href="../styles/style.css">
         <!--Link to Font Awesome-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
        <!--Javascript-->
        <script>
            /*Textarea met ckeditor vervangen*/
            $(document).ready(function() {
                CKEDITOR.replace( 'ckeditor' );
            });
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
                 <a class="nav-link active" href="write.php">Write</a>
                </li>
                <li class="nav-item">
                 <a class="nav-link" href="files.php">Files</a>
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
            
            <!-- Title and summary-->
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
            
            <!--CKEditor-->
            <div class="write-ckeditor-container">
                <textarea name="ckeditor" id="ckeditor" rows="20"></textarea>
            </div>
            
            <!--Navbar for the tabs-->
            <nav class="write-nav-tabs">
                <ul class="nav nav-tabs">
                    <li class="nav-item">
                        <a class="nav-link active" href="#tabPublish" role="tab" data-toggle="tab">Publish</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabCategories" role="tab" data-toggle="tab">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabFiles" role="tab" data-toggle="tab">Files</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tabDate" role="tab" data-toggle="tab">Date</a>
                    </li>
                </ul> 
            </nav>
            
            <!--All the tabs from the navbar above-->
            <div class="tab-content write-tabpane-container">  
                
                <!-- Tab pane publish-->
                <div role="tabpanel" class="tab-pane fade show active" id="tabPublish">
                    <div class="card card-body bg-light write-publish-checkbox-container">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="website" checked disabled>
                            <label class="custom-control-label" for="website">Website</label>
                        </div>
                        <?php
                            //show all the channels on the screen
                            include("../php/showpublishmedia.php")
                        ?>
                    </div><!--checkbox container--> 
                    <div class="write-publish-row row d-flex flex-row">
                        <div class="flex-fill write-publish-extra">
                            <label for="exampleInputEmail1">Signed</label>
                            <input type="text" class="form-control" id="articleSigner" placeholder="Enter Signer">
                        </div>
                        <div class="flex-fill write-publish-extra">
                            <button class="btn btn-primary" onclick="SaveArticle()" type="submit">Save</button>
                        </div>
                    </div><!--author and publish buttton container-->
                </div><!--Tab pane publish-->
                
                <!-- Tab pane Categories-->
                <div role="tabpanel" class="tab-pane fade" id="tabCategories"> 
                    <div class="container-fluid card card-body bg-light">
                         <div class="container"> 
                        <h3 class="write-category-title text-primary">Categories</h3>
                            <?php 
                                //Include all categories (not subcategories)
                                include("../php/showcategories.php");
                            ?>
                        </div>
                        <div class="container container-subcategories"></div>
                    </div>
                </div>

                <!-- Tab pane Files-->
                <div role="tabpanel" class="tab-pane fade files-file-directory-container card" id="tabFiles">
                    <!--Breadcrumbs-->
                    <nav aria-label="breadcrumb" class="files-breadcrumbs-directory-path card-header">
                        <ol class="breadcrumb" id="breadcrumbs">
                            <li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-0" data-value="assets" onclick="BaseDir(0,'false')">assets</a></li>
                        </ol>
                    </nav>
                    <!--directory body-->
                    <div class="files-directory-body card-body">
                        <?php 
                            //show folders and files without admin options
                            /*$admin is true on files.php, if $admin = true, the delete icon will appear on hover, and on click of an image
                            the image won't be inserted in ckeditor, on false the image will be inserted into ckeditor and no delete icon
                            will be shown */
                            $admin = "false";
                            include("../php/lookindir.php");
                        ?>
                    </div>
                </div>
                
                <!-- Tab pane publish date-->
                <div role="tabpanel" class="tab-pane fade" id="tabDate">4</div>
            </div>
            
        </main>
        
        


        <!--Overlay-->
        <div class="overlay-wrapper">
            <div class="overlay-box" id="overlayBody"></div>
        </div>
        <div class="card card-body bg-dark" id="overlay-quick"></div>   

       

        <!--Bootstrap & Bootstrap related CDN's-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>


