<?php 

class viewsModel {

    protected function getViewsModel( $views ) {

        $list = [
            "admin",
            "adminlist",
            "adminsearch",
            "book",
            "bookconfig",
            "bookinfo",
            "catalog",
            "category",
            "categorylist",
            "client",
            "clientlist",
            "clientsearch",
            "company",
            "companylist",
            "home",
            "myaccount",
            "mydata",
            "provider",
            "providerlist",
            "search",
            "404"
        ];

        if( in_array($views, $list) ) {

            if( is_file("./views/pages/".$views."-view.php") ) {
                $container = "./views/pages/".$views."-view.php";
            }else {
                $container = "login";
            }

        }elseif($views == "login") {
            $container = "login";
        }elseif($views == "index") {
            $container = "login";
        }else {
            $container = "404";
        }

        return $container;
    }


}