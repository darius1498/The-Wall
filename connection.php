<?php  

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); //set DB_PASS as 'root' if you're using mac
define('DB_DATABASE', 'wall'); //make sure to set your database
//connect to database host
$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

?>
