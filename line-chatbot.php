<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // รับข้อมูลจากฟอร์ม
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id = $_POST['id'];

    // สร้างข้อความที่คุณต้องการส่งไปยัง Line Chatbot
    $message = "Hello, $firstname $lastname! Your ID is $id.";

    // เรียกใช้ฟังก์ชันส่งข้อความไปยัง Line Chatbot
    sendLineMessage($message);
}

function sendLineMessage($message) {
    // กำหนด Channel Access Token ที่คุณได้รับจาก Line Developer
    $channelAccessToken = '+juKyX1yFgY+1TkQaWUUyMwb3cC4sTC6Wk+zDATAyFRocU48+NGh/tZlZUE5F4cYSehA0oer88nexDJuomtLu32VFrh6QXPR1uN8kZbLw88L93rMCw8Dqx9X2sBL0GVb9jcm8e+3tjHCOMaH52/59gdB04t89/1O/w1cDnyilFU=';

    // ข้อมูลที่ต้องการส่งไปยัง Line Messaging API
    $data = array(
        'to' => 'U30fe605f85ba4531316e5e75e331a3b4', // ค่า USER_ID ของผู้ใช้ Line Chat ที่คุณต้องการส่งข้อความถึง
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
