<?php
session_start();

require('includes/connect.php');
require('includes/functions.php');
require('includes/emails.php');


if ($_SERVER["REQUEST_METHOD"] == "GET") {
	if (count($_GET) == 2 AND isset($_GET['code']) && !empty($_GET['code']) AND ( (isset($_GET['mail']) && !empty($_GET['mail'])) || (isset($_GET['user']) && !empty($_GET['user'])))) {

		//Guardamos los datos en sesiones para poderlos usar en el POST
		$_SESSION['pswCodeHASH'] = $hash = filter_input(INPUT_GET, 'code');

		if (isset($_GET['user'])) {
			$user = obtenerMail($_GET['user']);
			$_SESSION['userPSW'] = $usernameMail = filter_input(INPUT_GET, 'user');
		} else {
			$user = $_GET['mail'];
			$_SESSION['userPSW'] = $usernameMail = filter_input(INPUT_GET, 'mail');
		}

		//Compruebo si existe el usuario, el codigopsw y si el tiempo es menor a 30min
		if (!(compruebaUsuMail($user) > 0) AND ! (existeCodigoPsw($user, $_GET['code'])) > 0 AND ! (compruebaValidezPswCode($usernameMail, $_GET['code']))) {
			header('Location: index.php');
			exit;
		}
	} else {
		header('Location: index.php');
		exit;
	}
} else if ($_SERVER["REQUEST_METHOD"] == "POST") {

	$pswCode = $_SESSION['pswCodeHASH'];
	$usernameMail = $_SESSION['userPSW'];

	if (filter_var($usernameMail, FILTER_VALIDATE_EMAIL))
		$mail = $usernameMail;
	else
		$mail = obtenerMail($usernameMail);
	if (!(compruebaValidezPswCode($usernameMail, $pswCode))) {
		$password = filter_input(INPUT_POST, 'primerapass');
		$verifypass = filter_input(INPUT_POST, 'segundapass');

		if ($password == $verifypass) {
			if (!pswIgual($usernameMail, $password)) {
				$newPsw = password_hash($password, PASSWORD_DEFAULT);
				nuevaPswHasheada($usernameMail, $newPsw);
				enviarMailContrasenyaCanviada($mail);
				resetearDatosPsw($usernameMail);
			}else $error=true;
		}else $error=true;
	}else $error=true;
	
	if(isset($error)) enviarMailCanceladoPassword($mail);
	
	resetearDatosPsw($usernameMail);
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE html>
<html lang="es">
	<head>
		<title>IMAGINEST</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!--===============================================================================================-->	
		<link rel="icon" type="image/png" href="images/icons/imaginlogo.png"/>
		<!--===============================================================================================-->	
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
		<!--===============================================================================================-->
		<link rel="stylesheet" type="text/css" href="assets/utilogin.css">
		<link rel="stylesheet" type="text/css" href="assets/login.css">
		<!--===============================================================================================-->
	</head>
	<body class="bg-dark">

		<div class="limiter">
			<div class="container-login100" style="background-image: url('images/BG-login.jpg');">
				<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">

					<span class="login80-form-title p-b-40">
						Cambiar Contraseña
					</span>

					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
						<div class="wrap-input100 validate-input m-b-23" data-validate = "Password is required">
							<label for="primerapass" class="form-label fw-bold">Nueva Contraseña</label>
							<input type="password" name="primerapass" class="input80" id="primerapass" placeholder="Introduzca la Contraseña" autocomplete="off">
						</div>
						<div class="mb-4">
							<label for="segundapass" class="form-label fw-bold">Verificar Contraseña</label>
							<input type="password" name="segundapass" id="segundapass" class="input80" placeholder="Repita la Contraseña">
						</div>
						<button type="submit" class="btn btn-primary w-100 fw-bold mb-4" name="resetPswd">Enviar</button>
					</form>

				</div>
			</div>
		</div>

	</body>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</html>
