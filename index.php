<?php 

    include('core/configGeneral.php');
    include('controller/viewsController.php');
    
    $temple = new viewsController();
    $temple->getTempleController();
    
    