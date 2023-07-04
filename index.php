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
    </style>
<h1 class="content">Line Notify Test</h1>
</head>
<body>
    <div class="content">
        <form action="line-notify.php" method="post">
            <input name="firstname" placeholder='ชื่อ (required)' type='text'>
            <br>
            <input name="lastname" placeholder='นามสกุล (required)' type='text'>
            <br>
            <input placeholder='รหัสนักเรียน (required)' name="id" type='text'>
            <br>
            <input class='send' name="submit" type='submit' value='ส่ง'>
        </form>
    </div>
</body>
</html>