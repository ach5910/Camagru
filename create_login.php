<?php
session_start();
function validate_info()
{
	$pattern = "^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$";
	if ($_POST['login'] === '' || $_POST['passwd'] === '' || $_POST['verifypw'] === '' || $_POST['email'] === '')
		$_SESSION['error'] = 'Complete all Fields';
	else if ($_POST['passwd'] !== $_POST['verifypw'])
		$_SESSION['error'] = 'Passwords Do Not Match';
	else if (strlen($_POST['passwd']) < 4 || strlen($_POST['passwd']) > 16)
		$_SESSION['error'] = 'Password must contain 4-16 characters';
	else if (preg_match('/'.$pattern.'/', $_POST['email']) !== 1)
		$_SESSION['error'] = 'Invalid email';
	if ($_SESSION['error'] !== '')
		return FALSE;
	return TRUE;
}
$_SESSION['error'] = '';
if ($_POST['submit'] === 'OK' && validate_info())
{
	if(file_exists("private/passwd"))
		$accounts = unserialize(file_get_contents("private/passwd"));
	else
		$accounts = array();
	if (!array_key_exists($_POST['login'], $accounts))
	{
		$accounts[$_POST['login']]['email'] = $_POST['email'];
		$accounts[$_POST['login']]['passwd'] = hash("whirlpool", $_POST['passwd']);
		@mkdir("private");
		file_put_contents("private/passwd", serialize($accounts));
		$_SESSION['loggedIn'] = $_POST['login'];
		header("Location: index.php");
	}
	$_SESSION['error'] = 'Account name in use';
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
			
			<form method='post'>
				<fieldset>
				<legend><h2>Create Account</h2></legend>
				<?php
				if ($_SESSION['error'] !== '')
					echo '<h3 style="color: red;">'.$_SESSION['error'].'</h3>'; 
				?>
				<p4>Account Name</p4>
				<input type='text' name='login' value=''>
				<p4>Password</p4>
				<input type='password' name='passwd' value=''>
				<p4>Verify Password</p4>
				<input type='password' name='verifypw' value=''>
				<p4>Email</p4>
				<input type='text' name='email' value=''>
				<input type='submit' name='submit' value='OK'>
				</fieldset>
			</form>
		</div>
	</div>
</body>
</html>
