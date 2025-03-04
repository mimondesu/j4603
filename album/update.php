<?php
include_once("../connectdb.php");
$sql = "SELECT * FROM `product` WHERE `p_id` = '{$_GET['id']}' ";
$rs = mysqli_query($conn, $sql);
$data = mysqli_fetch_array($rs);
?>

<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ฟอร์มแก้ไขข้อมูลสินค้า</title>
</head>

<body>

<h1>ฟอร์มแก้ไขข้อมูลสินค้า</h1>
<form method="post" action="" enctype="multipart/form-data">
    ชื่อสินค้า:
    <input type="text" name="pname" value="<?php echo $data['p_name']; ?>" required autofocus><br>
    ราคา:
    <input type="text" name="pprice" value="<?php echo $data['p_price']; ?>" required><br>
    รายละเอียดสินค้า:<br>
    <textarea name="pdetail" rows="4" cols="50" required><?php echo $data['p_detail']; ?></textarea><br>

    รูปภาพปัจจุบัน:<br>
    <?php if (!empty($data['p_ext'])): ?>
        <img src="../im/<?php echo $data['p_id'] . '.' . $data['p_ext']; ?>" alt="รูปภาพสินค้า" width="200"><br>
    <?php else: ?>
        <p>ไม่มีรูปภาพ</p>
    <?php endif; ?>

    อัปเดตรูปภาพใหม่:
    <input type="file" name="pimage" accept="image/*"><br>

    <button type="submit">บันทึก</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pdetail = $_POST['pdetail'];

    // อัปเดตข้อมูลพื้นฐาน
    $sql = "UPDATE product SET p_name='{$pname}', p_price='{$pprice}', p_detail='{$pdetail}' WHERE p_id='{$_GET['id']}' ";
    if (!mysqli_query($conn, $sql)) {
        die('ข้อผิดพลาดในการอัปเดตข้อมูลพื้นฐาน: ' . mysqli_error($conn));
    }

    // ตรวจสอบว่าอัปโหลดไฟล์ใหม่หรือไม่
    if (!empty($_FILES['pimage']['name'])) {
        $imageFileType = strtolower(pathinfo($_FILES['pimage']['name'], PATHINFO_EXTENSION));
        $target_dir = "../im/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . $_GET['id'] . "." . $imageFileType;

        // ลบไฟล์เก่าหากมี
        if (file_exists($target_dir . $_GET['id'] . "." . $data['p_ext'])) {
            unlink($target_dir . $_GET['id'] . "." . $data['p_ext']);
        }

        // อัปโหลดไฟล์ใหม่
        if (move_uploaded_file($_FILES['pimage']['tmp_name'], $target_file)) {
            $sql = "UPDATE product SET p_ext='{$imageFileType}' WHERE p_id='{$_GET['id']}' ";
            if (!mysqli_query($conn, $sql)) {
                die('ข้อผิดพลาดในการอัปเดตชนิดไฟล์: ' . mysqli_error($conn));
            }
            echo "อัปโหลดรูปภาพสำเร็จ!";
        } else {
            echo "ข้อผิดพลาดในการอัปโหลดรูปภาพ: " . $_FILES['pimage']['error'];
        }
    }

    echo "<script>";
    echo "alert('แก้ไขข้อมูลเสร็จเรียบร้อย'); window.location='update.php?id={$_GET['id']}';";
    echo "</script>";
}
?>

</body>
</html>