<?php
include 'db_connection.php';
include 'funtion.php';

// รับข้อมูลจากฟอร์ม
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$studentID = $_POST['studentID'];

// เชื่อมต่อฐานข้อมูล
$conn = createDBConnection();

// เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
$result = insertStudentData($conn, $firstName, $lastName, $studentID);
echo $result;
$conn->close();




?>
