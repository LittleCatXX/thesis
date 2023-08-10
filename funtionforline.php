<?php

// Create the bot client instance
$client = new \GuzzleHttp\Client();
$config = new \LINE\Clients\MessagingApi\Configuration();
$config->setAccessToken('<channel access token>');
$messagingApi = new \LINE\Clients\MessagingApi\Api\MessagingApiApi(
  client: $client,
  config: $config,
);



?>