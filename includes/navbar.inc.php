<<<<<<< Updated upstream
<?php
    //Get url.
    $url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
 
    //Check if user is logged in (only admin can log in).
    if (isset($_SESSION["userID"])) {

        //check directory path to create the links. And check if user (admin) is logged in.
        if ($_SESSION["userFunction"] == 1) 
            $text = "Admin";
        else 
            $text = "Moderator";

        echo "<li class='nav-link admin-navbar-header'><span class='admin-burger-menu' onclick='toggleAdminNav()'>&#9776;</span>".$text."</li>";
        echo "<li class='nav-item admin-nav-item'>";
        if (!strpos($url,'pages') == TRUE) {    
            echo "<a class='nav-link nav-link-admin' href='index.php'>Index</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/write.php'>Write</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/files.php'>Files</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/categories.php'>Categories</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/calendar.php'>Calendar</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/account.php'>Account</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
        } else {
            echo "<a class='nav-link nav-link-admin' href='../index.php'>Index</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='write.php'>Write</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='files.php'>Files</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='categories.php'>Categories</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='calendar.php'>Calendar</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='account.php'>Account</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
        }
        echo "<button class='button-logout' type='button' onclick='logout()'>Logout</button>";
        echo "</li>";
    } 
?>
=======
<?php
    //Get url.
    $url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
 
    //Check if user is logged in (only admin can log in).
    if (isset($_SESSION["userID"])) {

        //check directory path to create the links. And check if user (admin) is logged in.
        if ($_SESSION["userFunction"] == 1) 
            $text = "Admin";
        else 
            $text = "Moderator";

        echo "<li class='nav-link admin-navbar-header'><span class='admin-burger-menu' onclick='toggleAdminNav()'>&#9776;</span>".$text."</li>";
        echo "<li class='nav-item admin-nav-item'>";
        if (!strpos($url,'pages') == TRUE) {    
            echo "<a class='nav-link nav-link-admin' href='index.php'>Index</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/write.php'>Write</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/files.php'>Files</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/categories.php'>Categories</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/calendar.php'>Calendar</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='pages/account.php'>Account</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
        } else {
            echo "<a class='nav-link nav-link-admin' href='../index.php'>Index</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='write.php'>Write</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='files.php'>Files</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='categories.php'>Categories</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='calendar.php'>Calendar</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
            echo "<a class='nav-link nav-link-admin' href='account.php'>Account</a>";
            echo "</li>";
            echo "<li class='nav-item admin-nav-item'>";
        }
        echo "<button class='button-logout' type='button' onclick='logout()'>Logout</button>";
        echo "</li>";
    } 
?>
>>>>>>> Stashed changes
     