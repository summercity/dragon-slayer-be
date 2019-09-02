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
  IF (SELECT COUNT(id) FROM generated_dates WHERE scheduled_date = new.start_date ) THEN
    BEGIN
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
	   VALUES (
                new.flight_number,
                'NA',
                new.customer_name,
                new.company_name,
                new.equipment,
                new.terminal,
                new.ground_time,
                new.departure,
                'NA',
                'NA',
                CURDATE(),
                new.start_date,
                new.stop_date,
                'Pending',
                FALSE,
                new.created_by,
                new.updated_by,
                CURDATE(),
                CURDATE()
	    );
    END;
  END IF;
END;