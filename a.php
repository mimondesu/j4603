<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Date palm</title>
</head>

<body>
<h1>Date palm</h1>

<?php

include_once("connectdb.php"); //เชื่อมต่อข้อมูล

$sql = "SELECT * FROM `product` ORDER BY `product`.`p_id` ASC" ;
$rs = mysqli_query($conn,$sql); // mysqli_query เก็บ database

while ($data = mysqli_fetch_array($rs)){ // array ตัวแปรเก็บข้อมูลได้มากกว่า 1 ตัว
	$img = $data['p_id'].".".$data['p_ext'];
	echo "<img src='images/{$img}' width='200'><br>";
	echo $data['p_id']."<br>";
	echo "ชื่อสินค้า: ".$data['p_name']."<br>";
	echo $data['p_detail']."<br>";
	echo $data['p_price']." บาท <hr>";
	}
mysqli_close($conn);


?>

</body>
</html>