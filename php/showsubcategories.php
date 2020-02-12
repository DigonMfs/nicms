<?php
    //Check if variables are set
    if (isset($_GET["level"]) && isset($_GET["parent_id"])) {
        
        //Include connection to the database
        include_once("dbconn.php");
        
        //Get the values
        $level = $_GET["level"];
        $parent_id = $_GET["parent_id"];
        
        //Get categories from the database with correct parent_id
        $sql = "SELECT * FROM category WHERE parent_id= $parent_id";
        $result = $conn->query($sql);
        
          //Output all categories.
        if ($result->num_rows > 0) {

            //Output non repetetive data
            echo '
                <h3 class="write-category-title text-primary">Subcategory</h3>
                <select class="custom-select write-sub-categories-container" id="articleSubcategory" onchange="ShowSubCategories(this.value)">
                    <option option="undefined" selected disabled>Choose a subcategory</option>
            ';
            //Output each sub category
            while($row = $result->fetch_assoc()) {
                echo '<option option="'.$row["row_id"].'" value="'.($level + 1).','.$row["row_id"].'">'.$row["category"].'</option>';
            }//while
            //Output non repetetive data
            echo '</div>';
            
        } else {
            //Output data on screen
            echo "<p class='alert alert-success' id='categoriesInfoMessages' role='alert'>All categories and subcategories have been selected.</p>";
            
        }//if $result > 0
        
        //Close connection
        $conn->close();
        
    } else {
        //variables are not set
        echo "<p class='alert alert-danger' id='categoriesInfoMessages' role='alert'>Undefined values.</p>";
        die();
    }

?>