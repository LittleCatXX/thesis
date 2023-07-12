<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

// เชื่อมต่อกับฐานข้อมูล
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("ไม่สามารถเชื่อมต่อกับฐานข้อมูลได้: " . mysqli_connect_error());
}

// ดำเนินการต่อไปเมื่อเชื่อมต่อสำเร็จ
// ...

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($conn);
?>