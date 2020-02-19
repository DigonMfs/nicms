<?php 
    //Check if page is accessed with ajax, then dbconn is necessary.
    //When the page is included no dbconn is needed.
    if (isset($_GET["categoryName"])) {
        include_once("../dbconn.php");
    }//if isset

    //Check if connection is set
    if ($conn) {
        
        //LEFT SELF JOIN the table categories on parent_id
        // p = parent (category), c = child (subcategory)
        $sql = "SELECT p.row_id AS p_row_id, p.category AS p_category, p.parent_id AS p_parent_id, c.row_id AS c_row_id, c.category AS c_category, c.parent_id AS c_parent_id 
        FROM category p LEFT JOIN category c
        ON p.row_id = c.parent_id WHERE p.parent_id = 0 ORDER BY c.parent_id ASC";
        $result = $conn->query($sql);

        $row_id = "";
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {

                //See if category_id from the last record is the same as current category_id
                if ($row_id != $row["p_row_id"]) {

                    //If row_id != "", it means we need to close the div of that current category
                    if ($row_id != "") {
                        echo
                            "<div>
                                <input class='add-subcategory form-control' id='subcategoryName".$row['p_row_id']."' type='text'>
                                <i class='fas fa-check text-success' onclick='AddSubcategory(".$row['p_row_id'].")'></i>
                            </div>
                            </div>
                            </div>
                        ";
                    }

                    //Ouput the header and category on the screen
                    echo "
                        <div class='card categories-category-card'>
                            <div class='card-header bg-secondary text-white'>
                            ".$row['p_category']."
                            <i class='delete-categories-icon text-white far fa-trash-alt' onclick='AskCategoryDelete(".$row['p_row_id'].",0)'></i><br>
                        </div>
                        <div class='card-body text-primary text-left'>
                    ";

                    
                    //Output the first coresponding subcategory of the category
                    if ($row["c_category"]) {
                       echo
                            $row['c_category']."
                            <i class='delete-categories-icon text-dark far fa-trash-alt' onclick='AskCategoryDelete(".$row['p_row_id'].",1)'></i><br>
                        "; 
                    }
                    
                
                } else {

                    //Output all subcategories on screen (except 1st one, that one is outputted with the category)
                    echo
                        $row['c_category']."
                            <i class='delete-categories-icon text-dark far fa-trash-alt'></i><br>
                    ";
             
                }//if old row_id != current row_id

                //Set the row_id to the current row_id
                $row_id = $row["p_row_id"];
                
            }//while
            
        } else {
            echo "<p class='alert alert-danger' role='alert'>No categories have been found! Create your first.</p>";
            die();
        }

        //Output the last div closing of the category
        echo "
            <div>
                <input class='add-subcategory id='subcategoryName".$row_id."' form-control' type='text'>
                <i class='fas fa-check text-success' onclick='AddSubcategory(".$row_id.")'></i>
            </div>
            </div>
            </div>
        ";
        
    //output no connection error message
    } else {
        echo "<p class='alert alert-danger' role='alert'>No connection with the database</p>";
        die();
    }//if $connection

?>