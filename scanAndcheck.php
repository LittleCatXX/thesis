<!DOCTYPE html>
<html>
<head>
    <title>ตัวอย่างการสแกนบาร์โค้ด</title>
    <link rel="stylesheet" type="text/css" href="style.css"> <!-- เพิ่มเป็นตัวอย่างเท่านั้น -->
</head>
<body>
<?php include "navbar.php"; ?>
<form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
    <label for="barcode">บาร์โค้ด:</label>
    <input type="text" name="barcode" id="barcode" oninput="clearResult()">
    <input type="submit" value="เช็ค" onclick="processBarcode(event)">
</form>

<script>
function processBarcode(event) {
    event.preventDefault(); // ป้องกันการรีโหลดหน้าเว็บ

    var barcode = document.getElementById("barcode").value;

    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById("resultContainer").innerHTML = xhr.responseText;
            document.getElementById("barcode").value = "";
        }
    };
    xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.send("barcode=" + barcode);
}

function clearResult() {
    document.getElementById("resultContainer").innerHTML = "";
}
</script>

<div id="resultContainer"></div>

</body>
</html>


<?php
// ข้อมูลการเชื่อมต่อฐานข้อมูล
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "thesis";

// สร้างการเชื่อมต่อ
$conn = new mysqli($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if ($conn->connect_error) {
    die("การเชื่อมต่อล้มเหลว: " . $conn->connect_error);
}

// ตรวจสอบว่ามีการส่งค่าบาร์โค้ดผ่าน input
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['barcode'])) {
    // ค่าตัวเลขบาร์โค้ดที่ต้องการเช็ค
    $barcode = $_POST['barcode'];

    // สร้างคำสั่ง SQL SELECT
    $sql = "SELECT * FROM save_barcode_data WHERE itemBarcode = '$barcode'";

    // ส่งคำสั่ง SQL ไปยังฐานข้อมูล
    $result = $conn->query($sql);

    // ตรวจสอบผลลัพธ์
    if ($result->num_rows > 0) {
        // มีข้อมูลในตารางที่ตรงกับบาร์โค้ดที่เช็ค
        while ($row = $result->fetch_assoc()) {
            // ดำเนินการกับข้อมูลที่พบ
            // เช่น แสดงข้อมูลบาร์โค้ดหรือคอลัมน์อื่น ๆ
            echo "บาร์โค้ดที่พบ: " . $row["itemBarcode"] . "<br>";
        }
    } else {
        // ไม่มีข้อมูลในตารางที่ตรงกับบาร์โค้ดที่เช็ค
        echo "ไม่พบบาร์โค้ดที่ต้องการ";
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
$conn->close();
?>
