<?php
include 'db_connection.php'; // เรียกใช้ไฟล์เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") { // ตรวจสอบว่ามีการส่งข้อมูลมาจากแบบฟอร์มหรือไม่
    if (isset($_POST["scannerInput"]) && is_numeric($_POST["scannerInput"])) { // ตรวจสอบว่ามีข้อมูลและเป็นตัวเลขหรือไม่
        $scannedValue = $_POST["scannerInput"]; // รับค่าที่ส่งมาจากฟอร์ม
        $valueLength = strlen($scannedValue); // ความยาวของค่าที่ส่งมา

        if ($valueLength === 8 || $valueLength === 14) { // ตรวจสอบความยาวของค่า

            $desiredValue = ($valueLength === 14) ? substr($scannedValue, 5, 8) : $scannedValue; // ตัดค่าตามตำแหน่งที่ต้องการ


            $conn = createDBConnection();
    $checkDuplicateSql = "SELECT * FROM scanneddata WHERE valueofscan = '$desiredValue'";
    $result = $conn->query($checkDuplicateSql);

    if ($result->num_rows > 0) {
        // ถ้ามีข้อมูลที่ซ้ำกันในฐานข้อมูลแล้ว
        echo "ข้อมูลซ้ำกัน ไม่สามารถลงทะเบียนซ้ำได้";
        $conn->close();

        header("Location: scanner.html");
            exit();

    } else {
        // ถ้าไม่มีข้อมูลที่ซ้ำกัน
        $insertSql = "INSERT INTO scanneddata (valueofscan) VALUES ('$desiredValue')";
        
        if ($conn->query($insertSql) === TRUE) {
            echo "เพิ่มข้อมูลเรียบร้อยแล้ว!";
        } else {
            echo "ข้อผิดพลาด: " . $insertSql . "<br>" . $conn->error;
        }

        $conn->close();

        // ... (โค้ดที่เหมือนเดิม)
    }

            $conn = createDBConnection(); // เชื่อมต่อฐานข้อมูล

            $sql = "INSERT INTO scanneddata (valueofscan) VALUES ('$desiredValue')"; // เตรียมคำสั่ง SQL เพื่อเพิ่มข้อมูล

            if ($conn->query($sql) === TRUE) { // ดำเนินการเพิ่มข้อมูล
                echo "เพิ่มข้อมูลเรียบร้อยแล้ว!";
            } else {
                echo "ข้อผิดพลาด: " . $sql . "<br>" . $conn->error;
            }

            $conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล

            // หน่วงเวลา 2 วินาที
            sleep(2);

            // กลับไปยังหน้าฟอร์ม
            header("Location: scanner.html");
            exit();
        } else {
            // แสดงข้อความและกลับหน้าเดิมหลังจาก 1 วินาที
            echo "ค่าที่ป้อนจะต้องมีความยาว 8 หรือ 14 หลัก โปรดป้อนค่าที่เป็นตัวเลข";
            echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
        }
    } else {
        // แสดงข้อความและกลับหน้าเดิมหลังจาก 1 วินาที
        echo "ค่าที่ป้อนไม่ถูกต้อง โปรดป้อนเป็นตัวเลข หรือเปลี่ยนเป็นภาษาแป้นพิมของคุณ";
        echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
    }
}
include 'store_cleanup_data.php';
?>
