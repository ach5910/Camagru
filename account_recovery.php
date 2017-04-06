<?php
session_start();
include 'setup.php';
include 'database.php';
include 'email.php';
$_SESSION['error'] = '';
$_SESSION['email_message'] = '';

if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	if ($res = $db->get_user_by_email($_POST['email']))
	{
		$newpw = substr(str_shuffle(str_repeat(
			'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,5);
		$db->update_password($res['id'], hash("whirlpool", $newpw));
		send_account_recovery_email($res['name'], $newpw, $_POST['email']);
	}
	else
		$_SESSION['error'] = 'Invalid Email';
	$db = null;
}
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='index.css'/>
</head>
<body>
	<?php include'nav.html';?>
	<div class='login-backdrop'>
		<div class='login-container'>
			<?php
			if ($_SESSION['email_message'] === '')
			{
			?>
			<form method='post'>
				<fieldset>
				<legend><h2>Account Recovery</h2></legend>
				<?php
				if ($_SESSION['error'] !== '')
					echo '<h3 style="color: red;">'.$_SESSION['error'].'</h3>'; 
				?>
				<p4>email</p4>
				<input type='text' name='email' value=''>
				<input type='submit' name='submit' value='OK'>
				</fieldset>
			</form>
			<?php
			}
			else
			{
				echo '<h2>'.$_SESSION['email_message'].'</h2';
			?>
			<p4>Please check your email and return to Log In</p4>
			<form action="index.php">
				<input type="submit" name="Log In" value='Log In'>
			</form>
			<?php
			}
			?>
		</div>
	</div>
</body>
</html>