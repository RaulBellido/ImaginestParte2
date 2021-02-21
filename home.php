<?php
session_start();

if (!isset($_SESSION['username']))header('Location: index.php');

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
	<body>

		<div class="limiter">
			<div class="container-login100" style="background-image: url('images/BG-login.jpg');">
				<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">
					<a class="nav-link" href="cerrarSesion.php">Cerrar Session</a>
				</div>
			</div>
		</div>

	</body>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
</html>
