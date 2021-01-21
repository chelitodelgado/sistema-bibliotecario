<?php 

require_once "./model/viewsModel.php";

class viewsController extends viewsModel{
    
    public function getTempleController(){
        return include("./views/temple.php");
    }

    public function getViewsController() {

        if( isset($_GET['views']) ){
            $path = explode("/", $_GET['views'] );
            $resp = viewsModel::getViewsModel($path[0]) ;
        } else {
            $resp = "login";
        }

        return $resp;

    }

}