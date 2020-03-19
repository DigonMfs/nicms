//Global variables
teller = 0;
subcatLevels = 0;
amount = 0; //limit of calendar page.


/*Articles page - Login*/
function openLogindialog() {
    url = window.location.href;
    if (!url.includes("?login")) {
        return false;
    }

    //Open overlay
    $(".overlay-wrapper").fadeIn();
    $(".overlay-box").css({
        'margin-top' : '100px'
    });

    //Put in Correct Content
    document.getElementById("overlayBody").innerHTML ='\
        <h2 class="overlay-title">Login</h2>\
        <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
        <div class="form-group form-group-login">\
            <label for="username">Username</label>\
            <input type="text" class="form-control" id="username" placeholder="Enter Username">\
            <label for="password">Password</label>\
            <input type="password" class="form-control" id="password" placeholder="Enter Password">\
            <small id="loginMessage"></small>\
        </div>\
        <div class="button-container button-container-login">\
            <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
            <button class="btn btn-primary" onclick="login()">Login</button>\
        </div>\
    ';
}

function login() {
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;
    if (username == "" || password == "") {
        $("#loginMessage").html("Values are empty.");
        return false;
    }
    if (!IsAlphaNumeric(username) || !IsAlphaNumeric(password)) {
        $("#loginMessage").html("Values are not alphanumeric.");
        return false;
    }

    $.ajax({
        type: "POST",
        url: "classes/handler.class.php",
        data: {
            username:username,
            password:password,
            login:"login"
        },
        success: function(data) {
            //$(".index-alert-messages").html(data);
            newURL = url.replace("login", "");
            document.location.href = newURL;
            Toggleoverlay('close',0);
        },
    });//ajax
}//Method login.

function logout() {
    url = window.location.href;
    if (url.includes('pages')) {
        ajaxUrl = "../classes/";
    } else {
        ajaxUrl = "classes/"
    }
    $.ajax({
        type: "POST",
        url: ajaxUrl+"handler.class.php",
        data: {
            logout:"logout"
        },
        success: function(data) {
           location.reload();
        },
    });//ajax
}//Method logout.


/*All function about the explorer window*/

//This function opens a subdir in a dir.
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
    
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();

    //Execute Ajax
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            aPath:aPath,
            admin:admin,
            dirClick:"dirClick"
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
    aPath.join(',');

    //Call ajax
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            aPath:aPath,
            dirName:dirName,
            createDir:"createDir"
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
    if (file_size > 5000000) {
        //file too big
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>File is too big.</p>");
        Toggleoverlay('close',0);
        return false;
    }
    
    var form_data = new FormData();
    form_data.append('file', property);
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();
    aPath.join(',');
    form_data.append('aPath', aPath);
    form_data.append('uploadFile', aPath);

    $.ajax({
        url: "../classes/handler.class.php",
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
     //Open overlay.
     Toggleoverlay('open',0);

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
    if (!dirPath.startsWith("../assets")) {
        //Give error message on screen
        $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed</p>");
        
        //close overlay
        Toggleoverlay('close',0);
        return false;
    }//if
    
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            dirPath:dirPath,
            fileName:fileName,
            type:type,
            deleteFileFolder:"deleteFileFolder"
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
        CKEDITOR.instances.ckeditor.insertHtml('<img class="articles-article-img" src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor"> <br>');

}//function Insertfile




function copyFile(path,fileName,type) {
    //Copy the text to your clipboard
    var inp =document.createElement('input');
    document.body.appendChild(inp);

    if (type == "pdf") {
        copyText = '<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a>';
    } else {
        copyText = '<img class="articles-article-img" src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor">';
    }

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
    inp.remove();
}






/*Functions About the Write page*/




//function show subcategories on write page
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
        url: "../classes/handler.class.php",
        data: {
            level:level,
            parent_id:parent_id,
            showSubcategories:"showSubcategories"
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
    articleTitle = document.getElementById("articleTitle").value;
    articleSummary = document.getElementById("articleSummary").value;
    articleBody = CKEDITOR.instances.ckeditor.getData();
    mArticleCategory = document.getElementById("articleCategory").value;
    mArticleSubcategory = document.getElementById("articleSubcategory").value;
    articleSigner = document.getElementById("articleSigner").value;
    articleURL = document.getElementById("articleURL").value;

    //Values of the category and subcategory ID container 2 values, their ID, and their Parent_ID,
    //They are separated by a , so we split the value and take the last value (row_id)
    aArticleCategory = mArticleCategory.split(',');
    articleCategory = aArticleCategory[1];
    aArticleSubcategory = mArticleSubcategory.split(',');
    articleSubcategory = aArticleSubcategory[1];
 
    //Call ajax
    $.ajax({
        type: "POST",
        url: "../classes/handler.class.php",
        data: {
            articleTitle:articleTitle,
            articleSummary:articleSummary,
            articleBody:articleBody,
            articleCategory:articleCategory,
            articleSubcategory:articleSubcategory,
            articleSigner:articleSigner,
            articleURL:articleURL,
            saveArticle:"saveArticle"
        },
        success: function(data) {
            alert(data);
        },
    });//ajax
    
}//function



function AskCategoryDelete(id,catSubcat) {
    //Open overlay.
    Toggleoverlay('open',0);

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
        url: "../classes/handler.class.php",
        data: {
            id:id,
            catSubcat:catSubcat,
            deleteCatSubcat:"deleteCatSubcat"
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




function ListCategories() {
     //call ajax
     $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            listCategories:"listCategories"
        },
        success: function(data) {
            $(".categories-category-container").html(data);
        },
    });//ajax
}//Function ListCategories.






/*Functions on categories page */
function SaveCategory(parent_id) {
    //Get the value and validate it
    catSubcatName = document.getElementById("categoryName").value;
    
    if(!IsAlphaNumeric(StripSpaces(catSubcatName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The string must be alphanumeric</p>");
        Toggleoverlay('close',0);
        return false;
    }//if alphanumeric
    
    //Validate length, min=3;max=30
    if (!ValidateLength(catSubcatName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name has to be between 3 and 30 characters long</p>");
        Toggleoverlay('close',0);
        return false;
    }//if length

    //execute ajax
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            parent_id:parent_id,
            catSubcatName:catSubcatName,
            setCatSubcat:"setCatSubcat"
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



function AddSubcategory(parent_id) {
   
    //check if ID exists
    if (!$('#subcategoryName'+parent_id).length) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>can't find subcategory name input</p>");
        return false;
    }//if length
    
    //get subcategory name
    catSubcatName = $("#subcategoryName"+parent_id).val();
    
    //check if subcategoryname has a value
    if (!catSubcatName) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The subcategory name is empty</p>");
        return false;
    }//if == ''
    
    //check if name is alphanumeric
    if (!IsAlphaNumeric(StripSpaces(catSubcatName))) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The name is not alphanumeric</p>");
        return false;
    }//if IsAlphanumeric
    
    //Check if name is between 3 and 30 characters long
    if (!ValidateLength(catSubcatName,3,30)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>The subcategory name has to be between 3 and 30 characters long</p>");
        return false;
    }//if length

    //Cal ajax.
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            parent_id:parent_id,
            catSubcatName: catSubcatName,
            setCatSubcat:"setCatSubcat"
        },
        success: function(data) {
            $(".categories-alert-messages").html(data);
            ListCategories();
        },
    });//ajax

}//function AddSubcategory



//Show articles to publish
function showArticlesToPublish() {
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            showArticlesToPublish:"showArticlesToPublish"
        },
        success: function(data) {
            $(".calendar-topublish-articles-container").html(data);
        },
    });//Ajax.
}//Function showArticlesToPublish.

//Refreshes filters on calendar page.
function filterArticles() {
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();

    $.ajax({
        type: "POST",
        url: "../classes/handler.class.php",
        data: {
            visibility:visibility,
            sort:sort,
            filterArticles:"filterArticles"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });//Ajax.
}



function askPublishArticle(id) {
    //toggle overlay
    Toggleoverlay('open',0);

    document.getElementById("overlayBody").innerHTML = '\
    <h2 class="overlay-title">Publish Article</h2>\
    <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
    <div class="form-group">  \
      <p>Are you sure you want to publish this article?</p>\
    </div>\
    <div class="button-container">\
        <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
        <button class="btn btn-primary" onclick="publishArticle('+id+')">Publish</button>\
    </div>\
';
}//Method askPublishArticle.

//Publish article
function publishArticle(id) {
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            id:id,
            publishArticle:"publishArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();
        },
    });//Ajax.
}//Function publishArticle.







function askUnpublishArticle(id) {
    //toggle overlay
    Toggleoverlay('open',0);

    document.getElementById("overlayBody").innerHTML = '\
    <h2 class="overlay-title">Unpublish Article</h2>\
    <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
    <div class="form-group">  \
      <p>Are you sure you want to unpublish this article?</p>\
    </div>\
    <div class="button-container">\
        <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
        <button class="btn btn-primary" onclick="unpublishArticle('+id+')">Unpublish</button>\
    </div>\
';
}//Method askPublishArticle.

function unpublishArticle(id) {
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            id:id,
            unpublishArticle:"unpublishArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();
        },
    });//Ajax.
}//Function publishArticle.






function editArticle() {
    alert("Coming Later.");
}//Method editArticle.

function askDeleteArticle(id) {
    Toggleoverlay('open',0);

    $('body').bind('touchmove', function(e){e.preventDefault()});
     document.getElementById("overlayBody").innerHTML = '\
     <h2 class="overlay-title">Delete Article</h2>\
     <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
     <div class="form-group">  \
       <p>Are you sure you want to delete this article?</p>\
     </div>\
     <div class="button-container">\
         <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
         <button class="btn btn-primary" onclick="deleteArticle('+id+')">Delete</button>\
     </div>\
 ';
}


function deleteArticle(id) {
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            id:id,
            deleteArticle:"deleteArticle"
        },
        success: function(data) {
            showArticlesToPublish();
            $(".calendar-alert-messages").html(data);
            Toggleoverlay('close',0);
            filterArticles();
        },
    });//Ajax.
}//Method askDeleteArticle.


function calendarLoadMoreArt() {
    //Make sure filters are the same on load more articles.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();
    amount = amount + 10;

    $.ajax({
        type: "POST",
        url: "../classes/handler.class.php",
        data: {
            amount:amount,
            visibility:visibility,
            sort:sort,
            calendarLoadMoreArt:"calendarLoadMoreArt"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });//Ajax.
}




function showArticlesIndex(id,name) {
    //Check if parameter is an integer.
    if(!IsInteger(id)) {
        $(".categories-alert-messages").html("<p class='alert alert-danger' role='alert'>Unknown parameter.</p>");
        return false;
    }//if IsInteger
    
    //Add subcategory to the breadcrumbs.
    if($('#breadcrumbSubcat').length){
        $("#breadcrumbSubcat").html("<a class='index-breadcrumb-button' onclick='showArticlesIndex("+id+",\""+name+"\")'>"+name+"</a>");
    } else {
        $(".breadcrumbs-index").append("<li class='breadcrumb-item active' aria-current='page' id='breadcrumbSubcat'><a class='index-breadcrumb-button' onclick='showArticlesIndex("+id+",\""+name+"\")'>"+name+"</a></li>");
    }
    
    $.ajax({
        type: "POST",
        url: "classes/handler.class.php",
        data: {
            id:id,
            showArticlesIndex:"showArticlesIndex"
        },
        success: function(data) {
            $(".articles-article-overview-container").html(data);
        },
    });//Ajax.
    
}//Method askDeleteArticle.

function toggleAdminNav() {
    if ($('.admin-nav-item').css('display') == 'none') {
        $(".admin-nav-item").slideDown();
    } else {
        $(".admin-nav-item").slideUp();
    }
}
