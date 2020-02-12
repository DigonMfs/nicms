<?php 
    //Show the basic categories
    //include dbconn.php not necessary, because this file is inclued in write.php
    
    //Check if dbconn is set
    if (isset($conn)) {
		
    $level = 0;

        //Select all categories without a parent_id (parent_id = 0)
        $sql = "SELECT * FROM category WHERE parent_id= 0";
        $result = $conn->query($sql);

        //Output all categories.
        if ($result->num_rows > 0) {

            //Output non repetetive data
            echo '<select class="custom-select write-sub-categories-container" id="articleCategory" onchange="ShowSubCategories(this.value)">';
            echo '<option option="undefined" value="undefined" selected disabled>Choose a category</option>';
            //Output each category
            while($row = $result->fetch_assoc()) {
                echo '<option option="'.$row["row_id"].'" value="0,'.$row["row_id"].'"> '.$row["category"].'</option>';
            }//while
            //Output non repetetive data
            echo '</select> ';

        } else {
            //No categories have been found
            echo 'no categories';
        }//if results 0

    } else {
        //Database connection $conn is not set
        echo "<p class='alert alert-danger' role='alert'>Can't connect to the database.</p>";
        die();
    }//if $conn isset
?>