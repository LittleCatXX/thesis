<?php
include 'db_connection.php';
include 'funtion.php';

// รับข้อมูลที่ต้องการอัพเดตจากฟอร์ม
$studentID = $_POST['studentID'];
$newFirstName = $_POST['firstName'];
$newLastName = $_POST['lastName'];


// เชื่อมต่อฐานข้อมูล
$conn = createDBConnection();

// เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
$updateResult = updateStudentData($conn, $studentID, $newFirstName, $newLastName);
echo $updateResult;
$conn->close();




?>