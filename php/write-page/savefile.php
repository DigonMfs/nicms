<?php 
    //Include connection with the database
    include_once("../dbconn.php");
    
    //Get all values and do real_escape_string
    $articleTitle = $_GET["articleTitle"];
    $articleSummary = $_GET["articleSummary"];
    $ArticleBody = $_GET["articleBody"];
    $articleCategory = $_GET["articleCategory"];
    $articleSubcategory = $_GET["articleSubcategory"];
    $articleSigner = $_GET["articleSigner"];
    $date = date('Y-m-d H:i:s');
    
    echo $articleCategory.',';
    echo $articleSubcategory;
    
    //Check if all values are set
    if (!empty($articleTitle) && !empty($articleSummary) && !empty($ArticleBody) && !empty($articleCategory) && !empty($articleSubcategory) && !empty($articleSigner)) {
        
        //Upload file
        //Author ID is currently always 1 because log in system has not been made yet
        $sql = "INSERT INTO article (author_id, creation_time, published, title, content, abstract, category_id, subcategory_id, signed_by)
        VALUES ('1', '$date', '0','$articleTitle','$ArticleBody','$articleSummary','$articleCategory','$articleSubcategory','$articleSigner')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    } else {
        echo "<p class='alert alert-danger' role='alert'>Not all variables contain a value</p>";
        die(); 
    }//if !empty()
    
?>
