<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("การเชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}

if (isset($_POST['id_to_check'])) {
    $id_to_check = $_POST['id_to_check'];

    $sql = "SELECT * FROM table_name WHERE id = '$id_to_check'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // ID พบในตาราง
        while ($row = $result->fetch_assoc()) {
            // ดำเนินการตามค่าที่พบ
            echo "ID พบในตาราง: " . $row["id"];
            // ...
        }
    } else {
        // ID ไม่พบในตาราง
        echo "ID ไม่พบในตาราง";
    }
}

$conn->close();

?>
