<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (isset($_POST['qr_data'])) {
    $qr_data = $_POST['qr_data'];

    // ทำสิ่งที่คุณต้องการกับข้อมูลที่ได้รับจาก QR scanner
    // เช่น เก็บลงฐานข้อมูลหรือประมวลผลต่อไป
    echo "QR Data: " . $qr_data;

    $sql = "INSERT INTO save_barcode_data (itemBarcode, barcode) VALUES ('$qr_data', '')";

    if ($conn->query($sql) === TRUE) {
        echo "บันทึกข้อมูลเรียบร้อยแล้ว";
        // เปลี่ยนเส้นทางหน้า
        header("Location: scanQR.php");
        exit; // ออกจากสคริปต์เพื่อหยุดการทำงานต่อ
    } else {
        echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}

mysqli_close($conn);
?>
