<?php
    //Get url.
    $url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];
 
    //Check if user is logged in (only admin can log in).
    if (isset($_SESSION["userID"])) {

        //Check if user (admin) is logged in.
        if ($_SESSION["userFunction"] == 1) 
            $text = "Admin";
        else 
            $text = "Moderator";

        echo "<li class='nav-link admin-navbar-header'><span class='admin-burger-menu' onclick='toggleAdminNav()'>&#9776;</span>".$text."</li>";
        echo "<li class='nav-item admin-nav-item'>"; 
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."index'>Index</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."write'>Write</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."files'>Files</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."categories'>Categories</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."channels'>Channels</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."calendar'>Calendar</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."account'>Account</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<a class='nav-link nav-link-admin' href='".$linkUrl."FAQ'>FAQ</a>";
        echo "</li>";
        echo "<li class='nav-item admin-nav-item'>";
        echo "<button class='button-logout' type='button' onclick='logout()'><i class='fas fa-sign-out-alt'></i></button>";
        echo "</li>";

        //With relative paths.
        //if (!strpos($url,'pages') == TRUE) {   }
        //else {}
    } 
?>