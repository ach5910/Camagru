<?php
session_start();
include 'setup.php';
include 'database.php';
$_SESSION['error'] = '';

if ($_POST['submit'] === 'OK')
{
	$db = new CamagruPDO($DBDSN, $DBUSER, $DBPASS);
	$is_valid = $db->validate_login($_POST['login'], hash("whirlpool", $_POST['passwd']));
	$db = null;
	if ($is_valid)
	{
		$_SESSION['loggedIn'] = $_POST['login'];
		header("Location: index.php");
	}
	else
	{
		$_SESSION['error'] = 'Invalid Login';
	}
}
?>
<html>
<head>
	<link rel='stylesheet' type='text/css' href='index.css'/>
	
</head>
<body>
	<?php include'nav.html';?>
	<div class='media'>
		<div class='login-backdrop'>
			<div class='login-container'>
				
				<form method='post'>
					<fieldset>
					<legend><h2>Sign-In</h2></legend>
					<?php
					if ($_SESSION['error'] !== '')
						echo '<h3 style="color: red;">'.$_SESSION['error'].'</h3>'; 
					?>
					<p4>Account Name</p4>
					<input type='text' name='login' value=''>
					<p4>Password</p4>
					<input type='password' name='passwd' value=''>
					<input type='submit' name='submit' value='OK'>
					</fieldset>
				</form>
				<a href='create_login.php'>Create Account</a>
				<a href='account_recovery.php'>Forgot Password</a>
			</div>
		</div>
	</div>
</body>
</html>