

<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo COMMPANY; ?></title>
	<meta charset="UTF-8">
	<link rel="shortcut icon" type="image/x-icon" href="<?php ECHO SERVERURL; ?>views/favicon.ico" />
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?php ECHO SERVERURL; ?>views/css/main.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <?php include('views/modules/scripts.php') ?>
</head>
<body>

<?php 

    $ajaxP = false;
    
    $vt = new viewsController();
    $viewsR = $vt->getViewsController();
    if($viewsR=="login" || $viewsR=="404"):
        if($viewsR=="login") {
            include("./views/pages/login-view.php");
        }else {
            include("./views/pages/404-view.php");
        }
    else:
        session_start(['name'=>'SBP']);

        require_once "./controller/loginController.php";

        $lc = new loginController();
        if( !isset( $_SESSION['token_SBP'] ) || !isset($_SESSION['usuario_SBP']) ){
            $lc->destroySessionController();
        }
    ?>
    
    <?php include('modules/header.php');  ?>
    
    <!-- Content page-->
    <section class="full-box dashboard-contentPage">

        <!-- NavBar-->
        <?php include('views/modules/navbar.php') ?>
        <!-- Content page -->
        <?php require_once $viewsR ?>

    </section>
    <?php include('views/modules/logoutScript.php') ?>

    <?php endif; ?>

<?php include('modules/footer.php'); ?>
