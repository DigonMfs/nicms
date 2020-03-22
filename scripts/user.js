//Open login dialox box on the index page.
function openLogindialog() {
    //Check if the url contains "login".
    url = window.location.href;
    if (!url.includes("login")) {
        return false;
    }

    //Open overlay.
    $(".overlay-wrapper").fadeIn();
    $(".overlay-box").css({
        'margin-top' : '100px'
    });

    //Put in Correct Content.
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
}//Function openLoginDialog.

//Log the user in.
function login() {
    //Get the username and password.
    username = document.getElementById("username").value;
    password = document.getElementById("password").value;

    //Validate the username and password.
    if (username == "" || password == "") {
        $("#loginMessage").html("Values are empty.");
        return false;
    }
    if (!IsAlphaNumeric(username) || !IsAlphaNumeric(password)) {
        $("#loginMessage").html("Values are not alphanumeric.");
        return false;
    }

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            username:username,
            password:password,
            login:"login"
        },
        success: function(data) {
            //remove "/login" or "?login" from the url.
            newURL = url.replace("?login", "");
            newURL = newURL.replace("/login", "");
            document.location.href = newURL;
            Toggleoverlay('close',0);
        },
    });
}//Function login.

//Log the user out.
function logout() {
    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            logout:"logout"
        },
        success: function(data) {
           location.reload();
        },
    });
}//Function logout.