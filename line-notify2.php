<!-- VI5VoYtGOly1LDNIeMvSzpCtnAIeGJBhE4skSsNrght -->
<?php 


    $header = "Testing Line Notify";
    $vehicle1 = $_POST['vehicle1'];
    $vehicle2 = $_POST['vehicle2'];
    
    $message = $header.
                "\n". $vehicle1 .
                "\n". $vehicle2;

    if (isset($_POST["submit"])) {
        if ( $vehicle1 <> "" ||  $vehicle2 <> ""  ) {
            sendlinemesg();
            header('Content-Type: text/html; charset=utf8');
            $res = notify_message($message);
            echo "<script>alert('เช็คชื่อแล้ว');</script>";
            header("location: index2.php");
        } else {
            echo "<script>alert('ยังไม่ได้เช็คชื่อ');</script>";
            header("location: index2.php");
        }
    }

    function sendlinemesg() {
        define('LINE_API',"https://notify-api.line.me/api/notify");
        define('LINE_TOKEN',"VI5VoYtGOly1LDNIeMvSzpCtnAIeGJBhE4skSsNrght");

        function notify_message($message) {
            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData,'','&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                ."Authorization: Bearer ".LINE_TOKEN."\r\n"
                                ."Content-Length: ".strlen($queryData)."\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINE_API, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }
    }


?>