<?php 
    session_start();
    
    //Variable containing the entire path to the website.
    $linkUrl = "//localhost/Websites/nicms/";

    interface AutoloadInterface {
        public function __construct();
    }

    class Autoload implements AutoloadInterface {
        //Properties
        private $url;
        protected $path;

        //Methods.
        public function __construct() {
            $this->url = $_SERVER["HTTP_HOST"] . $_SERVER['REQUEST_URI'];

            if (strpos($this->url,'classes') == TRUE) {
                $this->path = "";
            } else if (strpos($this->url,'pages') == TRUE) {
                $this->path = "../classes/";
            } else {
                $this->path = "classes/";
            }

            include_once($this->path."dbh.class.php");
            //include_once($this->path."handler.class.php");
            include_once($this->path."functions.class.php");

            include_once($this->path."user.class.php");
            include_once($this->path."usercontr.class.php");
            include_once($this->path."userview.class.php");

            include_once($this->path."write.class.php");
            include_once($this->path."writecontr.class.php");
            include_once($this->path."writeview.class.php");

            include_once($this->path."category.class.php");
            include_once($this->path."categoryview.class.php");
            include_once($this->path."categorycontr.class.php");
            
            include_once($this->path."filesview.class.php");
            include_once($this->path."filescontr.class.php");

            include_once($this->path."article.class.php");
            include_once($this->path."articleview.class.php");
            include_once($this->path."articlecontr.class.php");

        }//Method __construct.
    }//Autoload.
