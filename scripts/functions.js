//Function checks if parameter is alphanumeric
function IsAlphaNumeric(value) {
    if (! /^[a-zA-Z0-9]+$/.test(value)) {
        return false;
    } else {
        return true;
    }
}//funcion IsAlpheNummeric


function StripAlphaNumeric(value) {
    return value.replace(/[\W_]+/g,"");
}//function StripAlphaNumeric

function StripSpaces(value) {
    return value.replace(/ /g,"");
}//function StripSpaces

function ValidateLength(value,min,max) {
    //check if length of the value is correct
    if (value.length < min || value.length > max) {
        return false;
    } else {
        return true;
    }//if test length
}//function ValidateLength

function IsInteger(value) {
    return Number.isInteger(value);
}//function IsInteger


//This function is called by multiple functions and returns the path of the current dir that is opened
function CreatePath() {
    //Declare Array
    var aPath = new Array();
    //Gp through all breadcrumbs data-values and add to array, then afterwards pass to php
    for (i=0;i<=teller;i++) {
        //Get all dirs
        relativePath = document.getElementById("breadcrumbs-"+i).getAttribute('data-value');

        //Check if first dir == "assets"
        if (i == 0) {
            if (relativePath != "assets") {
                return false;
            }//if != assets
        }//if i == 0

        //Join path to array
        aPath.push(relativePath);

    }//for
    return aPath;
}//Function CreatePath

function ListCategories() {
    $.ajax({
        type: "GET",
        url: "../php/categories-page/listcategories.php",
        data: {
            categoryName:categoryName
        },
        success: function(data) {
            $(".categories-category-container").html(data);
        },
    });//ajax
}


//This function toggles the visibility of the overlay, and the correct content
function Toggleoverlay(toggle,content) {
    //check if close or open is clicked
    if (toggle == "close") {
        //close overlay
        $(".overlay-wrapper").fadeOut();
        $(".overlay-box").css({
            'margin-top' : '0px'
        });

    }else if(toggle == "open") { 
        //Open overlay
        $(".overlay-wrapper").fadeIn();
        $(".overlay-box").css({
            'margin-top' : '100px'
        });

    } else {
        alert("Unknown parameter 1");
        return false;
    }//if val==0

    //Change content of the overlay
    switch (content) {
        case 1:
            document.getElementById("overlayBody").innerHTML ='\
                <h2 class="overlay-title">Create Directory</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">\
                    <label for="dirName">Directory Name</label>\
                    <input type="text" class="form-control" id="dirName" placeholder="Enter Name">\
                    <small id="overlaySmall" class="overlay-small">The name must be alphanumeric, spaces will be replaced with underscores. The length must be between 1 and 30</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="CreateDir()">Create</button>\
                </div>\
            ';
            break;
        case 2:
            document.getElementById("overlayBody").innerHTML ='\
                <h2 class="overlay-title">Upload File</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">\
                    <label for="dirName">Select File</label><br>\
                    <input type="file" name="file" id="file" accept="image/jpeg,image/png,application/pdf,image/jpg"><br>\
                    <small id="overlaySmall" class="overlay-small">Only images (jpg,jpeg,png) and pdf files are allowed, The name of the\
                    file has to be alphanumeric. And the length has to be between 1 and 30</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="UploadFile()">Upload</button>\
                </div>\
            ';
            break;
        case 3:
            document.getElementById("overlayBody").innerHTML = '\
                <h2 class="overlay-title">Add Category</h2>\
                <i class="fas fa-times close-overlay" onclick="Toggleoverlay(\'close\',0)"></i>\
                <div class="form-group">  \
                    <label for="categoryName">Category name</label>\
                    <input type="text" class="form-control" id="categoryName" placeholder="Enter Category..">\
                    <small>The name must be alphanumeric, spaces are allowed. And the name has to be between 3 and 30 characters</small>\
                </div>\
                <div class="button-container">\
                    <button class="btn btn-secondary" onclick="Toggleoverlay(\'close\',0)">Close</button>\
                    <button class="btn btn-primary" onclick="SaveCategory()">Save</button>\
                </div>\
            ';
            break;
        default:
            break;
    }//switch
}//function toggleoverlay