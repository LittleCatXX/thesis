<?php
require __DIR__ . '/vendor/autoload.php';


use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event\MessageEvent\TextMessage;

include 'token.php';
$access_token 
$channelSecret 

$httpClient = new CurlHTTPClient($access_token );
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$signature = $_SERVER['HTTP_' . LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
    if ($event instanceof TextMessage) {
        $messageText = $event->getText();
        
        if ($messageText == 'สวัสดี') {
            $replyText = 'ว่าไงชาวโลก';
        } 

        //เพิ่ม IF ได้
        
        else {
            $replyText = 'ขอโทษครับ ฉันไม่เข้าใจคำถาม';
        }
        
        $bot->replyText($event->getReplyToken(), $replyText);
    }
}
?>

