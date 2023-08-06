<?php



function replyToUser($access_token, $user_id, $reply_message) {

    $access_token = "3CuFe7QESNHNa0r74OzbeTyUjNcE7iBV68RwZP6H8UwPUfJCPBkh75cwJS3Al94AddlpHANxARzGBpTBPaPmVzVamVTwY8od9++E8Ox8v9VLptaNhVJ4uCd7uNOxAnXlyAnFxZoCcbp3VA3Uq97IxgdB04t89/1O/w1cDnyilFU=";
    
    

    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    );

    $data = array('replyToken' => $user_id, 'messages' => array(array('type' => 'text', 'text' => $reply_message)));

    $headers = array(
        'Authorization: Bearer ' . $access_token,
        'Content-Type: application/json'
    );


    


    $ch = curl_init('https://api.line.me/v2/bot/message/push');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    curl_close($ch);

    // แสดงผลค่าที่ได้จากการเรียกใช้ LINE Messaging API
    var_dump($result);

    $conn = createDBConnection();
    $content = $conn->real_escape_string($reply_message);
    $sql = "INSERT INTO messagesline (user_id, content) VALUES ('$user_id', '$content')";
    $conn->query($sql);
    $conn->close();

}

?>