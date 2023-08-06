<?php
// ข้อมูลสำหรับการเชื่อมต่อกับฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

// สร้างการเชื่อมต่อใหม่กับ MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
} else {
    echo "เชื่อมต่อฐานข้อมูลสำเร็จแล้ว!";
}

// ทำสิ่งต่าง ๆ ที่ต้องการในการใช้งานกับฐานข้อมูล

// ปิดการเชื่อมต่อ
$conn->close();
?>
