teller = 0;



//This function open is subdir in the dir
function DirClick(dirName) {
    //if function is called after creating folder 'dirName' will be undefined
    if (dirName) {
        teller++;
        document.getElementById("breadcrumbs").innerHTML += '<li class="breadcrumb-item"><a id="breadcrumbs-'+teller+'" data-value="'+escape(dirName)+'">'+dirName+'</a></li>';
    }

    //Call CreatePath function and get the path from homeDirectory to current dir in an array
    aPath = CreatePath();

    //Execute Ajax
    $.ajax({
        type: "GET",
        url: "../php/lookindir.php",
        data: {aPath:aPath},
        success: function(data) {
            $(".files-directory-body").html(data);
        },
    });//ajax

}//function DirClick



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
            DirClick();
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
            //close overlay
            Toggleoverlay('close',0);
            //Go in to the created dir
            DirClick();
        }//succes
    });//ajax
}//function


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
            //Go in to the created dir
            DirClick();
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
                    <small id="overlaySmall" class="overlay-small">Only images (jpg,jpeg,png) and pdf file are allowed</small>\
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