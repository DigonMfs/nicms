<?php
    $imgLink = "/websites/nicms/images/logo.png";
    $indexPath = "/websites/nicms/index.php";
    
    //Get url.
    $url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
    
    /*if (!strpos($url,'pages') == TRUE) {
       $indexPath = "index.php";
    } else {
        $indexPath = "../index.php";
    }*/
    
?>

<header class="header">
    <div class="inner-header">
        <div class="inner-header-logo-container">
            <img class="inner-header-logo-image" src="<?php echo $imgLink ?>" alt="Logo">
            <a class="inner-header-logo-text" href="<?php echo $indexPath ?>">Digon</a>
        </div>
        <div class="inner-header-navbar-container">
            <?php
                //Check if user is logged in (only admin can log in).
                /*if (!isset($_SESSION["userID"])) {
                    //No, place login button.
                    //echo '<button class="inner-header-navbar-button-login" type="button" onclick="openLogindialog()">Login</button>';
                } else {
                    //check directory path to create the links. And check if user (admin) is logged in.
                    if (!strpos($url,'pages') == TRUE) {    
                        echo '<a href="pages/write.php" class="inner-header-navbar-link" type="button">Write</a>';
                        echo '<a href="pages/files.php" class="inner-header-navbar-link" type="button">Files</a>';
                        echo '<a href="pages/categories.php" class="inner-header-navbar-link" type="button">Categories</a>';
                        echo '<a href="pages/calendar.php" class="inner-header-navbar-link" type="button">Calendar</a>';
                        echo '<a href="pages/account.php" class="inner-header-navbar-link" type="button">Account</a>';
                    } else {
                        echo '<a href="write.php" class="inner-header-navbar-link" type="button">Write</a>';
                        echo '<a href="files.php" class="inner-header-navbar-link" type="button">Files</a>';
                        echo '<a href="categories.php" class="inner-header-navbar-link" type="button">Categories</a>';
                        echo '<a href="calendar.php" class="inner-header-navbar-link" type="button">Calendar</a>';
                        echo '<a href="account.php" class="inner-header-navbar-link" type="button">Account</a>';
                    }
                    //Show logout button.
                    echo '<button class="inner-header-navbar-button-login" type="button" onclick="logout()">Logout</button>';
                } */
            ?>
        </div>
    </div>
</header>