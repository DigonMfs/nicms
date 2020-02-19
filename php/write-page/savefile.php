<?php 
    //Include connection with the database
    include_once("../dbconn.php");
    
    //Get all values and do real_escape_string
    $articleTitle = $conn -> real_escape_string($_GET["articleTitle"]);
    $articleSummary = $conn -> real_escape_string($_GET["articleSummary"]);
    $ArticleBody = $conn -> real_escape_string($_GET["articleBody"]);
    $articleCategory = $conn -> real_escape_string($_GET["articleCategory"]);
    $articleSubcategory = $conn -> real_escape_string($_GET["articleSubcategory"]);
    $articleSigner = $conn -> real_escape_string($_GET["articleSigner"]);
    $date = date('Y-m-d H:i:s');
    
    //Check if all values are set
    //This is against changing values when spectating an element
    if (!empty($articleTitle) && !empty($articleSummary) && !empty($ArticleBody) && !empty($articleCategory) && !empty($articleSubcategory) && !empty($articleSigner)) {

        //Check if category has been selected
        if (!is_int($articleCategory) && !is_int($articleSubcategory)) {

            //See if cat ID corresponds to a category in the database 
            //This is against changing values when spectating an element
            $sql = "SELECT * FROM category WHERE row_id= $articleCategory AND parent_id=0";
            $result = $conn->query($sql);

            //See if results are > 0
            if ($result->num_rows > 0) {

                //See if cat ID corresponds to a subcategory in the database 
                //This is against changing values when spectating an element
                $sql = "SELECT * FROM category WHERE row_id= $articleCategory AND parent_id=0";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    //Upload file
                    //Author ID is currently always 1 because log in system has not been made yet
                    $sql = "INSERT INTO article (author_id, creation_time, published, title, content, abstract, category_id, subcategory_id, signed_by)
                    VALUES ('1', '$date', '0','$articleTitle','$ArticleBody','$articleSummary','$articleCategory','$articleSubcategory','$articleSigner')";

                    if ($conn->query($sql) === TRUE) {
                        echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }//if $insert succes

                } else {
                    echo "<p class='alert alert-danger' role='alert'>Selected subcategory is not a valid subcategory</p>";
                    die(); 
                }//if result > 0, subcategory
               
            } else {
                echo "<p class='alert alert-danger' role='alert'>Selected category is not a valid category</p>";
                die(); 
            }//if result > 0, category

        } else {
            echo "<p class='alert alert-danger' role='alert'>Please select a category</p>";
            die(); 
        }// if is_int
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>Not all variables contain a value</p>";
        die(); 
    }//if !empty()
    
?>
