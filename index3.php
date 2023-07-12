<!DOCTYPE html>
<html>
<head>
  <title>Checkbox และข้อความใน PHP</title>
  <script>
    function enableText() {
      var checkbox = document.getElementById("my_checkbox");
      var inputText = document.getElementById("user_input");
      inputText.disabled = !checkbox.checked;
    }
  </script>
</head>
<body>
  <form method="POST" action="process.php">
    <input type="checkbox" id="my_checkbox" onclick="enableText()"> เลือกฉัน<br>
    <input type="text" id="user_input" name="user_input" placeholder="กรอกข้อความ" disabled><br>
    <input type="submit" value="ส่งข้อมูล">
  </form>
</body>
</html>



//  <input type="checkbox" id="vehicle1" name="vehicle1" value="First"  placeholder= 'ใส่สิ่งที่ต้องการ'       >
                 <label for="vehicle1"> เช็ค </label><br>
                 <input type="checkbox" id="vehicle2" name="vehicle2" value="Big">
                 <label for="vehicle2"> test block II</label><br>  