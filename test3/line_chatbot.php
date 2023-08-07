<?php
// Include ไฟล์ที่มีฟังก์ชัน replyToUser() และฟังก์ชันเชื่อมต่อฐานข้อมูล
include 'db_connection.php';
include 'token.php';

// ตรวจสอบว่ามีข้อมูลที่ส่งมาจาก Line API ผ่าน Webhook หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                // ดึง UID ของผู้ใช้ที่ส่งข้อความมา
                $user_id = $event['source']['userId'];
                $message = $event['message']['text'];

                // ทำการเก็บ User ID และข้อความที่ผู้ใช้งานส่งมาลงในฐานข้อมูล
                $sql = "INSERT INTO usersline (user_id, message_content) VALUES ('$user_id', '$message')";
                $conn->query($sql);

                // ทำการคิวรีค่า $user_id ที่เก็บในตาราง usersline
                $sql_query = "SELECT user_id FROM usersline";
                $result = $conn->query($sql_query);

                if ($result->num_rows > 0) {
                    // อ่านข้อมูลและเก็บค่า $user_id ล่าสุดที่พบ
                    while ($row = $result->fetch_assoc()) {
                        $user_id = $row["user_id"];
                        // ในที่นี้เราจะทำการตอบกลับทุกครั้งที่มีการค้นหาค่า $user_id
                        $reply_message = "ทดสอบส่งข้อความกลับถึงผู้ใช้ " . $message;

                        // ส่งข้อความกลับไปยังผู้ใช้งานผ่าน LINE Messaging API
                        replyToUser($accessToken, $user_id, $reply_message);
                    }
                } else {
                    echo "ไม่พบข้อมูลในตาราง usersline";
                }
            }
        }
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    $conn->close();
}

// ฟังก์ชันสำหรับส่งข้อความผ่าน LINE Messaging API
function replyToUser($access_token, $user_id, $reply_message) {
    // ตั้งค่า HTTP headers สำหรับส่งข้อมูลไปยัง LINE Messaging API
    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    );

    // ข้อมูลที่ต้องการส่งไปยัง LINE Messaging API
    $data = array(
        'to' => $user_id, // ค่า USER_ID ของผู้ใช้ Line Chat ที่คุณต้องการส่งข้อความถึง
        'messages' => array(
            array(
                'type' => 'text',
                'text' => $reply_message
            )
        )
    );

    // ใช้ cURL เพื่อส่งข้อมูลไปยัง LINE Messaging API
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
?>
