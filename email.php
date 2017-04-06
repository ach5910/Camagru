<?php
session_start();

function send_activation_email($login, $email){
	$message = 'Account Login: '.$login.' '.PHP_EOL;
	$message .='Congratulations!!! Your Camagru account has successfully been activated.'.PHP_EOL;
	$subject = 'Account Activation - Camagru';
	$header = 'From: CamagruDevTeam@email.com';
	mail($email, $subject, $message, $header);
}

function send_liked_email($file, $login, $email, $liked_by){
	$message = 'Account Login: '.$login.' '.PHP_EOL;
	$message .='Your Image "'.$file.'" has just been liked by '.$liked_by.' '.PHP_EOL;
	$subject = 'Image Liked Notification - Camagru';
	$header = 'From: CamagruDevTeam@email.com';
	mail($email, $subject, $message, $header);
}

function send_comment_email($file, $login, $email, $comment, $author){
	$message = 'Account Login: '.$login.' '.PHP_EOL;
	$message .= $author.' commented on your Image "'.$file.'" saying "'.$comment.'".'.PHP_EOL;
	$subject = 'Image Comment Notification - Camagru';
	$header = 'From: CamagruDevTeam@email.com';
	mail($email, $subject, $message, $header);
}

function send_account_recovery_email($login, $pw, $email){
	$message = 'Account Login: '.$login.PHP_EOL;
	$message .='Temporary Password: '.$pw.' '.PHP_EOL;
	$subject = 'Account Recovery - Camagru';
	$header = 'From: CamagruDevTeam@email.com';
	if (mail($email, $subject, $message, $header))
		$_SESSION['email_message'] = 'Email Sucessfully Sent';
	else
		$_SESSION['email_message'] = 'Error Sending Email';
}
?>