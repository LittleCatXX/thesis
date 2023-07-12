<!-- VI5VoYtGOly1LDNIeMvSzpCtnAIeGJBhE4skSsNrght -->
<?php 


    $header = "Testing Line Notify";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $id = $_POST['id'];
    $user_input = $_POST['user_input'];
    

    
    if (isset($_GET['barcode'])) {
        $barcode = $_GET['barcode'];
    
        // ทำสิ่งที่คุณต้องการกับค่าบาร์โค้ดที่สแกนได้
        // เช่น บันทึกลงฐานข้อมูล ประมวลผลข้อมูล หรืออื่น ๆ
        // ตัวอย่าง: แสดงข้อมูลบาร์โค้ด
        echo "คุณสแกนบาร์โค้ด: " . $barcode;
    }
    

    $message = $header.
                "\n". "ชื่อ: " . $firstname .
                "\n". "นามสกุล: " . $lastname .
                "\n". "รหัส: " . $id .
                "\n". "**barcode test block** : " . $barcode .
                "\n". "ข้อความใน text : " . $user_input;
    
                if (isset($_POST["submit"])) {
                    if ($firstname !== "" || $lastname !== "" || $id !== "" || $user_input !== "") {
                        // เรียกใช้งานฟังก์ชันส่งข้อความผ่าน Line Notify
                        sendlinemesg();
                        header('Content-Type: text/html; charset=utf8');
                        $res = notify_message($message);
                        echo "<script>
                                document.getElementById('message').innerText = 'ส่งข้อมูลแล้ว';
                              </script>";
                        header("location: index.php");
                    } else {
                        echo "<script>
                                document.getElementById('message').innerText = 'ยังไม่ได้เช็คชื่อ';
                              </script>";
                        header("location: index.php");
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