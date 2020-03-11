<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();

    if(!isset($_SESSION["userID"])) {
        header("Location: ../index.php");
    }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Digon | Admin | Profile</title>
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
            //Header.
            include_once "../includes/header.inc.php";
        ?>
        
        <!--Main.-->
        <main class="general-main">
                 
            <!--Alert messages.-->
            <div class="account-alert-messages"></div>
            

            <!--Change account settings.-->
            <div class="row">
                <!--Title.-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <h3 class="account-settings-title">Change Account information</h3>
                </div>

                <!--Change password.-->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form>
                        <h4 class="account-settings-subtitle">Change password</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changePasswordOld" class="account-settings-label text-primary">Old password</label>
                            <input type="password" class="form-control" id="changePasswordOld" placeholder="Enter old password..">
                        </div>
                        <div class="form-group">
                            <label for="changePasswordNew" class="account-settings-label text-primary">New password</label>
                            <input type="password" class="form-control" id="changePasswordNew" placeholder="Enter new password..">
                        </div>
                        <div class="form-group">
                            <label for="changePasswordNewConfirm" class="account-settings-label text-primary">Confirm new password</label>
                            <input type="password" class="form-control" id="changePasswordNewConfirm" placeholder="Confirm new password..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>

                <!--Change username and displayname-->
                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form>
                        <h4 class="account-settings-subtitle">Change username</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changeUsername" class="account-settings-label text-primary">Username</label>
                            <input type="text" class="form-control" id="changeUsername" placeholder="Enter Username..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                    <form>
                        <h4 class="account-settings-subtitle">Change displayname</h4>
                        <hr class="account-settings-subtitle-underline">
                        <div class="form-group">
                            <label for="changeDisplayname" class="account-settings-label text-primary">Displayname</label>
                            <input type="text" class="form-control" id="changeDisplayname" placeholder="Enter Displayname..">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                        </div>
                    </form>
                </div>
            </div><!--.Row.-->

            <!--View all accounts.-->
            <div class="row">
                 <!--Title.-->
                 <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr class="account-settings-title-underline">
                    <h3 class="account-settings-title">View all accounts</h3>  
                </div>
                
                <!--Table with all accounts.-->
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Username</th>
                                <th scope="col">Displayname</th>
                                <th scope="col">Password</th>
                                <th scope="col">function</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>admin</td>
                                <td>admin</td>
                                <td> 
                                    *****
                                </td>
                                <td><span class="badge-danger badge">Admin</span></td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>moderator</td>
                                <td>moderator</td>
                                <td> 
                                    <input type="text"> 
                                    <i class='fas fa-check text-success'></i>
                                </td>
                                <td><span class="badge-success badge">moderator</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div><!--Row.-->
                
            </div>

            <!--Add an account.-->
            <div class="row">
                 <!--Title.-->
                 <div class="col-lg-12 col-md-12 col-sm-12">
                    <hr class="account-settings-title-underline">
                    <h3 class="account-settings-title">Add an account</h3>    
                </div>

                 <!--Change password.-->
                 <div class="col-lg-6 col-md-12 col-sm-12">
                    <form>
                        <div class="form-group">
                            <label for="chooseUsername" class="account-settings-label text-primary">Username</label>
                            <input type="text" class="form-control" id="chooseUsername" placeholder="Enter username..">
                        </div>
                        <div class="form-group">
                            <label for="chooseDisplayname" class="account-settings-label text-primary">Displayname</label>
                            <input type="text" class="form-control" id="chooseDisplayname" placeholder="Enter displayname..">
                        </div>
                    </form>
                </div>

                <div class="col-lg-6 col-md-12 col-sm-12">
                    <form>
                        <div class="form-group">
                            <label for="choosePassword" class="account-settings-label text-primary">Password</label>
                            <input type="password" class="form-control" id="choosePassword" placeholder="Enter password..">
                        </div>
                        <div class="form-group">
                            <label for="choosePasswordConfirm" class="account-settings-label text-primary">Confirm password</label>
                            <input type="password" class="form-control" id="choosePasswordConfirm" placeholder="Confirm password..">
                        </div>
                    </form>
                </div>

                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="form-group">
                        <button type="submit" class="account-settings-button btn btn-primary btn-sm">Save</button>
                    </div>
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


