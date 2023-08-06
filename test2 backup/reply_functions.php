<?php
include 'token.php'; // ไฟล์ที่มีการนิยามค่า access_token

function replyToUser($access_token, $user_id, $reply_message) {
    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    );

    $data = array('replyToken' => $user_id, 'messages' => array(array('type' => 'text', 'text' => $reply_message)));

    $ch = curl_init('https://api.line.me/v2/bot/message/reply');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    // แสดงผลค่าที่ได้จากการเรียกใช้ LINE Messaging API
    var_dump($result);

}


$conn = createDBConnection();
$sql = "SELECT user_id FROM usersline"; // แก้ไขชื่อตาราง usersline ตามชื่อที่ใช้ในฐานข้อมูล
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $user_id = $row['user_id'];
        
        $reply_message = "Your reply message goes here."; // ข้อความที่ต้องการตอบกลับ

        // เรียกใช้ฟังก์ชัน replyToUser() เพื่อตอบกลับไปยังผู้ใช้ที่มี user_id ที่อ่านมาจากฐานข้อมูล
        replyToUser($access_token, $user_id, $reply_message);
    }
}

$conn->close();

// ตัวอย่างการเรียกใช้ฟังก์ชันเพื่อตอบกลับ
