<?php
include 'db_connection.php';

// สร้างการเชื่อมต่อฐานข้อมูล
$conn = new mysqli($servername, $username, $password, $dbname);


$desired_studentID = $_POST['studentID']; // ค่า studentID ที่คุณต้องการเช็คชื่อ
$desired_value = $_POST['value']; // ค่าที่คุณต้องการเพิ่มหรืออัพเดตในตาราง checklistdata

// เชื่อมต่อฐานข้อมูล
$conn = createDBConnection();

// ตรวจสอบว่า studentID นั้นมีอยู่ในตาราง students หรือไม่
$check_query = "SELECT COUNT(*) AS count FROM students WHERE studentID = $desired_studentID";
$result = $conn->query($check_query);
$row = $result->fetch_assoc();

if ($row['count'] > 0) {
    // หากมี studentID ในตาราง students ให้เพิ่มหรืออัพเดตข้อมูลในตาราง checklistdata
    $update_query = "INSERT INTO checklistdata (studentID, valueofscan, created_at)
                     VALUES ($desired_studentID, $desired_value, NOW())
                     ON DUPLICATE KEY UPDATE valueofscan = $desired_value, created_at = NOW()";
    
    if ($conn->query($update_query) === TRUE) {
        echo "เช็คชื่อและเพิ่มหรืออัพเดตข้อมูลเรียบร้อยแล้ว";
    } else {
        echo "เกิดข้อผิดพลาดในการเช็คชื่อและเพิ่มหรืออัพเดตข้อมูล: " . $conn->error;
    }
} else {
    echo "ไม่พบ studentID ในตาราง students";
}

// ปิดการเชื่อมต่อ
$conn->close();
?>
