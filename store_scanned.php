<?php
include 'db_connection.php';
include 'funtion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["scannerInput"]) && is_numeric($_POST["scannerInput"])) {
        $scannedValue = $_POST["scannerInput"];
        $valueLength = strlen($scannedValue);

        if ($valueLength === 8 || $valueLength === 14) {
            $conn = createDBConnection();
            $desiredValue = extractDesiredValue($scannedValue, $valueLength);

            // ตั้งคำสั่ง SQL และตรวจสอบข้อมูล...
            
            // ทำการเพิ่มข้อมูลลงในตาราง checklistdata...
            echo insertDataIntoChecklist($conn, $desiredValue);
            
            $conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล
        } else {
            echo "Input must be either 8 or 14 digits long. Please enter a numeric value.";
            echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
        }
    } else {
        echo "Invalid input. Please enter a numeric value or change lan in keyboard. โปรดใส่เป็นตัวเลข หรือ เปลี่ยนภาษาแป้นพิม";
        echo "<script>setTimeout(function(){ window.location.href = 'scanner.html'; }, 1000);</script>";
    }
}
?>
