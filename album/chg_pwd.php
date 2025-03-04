<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
<form method="post" action="">
    <input type="text" name="buser_id" placeholder="รหัส user" required>
    <input type="password" name="new_password" placeholder="รหัสผ่านใหม่" required>
    <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่" required>
    <button type="submit">เปลี่ยนรหัสผ่าน</button>
</form>
    
<?php
include_once("../connectdb.php");
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['buser_id'];
    //$user_id = $_SESSION['buser_id']; // รับ user_id จาก session
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if ($new_password === $confirm_password) {
        $new_hashed = password_hash($new_password, PASSWORD_DEFAULT); // เข้ารหัสรหัสผ่านใหม่
        $stmt = $conn->prepare("UPDATE admin SET a_pwd = ? WHERE a_id = ?");
        $stmt->bind_param("si", $new_hashed, $user_id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ');</script>";
        } else {
            echo "<script>alert('ไม่สามารถเปลี่ยนรหัสผ่านได้');</script>";
        }
    } else {
        echo "<script>alert('รหัสผ่านใหม่ไม่ตรงกัน');</script>";
    }
}
?>


</body>
</html>