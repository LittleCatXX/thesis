<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        input {
            border:1px solid #ccc;
            width:200px;
            padding:10px;
            margin:5px 15px;
            border-radius:5px;
        }
        .send {
            width:220px;
        }

        .content {
            max-width: 500px;
            margin: auto;
            background: white;
            padding: 10px;
        }

        /* สไตล์สำหรับ Popup */
        .popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #ffffff;
            border: 1px solid #cccccc;
            padding: 20px;
            z-index: 9999;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
            display: none; /* ซ่อน popup ตอนเริ่มต้น */
        }
    </style>

    <script>
        function enableText() {
            var checkbox = document.getElementById("my_checkbox");
            var inputText = document.getElementById("user_input");
            inputText.disabled = !checkbox.checked;
        }

        function showPopup() {
            // แสดง popup
            document.getElementById('popup').style.display = 'block';

            // เพิ่ม event listener ให้กับเอกสาร
            document.addEventListener('click', closePopupOnClickOutside);
        }

        function closePopup() {
            // ปิด popup
            document.getElementById('popup').style.display = 'none';

            // ลบ event listener ออกจากเอกสาร
            document.removeEventListener('click', closePopupOnClickOutside);
        }

        function closePopupOnClickOutside(event) {
            // ตรวจสอบว่าคลิกภายนอกพื้นที่ของ Popup
            if (!event.target.closest('.popup')) {
                closePopup();
            }
        }
    </script>
</head>
<body>
    <div class="content">
        <?php include "navbar.php"; ?>

        <form id="myForm" action="line-notify.php" method="post">
            <input name="firstname" placeholder='ชื่อ (required)' type='text'>
            <br>
            <input name="lastname" placeholder='นามสกุล (required)' type='text'>
            <br>
            <input placeholder='รหัสนักเรียน (required)' name="id" type='text'>

            <br>

            <input type="checkbox" id="my_checkbox" onclick="enableText()"> อื่นๆ <br>
            <input type="text" id="user_input" name="user_input" placeholder="กรอกข้อความ" disabled><br> 

            <input class='send' name="submit" type='submit' value='ส่ง' onclick="showPopup()">
        </form>

        <div id="popup" class="popup">
            <h3>ส่งข้อมูลแล้ว</h3>
            <button onclick="closePopup()">ลงทะเบียนอีกครั้ง</button>
        </div>
    </div>
</body>
</html>
