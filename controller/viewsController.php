<?php 

require_once "./model/viewsModel.php";

class viewsController extends viewsModel{
    
    public function getTempleController(){
        return include("./views/temple.php");
    }

}