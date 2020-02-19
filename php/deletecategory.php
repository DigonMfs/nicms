<?php 
    //Check if parameters are set
    if (isset($_GET["id"]) && isset($_GET["catSubcat"])) {
        
        //include dbconn and functions
        include_once ('dbconn.php');
        include_once ('functions.php');
        
        //Get values and do real_escape_string
        $id = $conn -> real_escape_string($_GET["id"]);
        $catSubcat = $conn -> real_escape_string($_GET["catSubcat"]);
        
        //check if id is integer, and if subcat is a boolean
        if (IsInteger($id) == 1 && $catSubcat == 1 || $catSubcat == 0) {
            
            //check to delete a cat or subcat 0=cat;1=subcat
            if ($catSubcat == 0) {
                
                //Category, look if cat_id is actually a cat id
                $sql = "SELECT * FROM category WHERE parent_id = 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    
                    //Delete the category
                    $sql = "DELETE FROM category WHERE row_id=$id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='alert alert-success' role='alert'>Category has succesfully been deleted</p>";
                        die();
                        
                    } else {
                        echo "Error deleting record: " . $conn->error;
                        die();
                    }//if success delete

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Category does not exist</p>";
                    die();
                }//results > 0
                
            } else {
                
                //Subcategory, look if subcat_id is actually a subcat_id
                $sql = "SELECT * FROM category WHERE parent_id != 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    
                    //Delete the subcategory
                    $sql = "DELETE FROM category WHERE row_id=$id";
                    if ($conn->query($sql) === TRUE) {
                        echo "<p class='alert alert-success' role='alert'>Subcategory has successfully been deleted.</p>";
                        die();
                        
                    } else {
                        echo "Error deleting record: " . $conn->error;
                        die();
                    }//if succes delete

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Subcategory does not exist.</p>";
                    die();
                }//results > 0
                
            }//if subcat == 0
            
        } else {
            echo "<p class='alert alert-danger' role='alert'>Wrong parameter type.</p>";
            die();
        }//if IsInteger
    
    } else {
        echo "<p class='alert alert-danger' role='alert'>Unknown parameters.</p>";
        die();
    }//if isset
    
?>
