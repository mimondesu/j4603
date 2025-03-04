<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ฟอร์มเพิ่มข้อมูลสินค้า</title>
</head>

<body>
<h1>ฟอร์มเพิ่มข้อมูลสินค้า</h1>
<form method="post" action="" enctype="multipart/form-data">
    ชื่อสินค้า: <input type="text" name="pname" required autofocus> <br>
    ราคา: <input type="text" name="pprice" required> <br>
    รายละเอียดสินค้า: <textarea name="pdetail" required></textarea> <br>
    รูปภาพสินค้า: <input type="file" name="pimage" accept="image/*" required> <br>
    <button type="submit">บันทึก</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include_once("../connectdb.php");

    // รับค่าจากฟอร์ม
    $pname = $_POST['pname'];
    $pprice = $_POST['pprice'];
    $pdetail = $_POST['pdetail'];

    // ตรวจสอบการอัปโหลดรูปภาพ
    if (isset($_FILES['pimage']) && $_FILES['pimage']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['pimage']['tmp_name'];
        $fileName = $_FILES['pimage']['name'];
        $fileSize = $_FILES['pimage']['size'];
        $fileType = $_FILES['pimage']['type'];
        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($fileExt, $allowedExt)) {
            // สร้างรหัสสินค้าใหม่
            $result = mysqli_query($conn, "SELECT MAX(p_id) AS max_id FROM product");
            $row = mysqli_fetch_assoc($result);
            $newProductId = $row['max_id'] + 1;

            // ตั้งชื่อไฟล์รูปภาพตามรหัสสินค้า
            $newFileName = $newProductId . '.' . $fileExt;
            $uploadPath = "../images/" . $newFileName;

            // ย้ายไฟล์ไปยังโฟลเดอร์ images
            if (move_uploaded_file($fileTmpPath, $uploadPath)) {
                // บันทึกข้อมูลสินค้าในฐานข้อมูล
                $sql = "INSERT INTO product (p_id, p_name, p_detail, p_price, p_ext, c_id) 
                        VALUES ('$newProductId', '$pname', '$pdetail', '$pprice', '$fileExt', '1')";
                if (mysqli_query($conn, $sql)) {
                    echo "<script>alert('เพิ่มข้อมูลสำเร็จ');</script>";
                } else {
                    echo "<script>alert('เกิดข้อผิดพลาดในการบันทึกข้อมูล');</script>";
                }
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ');</script>";
            }
        } else {
            echo "<script>alert('รูปภาพต้องเป็นไฟล์ชนิด jpg, jpeg, png หรือ gif เท่านั้น');</script>";
        }
    } else {
        echo "<script>alert('กรุณาอัปโหลดรูปภาพสินค้า');</script>";
    }
}
?>
</body>
</html>
