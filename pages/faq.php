<?php
    include_once("../includes/autoload.inc.php");
    $object = new AutoLoad();

    //Check if user is logged in.
    if(!isset($_SESSION["userID"])) {
        header("Location: ".$linkUrl."index");
    }
?>
<!DOCTYPE html>
<html lang="nl">
    <head>
        <title>Digon | Admin | FAQ</title>
        <?php 
            //Head tags.
            include "../includes/head.inc.php";
        ?>
    </head>
    <body>

        <?php 
            //Header
            include_once "../includes/header.inc.php";
        ?>
        
        <!--Main-->
        <main class="general-main container">

            <!--Navbar for admin pages-->
            <ul class='nav nav-pills admin-navbar'>
                <?php 
                    include_once "../includes/navbar.inc.php";
                ?>
            </ul>
            
           

            <section class="faq-faq-section">
                <i class="fas fa-file text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-0" onclick="toggleFAQ(0)"></i>
                <h2 class="text-primary">Index</h2>
                <article class="faq-section-articles" id="faq-section-article-0">
                <h3>Navigation</h3>
                <p class="counter counter-bullet">
                    The index page refers to the page showing all subcategories. Which subcategories are shown depends on which category you clicked.
                    Once you click on one of the subcategories shown a list of articles of that subcategory will appear.
                    And the breadcrumb navigation bar at the top of the page will now include the subcategory you click on.
                    If you desire to go back you can click on the category name in the breadcrumbs, and the list of articles will dissappear.
                    At last you can click on an article to read the Article. You will then be navigated to the article page.
                </p>
                <h3>Login</h3>
                <p class="counter counter-bullet">
                    Obviously you can't write any articles from the index page and without logging in first. To login you can type '/login' or '?login' in the url.
                    Then you enter. The page will now be reloaded and a dialog box will appear.
                    You can now proceed to loggin in. Once you are logged in the '.login' or '?login' will be removed from the url. 
                    And an extra navigation bar will appear at the top of the screen.
                    You can use this navigation bar to navigate through all the admin pages.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-eye text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-1" onclick="toggleFAQ(1)"></i>
                <h2 class="text-primary">Article</h2>
                <article class="faq-section-articles" id="faq-section-article-1">
                <h3>Article</h3>
                <p class="counter counter-bullet">
                    On the article page you can read the article you clicked on. You can also see that the article title has been added to the breadcrumbs.
                    And depending on the screensize a list with relevant articles will appear above or the the left of the article.
                    These relevant articles are a list of the same articles shown on the index page. All these articles share the same subcategory.
                    You can click on any of these articles to read those articles.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-feather-alt text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-2" onclick="toggleFAQ(2)"></i>
                <h2 class="text-primary">Write</h2>

                <article class="faq-section-articles" id="faq-section-article-2">
                <h3>Writing an article</h3>
                <p class="counter counter-number">
                    On the write page you can write an article. But before you start to write an article you have to save the files you want to include in your article.
                    You can read how to save files at the 'Files' section. 
                    And you have to make sure the category and subcategory of your article exists.
                    You can read how to create a category with subcategories on the 'Category' section.
                </p>
                <p class="counter counter-number">
                    Now that you have everything you can start by writing an article.
                    Writing the article is very easy. The title and summary are at the top.
                    Underneath you can write and style your article anyway you want with CKEditor.
                    And at the bottom you can write the author. The author doesn't need to be you.
                </p>
                <h3>Link</h3>
                <p class="counter counter-bullet">
                    You probably noticed the input with the keywoard 'link'. This value has to be unique for every article, and it refers to the link shown
                    in the url on the article page.
                    So with this input you can style the visibility of the url of your article.
                    But keep in mind, this value has to be alphanumeric and all spaces will be converted to dashes.
                </p>
                <h3>Files</h3>
                <p class="counter counter-bullet">
                    On the write page underneath the CKEditor there are multiple tabs. One of them being 'files', this is not the files section. 
                    Meaning on this tab you can't save you files or create folders. In this tab you can only acces your files to include them in your article. 
                    
                    When you click on the files tab, a explorer like dialog box will appear. Showing all the files and folder. At the top you can see breadcrumbs and the word 'assets'. 
                    'assets' is the root directory where you can store all you files you wish to include in your articles. 
                    When you hover over a file 2 buttons will appear 'copy' and 'insert' If you click on insert the file will be included in the article. 
                    If you click on copy the file link will be copied to your clipboard.

                    If you click on a folder you will go into that subdirectory. And all files and folder of that subdirectory will be displayed. the breadcrumbs will now also show the name of the 
                    subdirectory. By clicking on any of the links on the breadcrumbs you will go back to that subdirectory. Or the root directory if you clicked on 'assets'.
                </p>
                <h3>Category</h3>
                <p class="counter counter-bullet">
                    Next to the 'files' tab there is also a tab 'category'. If you click on this tab a dropdown list with all categories will appear.
                    When you select a category a new dropdown list will appear underneath the already existing dropdown. This new dropdown list shows all the subcategories 
                    of the category you just selected.
                    When you change the category. the dropdown list of the subcategories will also change
                </p>
                <h3>Save</h3>
                <p class="counter counter-number">
                    Now that you have written your article, included all files, selected the category and subcategory you can proceed to change the article.
                    The article will now be saved, not published.
                    You can go to the 'Calendar' section to read how to publish or edit an article.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-folder text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-3" onclick="toggleFAQ(3)"></i>
                <h2 class="text-primary">Files</h2>
                <article class="faq-section-articles" id="faq-section-article-3">
                <h3>Files</h3>
                <p class="counter counter-bullet">
                    In this section you will read on how to add or delete folders and files. If you want to know how to navigate through the files explorer dialog you can go the 
                    'files' title in the 'Write' section.
                </p>
                <p class="counter counter-bullet">
                    Once on the files page, there will be an explorer dialog showing all the files and folder of the root directory 'assets'. You should already know and recognize this
                    from the 'files' title on the 'Write' section.
                    the main difference here is that above the explorer dialog are 2 buttons. 1 to add a folder and 1 to add a file.
                    Go the the subdirectory where you want to save your folder or uplaod your file and click the corresponding button. 
                    Then you can add/upload the file/folder and the file/folder will appear in the current subdirectory.
                </p>
                <p class="counter counter-bullet">
                    The name of the file and folder has to be between the 3 and 30 characters long, and be alphanumeric. This does not include the extension of the file.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-book text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-4" onclick="toggleFAQ(4)"></i>
                <h2 class="text-primary">Categories</h2>
                <article class="faq-section-articles" id="faq-section-article-4">
                <h3>Categories</h3>
                <p class="counter counter-bullet">
                    On the category page you can view all the existings categories with their subcategories. And you can create/delete 
                    categories or subcategories.
                    To add a category you click on the button at the top. a Dialogbox will appear asking for the name of the category. Once you've entered the name
                    and clicked on add, the category will now be visible next to the already existing categories. To add a subcategory you enter the name
                    in the inputbox underneath the category and press the green check icon.
                    If you want to delete a category, you first have to delete all the subcategories belonging to that category. You can do this by hovering over the 
                    category container. Trash cans will appear on hover. Click those trash cans to delete the subcategories.
                    Once all subcategories have been deleted you can click on the trash can corresponding to the category.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-calendar-minus text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-5" onclick="toggleFAQ(5)"></i>
                <h2 class="text-primary">Calendar</h2>
                <article class="faq-section-articles" id="faq-section-article-5">
                <h3>Calendar</h3>
                <p>
                    The calendar page is a big page, in the sense it has a lot of functionality. You can view all the articles on the calendar page. No matter
                    if the article is saved, published or even deleted. You can sort and filter these articles on there status (saved,...) and sort them on their creation time.
                    the main purpose of the calendar page is to publish or edit articles. But you can also delete or unpublish the articles.
                </p>
                <h3>Publish & unpublish</h3>
                <p class="counter counter-bullet">
                    To publish an article you simple have to search for the correct article and click on the publish icon, Then you can select on which media platforms you
                    want to publish the article. And click on publish.
                    Unpublish works the same, you click on unpublish and the article will be unpublished. But keep in mind not all media platforms allow articles to be unpublished.
                    Once an article is unpublished you cannot see the article on the index page.
                    But you can navigate to the article by typing the correct link keyword <small>Read the link tab in the write section</small> in the url. If you know the url atleast.
                    If an article is deleted you can NOT find the article anymore even if you have the correct url. 
                    The reason you can still find unpublished articles is because not all media platforms allow an article to be unpublished. This way the link to the article will still
                    be valid.
                </p>
                <h3>Delete</h3>
                <p class="counter counter-bullet">
                    Unlike unpublishing an article once deleted the article cannot be undeleted from the interface, this will have to be done manually in the database. This is done because
                    deleting an article should be permanent. You also can't find the article anymore by the corresponding url once the article has been deleted, if an article is unpublished this is possible.
                </p>
                <h3>Edit</h3>
                <p class="counter counter-bullet">
                    To edit an article you can simply click on the edit button in the calendar page. This will redirect you to the write page. but all the inputboxes, textareas, etc.. are already filled in 
                    with the article you chose to edit. You can now edit the article, and save it afterwards. The article has now been edited.
                </p>
                </article>
            </section>

            <section class="faq-faq-section">
                <i class="fas fa-user text-primary"></i>
                <i class="fas fa-angle-down faq-angle" id="faq-angle-6" onclick="toggleFAQ(6)"></i>
                <h2 class="text-primary">Account</h2>
                <article class="faq-section-articles" id="faq-section-article-6">
                <h3>Account</h3>
                <p>
                    The account page is also a large page with a lot of functionality. You can change your account information such as, your password, username and displayname.
                    You can also see a list with all existing accounts. And you can add an account.
                </p>
                <h3>Change account information</h3>
                <p class="counter counter-bullet">
                    The change account information section will and can only change the information of the user that is currently logged in. To change the account information of another account
                    you need acces to that account. Change the account information is simple, You simply fill in all the inputboxes and click on change.
                </p>
                <h3>Account list</h3>
                <p class="counter counter-bullet">
                    The table that lists all accounts, has no functionality other then showing all accounts yet.
                </p>
                <h3>Add an account</h3>
                <p class="counter counter-bullet">
                    To add an account you fill in all the inputboxes, and the account will be added. The function of that account will automatically be 0 (moderator). 
                    There is only one pre-existing account with function 1 (admin). And has no functions then being the root account.
                </p>
                </article>
            </section>
           
        </main>
  
    </body>
</html>


