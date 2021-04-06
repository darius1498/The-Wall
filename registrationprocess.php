<?php 
	require_once("connection.php");
	session_start();

	if (isset($_POST['action']) && $_POST['action'] == 'register') 
	{
		register_user($_POST);
	}
	else if (isset($_POST['action']) && $_POST['action'] == 'login') 
	{
		login_user($_POST);
	}
	else 
	{
		session_destroy();
		header('location: index.php');
		die();
	}

	function register_user($post){

		$_SESSION['errors'] = array();

		if (empty($post['fname'])) 
		{
			$_SESSION['errors'][] = "First name can't be blank!";
		}
		else if (empty($post['lname'])) 
		{
			$_SESSION['errors'][] = "Last name can't be blank!";
		}
		else if (strlen($post['fname']) <= 2) {
			$_SESSION['errors'][] = "First name is too short!"; 
		}
		else if (strlen($post['lname']) <= 2) {
			$_SESSION['errors'][] = "Last name is too short!"; 
		}
		else if (!preg_match('/^[a-zA-Z]+$/', $post['fname']) || !preg_match('/^[a-zA-Z]+$/', $post['lname'])) {
			$_SESSION['errors'][] = "Only alphabet character are allowed!"; 
		}
		else if (empty($post['email'])) 
		{
			$_SESSION['errors'][] = "E-mail can't be blank!";
		}
		else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) 
		{
			$_SESSION['errors'][] = "Invalid e-mail!";
		}
		else if (empty($post['password']) || empty($post['re-password'])) 
		{
			$_SESSION['errors'][] = "Password can't be blank!";
		}
		else if ($post['password'] !== $post['re-password']) 
		{
			$_SESSION['errors'][] = "Password didn't match!";
		}
		else if (strlen($post['password']) < 8 || strlen($post['re-password']) < 8) 
		{
			$_SESSION['errors'][] = "Password too short!";
		}


		else 
		{
			global $connection;
			$hashedPassword = md5($post['password']);
			$date = date('Y-m-d H:i:s');
			$query = "INSERT INTO users (first_name, last_name, email, password, created_at, updated_at)
						VALUES ('{$post['fname']}', '{$post['lname']}', '{$post['email']}', '$hashedPassword', '$date', '$date')";
			if(mysqli_query($connection, $query))
			{
				$_SESSION['errors'][] = "Success!";
				header("location: index.php");
			} 

			else {
				$_SESSION['errors'][] = "Something went wrong.";
				header("location: index.php");
			}
		}
		header("location: index.php");
	}

	function login_user($post){
		if (empty($post['email'])) 
		{
			$_SESSION['errors'][] = "E-mail can't be blank!";
			header("location: index.php");
		}
		else if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) 
		{
			$_SESSION['errors'][] = "Invalid e-mail!";
			header("location: index.php");
		}
		else if (empty($post['password'])) 
		{
			$_SESSION['errors'][] = "Password can't be blank!";
			header("location: index.php");
		}
		else {
			global $connection;

			$confirming_pass =  md5($post['password']);
			$query = "SELECT * FROM users WHERE users.email = '{$post['email']}' AND users.password = '$confirming_pass'";
			
			$ouput = mysqli_query($connection, $query);

			if (mysqli_num_rows($ouput) > 0) 
			{
	    	// output data of each row
	    		while($row = mysqli_fetch_assoc($ouput)) 
	    		{
	    			$_SESSION['fname'] = $row['first_name'];
	    			$_SESSION['lname'] = $row['last_name'];
	    			$_SESSION['id'] = $row['id'];
	    			$_SESSION['logged-in'] = TRUE;
	    			header("location: main.php");
	       		}
	    	}
	    	else
	    	{
	    		$_SESSION['errors'][] = "Incorrect credentials!";
	    		header("location: index.php");
	    	}
		}
		

	}
?>