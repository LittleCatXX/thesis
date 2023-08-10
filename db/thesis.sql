DELIMITER //
CREATE TRIGGER after_update_scanneddata
AFTER UPDATE ON scanneddata FOR EACH ROW
BEGIN
    -- ทำการอัพเดตข้อมูลในตาราง checklistdata
    UPDATE checklistdata
    SET value = NEW.value
    WHERE idchecklist = OLD.value;
END;
//
DELIMITER ;


DELIMITER //
CREATE TRIGGER after_insert_scanneddata
AFTER INSERT ON scanneddata FOR EACH ROW
BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata
    INSERT INTO checklistdata (studentID)
    VALUES (NEW.studentID NOW());
END;
//
DELIMITER ;


BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata
    INSERT INTO checklistdata (studentID)
    VALUES (studentID);
END


v1
BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata
    INSERT INTO checklistdata (studentID)
    VALUES (studentID);
END

v2

DELIMITER //
CREATE TRIGGER after_insert_students
AFTER INSERT ON students FOR EACH ROW
BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata โดยให้ค่า value เป็น NULL
    INSERT INTO checklistdata (studentID)
    VALUES (NEW.studentID, NULL, NOW());
END;
//
DELIMITER ;

v2

DELIMITER //
CREATE TRIGGER after_insert_scanneddata
AFTER INSERT ON scanneddata FOR EACH ROW
BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata
    INSERT INTO checklistdata (valueofscan)
    VALUES (NEW.valueofscan, NULL, NOW());
END
//
DELIMITER ;


สำหรับ Trigger after_update_scanneddata:

DELIMITER //
CREATE TRIGGER after_update_scanneddata
AFTER UPDATE ON scanneddata FOR EACH ROW
BEGIN
    -- อัพเดตข้อมูลในตาราง checklistdata ที่มี valueofscan ตรงกับข้อมูลที่อัพเดตใน scanneddata
    UPDATE checklistdata
    SET valueofscan = NEW.valueofscan,
        created_at = NOW()
    WHERE valueofscan = OLD.valueofscan; -- ใช้ OLD.valueofscan เพื่ออ้างถึงค่าก่อนการอัพเดต
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_delete_scanneddata
AFTER DELETE ON scanneddata FOR EACH ROW
BEGIN
    -- ลบข้อมูลในตาราง checklistdata ที่มี valueofscan ตรงกับข้อมูลที่ถูกลบใน scanneddata
    DELETE FROM checklistdata
    WHERE valueofscan = OLD.valueofscan; -- ใช้ OLD.valueofscan เพื่ออ้างถึงค่าก่อนการลบ
END;
//
DELIMITER ;


DELIMITER //
CREATE TRIGGER after_update_students
AFTER UPDATE ON students FOR EACH ROW
BEGIN
    -- อัพเดตข้อมูลในตาราง checklistdata ที่มี studentID ตรงกับข้อมูลที่อัพเดตใน students
    UPDATE checklistdata
    SET studentID = NEW.studentID
    WHERE studentID = OLD.studentID;
END;
//
DELIMITER ;

DELIMITER //
CREATE TRIGGER after_delete_students
AFTER DELETE ON students FOR EACH ROW
BEGIN
    -- ลบข้อมูลในตาราง checklistdata ที่มี studentID ตรงกับข้อมูลที่ถูกลบใน students
    DELETE FROM checklistdata
    WHERE studentID = OLD.studentID;
END;
//
DELIMITER ;



CREATE TRIGGER `after_insert_students` AFTER INSERT ON `students`
 FOR EACH ROW BEGIN
    -- เพิ่มข้อมูลใหม่ลงในตาราง checklistdata โดยให้ค่า value เป็น NULL
    INSERT INTO checklistdata (studentID)
    VALUES (NEW.studentID);
END