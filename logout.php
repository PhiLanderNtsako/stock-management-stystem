<?php 
	include 'send-report.php';

	unset($_SESSION['admin_id']);
	session_destroy();

	echo '<meta http-equiv="refresh" content="0; url= login.php">';

 ?>