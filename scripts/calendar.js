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
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Publish Article";
    body = "<p>Are you sure you want to publish this article?</p>";
    button = " <button class='btn btn-primary' onclick='publishArticle("+id+")'>Publish</button>";
    openDialog(heading,body,button);
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
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Unpublish Article";
    body = "<p>Are you sure you want to unpublish this article?</p>";
    button = "<button class='btn btn-primary' onclick='unpublishArticle("+id+")'>Unpublish</button>";
    openDialog(heading,body,button);
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
function editArticle(id) {
    window.location = linkUrl+"write/"+id;
}//Function editArticle.

//Ask to delete article.
function askDeleteArticle(id) {
    //Open the overlay.
    Toggleoverlay('open',0);

    //Set the correct content in the dialog.
    heading = "Delete Article";
    body = "<p>Are you sure you want to delete this article?</p>";
    button = "<button class='btn btn-primary' onclick='deleteArticle("+id+")'>Delete</button>";
    openDialog(heading,body,button);
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
