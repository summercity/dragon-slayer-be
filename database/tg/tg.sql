DROP TRIGGER /*!50032 IF EXISTS */ `before_insert_schedules`;
CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `before_insert_schedules` BEFORE INSERT ON `schedules` 
    FOR EACH ROW BEGIN
  IF new.id IS NULL THEN
    SET new.id = UUID();
  END IF;
END;


DROP TRIGGER /*!50032 IF EXISTS */ `before_insert_generated_dates`;
CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `before_insert_generated_dates` BEFORE INSERT ON `generated_dates` 
    FOR EACH ROW BEGIN
  IF new.id IS NULL THEN
    SET new.id = UUID();
  END IF;
END;
