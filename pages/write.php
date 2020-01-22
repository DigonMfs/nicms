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
        <!--Link To CSS-->
        <link rel="stylesheet" type="text/css" href="../styles/style.css">
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
        <nav class="container col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 general-nav">
            <ul class="nav nav-pills">
                <li class="nav-item">
                 <a class="nav-link" href="../articles.php">Articles</a>
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
                    <a class="nav-link" href="calender.php">Calender</a>
                </li>
             </ul> 
        </nav>
        
        <!-- Main-->
        <main class="col-lg-8 offset-lg-2 col-md-10 offset-md-1 col-sm-12 general-main">
            
            <!-- Title and summary-->
            <div class="card card-body bg-light">
                <div class="form-group">
                    <label for="exampleInputEmail1">Title</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Title">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <textarea class="form-control" id="exampleInputPassword1" placeholder="Enter Summary"></textarea>
                </div>
            </div>
            
            <!--CKEditor-->
            <div class="write-ckeditor-container">
                <textarea name="editor1" id="ckeditor" rows="20"></textarea>
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
                            <label for="exampleInputEmail1">Author</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Author">
                        </div>
                        <div class="flex-fill write-publish-extra">
                            <button class="btn-primary btn" type="submit">Save</button>
                        </div>
                    </div><!--author and publish buttton container-->
                    
                </div><!--Tab pane publish-->
                
                <!-- Tab pane Categories-->
                <div role="tabpanel" class="tab-pane fade" id="tabCategories">2</div>
                
                <!-- Tab pane Files-->
                <div role="tabpanel" class="tab-pane fade" id="tabFiles">
                    <div class="card card-body bg-light">
                        
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tabDate">4</div>
            </div>
            
        </main>
        
        
       
       
        <!--Bootstrap & Bootstrap related CDN's-->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    </body>
</html>


