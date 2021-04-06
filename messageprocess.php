<?php  
	require_once("connection.php");
	session_start();

	if (isset($_POST['action']) && $_POST['action'] == 'message') 
	{
		make_post($_POST);
	}
	else if (isset($_POST['action']) && $_POST['action'] == 'comment') 
	{
		make_comment($_POST);
	}
	else 
	{
		session_destroy();
		header('location: index.php');
		die();
	}

	function make_post($post){

		$_SESSION['errors'] = array();

		if (empty($post['message'])) 
		{
			$_SESSION['errors'][] = "You are submitting a blank post!";
			header("location: main.php");
		}
		else 
		{
			global $connection;

			$user_id = $_SESSION['id'];
			$date = date('F jS Y g:i A');

			$query = "INSERT INTO messages (user_id, message, created_at, updated_at)
						VALUES ('$user_id', '{$post['message']}', '$date', '$date')";
			if(mysqli_query($connection, $query))
			{
				$_SESSION['errors'][] = "Success!";
				header("location: main.php");
			} 

			else 
			{
				$_SESSION['errors'][] = "Something went wrong.";
				header("location: main.php");
			}
		}
	}

	function make_comment($post){

		$_SESSION['errors'] = array();

		if (empty($post['comment'])) 
		{
			$_SESSION['errors'][] = "You are submitting a blank comment!";
			header("location: main.php");
		}
		else 
		{
			global $connection;

			$user_id = $_SESSION['id'];
			$post_id = $_POST['post_id'];
			$date = date('F jS Y g:i A');

			$query = "INSERT INTO comments (message_id, user_id, comment, created_at, updated_at)
						VALUES ('$post_id','$user_id','{$post['comment']}','$date','$date')";
	
			if(mysqli_query($connection, $query))
			{
				$_SESSION['errors'][] = "Success!";
				header("location: main.php");
			} 

			else {
				$_SESSION['errors'][] = "Something went wrong.";
				header("location: main.php");
			}
		}
	}

	
?>