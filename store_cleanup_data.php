<?php
include 'db_connection.php';

$conn = createDBConnection();

// คำสั่ง SQL เพื่อลบข้อมูลที่มีอายุเกิน 1 ชั่วโมง
$deleteSql = "DELETE FROM scanneddata WHERE TIMESTAMPDIFF(HOUR, created_at, NOW()) > 1";
$conn->query($deleteSql);

$conn->close();
?>
