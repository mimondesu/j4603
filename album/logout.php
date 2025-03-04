<?php
	session_start();
	
	unset($_SESSION['s_id']);
	unset($_SESSION['s_name']);
	
		echo "<script>";
		echo "window.location='index.php';";
		echo "</script>"



?>