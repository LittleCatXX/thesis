<?php
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // ตรวจสอบว่ามีการส่งข้อมูลมาจากแบบฟอร์มหรือไม่
    if (isset($_POST["scannerInput"]) && is_numeric($_POST["scannerInput"])) {
        // ตรวจสอบความยาวของค่าที่เข้ามา
        $scannedValue = $_POST["scannerInput"];
        $valueLength = strlen($scannedValue);

        // ตรวจสอบว่าค่ามีความยาว 8 หรือ 14 หลัก
        if ($valueLength === 8 || $valueLength === 14) {
            // ถ้าค่ามี 14 หลักให้ตัดค่าตามตำแหน่งที่ต้องการ (ตั้งแต่ตำแหน่งที่ 5 ถึง 8)
            $desiredValue = ($valueLength === 14) ? substr($scannedValue, 5, 8) : $scannedValue;

            // เชื่อมต่อฐานข้อมูล
            $conn = createDBConnection();

            // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง
            $sql = "INSERT INTO scanned_data (value) VALUES ('$desiredValue')";

            // ดำเนินการเพิ่มข้อมูล
            if ($conn->query($sql) === TRUE) {
                echo "Data added successfully!";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            // ปิดการเชื่อมต่อฐานข้อมูล
            $conn->close();

            // เรียกใช้ฟังก์ชันอื่น

            // หน่วงเวลา 2 วินาที
            sleep(2);

            // กลับไปยังหน้าฟอร์ม
            header("Location: scanner.html");
            exit();
        } else {
            // แสดงข้อความและกลับหน้าเดิมหลังจาก 5 วินาที
            echo "Input must be either 8 or 14 digits long. Please enter a numeric value.";
            echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
        }
    } else {
        // แสดงข้อความและกลับหน้าเดิมหลังจาก 5 วินาที
        echo "Invalid input. Please enter a numeric valueor change lan in keyboad. โปรดใส่เป็นตัวเลข หรือ เปลี่ยนภาษาแป้นพิม";
        echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
    }
}
