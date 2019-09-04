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


DROP TRIGGER /*!50032 IF EXISTS */ `before_insert_non_recurring_schedules`;

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `before_insert_non_recurring_schedules` BEFORE INSERT ON `non_recurring_schedules` 
    FOR EACH ROW BEGIN
  IF new.flight_number IS NULL THEN
    SET new.flight_number = LEFT(UPPER(UUID()), 7);
  END IF;
END;



DROP TRIGGER /*!50032 IF EXISTS */ `after_insert_non_recurring_schedules`;

CREATE
    /*!50017 DEFINER = 'root'@'localhost' */
    TRIGGER `after_insert_non_recurring_schedules` AFTER INSERT ON `non_recurring_schedules` 
    FOR EACH ROW BEGIN
  IF (SELECT COUNT(id) FROM generated_dates WHERE scheduled_date = CURDATE() ) THEN

		    INSERT INTO schedules (
			flight_number, 
			destination,
			customer_name,
			company_name,
      equipment,
			terminal,
			ground_time,
			departure,
			repeated,
			repeated_json,
			scheduled_date,
      start_date,
			stop_date,
			`status`,
			recurring,
			created_by,
			updated_by,
			created_at,
			updated_at
			)
		    	SELECT 
			       a.flight_number,
			       'NA' destination,
			       a.customer_name,
			       a.company_name,
			       a.equipment,
			       a.terminal,
			       a.ground_time,
			       a.departure,
			       'NA' repeated,
			       'NA' repeated_json,
			       CURDATE() scheduled_date,
			       a.start_date,
			       a.stop_date,
			       'Pending' `status`,
			       FALSE recurring,
			       a.created_by,
			       a.created_by updated_by,
			       CURDATE(),
			       CURDATE()
				FROM non_recurring_schedules a
					WHERE id = new.id AND a.start_date = CURDATE();


  END IF;
END;