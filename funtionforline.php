<?php
///ไม่น่าได้ใช้โค้ดนี้ 

// Usage $channelAccessToken = '<your-channel-access-token>'; $messagingApiClient = createMessagingApiClient($channelAccessToken);
// Create the bot client instance


use \GuzzleHttp\Client;
use \LINE\Clients\MessagingApi\Configuration;
use \LINE\Clients\MessagingApi\Api\MessagingApiApi;

function createMessagingApiClient($channelAccessToken) {
    // Create the Guzzle HTTP client instance
    $client = new Client();

    // Create the LINE Messaging API configuration instance
    $config = new Configuration();
    $config->setAccessToken($channelAccessToken);

    // Create the MessagingApiApi instance
    $messagingApi = new MessagingApiApi([
        'client' => $client,
        'config' => $config,
    ]);

    return $messagingApi;
}



// ใช้ฟังก์ชันเพื่อดึงข้อมูล JSON จากการรับข้อมูล  $events = getJSONDataFromInput();
function getJSONDataFromInput() {
  $raw_input = file_get_contents('php://input');
  $data = json_decode($raw_input, true);
  return $data;
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
}


// ทำการคิวรีค่า $user_id ที่เก็บในตาราง usersline
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


















?>