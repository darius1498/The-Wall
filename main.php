<?php  
	require_once("connection.php");
	session_start();
?>

<!DOCTYPE html>
<html>
	<head>
		<title>The Wall</title>
		<link rel="stylesheet" type="text/css" href="wall.css">
	</head>
	<body>
		<div class="header">
			<h2>CodingDojo Wall</h2>
			<div>
				<p>Welcome,  
<?php 				if (isset($_SESSION['fname'])) {
						echo $_SESSION['fname'];
					} else {
						header("location: registrationprocess.php");
					}
?>				</p>
				<a href="registrationprocess.php">Log off</a>
			</div>
		</div>
		<div class="message">
			<form action="messageprocess.php" method="post">
				<input type="hidden" name="action" value="message">
				<h4>Post a message</h4>
				<textarea name="message" rows="4"></textarea>
				<span><input type="submit" value="Post a message"></span>
			</form>
		</div>
		<div class="comment">
<?php 
			$query =  "SELECT messages.id, messages.user_id, users.first_name, users.last_name, messages.message, messages.created_at
						FROM users
						INNER JOIN messages
						ON users.id = messages.user_id
						ORDER BY messages.created_at;";
	    	$result = mysqli_query($connection, $query);

	    	if (mysqli_num_rows($result) > 0) {
	    	
	    		while($row = mysqli_fetch_assoc($result)) {	
?>
	        		<h4><?= $row['first_name']." ".$row['last_name']; ?> &mdash; <?= $row['created_at']; ?></h4>
					<p><?= $row['message']; ?></p>

					<form action="messageprocess.php" method="post">
<?php  			
						$counter =  $row['id'];
						$commentquery = "SELECT comments.message_id, users.first_name, users.last_name, comments.comment, comments.created_at
							FROM users
	                        INNER JOIN comments
	                        ON users.id = comments.user_id
	                        LEFT JOIN messages
                            ON comments.message_id = messages.id
                            WHERE messages.id = '{$counter}'
	                        ORDER BY comments.created_at;";

	       				$comment_result = mysqli_query($connection, $commentquery);
	       				if (mysqli_num_rows($comment_result) > 0) {
	                    	while ($row = mysqli_fetch_assoc($comment_result)) {
?>
							<div>
								<h4><?= $row['first_name']." ".$row['last_name']; ?> &mdash; <?= $row['created_at']; ?></h4>
		                    	<p><?=  $row['comment']; ?></p>	
							</div>
<?php
	                    	}  
	                    }            
?>
						<input type="hidden" name="action" value="comment">
						<input type="hidden" name="post_id" value="<?= $counter; ?>">
						<h4>Post a comment</h4>
						<textarea name="comment" rows="4"></textarea>
						<span><input type="submit" value="Post a comment"></span>
					</form>
<?php  
					
?>
<?php 
	       		}
	    } 
?>
			
		</div>
	</body>
</html>