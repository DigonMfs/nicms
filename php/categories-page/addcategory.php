<?php
    if (isset($_GET["categoryName"])) {
        
        //include dbconn and functions
        include_once ('../dbconn.php');
        include_once ('../functions.php');
        
        //Get value and do real_escape_string
        $categoryName = $conn -> real_escape_string($_GET["categoryName"]);
        //Check if name is alphanumeric
        if (IsAlphaNumeric(StripSpaces($categoryName))) {
            
            if (ValidateLength($categoryName,3,30)) {
                
                //Add the category to the database
                $sql = "INSERT INTO category (category, parent_id)
                VALUES ('$categoryName', '0')";

                if ($conn->query($sql) === TRUE) {
                    
                    echo "<p class='alert alert-success' role='alert'>The category has successfully been added.</p>";
                    die();
                    
                } else {
                    echo "<p class='alert alert-danger' role='alert'>Unable to add category to the database</p>";
                    die();
                }//if insert succes
                
            } else {
                echo "<p class='alert alert-danger' role='alert'>The name has to be between 3 and 30 characters long</p>";
                die();
            }//if length
            
        } else {
            echo "<p class='alert alert-danger' role='alert'>The name is not alphanumeric</p>";
            die(); 
        }//if alphanumeric
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>Unknown parameters</p>";
        die(); 
    }//if isset $_GET
?>
