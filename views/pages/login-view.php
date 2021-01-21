
<!DOCTYPE html>
<html lang="es">
<head>
	<title><?php echo COMMPANY; ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link rel="stylesheet" href="<?php ECHO SERVERURL; ?>views/css/main.css">
	<?php include('./views/modules/scripts.php') ?>
</head>
<body>
	<div class="full-box login-container cover">
		<form action="" method="POST" autocomplete="off" class="logInForm">
			
			<p class="text-center text-muted"><i class="zmdi zmdi-account-circle zmdi-hc-5x"></i></p>
			<p class="text-center text-muted ">Inicia sesión</p>

			<div class="form-group label-floating">
				<label class="control-label" for="UserName">Usuario</label>
				<input class="form-control textcolorwhite" id="UserName" name="usuario" type="text" autofocus>
				<p class="help-block">Escribe tú nombre de usuario</p>
			</div>

			<div class="form-group label-floating">
				<label class="control-label" for="UserPass">Contraseña</label>
				<input class="form-control textcolorwhite" id="UserPass" name="password" type="password">
				<p class="help-block">Escribe tú contraseña</p>
			</div>

			<div class="form-group text-center">
				<input type="submit" value="Iniciar sesión" class="btn btn-info" style="color: #FFF;">
			</div>

		</form>
	</div>

	<?php 
		if( isset($_POST['usuario']) && isset($_POST['password']) ) {
			require_once "./controller/loginController.php";
			$login = new loginController();
			echo $login->startSessionController();
		}
	?>
<script>
    $.material.init();
</script>
</body>
</html>