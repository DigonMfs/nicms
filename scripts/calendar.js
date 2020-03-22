//Show articles to publish.
function showArticlesToPublish() {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: "../classes/handler.class.php",
        data: {
            showArticlesToPublish:"showArticlesToPublish"
        },
        success: function(data) {
            $(".calendar-topublish-articles-container").html(data);
        },
    });
}//Function showArticlesToPublish.

//Filter the articles on the calendar page.
function filterArticles() {
    //Get the values.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            visibility:visibility,
            sort:sort,
            filterArticles:"filterArticles"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });
}//Function filterArticles.

//Ask to publish the article.
function askPublishArticle(id) {
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
}//Function askPublishArticle.

//Publish article.
function publishArticle(id) {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
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
    });
}//Function publishArticle.

//Ask to unpublish article.
function askUnpublishArticle(id) {
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
}//Function askPublishArticle.

//Unpublish te article.
function unpublishArticle(id) {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
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
    });
}//Function publishArticle.

//Function editArticle.
function editArticle() {
    alert("Coming Later.");
}//Function editArticle.

//Ask to delete article.
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
}//Function askDeleteArticle.

//Delete the article.
function deleteArticle(id) {
    //Call ajax.
    $.ajax({
        type: "GET",
        url: linkUrl+"classes/handler.class.php",
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
    });
}//Function deleteArticle.

//Load more articles on the calendar page.
function calendarLoadMoreArt() {
    //Get values. And make sure the filters still apply after the load more.
    visibility = $("#selectSortArticles").val();
    sort = $("#selectFilterArticles").val();
    amount = amount + 10;

    //Call ajax.
    $.ajax({
        type: "POST",
        url: linkUrl+"classes/handler.class.php",
        data: {
            amount:amount,
            visibility:visibility,
            sort:sort,
            calendarLoadMoreArt:"calendarLoadMoreArt"
        },
        success: function(data) {
            $("#calendarArticlesContainer").html(data);
        },
    });
}//Function calendarLoadMoreArt.
