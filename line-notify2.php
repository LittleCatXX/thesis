<?php 


    $header = "Testing Line Notify";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id = $_POST['id'];

    $message = $header.
                "\n". "ชื่อ: " . $firstname .
                "\n". "นามสกุล: " . $lastname .
                "\n". "รหัส: " . $id;

    if (isset($_POST["submit"])) {
        if ( $firstname <> "" ||  $lastname <> "" ||  $phone <> "" ||  $email <> "" ) {
            sendlinemesg();
            header('Content-Type: text/html; charset=utf8');
            $res = notify_message($message);
            echo "<script>alert('เช็คชื่อแล้ว');</script>";
            header("location: index.php");
        } else {
            echo "<script>alert('ยังไม่ได้เช็คชื่อ');</script>";
            header("location: index.php");
        }
    }
        function sendlinemesg() {
            $channelAccessToken = "+juKyX1yFgY+1TkQaWUUyMwb3cC4sTC6Wk+zDATAyFRocU48+NGh/tZlZUE5F4cYSehA0oer88nexDJuomtLu32VFrh6QXPR1uN8kZbLw88L93rMCw8Dqx9X2sBL0GVb9jcm8e+3tjHCOMaH52/59gdB04t89/1O/w1cDnyilFU=";
            $channelSecret = "c02ad4f659aabc2867cf6a5154ce3f78";

            $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($channelAccessToken);
            $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => $channelSecret]);

            $signature = $_SERVER['HTTP_X_LINE_SIGNATURE'];
            $body = file_get_contents('php://input');

            try {
            $events = $bot->parseEventRequest($body, $signature);
            foreach ($events as $event) {
                // ประมวลผลเหตุการณ์ต่าง ๆ จาก Line Chatbot ที่นี่
                // เช่น ส่งข้อความกลับไปยังผู้ใช้
                }
            } catch (Exception $e) {
                // จัดการข้อผิดพลาดที่เกิดขึ้น
        }
    }


?>