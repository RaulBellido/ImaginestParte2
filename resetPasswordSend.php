<?php

session_start();

require('includes/connect.php');
require('includes/functions.php');
require('includes/emails.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST['resetpassword'])) {
		$usernameMail = filter_input(INPUT_POST, 'user');
		if (compruebaUsuMail($usernameMail) > 0) {
			$resetPassCode = hash('sha256', mt_rand());
			updatePassword($resetPassCode, $usernameMail);

			if (filter_var($usernameMail, FILTER_VALIDATE_EMAIL)) {
				$EsMail = true;
			} else {
				$EsMail = false;
			}

			enviaCorreuReset($resetPassCode, $usernameMail, $EsMail);
		}
	}
}

header("Location:index.php");
?>