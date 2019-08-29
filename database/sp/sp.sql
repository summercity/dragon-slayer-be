DROP PROCEDURE IF EXISTS `sp_generate_schedule`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_generate_schedule`(IN userId BIGINT(20))
BEGIN
		
	IF (SELECT COUNT(id) FROM generated_dates WHERE scheduled_date = CURDATE() ) THEN
		BEGIN
		    SELECT * FROM schedules WHERE scheduled_date = CURDATE();
		END;
		ELSE
		BEGIN
		    INSERT INTO generated_dates (
			created_at,
			updated_at,
			generated_by,
			scheduled_date
		    )
		    VALUES
		    (CURDATE(), CURDATE(), userId,  CURDATE());		
		
		    INSERT INTO schedules (
			flight_number, 
			destination,
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
			       a.destination,
			       a.equipment,
			       a.terminal,
			       a.ground_time,
			       a.departure,
			       a.repeated,
			       a.repeated_json,
			       CURDATE() scheduled_date,
			       a.start_date,
			       a.stop_date,
			       'Pending' `status`,
			       TRUE recurring,
			       userId created_by,
			       userId updated_by,
			       CURDATE(),
			       CURDATE()
				FROM recurring_schedules a
					WHERE FIND_IN_SET(DAYNAME(NOW()), a.repeated);
		    
		    SELECT * FROM schedules WHERE scheduled_date = CURDATE();
		END;
	END IF;
    END;





DROP PROCEDURE IF EXISTS `sp_get_generated_date_for_today`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_generated_date_for_today`()
BEGIN
	SELECT * FROM generated_dates
		WHERE scheduled_date = CURDATE();
END;




DROP PROCEDURE IF EXISTS `sp_get_generated_schedules_for_today`;
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_generated_schedules_for_today`()
BEGIN
	SELECT * FROM schedules
		WHERE scheduled_date = CURDATE();
END;