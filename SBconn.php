<?php
// สร้างการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่าบาร์โค้ดผ่าน input
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['barcode'])) {
    // ค่าตัวเลขบาร์โค้ดที่ต้องการเช็ค
    $barcode = $_POST['barcode'];

    // สร้างคำสั่ง SQL SELECT ด้วย Prepared Statements
    $stmt = $conn->prepare("SELECT * FROM save_barcode_data WHERE itemBarcode = ?");
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "บาร์โค้ดที่พบ: " . $row["itemBarcode"] . "<br>";
        }
    } else {
        echo "ไม่พบบาร์โค้ดที่ต้องการ";
    }

    // ปิดคำสั่ง SQL
    $stmt->close();
}

// ปิดการเชื่อมต่อฐานข้อมูล

?>
