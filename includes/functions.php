<?php

// https://www.php.net/manual/es/book.pdo.php
// https://www.php.net/manual/es/pdostatement.bindparam.php
// https://www.php.net/manual/es/pdostatement.fetchcolumn.php

function compruebaUsuMail($usernameMail)
{
    global $db;
    $sql = "SELECT * FROM users WHERE (username = ? or mail = ?) and (active = 1)";
    $usumail = $db->prepare($sql);
    $usumail->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $usumail->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $usumail->execute();

    return $usumail->rowCount();
}

function compruebaPswd($usernameMail, $password)
{
    global $db;
    $sql = "SELECT passHash FROM users WHERE (username = ? or mail = ?)";
    $pswHash = $db->prepare($sql);
    $pswHash->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $pswHash->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $pswHash->execute();
    $pswd = $pswHash->fetchColumn();

    return password_verify($password, $pswd);
}

function actualitzarIniciSessio($usernameMail)
{
	global $db;
	$sql = "UPDATE users SET lastSignIn = NOW() WHERE (username = ? or mail = ?)";
	$actualizarLastSignIn = $db->prepare($sql);
    $actualizarLastSignIn->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $actualizarLastSignIn->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $actualizarLastSignIn->execute();	
}


function existeCorreo($email)
{
    global $db;
    $sql = "SELECT * FROM users WHERE mail = ?";
    $mailExist = $db->prepare($sql);
    $mailExist->bindParam(1, $email, PDO::PARAM_STR);
    $mailExist->execute();

    return $mailExist->rowCount();
}

function existeUsuario($username)
{
    global $db;
    $sql = "SELECT * FROM users WHERE username = ?";
    $UsuExist = $db->prepare($sql);
    $UsuExist->bindParam(1, $username, PDO::PARAM_STR);
    $UsuExist->execute();

    return $UsuExist->rowCount();
}

function añadirUsuarioSQL($email, $username, $password_hash, $firstname, $lastname, $activationcode)
{
    global $db;
    $sql = "INSERT INTO users (mail,username,passHash,userFirstName,userLastName,creationDate,active,activationCode) VALUES (? ,? ,? ,? ,?,NOW(),0,?)";
    $añadirUsu = $db->prepare($sql);
    $añadirUsu->bindParam(1, $email, PDO::PARAM_STR);
    $añadirUsu->bindParam(2, $username, PDO::PARAM_STR);
    $añadirUsu->bindParam(3, $password_hash, PDO::PARAM_STR);
    $añadirUsu->bindParam(4, $firstname, PDO::PARAM_STR);
    $añadirUsu->bindParam(5, $lastname, PDO::PARAM_STR);
	$añadirUsu->bindParam(6, $activationcode, PDO::PARAM_STR);
    return $añadirUsu->execute();
}

function getUsername($usernameMail)
{
    global $db;
    $sql = "SELECT username FROM users WHERE mail = ?";
    $usuSql = $db->prepare($sql);
    $usuSql->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $usuSql->execute();

    return $usuSql->fetchColumn();
}

function comprovaCodiActivacio($email, $hash)
{
    global $db;
    $sql = "SELECT * FROM users WHERE mail = ? AND activationCode = ? AND active = 0";
    $codeAct = $db->prepare($sql);
    $codeAct->bindParam(1, $email, PDO::PARAM_STR);
    $codeAct->bindParam(2, $hash, PDO::PARAM_STR);
    $codeAct->execute();

    return $codeAct->rowCount();
}

function activarCompte($email, $hash)
{
    global $db;
    $sql = "UPDATE users SET active = 1, activationDate = CURRENT_TIMESTAMP, activationCode = NULL WHERE mail = ? AND activationCode = ? AND active = 0";
    $activeUpp = $db->prepare($sql);
    $activeUpp->bindParam(1, $email, PDO::PARAM_STR);
    $activeUpp->bindParam(2, $hash, PDO::PARAM_STR);
    $activeUpp->execute();
}

function updatePassword($resetPassCode,$user)
{
    global $db;
    $sql = "UPDATE users SET resetPassCode = ?, resetPass = 1, resetPassExpiry = DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 30 MINUTE) WHERE (mail = ? or username = ?) AND active = 1";
    $addPswCol = $db->prepare($sql);
    $addPswCol->bindParam(1, $resetPassCode, PDO::PARAM_STR);
    $addPswCol->bindParam(2, $user, PDO::PARAM_STR);
	$addPswCol->bindParam(3, $user, PDO::PARAM_STR);
    $addPswCol->execute();
}

function obtenerMail($usuario){
	global $db;
	$sql = "SELECT mail from users WHERE username = ?";
	$elMail = $db->prepare($sql);
	$elMail->bindParam(1,$usuario, PDO::PARAM_STR);
	$elMail->execute();
	
	return $elMail->fetchColumn();
}

function existeCodigoPsw($usuario, $pswCodigo){
	global $db;
	$sql = "SELECT * from users WHERE (username = ? or mail = ?) and resetPassCode = ? AND resetPass = 1 AND active = 1";
	$coincidenPsw->bindParam(1,$usuario, PDO::PARAM_STR);
	$coincidenPsw->bindParam(2,$usuario, PDO::PARAM_STR);
	$coincidenPsw->bindParam(3,$pswCodigo, PDO::PARAM_STR);
	$coincidenPsw->execute();
	
	return $coincidenPsw->rowCount();	
}

function compruebaValidezPswCode($usernameMail, $hash)
{
    global $db;
    $sql = "SELECT resetPassExpiry < now() FROM users WHERE (username = ? OR mail = ?) AND resetPassCode = ? AND resetPass = 1 AND active = 1";
    $timePass = $db->prepare($sql);
    $timePass->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $timePass->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $timePass->bindParam(3, $hash, PDO::PARAM_STR);
    $timePass->execute();

    return $timePass->fetchColumn();
}

function pswIgual($usernameMail, $password){
	global $db;
    $sql = "SELECT passHash FROM users WHERE (username = ? OR mail = ?)";
    $pswComprovar = $db->prepare($sql);
    $pswComprovar->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $pswComprovar->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $pswComprovar->execute();
    $psw = $pswComprovar->fetchColumn();

    return password_verify($password, $psw);
}

function nuevaPswHasheada($usernameMail, $newPswHash){
    global $db;
    $sql = "UPDATE users SET passHash = ? WHERE (mail = ? OR username = ?) AND active = 1 AND resetPass = 1 ";
    $cambiarPsw = $db->prepare($sql);
    $cambiarPsw->bindParam(1, $newPswHash, PDO::PARAM_STR);
    $cambiarPsw->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $cambiarPsw->bindParam(3, $usernameMail, PDO::PARAM_STR);
    $cambiarPsw->execute();
}

function resetearDatosPsw($usernameMail)
{
    global $db;
    $sql = "UPDATE users SET resetPass = 0, resetPassExpiry = NULL, resetPassCode = NULL WHERE (username = ? OR mail = ?) AND active = 1";
    $limpiarDatosPsw = $db->prepare($sql);
    $limpiarDatosPsw->bindParam(1, $usernameMail, PDO::PARAM_STR);
    $limpiarDatosPsw->bindParam(2, $usernameMail, PDO::PARAM_STR);
    $limpiarDatosPsw->execute();
}