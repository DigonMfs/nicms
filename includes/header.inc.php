<?php
    $imgLink = "/nicms/images/logo.png";
    $indexPath = "/nicms/images/index.php";
?>

<header class="header">
    <div class="inner-header">
        <div class="inner-header-logo-container">
            <img class="inner-header-logo-image" src="<?php echo $imgLink ?>" alt="Logo">
            <a class="inner-header-logo-text" href="<?php echo $indexPath ?>">Digon</a>
        </div>
        <div class="inner-header-navbar-container">
            <?php 
                if (!isset($_SESSION["userID"])) {
                    echo '<button class="inner-header-navbar-button-login" type="button" onclick="openLogindialog()">Login</button>';
                }
            ?>
        </div>
    </div>
</header>