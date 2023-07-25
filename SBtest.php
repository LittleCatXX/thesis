<!DOCTYPE html>
<html>
<head>
    <title>ตัวอย่างการสแกนบาร์โค้ด</title>
    <script>
        var timeoutId;

        function scanBarcode(value) {
            clearTimeout(timeoutId);

            if (value.trim() !== "") {
                timeoutId = setTimeout(function() {
                    processBarcode(value);
                }, 500);
            } else {
                clearResult();
            }
        }

        function processBarcode(barcode) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    document.getElementById("resultContainer").innerHTML = xhr.responseText;
                    document.getElementById("barcode").value = "";
                    document.getElementById("barcode").focus();
                }
            };
            xhr.open("POST", "<?php echo $_SERVER['PHP_SELF']; ?>", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.send("barcode=" + barcode);
        }

        function clearResult() {
            document.getElementById("resultContainer").innerHTML = "";
        }

        function checkEnter(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
                var barcode = document.getElementById("barcode").value;
                scanBarcode(barcode);
            }
        }
    </script>
</head>
<body>
    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
        <label for="barcode">บาร์โค้ด:</label>
        <input type="text" name="barcode" id="barcode" oninput="scanBarcode(this.value)" onkeydown="checkEnter(event)">
    </form>

    <div id="resultContainer">
    <?php
    include "SBconn.php"; // เพิ่มบรรทัดนี้

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
        if ($result && $result->num_rows > 0) { // เพิ่มเงื่อนไข $result
            while ($row = $result->fetch_assoc()) {
                echo "บาร์โค้ดที่พบ: " . $row["itemBarcode"] . "<br>";
            }
        } else {
            echo "ไม่พบบาร์โค้ดที่ต้องการ";
        }

        // ปิดคำสั่ง SQL
        $stmt->close();
    }

    $conn->close(); // ปิดการเชื่อมต่อฐานข้อมูล

    exit(); // เพิ่มบรรทัดนี้เพื่อหยุดการทำงานของ PHP
    ?>
    </div>
</body>
</html>
