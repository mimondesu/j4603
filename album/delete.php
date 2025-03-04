<meta charset="utf-8">
<?php
if(!empty($_GET['id'])){
	include_once("../connectdb.php");
	$sql = "DELETE FROM 'product' where 'product'.'p_id' ='xx' ";
	mysqli_query($conn,$sql) or die ('Delete error');
	
	unlink("../images/{$_GET['id']}.{$_GET['ext']}");
	
	echo "<script>";
	echo "window.location='index.php';";
	echo "</script>";	
}
?>