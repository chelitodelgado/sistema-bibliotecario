<?php

$ajaxP = true;

require_once "../core/configGeneral.php";

if( isset($_GET['Token']) ){
    
    require_once "../controller/loginController.php";
    $logout = new loginController();
    echo $logout->sessionCloseController();

} else {
    
    session_start();
    session_destroy();
    echo '<script> window.location.href="'.SERVERURL.'login/" </script>';

}
