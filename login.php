<?php
session_start();
$_SESSION['error'] = '';
function validate_login()
{
	if(file_exists("private/passwd"))
	{
		$accounts = unserialize(file_get_contents("private/passwd"));
		if (array_key_exists($_POST['login'], $accounts) && $accounts[$_POST['login']]['passwd'] === hash("whirlpool", $_POST['passwd']))
		{
			return TRUE;
		}
	}
	return FALSE;
}
if ($_POST['submit'] === 'OK')
{
	if (validate_login())
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
	<object type="text/html" data="nav.html"></object>
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
</body>
</html>