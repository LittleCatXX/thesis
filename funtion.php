<?php

// เช็คค่า value รับค่ามาต้องเป็น int ยังเดียว และก็ ต้องมี ขนาด 8 ถ้ามากกว่า หรือ เท่ากับ 14 ให้เอาตำแหน่งที่ 5 กับ 8
function extractDesiredValue($scannedValue, $valueLength) {
    return ($valueLength === 14) ? substr($scannedValue, 5, 8) : $scannedValue;
}




// ฟังก์ชั่นเรียกใช้งานเก็บข้อมูลลงตาราง Checklist 
function insertDataIntoChecklist($conn, $escapedValue) {
    
    $insertDataSql = "INSERT IGNORE INTO checklistdata (studentID) VALUES ('$escapedValue')";

    if ($conn->query($insertDataSql) === TRUE) {

        header("Location: scanner.html");
        return "บันทึกข้อมูลลงในตาราง checklistdata สำเร็จ";
    } else {
        return "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}




// ฟังก์ชั่นเรียกใช้งานเก็บข้อมูลลงตาราง students
function insertStudentData($conn, $firstName, $lastName, $studentID) {
    // ตรวจสอบก่อนว่ามี studentID นี้ในฐานข้อมูลหรือไม่
    $checkQuery = "SELECT COUNT(*) AS count FROM students WHERE studentID = '$studentID'";
    $checkResult = $conn->query($checkQuery);

    if ($checkResult) {
        $rowCount = $checkResult->fetch_assoc()["count"];
        if ($rowCount > 0) {
            echo "<script>setTimeout(function(){ window.location.href = 'addstu.html'; }, 1000);</script>";
            return "ข้อมูลนักเรียนรหัสนี้มีอยู่ในระบบแล้ว";
            
        }
    } else {
        return "Error checking duplicate: " . $conn->error;
        
    }

    // เพิ่มข้อมูลนักเรียน 
    $insertQuery = "INSERT INTO students (firstName, lastName, studentID) VALUES ('$firstName', '$lastName', '$studentID')";
    if ($conn->query($insertQuery) === TRUE) {

        return "เพิ่มข้อมูลนักเรียนเรียบร้อยแล้ว";
        
    } else {
        return "Error inserting data: " . $conn->error;
    }
}










?>