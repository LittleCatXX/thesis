<?php
include 'db_connection.php';

// รับข้อมูลจากฟอร์ม
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$studentID = $_POST['studentID'];

// เชื่อมต่อฐานข้อมูล
$conn = createDBConnection();

// เตรียมคำสั่ง SQL สำหรับเพิ่มข้อมูล
$sql = "INSERT INTO students (firstName, lastName, studentID) VALUES ('$firstName', '$lastName', '$studentID')";
// $sql = "INSERT INTO checklistdata (studentID) VALUES ('$studentID')"; 
if ($conn->query($sql) === TRUE) {
    echo "เพิ่มข้อมูลนักเรียนเรียบร้อยแล้ว";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

header("Location: addstu.html");

?>
