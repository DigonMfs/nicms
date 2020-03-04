//Global variables.
var teller = 0;
var subcatLevels = 0;

class Files {

    //Open a subdir.
    DirClick(dirName,admin) {
        var formData = new FormData();

        if (!CreatePath()) {
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed!</p>");
            return false;
        }

        //If function is called after creating folder 'dirName' will be undefined.
        if (dirName) {
            teller++;
            document.getElementById("breadcrumbs").innerHTML += '<li class="breadcrumb-item bread-crumb-item"><a class="bread-crumb-links" id="breadcrumbs-'+teller+'" data-value="'+escape(dirName)+'" onclick="BaseDir('+teller+','+admin+')">'+dirName+'</a></li>';
        }

        aPath = FunctionsObj.CreatePath();

        formData.append("aPath", aPath);
        formData.append("admin", admin);
        formData.append("dirClick", "dirClick");

        if(FunctionsObj.ajaxHandler(formData)) {
            $(".files-directory-body").html(data);
        } else {
            $(".files-directory-body").html("Did not complete.");
        }
    }//Method DirClick.



    //Go back in subdirs.
    BaseDir(cur_level,admin) {
        for (i=cur_level;i<teller;i++) {
            $(".bread-crumb-item").eq(cur_level+1).remove();
        }
        //Reset global var teller to cur_level.
        teller = cur_level;
        
        this.DirClick(undefined,admin);
    }//Function BaseDir



    //Create a folder.
    CreateDir() {
        var formData = new FormData();
        var FunctionsObj = new Functions;
        dirName = document.getElementById("dirName").value;

        //Check if dirname is not empty, and is alphanumeric.
        if (!FunctionsObj.IsAlphaNumeric(FunctionsObj.StripSpaces(dirName)) || !dirName) {
            document.getElementById("overlaySmall").style.color = "red";
            return false;
        }
        
        //Call CreatePath function and get the path from homeDirectory to current dir in an array
        aPath = CreatePath();
        aPath.join(',');

        formData.append("aPath", aPath);
        formData.append("dirName", dirName);
        formData.append("createDir", "createDir");

        if(FunctionsObj.ajaxHandler(formData)) {
            $(".files-alert-messages").html(data);
            FunctionsObj.Toggleoverlay('close',0);
            this.DirClick(undefined,true);

        } else {
            $(".files-directory-body").html("Did not complete.");
        }
    }//Method CreateDir.


    //Upload a file.
    UploadFile() {
        var property = document.getElementById("file").files[0];
        var file_name = property.name;
        var file_extension = file_name.split('.').pop().toLowerCase();
        var formData = new FormData();
        var FunctionsObj = new Functions;
    
        //Check if file is image/pdf.
        if(jQuery.inArray(file_extension, ['jpg','jpeg','png','pdf']) == -1) {
            //Invalid extension.
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This file is not an image or a pdf file.</p>");
            FunctionsObj.Toggleoverlay('close',0);
            return false;
        }
        
        //Check if file is not too big.
        if (property.size > 5000000) {
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>File is too big.</p>");
            FunctionsObj.Toggleoverlay('close',0);
            return false;
        }
        
        formData.append('file', property);
        aPath = FunctionsObj.CreatePath();
        aPath.join(',');
        formData.append('aPath', aPath);
        formData.append('uploadFile', 'uploadFile');

        if(FunctionsObj.ajaxHandler(formData)) {
            $(".files-alert-messages").html(data);
            FunctionsObj.Toggleoverlay('close',0);   
            this.DirClick(undefined,true);

        } else {
            $(".files-directory-body").html("Did not complete.");
        }
    }//Method UploadFile.


    //Ask to delete a file or folder.
    AskDelete(dirPath,fileName,type) {
        //Open overlay.
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
            
        //Put in Correct Content.
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
    }//Method AskDelete.


    //Delete the file or folder.
    Delete(dirPath,fileName,type) {
        var formData = new FormData();
        var FunctionsObj = new Functions;

        //Check if al parameters exist.
        if (!dirPath || !fileName || !type) {
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Not all parameters are valid</p>");
            return false;
        }

        //Check if alphanumeric.
        if (!FunctionsObj.IsAlphaNumeric(FunctionsObj.StripAlphaNumeric(dirPath)) || !FunctionsObj.IsAlphaNumeric(FunctionsObj.StripAlphaNumeric(fileName)) || !FunctionsObj.IsAlphaNumeric(type)) {
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>Parameters container forbidden characters</p>");
            return false;
        }
        
        //Check if dirpath starts with the folder "assets".
        if (!dirPath.startsWith("../assets")) {
            $(".files-alert-messages").html("<p class='alert alert-danger' role='alert'>This path is not allowed</p>");
            FunctionsObj.Toggleoverlay('close',0);
            return false;
        }

        formData.append('dirPath', dirPath);
        formData.append('fileName', fileName);
        formData.append('type', type);
        formData.append('deleteFileFolder', 'deleteFileFolder');

        if(FunctionsObj.ajaxHandler(formData)) {
               $(".files-alert-messages").html(data);
               FunctionsObj.Toggleoverlay('close',0);
               this.DirClick(undefined,true);

        } else {
            $(".files-directory-body").html("Did not complete.");
        }
    }//Method Delete.



    //Insert the file into ckeditor.
    InsertFile(path,fileName,type) {
        if (type == "pdf")
            CKEDITOR.instances.ckeditor.insertHtml('<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a> <br>');
        else 
            CKEDITOR.instances.ckeditor.insertHtml('<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor"> <br>');
    }//Method Insertfile.

    

    //Copy file to clipboard.
    copyFile(path,fileName,type) {
        var inp =document.createElement('input');
        document.body.appendChild(inp)
        
        if (type == "pdf") {
            copyText = '<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a>';
        } else {
            copyText = '<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor">';
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
    }//Method copyFile.
    
}//Files.





class Categories {

    ShowSubCategories(value) {
        /*
            *Onclick event on an option inside a select, does not work with chrome. The solution i used is an onchange event on the select itself.
            *Using this solution i can only send 1parameter trough value="". Since all the parameters are integers I seperated them with a comma.
            *And thus I will need to split them.
        */
        var formData = new FormData();
        var FunctionsObj = new Functions;
        aValue = value.split(',');
        level = aValue[0];
        parent_id = aValue[1];
            
        //Category has been selected/reselected, so remove the error/succes message.
        $("#categoriesInfoMessages").remove();

        formData.append('level', level);
        formData.append('parent_id', parent_id);
        formData.append('showSubcategories', 'showSubcategories');

        if(FunctionsObj.ajaxHandler(formData)) {
            if($("#sub-category-level-"+level).length !== 0) {
                //Clear the data in the class.
                $("#sub-category-level-"+level).empty();
                //Add new data in the class.
                $("#sub-category-level-"+level).append(data); 
        
            } else {
                //Create class and add data into it.
                $(".container-subcategories").append("<div class='write-categories-container' id='sub-category-level-"+level+"'>"+data+"</div>");
                subcatLevels++;
            }//if id exists.

        } else {
            $(".files-directory-body").html("Did not complete.");
        }
    }//Method ShowSubCategories.
    

}//Categories.





class Functions {

    ajaxHandler(formData) {
        $.ajax({
            type: "GET",
            url: "../classes/handler.class.php",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            fail: function() {
                return false;
            },
            success: function(data) {
                return true;
            },
        });//ajax
    }//Method ajaxHandler.

    IsAlphaNumeric(value) {
        if (! /^[a-zA-Z0-9]+$/.test(value)) {
            return false;
        } else {
            return true;
        }
    }//Method IsAlphanumeric.

    StripAlphaNumeric(value) {
        return value.replace(/[\W_]+/g,"");
    }//Method StripAlphaNumeric.

    StripSpaces(value) {
        return value.replace(/ /g,"");
    }//Method StripSpaces.

    ValidateLength(value,min,max) {
        if (value.length < min || value.length > max) {
            return false;
        } else {
            return true;
        }
    }//Method ValidateLength.

    IsInteger(value) {
        return Number.isInteger(value);
    }//Method IsInteger.

    CreatePath() {
        var aPath = new Array();
    
        //Go through all breadcrumbs data-values and add to array, then afterwards pass to php.
        for (i=0;i<=teller;i++) {
            relativePath = document.getElementById("breadcrumbs-"+i).getAttribute('data-value');
            //Check if first dir == "assets".
            if (i == 0) {
                if (relativePath != "assets") {
                    return false;
                }
            }
            aPath.push(relativePath);
        }
        return aPath;
    }//Method CreatePath.



    Toggleoverlay(toggle,content) {
        //Check if close or open is clicked.
        if (toggle == "close") {
            //Close overlay.
            $(".overlay-wrapper").fadeOut();
            $(".overlay-box").css({
                'margin-top' : '0px'
            });
            return false;
    
        }else if(toggle == "open") { 
            //Open overlay.
            $(".overlay-wrapper").fadeIn();
            $(".overlay-box").css({
                'margin-top' : '100px'
            });
    
        } else {
            alert("Unknown parameter.");
            return false;
        }//If val==0.
    
        //Change content of the overlay.
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
                        <button class="btn btn-primary" onclick="SaveCategory(0)">Save</button>\
                    </div>\
                ';
                break;
            default:
                break;
        }//Switch.
    }//Method toggleoverlay.
  

}//Functions