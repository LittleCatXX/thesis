<?php
require __DIR__ . '/vendor/autoload.php';



use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event\MessageEvent\TextMessage;




$channelAccessToken = "P52UXHhWlbVPXb0ikNPk8135dzvwGrZ92/4cxDrwDlm/iM+VkQ2K1neE6r1ur1dEddlpHANxARzGBpTBPaPmVzVamVTwY8od9++E8Ox8v9VAqb1hg96ttFho4VP67FE2g/dBhkNRIysMAR1MV7VRswdB04t89/1O/w1cDnyilFU=";
$channelSecret = "79c62fefb47ab6f0a4b23d04cefa3cd2";

$httpClient = new CurlHTTPClient($channelAccessToken);
$bot = new LINEBot($httpClient, ['channelSecret' => $channelSecret]);

$signature = $_SERVER['HTTP_' . LINEBot\Constant\HTTPHeader::LINE_SIGNATURE];
$events = $bot->parseEventRequest(file_get_contents('php://input'), $signature);

foreach ($events as $event) {
    if ($event instanceof TextMessage) {
        $messageText = $event->getText();
        
        if ($messageText == 'สวัสดี') {
            $replyText = 'ว่าไงชาวโลก';
        } else {
            $replyText = 'ขอโทษครับ ฉันไม่เข้าใจคำถาม';
        }
        
        $bot->replyText($event->getReplyToken(), $replyText);
    }
}



?>

