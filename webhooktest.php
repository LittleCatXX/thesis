<?php
include 'funtiontest.php';
include 'db_connection.php';

// Access Token
$access_token = 'P52UXHhWlbVPXb0ikNPk8135dzvwGrZ92/4cxDrwDlm/iM+VkQ2K1neE6r1ur1dEddlpHANxARzGBpTBPaPmVzVamVTwY8od9++E8Ox8v9VAqb1hg96ttFho4VP67FE2g/dBhkNRIysMAR1MV7VRswdB04t89/1O/w1cDnyilFU=';
// รับค่าที่ส่งมา
$content = file_get_contents('php://input');
// แปลงเป็น JSON
$events = json_decode($content, true);
if (!empty($events['events'])) {
    foreach ($events['events'] as $event) {
        if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
            // ข้อความที่ส่งกลับ มาจาก ข้อความที่ส่งมา
            // ร่วมกับ USER ID ของไลน์ที่เราต้องการใช้ในการตอบกลับ
            
            $messages = array(
                'type' => 'text',
                'text' => 'Reply message : '.$event['message']['text']."\nUser ID : ".$event['source']['userId'],
            );
            $post = json_encode(array(
                'replyToken' => $event['replyToken'],
                'messages' => array($messages),
            ));









            // URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
            $url = 'https://api.line.me/v2/bot/message/reply';
            $headers = array('Content-Type: application/json', 'Authorization: Bearer '.$access_token);
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            $result = curl_exec($ch);
            curl_close($ch);
            echo $result;

            
        
            

            
            







        }

        $conn = createDBConnection();
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
                }
            }
        }
        $conn->close();   

   



    }
}

