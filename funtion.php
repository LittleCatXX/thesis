<?php
include '.php';
// เช็คค่า value รับค่ามาต้องเป็น int ยังเดียว และก็ ต้องมี ขนาด 8 ถ้ามากกว่า หรือ เท่ากับ 14 ให้เอาตำแหน่งที่ 5 กับ 8
function extractDesiredValue($scannedValue, $valueLength) {
    return ($valueLength === 14) ? substr($scannedValue, 5, 8) : $scannedValue;
}




// ฟังก์ชั่นเรียกใช้งานเก็บข้อมูลลงตาราง Checklist ของ scanner
function insertDataIntoChecklist($conn, $escapedValue) {
    
    $insertDataSql = "INSERT IGNORE INTO checklistdata (studentID) VALUES ('$escapedValue')";

    if ($conn->query($insertDataSql) === TRUE) {

        header("Location: scanner.html");
        return "บันทึกข้อมูลลงในตาราง checklistdata สำเร็จ";

        // เมื่อบันทึกเสร็จแล้วให้ทำการ ส่ง messeg กลับไปที่ user

    } else {
        return "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . $conn->error;
    }
}




// ฟังก์ชั่นเรียกใช้งานเก็บข้อมูลลงตาราง students ของ addstu
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
       

        $linkSelectQuery = "SELECT user_id FROM linelink WHERE studentID = '$studentID'";
        $linkResult = $conn->query($linkSelectQuery);

        if ($linkResult) {
        $linkRow = $linkResult->fetch_assoc(); // ดึงข้อมูล user_id ออกมา
        $user_id = $linkRow['user_id'];

        // เตรียมข้อมูลสำหรับส่งไปยัง Line Messaging API
        $message = "Hello, $firstname $lastname! Your ID is $id. เช็คชื่อแล้ว ";
        sendLineMessage($message, $user_id);
        return "เพิ่มข้อมูลนักเรียนเรียบร้อยแล้ว";
        
    } else {
        return "Error inserting data: " . $conn->error;
    }
    }
}

function sendLineMessage($message, $user_id) {
    // กำหนด Channel Access Token ที่คุณได้รับจาก Line Developer
    $channelAccessToken = 'P52UXHhWlbVPXb0ikNPk8135dzvwGrZ92/4cxDrwDlm/iM+VkQ2K1neE6r1ur1dEddlpHANxARzGBpTBPaPmVzVamVTwY8od9++E8Ox8v9VAqb1hg96ttFho4VP67FE2g/dBhkNRIysMAR1MV7VRswdB04t89/1O/w1cDnyilFU=';

    // ข้อมูลที่ต้องการส่งไปยัง Line Messaging API
    $data = array(
        'to' => $user_id, // ค่า USER_ID ของผู้ใช้ Line Chat ที่คุณต้องการส่งข้อความถึง
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $message
            )
        )
    );

    // ตั้งค่า HTTP headers สำหรับส่งข้อมูลไปยัง Line Messaging API
    $headers = array(
        'Authorization: Bearer ' . $channelAccessToken,
        'Content-Type: application/json'
    );

    // ใช้ cURL เพื่อส่งข้อมูลไปยัง Line Messaging API
    $ch = curl_init('https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    // ตรวจสอบค่าที่ได้จากการใช้งาน cURL
    // ถ้าส่งข้อความสำเร็จ ค่าที่ควรได้คือ string(0) ""
    var_dump($result);
}








?>