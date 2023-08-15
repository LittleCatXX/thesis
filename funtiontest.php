<?php

//// URL ของบริการ Replies สำหรับการตอบกลับด้วยข้อความอัตโนมัติ
/// ล้มเหลว
function sendMessageWithCurl($url, $headers, $post) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

function queryUserIDsFromUsersLine($conn) {
    $sql_query = "SELECT user_id FROM usersline";
    $result = $conn->query($sql_query);
    
    $user_ids = array();
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_ids[] = $row['user_id'];
        }
    }
    
    return $user_ids;
  }


  
function checkAndInsertLink($user_id, $message) {
    $conn = createDBConnection();
    
    // ค้นหา studentID ที่ตรงกับข้อความในตาราง students
    $query = "SELECT studentID FROM students WHERE studentID = '$message'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // studentID ตรงกัน ทำการเพิ่มข้อมูลเข้าตาราง linelink
        $sql = "INSERT INTO linelink (user_id, studentID) VALUES ('$user_id', '$message')";
        $conn->query($sql);
    }
    
    $conn->close();
}

//ไม่สามารถใช้ได้
function createReplyMessage($event) {
    $messages = array(
        'type' => 'text',
        'text' => 'Reply message : ' . $event['message']['text'] . "\nUser ID : " . $event['source']['userId'],
    );
    $post = json_encode(array(
        'replyToken' => $event['replyToken'],
        'messages' => array($messages),
    ));

    return $post;


}






?>