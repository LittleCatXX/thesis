<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$header = "Testing Line Notify";
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$id = $_POST['id'];
$user_input = $_POST['user_input'];

if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];
} else {
    $barcode = "";
}

$message = $header.
            "\n". "ชื่อ: " . $firstname .
            "\n". "นามสกุล: " . $lastname .
            "\n". "รหัส: " . $id .
            "\n". "**barcode test block** : " . $barcode .
            "\n". "ข้อความใน text : " . $user_input;

            if (isset($_POST["submit"])) {
                if ($firstname !== "" || $lastname !== "" || $id !== "" || $user_input !== "") {
                    // เรียกใช้งานฟังก์ชันส่งข้อความผ่าน Line Notify แล้วเก็บข้อมูลต่างๆไว้ในระบบ ใน  table line_notify_data
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
             
                $sql = "INSERT INTO line_notify_data (firstname, lastname, id_number, user_input) VALUES ('$firstname', '$lastname', '$id', '$user_input')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    alert('ส่งข้อมูลและบันทึกลงในฐานข้อมูลแล้ว');
                    window.location.href = 'index.php';
                  </script>";
            exit();
        } else {
            echo "เกิดข้อผิดพลาดในการบันทึกข้อมูล: " . mysqli_error($conn);
            exit();
        }
    } else {
        echo "<script>
                alert('ยังไม่ได้เช็คชื่อ');
                window.location.href = 'index.php';
              </script>";
        exit();
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




















mysqli_close($conn);

?>
