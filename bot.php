<?php
include_once('./vendor/autoload.php');

$httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>'); // ใส่ token แทน <channel access token> จาก tab Basic settings
$bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']); // ใส่แทน <channel secret> ด้วยข้อมูลจาก Messaging API นะ

$data = file_get_contents('php://input');
if ($data == '')
    return;

file_put_contents('chkData.txt', $data . PHP_EOL, FILE_APPEND);
return;

$textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
$response = $bot->replyMessage('<reply token>', $textMessageBuilder);
if ($response->isSucceeded()) {
    echo 'Succeeded!';
    return;
}

// Failed
echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
?>