//Global variables
teller = 0;
subcatLevels = 0;

/*All function about the explorer window*/

//This function open is subdir in the dir
function DirClick(dirName,admin) {

    //Check if createpath is valid
    if (!CreatePath()) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed!</p>");
        return false;
    }//if createPath

    //if function is called after creating folder 'dirName' will be undefined
    if (dirName) {
        teller++;
        document.getElementById("breadcrumbs").innerHTML += '<li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-'+teller+'" data-value="'+escape(dirName)+'" onclick="BaseDir('+teller+','+admin+')">'+dirName+'</a></li>';
    }

    //check if admin is true or false
    
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();

    //Execute Ajax
    $.ajax({
        type: "GET",
        url: "../php/files-page/lookindir.php",
        data: {
            aPath:aPath,
            admin:admin
        },
        success: function(data) {
            $(".files-directory-body").html(data);
        },
    });//ajax

}//function DirClick

function BaseDir(cur_level,admin) {
    /*Cur_level is the level is subdir you clicked on, teller, is the level of subdir you're in right now.
    so all the breadcrumbs after the once you clicked (cur_level+1) should be removed, until the last level (teller)
    the reason for not putting 'i' in the eq() is because when you delete one element the next one will lower with 1, so
    you don't need to increase the number in the eq()*/
    for (i=cur_level;i<teller;i++) {
        $(".bread-crumb-item").eq(cur_level+1).remove();
    }
    //reset global var teller to cur_level
    teller = cur_level;
    
    DirClick(undefined,admin);

}//Function BaseDir

//Create a directory in folder
function CreateDir() {
    //Get dirname
    dirName = document.getElementById("dirName").value;

    //Remove spaces, then check for alphanumeric
    dirNameStrip = StripSpaces(dirName);

    //Check if dirname is not empty, and is alphanumeric
    if (!IsAlphaNumeric(dirNameStrip) || !dirName) {
        document.getElementById("overlaySmall").style.color = "red";
        return false;
    }
    
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();
    //Call ajax
    $.ajax({
        type: "GET",
        url: "../php/files-page/createdir.php",
        data: {
            aPath:aPath,
            dirName:dirName
        },
        success: function(data) {
            $(".files-alert-messages").html(data);
            //close overlay
            Toggleoverlay('close',0);
            //Go in to the created dir
            DirClick(undefined,true);
        },
    });//ajax
}//function CreateDir

//Upload a file function
function UploadFile() {
    //Get all data from input file
    var property = document.getElementById("file").files[0];
    var file_name = property.name;
    var file_extension = file_name.split('.').pop().toLowerCase();

    //Check if file is image/pdf
    if(jQuery.inArray(file_extension, ['jpg','jpeg','png','pdf']) == -1) {
        //invalid extension
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This file is not an image or a pdf file.</p>");
        //Close overlay
        Toggleoverlay('close',0);
        return false;
    }
    
    //Check if file is not too big
    var file_size = property.size;
    if (file_size > 2000000) {
        //file too big
        return false;
    }
    
    var form_data = new FormData();
    form_data.append('file', property);
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();
    aPath.join();
    form_data.append('aPath', aPath);

    $.ajax({
        url: "../php/files-page/uploadfile.php",
        method: "POST",
        data: form_data,
        contentType: false,
        cache: false,
        processData: false,
        success:function(data){
            //Alert messages
            $(".files-alert-messages").html(data);
            //Close overlay
            Toggleoverlay('close',0);
            //Go in to the created dir
            DirClick(undefined,true);
        }//succes
    });//ajax
}//function

function AskDelete(dirPath,fileName,type) {
    //Open overlay
    $(".overlay-wrapper").fadeIn();
    $(".overlay-box").css({
        'margin-top' : '100px'
    });

    //Personalise message.
    if (type == 'file') {
        file_folder = "File";
        message = 'Are you sure you want to delete this '+file_folder+'?';
    }
    else {
        file_folder = "Folder";
        message = 'Are you sure you want to delete this '+file_folder+'? This folder will be deleted recursively!';
    }
        
    //Put in Correct Content
    document.getElementById("overlayBody").innerHTML ='\
            <h2 class="overlay-title">Delete '+file_folder+'</h2>\
            <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
            <div class="form-group">\
               <p class="overlay-text"></p>\
               <small id="overlaySmall" class="overlay-small">'+message+'</small?\
            </div>\
            <div class="button-container">\
                <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                <button class="btn btn-primary" onclick="Delete(\''+dirPath+'\',\''+fileName+'\',\''+type+'\')">Yes, Delete</button>\
            </div>\
        ';
}//Function AskDelete

//This function deletes a dir or a file
function Delete(dirPath,fileName,type) {

    //Check if al parameters exist
    if (!dirPath || !fileName || !type) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Not all parameters are valid</p>");
        return false;
    }

    //Remove . and / from dirpath
    dirPathStripped = StripAlphaNumeric(dirPath);
    fileNameStripped = StripAlphaNumeric(fileName);

    //Check if parameters don't contain special characters
    if (!IsAlphaNumeric(dirPathStripped) || !IsAlphaNumeric(fileNameStripped) || !IsAlphaNumeric(type)) {
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Parameters container forbidden characters</p>");
        return false;
    }//if
    
    //Check if dirpath starts with the folder "assets". The user MAY NOT delete any item anywere alse.
    //Extra validation will also be done in php
    if (!dirPath.startsWith("../../assets")) {
        //Give error message on screen
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed</p>");
        
        //close overlay
        Toggleoverlay('close',0);
        return false;
    }//if
    
    $.ajax({
        type: "GET",
        url: "../php/files-page/deletefolderorfile.php",
        data: {
            dirPath:dirPath,
            fileName:fileName,
            type:type
        },
        success: function(data) {
             //Alert messages
            $(".files-alert-messages").html(data);
            //close overlay
            Toggleoverlay('close',0);
            //Go in to the created dir
            DirClick(undefined,true);
        },
    });//ajax
}//function

//Insert the file into ckeditor
function InsertFile(path,fileName,type) {
    //Check if file is an image or pdf, and copy
    /*
        all Text highlighted in green is to copy the text to your clipboard. The method that is currently being used copies the img/pdf to ckeditor in source code.
    */
    if (type == "pdf")
        //copyText = '<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a>';
        CKEDITOR.instances.ckeditor.insertHtml('<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a> <br>');
    else 
        //copyText = '<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor">';
        CKEDITOR.instances.ckeditor.insertHtml('<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor"> <br>');
    
    //Copy the text to your clipboard
    /*var inp =document.createElement('input');
    document.body.appendChild(inp)
    inp.value = copyText
    inp.select();
    try {
        document.execCommand('copy',false);
        //Open overlay
        $("#overlay-quick").fadeIn();
        document.getElementById("overlay-quick").innerHTML= "<p class='text-white'>Text has been copied</p>";
        setTimeout(function() {
            $("#overlay-quick").fadeOut();
        }, 1000);
        
    } catch (err) {
       alert("failed to copy text!")
    }
    inp.remove();*/


}//function Insertfile






/*Functions About the Write page*/

//function show categories on write page
function ShowSubCategories(value) {
    /*
        *Onclick event on an option inside a select, does not work with chrome. The solution i used is an onchange event on the select itself.
        *Using this solution i can only send 1parameter trough value="". Since all the parameters are integers I seperated them with a comma.
        *And thus I will need to split them
    */
    aValue = value.split(',');
    level = aValue[0];
    parent_id = aValue[1];
        
    //Category has been selected/reselected, so remove the error/succes message.
    $("#categoriesInfoMessages").remove();

    //Calling ajax
    $.ajax({
        type: "GET",
        url: "../php/showsubcategories.php",
        data: {
            level:level,
            parent_id:parent_id
        },
        success: function(data) {
            
            if($("#sub-category-level-"+level).length !== 0) {

                //Clear the data in the class
                $("#sub-category-level-"+level).empty();
                //Add new data in the class
                $("#sub-category-level-"+level).append(data); 
                /*
                This code is unnecessary because there is only 1category and 1level of subcategory. If there should be more then 1sublevel
                category, just uncomment this code,
                //remove extra sub levels if existing
                if (level < subcatLevels) {  
                    //alert(level);
                    //alert(subcatLevels);
                    for (i=level; i <=subcatLevels; i++) {
                        $(".write-categories-container").eq(level).remove();
                    }
                }*/
            } else {
                //Create class and add data into it
                $(".container-subcategories").append("<div class='write-categories-container' id='sub-category-level-"+level+"'>"+data+"</div>");
                subcatLevels++;
            }//if id exists
        },//succes
    });//ajax
}//function ShowSubCategories

//Function save article
function SaveArticle() {
    
    //Get all values, and escape
    articleTitle = escape(document.getElementById("articleTitle").value);
    articleSummary = escape(document.getElementById("articleSummary").value);
    articleBody = escape(CKEDITOR.instances.ckeditor.getData());
    mArticleCategory = escape(document.getElementById("articleCategory").value);
    mArticleSubcategory = escape(document.getElementById("articleSubcategory").value);
    articleSigner = escape(document.getElementById("articleSigner").value);
    
    //Values of the category and subcategory ID container 2 values, their ID, and their Parent_ID,
    //They are separated by a , so we split the value and take the last value (row_id)
    aArticleCategory = mArticleCategory.split(',');
    articleCategory = aArticleCategory[1];
    aArticleSubcategory = mArticleSubcategory.split(',');
    articleSubcategory = aArticleCategory[1];
    
    //Call ajax
    $.ajax({
        type: "GET",
        url: "../php/write-page/savefile.php",
        data: {
            articleTitle:articleTitle,
            articleSummary:articleSummary,
            articleBody:articleBody,
            articleCategory:articleCategory,
            articleSubcategory:articleSubcategory,
            articleSigner:articleSigner
        },
        success: function(data) {
            alert(data);
        },
    });//ajax
    
}//function

/*Functions on categories page */
function SaveCategory() {
    //Get the value and validate it
    categoryName = escape(document.getElementById("categoryName").value);
    
    if(!IsAlphaNumeric(StripSpaces(categoryName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The string must be alphanumeric</p>");
        Toggleoverlay('close',0);
        return false;
    }//if alphanumeric
    
    //Validate length, min=3;max=30
    if (!ValidateLength(categoryName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name has to be between 3 and 30 characters long</p>");
        Toggleoverlay('close',0);
        return false;
    }//if length
    
    //execute ajax
    $.ajax({
        type: "GET",
        url: "../php/categories-page/addcategory.php",
        data: {
            categoryName:categoryName
        },
        success: function(data) {
            $(".categories-alert-messages").html(data);
            //close Overlay
            Toggleoverlay('close',0);
            //reload page, = new category will be displayed
            ListCategories();
        },
    });//ajax
    
}//function SaveCategory

function AskCategoryDelete(id,catSubcat) {
   
    //Open overlay
    $(".overlay-wrapper").fadeIn();
    $(".overlay-box").css({
        'margin-top' : '100px'
    });

    //Personalise message.
    if (catSubcat == 0)
        cat = "category";
    else
        cat = "subcategory";
 
    //Put in Correct Content
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
    
}//function Delete category



function DeleteCategory(id,catSubcat) {
    //Check if both parametes are integers
    if(IsInteger(id) && IsInteger(catSubcat)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>Unknown parameters</p>");
        return false;
    }//if IsInteger
     
    //call ajax
    $.ajax({
        type: "GET",
        url: "../php/categories-page/deletecategory.php",
        data: {
            id:id,
            catSubcat:catSubcat
        },
        success: function(data) {
            //close Overlay
            Toggleoverlay('close',0);
            $(".categories-alert-messages").html(data);
            //reload page, = new category will be displayed
            ListCategories();
        },
    });//ajax
    
}//function Delete category


function AddSubcategory(id) {
   
    //check if ID exists
    if (!$('#subcategoryName'+id).length) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>can't find subcategory name input</p>");
        return false;
    }//if length
    
    //get subcategory name
    subcategoryName = $("#subcategoryName"+id).val();
    
    //check if subcategoryname has a value
    if (!subcategoryName) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The subcategory name is empty</p>");
        return false;
    }//if == ''
    
    //check if name is alphanumeric
    if (!IsAlphaNumeric(StripSpaces(subcategoryName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name is not alphanumeric</p>");
        return false;
    }//if IsAlphanumeric
    
    //Check if name is between 3 and 30 characters long
    if (!ValidateLength(subcategoryName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The subcategory name has to be between 3 and 30 characters long</p>");
        return false;
    }//if length
    
}//function AddSubcategory
