<?php
include 'reply_functions.php';
include 'db_connection.php';
include 'token.php';
// สร้างการเชื่อมต่อฐานข้อมูล
$conn = createDBConnection();

// ดึงข้อมูลที่ได้รับจาก Line API ผ่าน Webhook
$raw_input = file_get_contents('php://input');
$events = json_decode($raw_input, true);

// ตรวจสอบข้อมูลที่ได้รับ
if (!empty($events['events'])) {
    foreach ($events['events'] as $event) {
        // ตรวจสอบว่าเป็นข้อมูลของข้อความ
        if ($event['type'] === 'message' && $event['message']['type'] === 'text') {
            $user_id = $event['source']['userId'];
            $message = $event['message']['text'];

            // ทำการเก็บ User ID ลงในฐานข้อมูล
            $sql = "INSERT INTO usersline (user_id, message_content) VALUES ('$user_id', '$message')";
            $conn->query($sql);

            // ทำการตอบกลับอัตโนมัติ
            $reply_message = "ทดสอบส่งข้อความกลับถึงผู้ใช้ " . $message;

            // ส่งข้อความกลับไปยังผู้ใช้งานผ่าน LINE Messaging API
            replyToUser($accessToken, $user_id, $reply_message);
        }
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
