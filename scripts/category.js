//Ask to delete a category.
function AskCategoryDelete(id,catSubcat) {
    Toggleoverlay('open',0);

    //Personalise message.
    if (catSubcat == 0)
        cat = "category";
    else
        cat = "subcategory";
 
    //Put in Correct Content.
    document.getElementById("overlayBody").innerHTML ='\
            <h2 class="overlay-title">Delete '+cat+'</h2>\
            <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
            <div class="form-group">\
               <p class="overlay-text"></p>\
               <small id="overlaySmall" class="overlay-small">Are you sure you want to delete this '+cat+'?</small?\
            </div>\
            <div class="button-container">\
                <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                <button class="btn btn-primary" onclick="DeleteCategory(\''+id+'\',\''+catSubcat+'\')">Yes, Delete</button>\
            </div>\
        ';
}//Function AskCategoryDelete.

//Delete a category.
function DeleteCategory(id,catSubcat) {

    //Check if both parametes are integers.
    if(IsInteger(id) && IsInteger(catSubcat)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>Unknown parameters</p>");
        return false;
    }
     
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            id:id,
            catSubcat:catSubcat,
            deleteCatSubcat:"deleteCatSubcat"
        },
        success: function(data) {
            Toggleoverlay('close',0);
            $(".categories-alert-messages").html(data);
            ListCategories();
        },
    });
}//Function DeleteCategory.

//List all the categories on the category page.
function ListCategories() {
     //Call ajax.
     $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            listCategories:"listCategories"
        },
        success: function(data) {
            $(".categories-category-container").html(data);
        },
    });
}//Function ListCategories.


//Add a category.
function SaveCategory(parent_id) {
    //Get the value.
    catSubcatName = document.getElementById("categoryName").value;
    
    //Validate the value.
    if(!IsAlphaNumeric(StripSpaces(catSubcatName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The string must be alphanumeric</p>");
        Toggleoverlay('close',0);
        return false;
    }
    if (!ValidateLength(catSubcatName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name has to be between 3 and 30 characters long</p>");
        Toggleoverlay('close',0);
        return false;
    }

    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            parent_id:parent_id,
            catSubcatName:catSubcatName,
            setCatSubcat:"setCatSubcat"
        },
        success: function(data) {
            $(".categories-alert-messages").html(data);
            Toggleoverlay('close',0);
            ListCategories();
        },
    });
}//Function SaveCategory.


//Add a subcategory.
function AddSubcategory(parent_id) {
   
    //check if ID exists.
    if (!$('#subcategoryName'+parent_id).length) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>can't find subcategory name input</p>");
        return false;
    }//if length
    
    //get the value.
    catSubcatName = $("#subcategoryName"+parent_id).val();
    
    //Check if name is alphanumeric.
    if (!IsAlphaNumeric(StripSpaces(catSubcatName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name is not alphanumeric</p>");
        return false;
    }
    
    //Validate the length.
    if (!ValidateLength(catSubcatName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The subcategory name has to be between 3 and 30 characters long</p>");
        return false;
    }

    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
        data: {
            parent_id:parent_id,
            catSubcatName: catSubcatName,
            setCatSubcat:"setCatSubcat"
        },
        success: function(data) {
            $(".categories-alert-messages").html(data);
            ListCategories();
        },
    });
}//Function AddSubcategory