<?php 

    #MVC MODEL
            //DB.class.php
            class db {
                $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            }
            //category.class.php
            class category extends db {
                protected function getCategories() {
                    $sql = "SELECT * FROM category";
                    return $this->connect()->query($sql);
                }
            }   
            //categoryview.contr.php
            class categoryview extends category {
                public function showCategories() {
                    echo $result = $this->getCategories();
                }
            }
            //categorycontr.php
            class categorycontr extends category {
                public function createCatSubcat($catSubcatName,$parent_id) {
                    $this->setCatSubcat($catSubcatName,$parent_id))
                    echo "success"; 
                }
            }
    




    #Solution 1
        //catsubcat.class.php
        class catsubcat {
            public function setCatAndSubcat();
            public function getCatAndSubcat();
            public function delCatAndSubcat();

            class cat {
                public function setCat();
                public function getCat();
                public function delCat();
            }
            class subcat {
                public function setSubcat();
                public function getSubcat();
                public function delSubcat();
            }
        }
    





    #Solution 2
        //catsubcat.class.php
        class catsubcat {
            public function setCatAndSubcat();
            public function getCatAndSubcat();
            public function delCatAndSubcat();
        }
        //cat.class.php
        class cat {
            public function setCat();
            public function getCat();
            public function delCat();
        }
        //subcat.php
        class subcat {
            public function setSubcat();
            public function getSubcat();
            public function delSubcat();
        }







    #solution 3 -> I use this one
        //cat.class.php
        class cat {
            public function setCatAndSubcat();
            public function getCatAndSubcat();
            public function delCatAndSubcat();

            public function setCat();
            public function getCat();
            public function delCat();

            public function setSubcat();
            public function getSubcat();
            public function delSubcat();
        }

?>