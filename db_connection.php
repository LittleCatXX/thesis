<?php

function createDBConnection() {
    // ข้อมูลสำหรับการเชื่อมต่อฐานข้อมูล
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "thesis";

    // สร้างการเชื่อมต่อใหม่กับ MySQL
    $conn = new mysqli($servername, $username, $password, $dbname);

    // ตรวจสอบการเชื่อมต่อ
    if ($conn->connect_error) {
        die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
    }

    return $conn;
}
