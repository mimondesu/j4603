<?php
session_start();

if(empty($_SESSION['s_id']) && !isset($_SESSION['s_id'])){
	echo "Access Denied";
	echo "<meta http-equiv='refresh' content='3; index.php'>";
	exit;
	}

?>
