//Global variables
teller = 0;
subcatLevels = 0;


/*All function about the explorer window*/

//This function open is subdir in the dir
function DirClick(dirName,admin) {
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
        url: "../php/lookindir.php",
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
    //Check if dirname only contains alphanumeric values
    //extra validation with PHP is also done, so don't bother changing this in page inspect
    if (dirName.match(/[^a-zA-Z0-9 ]/g) || !dirName) {
        document.getElementById("overlaySmall").style.color = "red";
        return false;
    }
    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();
    //Call ajax
    $.ajax({
        type: "GET",
        url: "../php/createdir.php",
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


//This function is called by multiple functions and returns the path of the current dir that is opened
function CreatePath() {
    //Declare Array
    var aPath = new Array();
    //Gp through all breadcrumbs data-values and add to array, then afterwards pass to php
    for (i=0;i<=teller;i++) {
        relativePath = document.getElementById("breadcrumbs-"+i).getAttribute('data-value');
        aPath.push(relativePath);
    }//for
    return aPath;
}//Function CreatePath

//Upload a file function
function UploadFile() {
    //Get all data from input file
    var property = document.getElementById("file").files[0];
    var file_name = property.name;
    var file_extension = file_name.split('.').pop().toLowerCase();

    //Check if file is image/pdf
    if(jQuery.inArray(file_extension, ['jpg','jpeg','png','pdf']) == -1) {
        //invalid extension
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
        url: "../php/uploadfile.php",
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
    $.ajax({
        type: "GET",
        url: "../php/deletefolderorfile.php",
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
        default:
            break;
    }//switch
}//function toggleoverlay

//Insert the file into ckeditor
function InsertFile(path,fileName,type) {
    //Check if file is an image or pdf, and copy
    if (type == "pdf")
        copyText = '<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a>';
        //CKEDITOR.instances.ckeditor.insertText('<a href="'+path+'/'+fileName+'" class="pdf-ckeditor-a">'+fileName+'</a> <br>');
    else 
        copyText = '<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor">';
        //CKEDITOR.instances.ckeditor.insertText('<img src="'+path+'/'+fileName+'" alt="'+fileName+'" class="images-ckeditor"> <br>');
    
    //Copy the text to your clipboard
    var inp =document.createElement('input');
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
    inp.remove();
}//function Insertfile







/*Functions about categories and subcategories*/
function ShowSubCategories(level,parent_id) {
    
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
                //Add new data in the class, timeout is to let user know the subcategory selection has changed
                setTimeout(function() {
                    $("#sub-category-level-"+level).append(data); 
                }, 300);
                
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