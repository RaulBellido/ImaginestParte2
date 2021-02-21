<?php

use PHPMailer\PHPMailer\PHPMailer;

require ('vendor/autoload.php');

function enviarMailVerificacio($email, $username, $activationcode) {
	$url = "http://localhost/IMAGINEST/mailCheckAccount.php?activationcode=" . $activationcode . "&mail=" . $email;

	$message = "
		<html>
		  <head>
			<meta charset=UTF-8' />
			<title>Verificación Correo</title>
		  </head>
		  <body>
			<div>
				<p>Bienvenido, $username</p>
				<p>Hemos recibido una solicitad de registro en nuestra pagina web Imaginest</p>
				<p>Si usted ha solicitado este registro debe de activar su cuenta dando click en el siguiente boton</p>
				<p><a href=" . $url . " href=" . $url . " target='_blank' style='width:80%; display: inline-block; color: #ffffff; background-color: #1883ba; border: solid 2px #0016b0; border-radius: 6px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'>Confirmar Registro</a></p> 
			</div>
		  </body>
		</html>";

	$mail = new PHPMailer();
	$mail->IsSMTP();

	//Para poder añadir las Ñ
	$mail->CharSet = 'UTF-8';

	//Configuració del servidor de Correu
	//Modificar a 0 per eliminar msg error
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;

	//Credencials del compte GMAIL
	$mail->Username = '';
	$mail->Password = '';

	//Dades del correu electrònic
	$mail->SetFrom('soporte@imaginest.com', 'Imaginest');
	$mail->AddAddress($email);

	$mail->Subject = 'Confirma el teu registre';
	$mail->IsHTML(true);
	$mail->MsgHTML($message);

	//Enviament
	$mail->Send();
}

function enviaCorreuReset($resetPassCode, $user, $esMailorNot) {

	if ($esMailorNot) {
		$url = "http://localhost/IMAGINEST/resetPassword.php?code=" . $resetPassCode . "&mail=" . $user;
		$email = $user;
	} else {
		$url = "http://localhost/IMAGINEST/resetPassword.php?code=" . $resetPassCode . "&user=" . $user;
		$email = obtenerMail($user);
	}

	$message = "
		<html>
		  <head>
			<meta charset='UTF-8' />
			<title>Verificación Correo Cambio Contraseña</title>
		  </head>
		  <body>
			<div>
				<p>Acabamos de recibir una solicitud de restablecimiento de contraseña en IMAGINEST.</p>
				<p>Si usted lo ha solicitado, debe de activar su cuenta dando click en el siguiente boton.</p>
				<p><a href=" . $url . " target='_blank' style='width:80%; display: inline-block; color: #ffffff; background-color: #1883ba; border: solid 2px #0016b0; border-radius: 6px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'>Restablecer Contraseña</a></p>
            </div>
		  </body>
		</html>";

	$mail = new PHPMailer();
	$mail->IsSMTP();

	//Para poder añadir las Ñ
	$mail->CharSet = 'UTF-8';
	//Configuració del servidor de Correu
	//Modificar a 0 per eliminar msg error
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;

	//Credencials del compte GMAIL
	$mail->Username = '';
	$mail->Password = '';

	//Dades del correu electrònic
	$mail->SetFrom('soporte@imaginest.com', 'Imaginest');
	$mail->AddAddress($email);

	$mail->Subject = 'Cambio de contraseña IMAGINEST';
	$mail->IsHTML(true);
	$mail->MsgHTML($message);

	//Enviament
	$mail->Send();
}

function enviarMailContrasenyaCanviada($email) {
	$url = "http://localhost/IMAGINEST/index.php";

	$message = "
		<html>
		  <head>
			<meta charset='UTF-8' />
			<title>Verificación Cambio Contraseña</title>
		  </head>
		  <body>
			<div>
				<p>Su contraseña se ha cambiado e verificado correctamente!</p>
				<p>Haga click en el siguiente boton para iniciar sesion en IMAGINEST</p>
				<p><a href=" . $url . " target='_blank' style='width:80%; display: inline-block; color: #ffffff; background-color: #1883ba; border: solid 2px #0016b0; border-radius: 6px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'>Iniciar Sesión</a></p>
			</div>
		  </body>
		</html>";

	$mail = new PHPMailer();
	$mail->IsSMTP();

	//Para poder añadir las Ñ
	$mail->CharSet = 'UTF-8';
	//Configuració del servidor de Correu
	//Modificar a 0 per eliminar msg error
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;

	//Credencials del compte GMAIL
	$mail->Username = '';
	$mail->Password = '';

	//Dades del correu electrònic
	$mail->SetFrom('soporte@imaginest.com', 'Imaginest');
	$mail->AddAddress($email);

	$mail->Subject = 'Contraseña Modificada Correctamente';
	$mail->IsHTML(true);
	$mail->MsgHTML($message);

	//Enviament
	$mail->Send();
}

function enviarMailCanceladoPassword($email){
	$url = "http://localhost/IMAGINEST/index.php";

	$message = "
		<html>
		  <head>
			<meta charset='UTF-8' />
			<title>Cancelación Cambio Contraseña</title>
		  </head>
		  <body>
			<div>
				<p>El cambio de contraseña no se ha realizado correctamente!</p>
				<p>Haga click en el siguiente boton para ir a IMAGINEST y solicitar un nuevo cambio de contraseña</p>
				<p><a href=" . $url . " target='_blank' style='width:80%; display: inline-block; color: #ffffff; background-color: #1883ba; border: solid 2px #0016b0; border-radius: 6px; box-sizing: border-box; cursor: pointer; text-decoration: none; font-size: 14px; font-weight: bold; margin: 0; padding: 12px 25px; text-transform: capitalize; border-color: #3498db;'>Iniciar Sesión</a></p>
			</div>
		  </body>
		</html>";

	$mail = new PHPMailer();
	$mail->IsSMTP();

	//Para poder añadir las Ñ
	$mail->CharSet = 'UTF-8';
	//Configuració del servidor de Correu
	//Modificar a 0 per eliminar msg error
	$mail->SMTPDebug = 0;
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'tls';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 587;

	//Credencials del compte GMAIL
	$mail->Username = '';
	$mail->Password = '';

	//Dades del correu electrònic
	$mail->SetFrom('soporte@imaginest.com', 'Imaginest');
	$mail->AddAddress($email);

	$mail->Subject = 'Cambio Contraseña Fallido';
	$mail->IsHTML(true);
	$mail->MsgHTML($message);

	//Enviament
	$mail->Send();
}
