<?php

/// query 
function queryUserIDsFromUsersLine($conn) {
    $sql_query = "SELECT user_id FROM usersline";
    $result = $conn->query($sql_query);
    
    $user_ids = array();
    
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_ids[] = $row['user_id'];
        }
    }
    
    return $user_ids;
  }


  ////ตารางเก็บข้อมูล linelink ไว้เก็บข้อมูลของ webhook 
function checkAndInsertLink($user_id, $message) {
    $conn = createDBConnection();
    
    // ค้นหา studentID ที่ตรงกับข้อความในตาราง students
    $query = "SELECT studentID FROM students WHERE studentID = '$message'";
    $result = $conn->query($query);
    
    if ($result->num_rows > 0) {
        // studentID ตรงกัน ทำการเพิ่มข้อมูลเข้าตาราง linelink
        $sql = "INSERT INTO linelink (user_id, studentID) VALUES ('$user_id', '$message')";
        $conn->query($sql);
    }
    
    $conn->close();
}








?>