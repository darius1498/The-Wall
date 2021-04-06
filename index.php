<?php  
	require_once("connection.php");
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Login and Registration</title>
		<style>
			body{
				font-family: arial;
			}
			form{
				display: inline-block;
				padding: 0px 20px;
				min-width: 300px;
				vertical-align: top;
				margin: auto;
				
			}
			input{
				display: block;
				margin: 5px;
			}
			input[type='submit']{
				margin-top: 20px;
				background-color: green;
				border: none;
				padding: 10px 20px;
				color: white;
			}
			p{
				width: 600px;
				text-align: center;
				font-size: 24px;
				padding: 0px 20px;
				color: red;
			}
		</style>
	</head>
	<body>
<?php  
		if(isset($_SESSION['errors']))
		{
			foreach ($_SESSION['errors'] as $error) {
				echo "<p>" . $error . "</p>";
			}
			unset($_SESSION['errors']);
		}
?>	
		<form action="registrationprocess.php" method="post">
			<h2>Register</h2>
			<input type="hidden" name="action" value="register">
			First name: <input type="text" name="fname"> 
			Last name: <input type="text" name="lname">
			Email address: <input type="text" name="email">
			Password: <input type="password" name="password">
			Repeat password: <input type="password" name="re-password">
			<input type="submit" value="Register">
		</form>
		<form action="registrationprocess.php" method="post">
			<h2>Login</h2>
			<input type="hidden" name="action" value="login">
			Email address: <input type="text" name="email">
			Password: <input type="password" name="password">
			<input type="submit" value="Login">
		</form>	
	</body>
</html>