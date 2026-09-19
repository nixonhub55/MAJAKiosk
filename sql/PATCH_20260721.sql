
-- USE `manilajockey_v4_test`;

 
-- ALTER TABLE overtimeform ADD isUndertime INT NOT NULL DEFAULT 0;

DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_overtime_submit_request`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_overtime_submit_request`(  
    IN pint_mode INT,    
    IN ot_AppNo VARCHAR(30),
    IN ot_ID VARCHAR(20),
    IN ot_Reason TEXT,
    IN ot_type VARCHAR(50),
    IN ot_location VARCHAR(50),
    IN ot_date VARCHAR(50),  
    IN ot_from VARCHAR(50),
    IN ot_to VARCHAR(50),
    IN ot_tot_break VARCHAR(15),
    IN ot_time_from VARCHAR(15), 
    IN ot_time_to VARCHAR(15), 
    IN time_tot VARCHAR(15), 
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtRemarks",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;
	
	SET num = 0;
	SET msg = '';
	
	SET ot_tot_break=(CASE WHEN ot_tot_break='0.00' THEN '00:00' ELSE ot_tot_break END);
	
	SET @fn_check_used_dates = (SELECT fn_check_used_dates(0,CONCAT('{"otFrom" : "',ot_from,'","otTo" : "',ot_to,'","otID" : "',ot_ID,'"}')));
        
        IF (@fn_check_used_dates<>'')THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"lbl_from_date",
				"msg":"',@fn_check_used_dates,'"	
			       }');  
            LEAVE proc_start;
        END IF;  
	 
	IF ((SELECT fn_time_5_strings(ot_time_from))=0) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_otTimeFrom",
			"msg":"Invalid OT Time From"	
			}');
		LEAVE proc_start;
	 END IF;
	 
	
	 
	 IF ((SELECT fn_time_5_strings(ot_time_to))=0) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_otTimeFrom",
			"msg":"Invalid OT Time To"	
			}');
		LEAVE proc_start;
	 END IF;
	 
	
	 IF ((SELECT fn_time_5_strings(ot_tot_break))=0) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_tot_break",
			"msg":"Invalid OT Break Time"	
			}');
		LEAVE proc_start;
	 END IF;
	  
	 
	SET @ottothours=(SELECT fn_ot_total_time_compute(ot_from,ot_to,ot_time_from,ot_time_to,ot_tot_break)); 
	SET @otCompute = @ottothours; 
	 
	
        SET @otComputeInt = CAST(@otCompute AS FLOAT);
	SET @otMinimumMinues = ROUND(CAST((SELECT minOTHours FROM companySetting) AS FLOAT),2);
	SET @otComputeMinutes=ROUND(CAST((SELECT HOUR(@otCompute) * 60 + MINUTE(@otCompute) AS total_minutes) AS FLOAT),2);
	SET @minTime = LEFT((SELECT SEC_TO_TIME(@otMinimumMinues * 60) AS time_result),8);
	
	 
     IF (ot_type IN ('','0')) THEN 
    
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_appOvertimeType",
			"msg":"Please select [Overtime Type]"	
		       }';
     LEAVE proc_start;
     END IF;
     
     
     IF (ot_location='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_appLocation",
			"msg":"Please select [Location]"	
		       }';
     LEAVE proc_start;
     END IF;
     
     
	IF (ot_date='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ot_date",
			"msg":"Please enter [Overtime Date]"	
		       }';
	LEAVE proc_start;
	END IF;
	
	 
	IF (ot_from='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_from_date",
			"msg":"Please enter [From Date]"	
		       }';
	LEAVE proc_start;
	END IF;
	
	SET @datediff = (SELECT DATEDIFF(ot_date,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(ot_date, INTERVAL (@datediff-3) DAY));
	
	
	 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_ot_date",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;
	 
	IF (ot_to='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_to_date",
			"msg":"Please enter [To Date]"	
		       }'; 
	LEAVE proc_start;
	END IF;
	
	
    
	
     --	IF ((@otMinimumMinues>@otComputeMinutes) AND ((DAYOFWEEK(ot_time_from) NOT IN (1,7)) OR (DAYOFWEEK(ot_time_to) NOT IN (1,7))) ) THEN  
     IF (@otMinimumMinues>@otComputeMinutes) THEN  
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_appTotalTime",
			"msg":"Overtime total should be greather than or equal ',@minTime,'"	
		       }');
     LEAVE proc_start;
     END IF;
     
 
	
     -- IF ((((SELECT CAST((@ottothours) AS INT))<=0) OR (@otComputeInt<=0))  AND ((DAYOFWEEK(ot_time_from) NOT IN (1,7)) OR (DAYOFWEEK(ot_time_to) NOT IN (1,7)))) THEN  
     IF (((SELECT CAST((@ottothours) AS INT))<=0) OR (@otComputeInt<=0)) THEN  
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_appTotalTime",
			"msg":"Invalid [Total Time]"	
		       }');
     LEAVE proc_start;
     END IF;
     
     
     IF (ot_Reason IN ('')) THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_txtRemarks",
			"msg":"Please enter [OT Remarks]"	
		       }'; 
	LEAVE proc_start;
	END IF;
	 
	
	SET @appDetails = CONCAT('{"appNo": "',ot_AppNo,'", "otID": "',ot_ID,'", "otDate": "',ot_date,'", "otFrDate": "',ot_from,'", "otToDate": "',ot_to,'", "fromTime" : "',ot_time_from,'", "toTime" : "',ot_time_to,'"}'); 
	CALL sp_check_application_if_exists(0,0,@appDetails, @valNum, @valmsg);
	   
	IF (@valNum=1) THEN
	
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_appOvertimeType",
				"msg":"',@valmsg,'"	
			       }');
		LEAVE proc_start;
	END IF;
	
	CALL sp_check_exists_app_valid_for_edit(0,ot_AppNo,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtRemarks",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	
   
	IF (pint_mode=1) THEN
		
		START TRANSACTION; 
		SET @fullname=(SELECT (CONCAT(firstname,' ',middlename,' ',lastname)) FROM identity WHERE identityid=ot_ID); 
		SET @code=(SELECT CODE  FROM identity WHERE identityid=ot_ID); 
		SET @costcode=(SELECT MAX(costcode)  FROM employeemovement WHERE CODE=@code);
		SET @depcode=(SELECT MAX(departmentcode)  FROM employeemovement WHERE CODE=@code); 
		-- SET @ottothours=(SELECT fn_ot_total_time_compute(ot_date,ot_from,ot_time_from,ot_time_to,@TotBreakTimeValidation)); -- (SELECT LEFT(TIMEDIFF(ot_time_to, ot_time_from),5)); 
		SET @otbreak=(SELECT FORMAT((HOUR(ot_tot_break) + MINUTE(ot_tot_break) / 60), 2)); 
		SET @batchid = (SELECT batchid   FROM identity WHERE identityid=ot_ID);  
		SET @locationname=(SELECT locationname  FROM location WHERE locationcode=ot_location); 
		SET @ottot_hours=(SELECT LEFT(TIME(@ottothours) - INTERVAL @otbreak HOUR,5));
		 
		
		IF (ot_AppNo>0) THEN 
			
			UPDATE overtimeform
			SET 	otID=ot_ID,
				otName=@fullname,
				otcoscenter=@costcode, 
				ottimefrom=ot_time_from,
				ottimeto=ot_time_to,
				otTotHours=@ottothours, 
				otReason=ot_Reason, 
				department=@depcode,
				otbreak=@otbreak,
				ottype=ot_type,
				batchid=@batchid,
				location=UPPER(ot_location),
				locationname=@locationname,
				otfrdate=ot_from,
				ottodate=ot_to
			WHERE otAppNo=ot_AppNo;
			
			CALL sp_approval_insert(0,ot_AppNo,ot_ID,@num1, @msg1); 
			
		ELSE
			INSERT INTO overtimeform (otID,otName,otcoscenter,otdate,ottimefrom,ottimeto,otTotHours,othours,otminutes,otReason,otreqdate,department,otbreak,ottype,batchid,location,locationname,otfrdate,ottodate,otAppDate) 
			VALUES (ot_ID,@fullname,@costcode,ot_date,ot_time_from,ot_time_to,@ottothours,'0.00','0.00',ot_Reason,DATE(NOW()),@depcode,@otbreak,ot_type,@batchid,UPPER(ot_location),@locationname,ot_from,ot_to,DATE(NOW()));
			
			 
			SET @otAppNo = (SELECT MAX(otAppNo) FROM overtimeform WHERE otID=ot_ID AND otStatus='P'); 
			SET ot_AppNo=@otAppNo;
			CALL sp_approval_insert(0,@otAppNo,ot_ID,@num1, @msg1); 
			
			 
		END IF;	  
			
		SET msg=ot_AppNo;
		COMMIT;
    END IF;
     
	 
END$$ 
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_timeentry_submit_request`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_timeentry_submit_request`( 
    IN pint_mode INT,	 
    IN r_teAppNo INT, 
    IN r_ID VARCHAR(30),      
    IN r_teDate VARCHAR(30), 
    IN r_teType VARCHAR(30), 
    IN r_teTime VARCHAR(30), 
    IN r_location VARCHAR(30), 
    IN r_teReason TEXT,  
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN 
		GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT; 
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtReason",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;
	
	SET num = 0;
	SET msg = '';
	 
	 
	IF (r_teType='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ddlType",
			"msg":"Please select [Type]"	
		       }';  
            LEAVE proc_start;
        END IF; 
         
        
         IF (r_location='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_appLocation",
			"msg":"Please select [Location]"	
		       }';  
            LEAVE proc_start;
        END IF; 
         
       IF (r_teDate='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_tedate",
			"msg":"Please select [Date]"	
		       }';  
            LEAVE proc_start;
        END IF; 
        
	SET @datediff = (SELECT DATEDIFF(r_teDate,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(r_teDate, INTERVAL (@datediff-3) DAY));


	 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_tedate",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;
        
        SET @fn_check_used_dates = ( SELECT fn_check_used_dates(1,CONCAT('{"taDate" : "',r_teDate,'","teID" : "',r_ID,'"}')));
        
        IF (@fn_check_used_dates<>'')THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"lbl_tedate",
				"msg":"',@fn_check_used_dates,'"	
			       }');  
            LEAVE proc_start;
        END IF; 
        
        
         IF (r_teReason='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_txtReason",
			"msg":"Please enter [Reason]"	
		       }';  
            LEAVE proc_start;
        END IF; 
         
        CALL sp_check_exists_app_valid_for_edit(5,r_teAppNo,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtReason",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	
	SET @fullname=(SELECT (CONCAT(firstname,' ',middlename,' ',lastname)) FROM identity WHERE identityid=r_ID); 
	SET @code=(SELECT CODE  FROM identity WHERE identityid=r_ID); 
	SET @costcode=(SELECT MAX(costcode)  FROM employeemovement WHERE CODE=@code);
	SET @depcode=(SELECT MAX(departmentcode)  FROM employeemovement WHERE CODE=@code);  
	SET @locationname=(SELECT locationname  FROM location WHERE locationcode=r_location);  
	
	SET @costcode=IFNULL(@costcode,0);
	SET @depcode=IFNULL(@depcode,0);
	SET @locationname=IFNULL(@locationname,'');
	
	IF (pint_mode=1) THEN
	
		START TRANSACTION; 
		IF (r_teAppNo=0) THEN
			 
			INSERT INTO timeentryform (teID,teName,teAppDate,teDate,teCosCenter,department,teType,teTime,location,locationName,teReason,teStatus)
			SELECT r_ID,@fullname,DATE(NOW()),r_teDate,@costcode,@depcode,r_teType,r_teTime,r_location,@locationname,r_teReason,'P';
			   
		 ELSE
			
			UPDATE timeentryform
			SET teID=r_ID
			   ,teName=@fullname 
			   ,teDate=r_teDate
			   ,teCosCenter=@costcode
			   ,department=@depcode
			   ,teType=r_teType
			   ,teTime=r_teTime
			   ,location=r_location
			   ,locationName=@locationname
			   ,teReason=r_teReason
			WHERE teAppNo=r_teAppNo;
			
		 END IF;
		 
		 
		DELETE FROM approval WHERE appNo = r_teAppNo AND document='timeentry'; 
		SET @maxAppNo = IFNULL((SELECT MAX(teAppNo) FROM timeentryform WHERE teID=r_ID),0); 
		SET msg = (CASE WHEN r_teAppNo=0 THEN CONCAT('New time entry Request has been successfully sent with application No.',@maxAppNo) ELSE CONCAT('Time entry application No.',@maxAppNo,' has been successfully Re-Sent') END);
		SET r_teAppNo =(CASE WHEN r_teAppNo=0 THEN @maxAppNo ELSE r_teAppNo END); 
		CALL sp_approval_insert(5,r_teAppNo,r_ID,@num1, @msg1); 
		SET msg = @maxAppNo; 
		-- SET msg = ((SELECT CONCAT('Time Entry Request has been successfully sent with application No.',@maxAppNo))); 
		COMMIT;
	END IF;	 
END$$ 
DELIMITER ;


 
-- CALL sp_leave_submit_application(0,0,'0601200001','VLP',11,'CEB','2026-07-22','2026-07-22','TEST','[{"num":1,"date":"2026-07-22","val":"1.00"}]', @num, @msg); SELECT @msg;
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_leave_submit_application`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_leave_submit_application`(
    IN pint_mode INT, 
    IN la_LstAppNo INT,
    IN la_ID VARCHAR(30),
    IN la_type VARCHAR(20),
    IN la_bal VARCHAR(20),
    IN la_location VARCHAR(20),	
    IN from_date VARCHAR(30),
    IN to_date VARCHAR(30),
    IN laReason TEXT,
    IN json_schedules TEXT, 
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
				GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lblReason",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;
	
	SET num = 0;
	SET msg = 'Success';
	
	
	 
	 -- DROP TABLE IF EXISTS tblJsonData; CREATE TABLE tblJsonData AS (SELECT json_schedules,rFileContent);
	-- SELECT * FROM tblJsonData
	-- SET @json_schedules = (SELECT json_schedules FROM tblJsonData);
	-- SET @rFileContent = (SELECT rFileContent FROM tblJsonData);
	
	 
	  
	SET @newID = (SELECT laAppNo FROM leaveapplicationform WHERE laAppNo=la_LstAppNo AND laStatus='P'); 
	SET @code=(SELECT CODE  FROM identity WHERE identityid=la_ID);   
	SET @bal=(SELECT leaveBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=la_type);
	SET @current=(SELECT currentBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=la_type);
        SET @newTot = IFNULL((SELECT SUM(JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].val'))))AS Total
		       FROM 
			(SELECT * FROM v_1krows) n
			WHERE 
			n.n < JSON_LENGTH(json_schedules)
			),0);
	-- SET @rFileContent = rFileContent;
	
	IF (@current>@bal) THEN
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_leave_bal",
				"msg":"Leave application failed. your current balance has a problem with your leave balance. please call admin!"	
				}'
		       ); 
		LEAVE proc_start;
	END IF;
				
	  
 
	 
	 
	SET @IsSL = (SELECT 1 FROM `leave` WHERE leaveCode=la_type AND leaveName LIKE '%sick%');
	
	IF (@IsSL=1 AND to_date>DATE(NOW()))THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_latodate",
			"msg":"Invalid advance date for Sick-Leave"	
		       }';  
            LEAVE proc_start;
        END IF;
	 
	 
	
	IF (@newTot=0) THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_latodate",
			"msg":"Please set schedule first"	
		       }';  
            LEAVE proc_start;
        END IF;
	 
	IF (la_type='') THEN
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lblappOvertimeType",
			"msg":"Please select [Leave Type]"	
		       }');  
            LEAVE proc_start;
        END IF;
      
      -- la_LstAppNo
       IF ((@bal<=0 OR @bal<@newTot OR @current<=0)) THEN 	
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"lbl_leave_bal",
				"msg":"Sorry, you only have ',@current,' current balance in your ',la_type,' which is not enough for ',@newTot,' day(s) of leave!"	
			       }'); 
	     LEAVE proc_start;
        END IF;
        
        
       
        IF (la_location='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblLocation",
			"msg":"Please select [Loction]"	
		       }'; 
	    LEAVE proc_start;
        END IF;
         
        
        IF (from_date='') THEN
	
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_laFromdate",
			"msg":"Please enter [From Date]"	
		       }'; 
             LEAVE proc_start;
        END IF;
        
	SET @datediff = (SELECT DATEDIFF(from_date,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(from_date, INTERVAL (@datediff-3) DAY)); 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_laFromdate",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;
		
       IF (to_date='') THEN
	
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_latodate",
			"msg":"Please enter [From Date]"	
		       }'; 
            LEAVE proc_start;
        END IF;
        
	SET @fn_check_used_dates = ( SELECT fn_check_used_dates(1,CONCAT('{"laFrom" : "',from_date,'","laTo" : "',to_date,'","laID" : "',la_ID,'"}')));
         
        IF (@fn_check_used_dates<>'')THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"lbl_latodate",
				"msg":"',@fn_check_used_dates,'"	
			       }');  
            LEAVE proc_start;
        END IF; 	
        
	IF (laReason='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblReason",
			"msg":"Plaese enter [Leave Reason]!"	
		       }'; 
	     LEAVE proc_start;
        END IF;
        
	IF((SELECT EXISTS (
		SELECT 1 
		FROM leaveapplicationlist 
		WHERE  laLstDate BETWEEN from_date AND to_date
		       AND  laLstAppNo IN (SELECT laAppNo 
					   FROM leaveapplicationform 
					   WHERE laID=la_ID 
						 AND laType=la_type
						 AND laStatus NOT IN ('C','D')
					  )
		))=1  AND la_LstAppNo=0) THEN
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_latodate",
			"msg":"Ops, you have already submited application using this date. kindly check your history or pending applications!"	
		       }'; 
	     LEAVE proc_start;
        END IF;
       
	IF (json_schedules='[]') THEN
	
	    SET num = 1;
	    SET msg = '{
			"id":"lblReason",
			"msg":"Sorry, you cant submit application without schedule(s)!"	
		       }'; 
             LEAVE proc_start;
        END IF;
	
	CALL sp_check_exists_app_valid_for_edit(1,la_LstAppNo,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lblReason",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	
	IF (pint_mode=1) THEN
		START TRANSACTION; 
		
		SET @fullname =(SELECT (CONCAT(firstname,' ',middlename,' ',lastname))  FROM identity WHERE identityid=la_ID); 
		SET @costcode=( SELECT MAX(costcode) FROM employeemovement WHERE CODE=@code);
		SET @depcode=( SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);
		SET @batchid=(SELECT batchid FROM identity WHERE identityId=la_ID);  
		SET @locationname =IFNULL((SELECT locationname  FROM location WHERE locationcode=la_location),'');   
		SET @TotDays=0;
		SET @leaveBalance=0; 
		
		IF (la_LstAppNo=0)  THEN
		 
			INSERT INTO leaveapplicationform(laID,laName,laCosCenter,laAppDate,laType,laDateFrom,laDateTo,laTotalDays,laBalance,laReason,laStatus,laBalanceCode,department,batchId,location,locationName) 
			SELECT la_ID AS laID,@fullname AS laName,@costcode AS laCosCenter,DATE(NOW()) AS laAppDate,la_type AS laType, 
				from_date AS laDateFrom, to_date AS laDateTo,@TotDays AS laTotalDays,@leaveBalance AS laBalance,laReason AS laReason,
				'P' AS laStatus,@code AS laBalanceCode, @depcode AS department,@batchid AS batchId,la_location AS location,
				@locationname AS locationName;
				
			 
		ELSE	
			SET @return_sched = (SELECT SUM(laSched) FROM leaveapplicationlist WHERE laLstAppNo=la_LstAppNo); 
			SET @oldLaType = (SELECT laType FROM leaveapplicationform WHERE laAppNo=la_LstAppNo);
			SET @oldlaTotalDays = (SELECT laTotalDays FROM leaveapplicationform WHERE laAppNo=la_LstAppNo); 
			
			UPDATE leaveapplicationform
			SET laID=la_ID
			   ,laName=@fullname
			   ,laCosCenter=@costcode 
			   ,laType=la_type
			   ,laDateFrom=from_date
			   ,laDateTo=to_date
			   ,laTotalDays=@TotDays
			   ,laBalance=@leaveBalance
			   ,laReason=laReason 
			   ,laBalanceCode=@code
			   ,department=@depcode
			   ,batchId=@batchid
			   ,location=la_location
			   ,locationName=@locationname 
			WHERE laAppNo=la_LstAppNo;
			 
			IF (@oldLaType<>la_type) THEN
				-- 
				UPDATE employeeleavebalances 
				SET currentBalance = (currentBalance + @oldlaTotalDays)
				/*
					SET currentBalance = (CASE 
							  WHEN IFNULL(@leaveUnit,'')='hours' THEN (currentBalance + @totalHours)
							  ELSE (currentBalance + @oldlaTotalDays)
							END)
				*/
				WHERE `code` = @code AND leaveCode = @oldLaType;
			ELSE
				 
				
				UPDATE employeeleavebalances 
				SET currentBalance = currentBalance+@oldlaTotalDays
				WHERE `code` = @code AND leaveCode = la_type;
			
			END IF;
			 
		END IF;
	 
		SET @laAppID=(SELECT MAX(laAppNo) FROM leaveapplicationform WHERE laID=la_ID AND laType=la_type);  
		SET @laAppID=(CASE WHEN la_LstAppNo=0 THEN @laAppID ELSE la_LstAppNo END);
		SET @currentBalance = (SELECT leaveBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=la_type);
		DELETE FROM leaveapplicationlist WHERE laLstAppNo=@laAppID;
		-- SET msg = @laAppID;	
		/*
		IF (@rFileContent NOT IN ('','[]')) THEN
			UPDATE leave_attachments SET visibility = 0 WHERE laAppNo=@laAppID;
			INSERT INTO leave_attachments (laAppNo,fileContent)
			SELECT @laAppID,@rFileContent; 
			
		END IF;
		*/
		 
		INSERT INTO leaveapplicationlist (laLstAppNo,laLstDate,laLstID,id,laSched,laBalAsOf,laBalance,laLstType,laLstDescription)
		SELECT *
		FROM(
			SELECT *,FORMAT(laBalAsOf-SUM(laSched) OVER (PARTITION BY id ORDER BY laLstDate),2) AS laBalance,la_type,''
			FROM(
				SELECT  @laAppID AS laLstAppNo,
				    JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].date'))) AS laLstDate,
				    JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].num'))) AS laLstID,
				    la_ID AS id,
				    JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].val'))) AS laSched,
				    @currentBalance AS laBalAsOf 
				FROM 
				    (SELECT * FROM v_1krows) n
				WHERE 
				    n.n < JSON_LENGTH(json_schedules)
			    )t1
		    )t1;
		  
		 
		SET @max_df = (SELECT MIN(laLstDate) FROM leaveapplicationlist WHERE laLstAppNo=@laAppID);
		SET @max_dt = (SELECT MAX(laLstDate) FROM leaveapplicationlist WHERE laLstAppNo=@laAppID);
		
		 
		UPDATE employeeleavebalances 
		SET currentBalance = (currentBalance - @newTot)
		WHERE `code` = @code AND leaveCode = la_type;
		
		
		-- SET @newBalance = ((SELECT currentBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=la_type)-@newTot);
		 
		SET @newBalance = (SELECT MIN(laBalance) FROM leaveapplicationlist WHERE laLstAppNo=@laAppID );
		-- SET num = 1; SET msg = CONCAT('{ "id":"lblReason", "msg":"',@laAppID,'!"  }'); ROLLBACK; LEAVE proc_start; 
		UPDATE leaveapplicationform 
		SET laTotalDays=@newTot, 
		    laBalance=@newBalance,
		    laDateFrom=@max_df,
		    laDateTo=@max_dt
		WHERE laAppNo=@laAppID;
		CALL sp_approval_insert(1,@laAppID,la_ID,@num1, @msg1);  
		COMMIT;
	END IF; 
	 
	 
    
END$$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_ob_application_submit_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_ob_application_submit_request(  
    IN pint_mode INT, 
    IN emp_id VARCHAR(30),    
    IN r_id VARCHAR(30),
    IN r_type VARCHAR(30),   
    IN r_reason TEXT,
    IN r_inout_date  VARCHAR(30),
    IN r_inout_time VARCHAR(30),  
    IN r_inout_location VARCHAR(30),
    IN r_days_df VARCHAR(30),
    IN r_days_dt VARCHAR(30),
    IN json_schedules JSON,
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
				GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtReason",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;
	SET num = 0;
	SET msg = 'Success';
    
      
 
	-- DROP TEMPORARY TABLE IF EXISTS temp_table;  
	-- CREATE TEMPORARY TABLE temp_table (
	DROP  TABLE IF EXISTS temp_table;  
	CREATE  TABLE temp_table (
	    id VARCHAR(30),
	    obLstAppNo INT,
	    obLstDate DATE,
	    obLstTimeFrom VARCHAR(30),
	    obLstTimeTo VARCHAR(30),
	    obLstTotHours VARCHAR(30),
	    obLstID INT,
	    obLocation VARCHAR(50),
	    location VARCHAR(50),
	    locationName VARCHAR(50) 
	);
	
	INSERT INTO temp_table (id,obLstAppNo,obLstDate,obLstTimeFrom,obLstTimeTo,obLstTotHours,obLstID,obLocation,location,locationName)
	SELECT emp_id,r_id,obLstDate,obLstTimeFrom,obLstTimeTo,obLstTotHours,obLstID,obLocation,location,locationName
	FROM(
		SELECT   
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].id'))) AS id,
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstAppNo'))) AS obLstAppNo, 
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstDate'))) AS obLstDate, 
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstTimeFrom'))) AS obLstTimeFrom, 
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstTimeTo'))) AS obLstTimeTo, 
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstTotHours'))) AS obLstTotHours, 
			-- JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLstID'))) AS obLstID, 
			(n.n+1) AS obLstID,
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].obLocation'))) AS obLocation, 
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].location'))) AS location,
			JSON_UNQUOTE(JSON_EXTRACT(json_schedules, CONCAT('$[', n.n, '].locationName'))) AS locationName 
		FROM 
			(SELECT * FROM v_1krows) n
		WHERE 
			n.n < JSON_LENGTH(json_schedules)
		)t1;
	 
	
		
	SET @Invalid_TimeRange = (SELECT 1 FROM temp_table WHERE obLstTimeTo<obLstTimeFrom LIMIT 1);
	SET @Invalid_TimeRange_id = (SELECT CONCAT('time_id2',obLstID) FROM temp_table WHERE obLstTimeTo<obLstTimeFrom LIMIT 1);
	
	SET @InvalidLocation = (SELECT 1 FROM temp_table WHERE obLocation="" LIMIT 1); 
	SET @InvalidLocation_id = (SELECT CONCAT('lbl',obLstID) FROM temp_table WHERE obLocation="" LIMIT 1);
	
	
	SET @InvalidLocationOthers = (SELECT 1 FROM temp_table WHERE obLocation="Others" AND location=""  LIMIT 1);
	SET @InvalidLocationOthers_id = (SELECT CONCAT('lbl',obLstID) FROM temp_table WHERE obLocation="Others"  AND location="" LIMIT 1);
	
	 
	 
	 
	IF (r_type IN ('',NULL)) THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ob_ddl",
			"msg":"Please select [OB Type]"	
		       }';
	LEAVE proc_start;
	END IF;	
	
	
	IF (r_type='Days') THEN
		IF (r_days_df IN ('',NULL)) THEN  
			SET num = 1;
			SET msg = '{
				"id":"lbl_ob_from_date",
				"msg":"Please pick [App. Date From]"	
			       }'; 
			LEAVE proc_start;
		END IF;
		
		SET @datediff = (SELECT DATEDIFF(r_days_df,DATE(NOW())));
		SET @dateSuggested = (SELECT DATE_ADD(r_days_df, INTERVAL (@datediff-3) DAY)); 
		IF (@datediff < 2 ) THEN 
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lbl_ob_from_date",
				"msg":"Application must be submitted at least 2 days before the schedule"	
			       }');
			LEAVE proc_start;
		END IF;

	END IF;	
	
	IF (r_type='Days' AND r_days_dt IN ('',NULL)) THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ob_to_date",
			"msg":"Please pick [App. Date To]"	
		       }'; 
	LEAVE proc_start;
	END IF;	
	
	IF (r_type='Days') THEN
		SET @fn_check_used_dates = ( SELECT fn_check_used_dates(3,CONCAT('{"obFrom" : "',r_days_df,'","obTo" : "',r_days_dt,'","obID" : "',emp_id,'"}')));
		
		IF (@fn_check_used_dates<>'')THEN 
		    SET num = 1;
		    SET msg = CONCAT('{
					"id":"lbl_ob_to_date",
					"msg":"',@fn_check_used_dates,'"	
				       }');  
		    LEAVE proc_start;
		END IF; 
	END IF;
	
	  
	  
		
	IF (r_type IN ('In','Out')) THEN
	
		IF (r_inout_date IN ('',NULL)) THEN  
			SET num = 1;
			SET msg = '{
				"id":"lbl_txtDate",
				"msg":"Please pick [Date]"	
			       }'; 
			LEAVE proc_start;
		END IF;	
		
		SET @datediff = (SELECT DATEDIFF(r_inout_date,DATE(NOW())));
		SET @dateSuggested = (SELECT DATE_ADD(r_inout_date, INTERVAL (@datediff-3) DAY)); 
		IF (@datediff < 2 ) THEN 
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lbl_txtDate",
				"msg":"Application must be submitted at least 2 days before the schedule"	
			       }');
			LEAVE proc_start;
		END IF;
	END IF;
	
	IF (r_type IN ('In','Out') AND r_inout_location IN ('',NULL)) THEN 
		    SET num = 1;
		    SET msg = '{
				"id":"lbl_txtlocation",
				"msg":"Please set [Location]"	
			       }';
	LEAVE proc_start;
	END IF;	
	 
	
	IF (@InvalidLocation = 1) THEN
	    SET num = 1;
	    SET msg = CONCAT('{
		"id": "', @InvalidLocation_id, '",
		"msg": "Invalid Location"
	    }');
	         
	 		       
	LEAVE proc_start;
	END IF;	
	
	
	IF (@InvalidLocationOthers = 1) THEN
	    SET num = 1;
	    SET msg = CONCAT('{
		"id": "', @InvalidLocationOthers_id, '",
		"msg": "Please specify location"
	    }'); 	       
	LEAVE proc_start;
	END IF;	
	 
	
	IF (@Invalid_TimeRange = 1) THEN
	    SET num = 1;
	    SET msg = CONCAT('{
		"id": "', @Invalid_TimeRange_id, '",
		"msg": "Invalid Time Range"
	    }'); 
	LEAVE proc_start;
	END IF;	
	
	
	IF (r_type='Days') THEN
	   -- SET r_inout_date = NULL;
	   -- SET r_inout_time = NULL;
	   SET r_inout_date = 'N/A';
	   SET r_inout_time = 'N/A';
	   SET r_inout_location = '';
	END IF;
	
	
	IF (r_type IN ('In','Out')) THEN
	   SET r_days_df = r_inout_date;
	   SET r_days_dt = r_inout_date; 
	END IF;
	
	IF (r_type='Days') THEN
		SET r_days_df =  (SELECT MIN(obLstDate) FROM temp_table);
		SET r_days_dt =  (SELECT MAX(obLstDate) FROM temp_table);
	END IF;	 
	
 
	
	
	SET @appDetails = CONCAT('{"obID": "',emp_id,'", "obType": "',r_type,'", "obDateFrom": "',r_days_df,'", "obDateTo" : "',r_days_dt,'", "obTimeFrom":"',r_inout_time,'"}');
	CALL sp_check_application_if_exists(1,3,@appDetails, @num1, @msg1); -- IN/OUT
	
	
	 
	IF (@num1<>0) THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_ob_ddl",
			"msg":"',@msg1,'"	
		       }');  
        LEAVE proc_start;
	END IF;
	
	
	
	CALL sp_check_application_if_exists(0,3,json_schedules, @num1, @msg1);  -- DAYS
	
	
	
	IF (@num1<>0) THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_ob_ddl",
			"msg":"',@msg1,'"	
		       }');  
        LEAVE proc_start;
	END IF;
	
	
	IF (r_reason='') THEN 
		SET num = 1;
		SET msg = '{
			"id":"lbl_txtReason",
			"msg":"Please enter [Reason]"	
		       }';  
		       
		LEAVE proc_start;
	END IF;	
	
	CALL sp_check_exists_app_valid_for_edit(3,r_id,@num2,@msg2);	 
	
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtReason",
			"msg":"',@msg2,'"	
		       }'); 
	    LEAVE proc_start;
	END IF; 

	
	IF (pint_mode=1) THEN 	
		START TRANSACTION; 
		SET @fullname =(SELECT (CONCAT(firstname,' ',middlename,' ',lastname)) FROM identity WHERE identityid=emp_id); 
		SET @code=(SELECT CODE FROM identity WHERE identityid=emp_id);  
		SET @batchId=(SELECT batchId FROM identity WHERE identityid=emp_id);  
		SET @costcode=(SELECT MAX(costcode) FROM employeemovement WHERE CODE=@code); 
		SET @depcode=(SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);  
		-- SET @locationname=(SELECT locationname  FROM location WHERE locationcode=r_location);  
		 
		SET @costcode = IFNULL(@costcode,0);  
		SET @depcode = IFNULL(@depcode,0);
		 
	   
		IF (r_id>0) THEN 
		
			UPDATE officialbusinessform
			SET obID=emp_id,
			    obName=@fullname,
			    obCosCenter=@costcode,
			    obDateFrom=r_days_df,
			    obDateTo=r_days_dt,
			    obType=r_type,
			    obReason=r_reason,
			    obStatus='P',
			    obLocation=r_inout_location,
			    department=@depcode,
			    batchId=@batchId,
			    location=r_inout_location,
			    locationName=r_inout_location,
			    obTimeFrom=r_inout_time
			WHERE ObAppNo=r_id;
			
		ELSE
		
			INSERT INTO officialbusinessform (obID,
							 obName,
							 obAppDate,
							 obCosCenter,
							 obDateFrom,
							 obDateTo,
							 obType,
							 obOverTime,
							 obTotHours,
							 obWorkHours,
							 obTime,
							 obTimeFrom,
							 obTimeTo,
							 obReason,
							 obStatus,
							 obLocation,
							 department,
							 batchId,
							 location,
							 locationName
							 )
			VALUES (emp_id,
				@fullname,
				DATE(NOW()),
				@costcode,
				r_days_df,
				r_days_dt,
				r_type,
				'',
				'',
				'',
				'',
				'NA',
				IFNULL(r_inout_time,'NA'),
				r_reason,
				'P',
				r_inout_location,
				@depcode,
				@batchId,
				r_inout_location,
				r_inout_location
				);
			
			SET r_id = (SELECT MAX(obAppNo) FROM officialbusinessform WHERE obID=emp_id AND obStatus='P');
		END IF;
		
		 
		SET @MaxObAppNo=(SELECT MAX(ObAppNo) FROM officialbusinessform WHERE obID=emp_id AND obStatus='P'); 
		
		IF (r_id>0) THEN
		     SET @MaxObAppNo=r_id;
		END IF;
		
		
		 
		 
		DELETE FROM officialbusinesslist WHERE obLstAppNo=@MaxObAppNo AND id=emp_id;
		
		UPDATE temp_table SET obLstAppNo=@MaxObAppNo;
		
		INSERT INTO officialbusinesslist (id,obLstAppNo,obLstDate,obLstTimeFrom,obLstTimeTo,obLstTotHours,obLstID,obLocation,location,locationName)
		SELECT id,obLstAppNo,obLstDate,obLstTimeFrom,obLstTimeTo,obLstTotHours,obLstID
			,(CASE WHEN t2.locationCode IS NULL THEN 'Others' ELSE obLocation END)AS obLocation
			,(CASE WHEN t2.locationCode IS NULL THEN location ELSE t2.locationCode END)AS location
			,(CASE WHEN t2.locationCode IS NULL THEN location ELSE t2.locationName END)AS locationName 
		FROM temp_table t1
		LEFT JOIN location t2 ON t1.obLocation=t2.locationCode
		ORDER BY t1.obLstID
		;
		  
		CALL sp_approval_insert(3,r_id,emp_id,@num1, @msg1); 
		
		COMMIT;
		
	END IF; 	 	
 
    
END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_schedule_change; 
DELIMITER $$   
CREATE PROCEDURE sp_schedule_change(
    IN pint_mode INT,
    IN appNo INT,  
    IN r_scID VARCHAR(30), 
    IN r_Day VARCHAR(30),  
    IN r_scSchedule VARCHAR(30),
    IN r_scReason TEXT,
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN  

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
				GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtRemarks",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;

	SET num = 0;
	SET msg = '';
	
	/*
	
		0 - INSERT
	*/
	 
	 
	
	IF (r_scSchedule IN ('','0')) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_ddlSchedule",
			"msg":"Please select [Schedule Name]"	
		       }');  
		LEAVE proc_start;
	END IF;
	
	SET @datediff = (SELECT DATEDIFF(r_Day,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(r_Day, INTERVAL (@datediff-3) DAY)); 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_ddlSchedule",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;

 
 
	IF (r_scReason ='') THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_txtRemarks",
			"msg":"Please enter [Reason]"	
		       }');  
		LEAVE proc_start;
	END IF;	 
	 
	CALL sp_check_exists_app_valid_for_edit(6,appNo,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtRemarks",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	IF (pint_mode=1) THEN
		START TRANSACTION;  
		IF (appNo=0) THEN
			
			SET @scPreviousSched=(SELECT schedule_Name FROM v_schedules WHERE employeeId=r_scID AND `day`=r_Day);
			SET @scPayrollPeriod=(SELECT payrollPeriod FROM v_schedules WHERE employeeId=r_scID AND `day`=r_Day);
			SET @scDay=(SELECT `day` FROM v_schedules WHERE employeeId=r_scID AND `day`=r_Day);
			
			SET @fullname =(SELECT (CONCAT(firstname,' ',middlename,' ',lastname))  FROM identity WHERE identityid=r_scID); 
			SET @code=(SELECT CODE  FROM identity WHERE identityid=r_scID);
			SET @costcode=(SELECT MAX(costcode)  FROM employeemovement WHERE CODE=@code); 
			SET @depcode=(SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);   
			SET @costName=(SELECT costName FROM costcenter WHERE costCode = @costcode); 
			SET @departmentName=(SELECT departmentName FROM department WHERE departmentCode=@depcode);
			
			
			SET @costcode=IFNULL(@costcode,0);
			SET @depcode=IFNULL(@depcode,0);
			
			
			
			-- SELECT * FROM schedulechange
			INSERT INTO schedulechange (scID,scName,scAppDate,scCosCenter,scReqDate,scSchedule,scPreviousSched,scPayrollPeriod,scDay,scReason,department)
			SELECT r_scID,@fullname,DATE(NOW()),@costcode,r_Day,r_scSchedule,@scPreviousSched,@scPayrollPeriod,@scDay,R_scReason,@depcode;
		ELSE
			UPDATE schedulechange
			SET scReqDate=r_scSchedule
			   ,scReason=R_scReason
			WHERE scAppNo=appNo;
			 
		END IF; 
		
		SET @MaxscAppNo =(SELECT MAX(scAppNo) FROM schedulechange WHERE scID=r_scID);
		
		SET @appNo = (CASE WHEN appNo=0 THEN @MaxscAppNo ELSE appNo END);
		SET msg=7;
		CALL sp_approval_insert(6,@appNo,r_scID,@num1, @msg1); 
		COMMIT;
       END IF;
       
       
	 
END $$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_hrd_cert_submit; 
DELIMITER $$  
CREATE PROCEDURE sp_hrd_cert_submit( 
    IN pint_mode INT,
    IN r_id VARCHAR(30),
    IN r_identityid VARCHAR(30),	 
    IN r_dateNeeded VARCHAR(30),    
    IN r_certOfemp VARCHAR(100),
    IN r_creditCardApp INT,
    IN r_creditCardAppBank VARCHAR(100),
    IN r_visaApp INT,
    IN r_visaAppCtry VARCHAR(100),
    IN r_visaAppForWhose VARCHAR(30),
    IN r_visaAppForWhoseOtherDetail VARCHAR(100),
    IN r_visaAppKind VARCHAR(30), 
    IN r_visaAppKindOtherDetail VARCHAR(100),
    IN r_loanApp INT,
    IN r_loanAppInstitution VARCHAR(100),
    IN r_idApp INT,
    IN r_idAppHospital VARCHAR(100),
    IN r_idAppHospRecipient VARCHAR(100),
    IN r_otherPurpose INT,
    IN r_otherPurposeDetail VARCHAR(100),
    IN r_hdmf INT,
    IN r_clearanceCert INT,
    IN r_otherCert INT,
    IN r_otherCertDetail VARCHAR(100),
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lblDateNeeded",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;
	
	SET num = 0;
	SET msg = '';	
	 
	
	  
	
	
	SET r_certOfemp = (CASE 
				WHEN r_certOfemp='checkEWC' THEN 'COEwithCompensation' 
				WHEN r_certOfemp='checkEWNC' THEN 'COEnoCompensation' 
				ELSE ''
			   END);
			   
	SET r_visaAppForWhose = (CASE 
				WHEN r_visaAppForWhose='checkEmp' THEN 'fwaEmployee' 
				WHEN r_visaAppForWhose='checkSP' THEN 'fwaSpouse' 
				WHEN r_visaAppForWhose='checkSPE' THEN 'fwaOthers' 
				ELSE ''
			   END);
	 		   
        SET r_visaAppKind = (CASE 
				WHEN r_visaAppKind='checkTR' THEN 'kovTourist' 
				WHEN r_visaAppKind='checkIM' THEN 'kovImmigrant' 
				WHEN r_visaAppKind='checkSPE2' THEN 'kovOthers' 
				ELSE ''
			   END);
	 
			   
       -- SET num = 0; SET msg = r_id; LEAVE proc_start;
	
	IF (IFNULL(r_dateNeeded,'') IN (''))THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblDateNeeded",
			"msg":"Please pick [Date needed]"	
		       }';  
            LEAVE proc_start;
        END IF; 
        
        
	SET @datediff = (SELECT DATEDIFF(r_dateNeeded,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(r_dateNeeded, INTERVAL (@datediff-3) DAY)); 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lblDateNeeded",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;

 
        
        IF (r_certOfemp='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblEWC",
			"msg":"Please select [Type of Certificate]"	
		       }';  
            LEAVE proc_start;
        END IF; 
        
        
        IF (r_creditCardApp=1 AND TRIM(r_creditCardAppBank)='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblCCA",
			"msg":"Please input [Name of bank or credit card company]"	
		       }';  
            LEAVE proc_start;
        END IF; 
        
        
        IF (r_visaApp=1 AND TRIM(r_visaAppCtry)='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblVA",
			"msg":"Please [Specify country]"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        
        IF (r_visaApp=1 AND r_visaAppForWhose='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblVA",
			"msg":"For whose application?"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        IF (r_visaApp=1 AND r_visaAppForWhose='fwaOthers' AND TRIM(r_visaAppForWhoseOtherDetail)='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblVA",
			"msg":"pls. specify [Others]"	
		       }';  
            LEAVE proc_start;
        END IF;
         
        IF (r_visaApp=1 AND r_visaAppKind='')THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lblVA",
			"msg":"pls. specify [Kind of Visa]"	
		       }';  
            LEAVE proc_start;
        END IF;
        
       IF (r_visaApp=1 AND r_visaAppKind='kovOthers' AND TRIM(r_visaAppKindOtherDetail)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblVA",
			"msg":" pls. specify [Others] visa"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        IF (r_loanApp=1 AND TRIM(r_loanAppInstitution)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblkLA",
			"msg":"Name of financing institution is missing"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        IF (r_idApp=1 AND TRIM(r_idAppHospital)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblIDAWHO",
			"msg":"Please enter Hospital name"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        IF (r_idApp=1 AND TRIM(r_idAppHospRecipient)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblIDAWHO",
			"msg":"To whom letter should be addressed?"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        
        IF (r_otherPurpose=1 AND TRIM(r_otherPurposeDetail)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblOP",
			"msg":"Please specify!"	
		       }';  
            LEAVE proc_start;
        END IF;
        
        IF (r_otherCert=1 AND TRIM(r_otherCertDetail)='')THEN  
	    SET num = 1;
	    SET msg = '{
			"id":"lblOC",
			"msg":"Please specify!"	
		       }';  
            LEAVE proc_start;
        END IF; 
        
        CALL sp_check_exists_app_valid_for_edit(7,r_id,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lblDateNeeded",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
         
        IF (pint_mode=1) THEN  
		
		START TRANSACTION; 
		SET @fullname=(SELECT (CONCAT(firstname,' ',middlename,' ',lastname))  FROM identity WHERE identityid=r_identityid); 
		SET @code =(SELECT CODE  FROM identity WHERE identityid=r_identityid);  
		SET @costcode=( SELECT MAX(costcode) FROM employeemovement WHERE CODE=@code);
		SET @depcode=( SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);
		-- SET @batchid=(SELECT batchid FROM identity WHERE identityid=r_osID);  
		-- SET @locationname=(SELECT locationname FROM location WHERE locationcode=r_location);   
		
		
		SET @costcode=IFNULL(@costcode,0);
		SET @depcode=IFNULL(@depcode,0);
			 
		IF (r_id=0) THEN
		
			INSERT INTO hrdcertificate (identityID,`name`,costcenter,department,requestDate,
					dateNeeded,certOfemp,creditCardApp,creditCardAppBank,visaApp,
					visaAppCtry,visaAppForWhose,visaAppForWhoseOtherDetail,visaAppKind,visaAppKindOtherDetail,
					loanApp,loanAppInstitution,idApp,idAppHospital,idAppHospRecipient,otherPurpose,otherPurposeDetail,
					hdmf,clearanceCert,otherCert,otherCertDetail,`status`)
			SELECT r_identityid,@fullname,@costcode,@depcode,DATE(NOW()),r_dateNeeded,r_certOfemp,r_creditCardApp,r_creditCardAppBank,r_visaApp,
				       r_visaAppCtry,r_visaAppForWhose,r_visaAppForWhoseOtherDetail,r_visaAppKind,r_visaAppKindOtherDetail,
				       r_loanApp,r_loanAppInstitution,r_idApp,r_idAppHospital,r_idAppHospRecipient,r_otherPurpose,r_otherPurposeDetail,
				       r_hdmf,r_clearanceCert,r_otherCert,r_otherCertDetail,'P';
				       
	        ELSE
			UPDATE hrdcertificate
			SET 	identityID=r_identityid,
				`name`=@fullname,
				costcenter=@costcode,
				department=@depcode, 
				dateNeeded=r_dateNeeded,
				certOfemp=r_certOfemp,
				creditCardApp=r_creditCardApp,
				creditCardAppBank=r_creditCardAppBank,
				visaApp=r_visaApp,
				visaAppCtry=r_visaAppCtry,
				visaAppForWhose=r_visaAppForWhose,
				visaAppForWhoseOtherDetail=r_visaAppForWhoseOtherDetail,
				visaAppKind=r_visaAppKind,
				visaAppKindOtherDetail=r_visaAppKindOtherDetail,
				loanApp=r_loanApp,
				loanAppInstitution=r_loanAppInstitution,
				idApp=r_idApp,
				idAppHospital=r_idAppHospital,
				idAppHospRecipient=r_idAppHospRecipient,
				otherPurpose=r_otherPurpose,
				otherPurposeDetail=r_otherPurposeDetail,
				hdmf=r_hdmf,
				clearanceCert=r_clearanceCert,
				otherCert=r_otherCert,
				otherCertDetail=r_otherCertDetail
			WHERE appNo=r_id;
		 
		END IF;
        
			SET @MaxappNo = (SELECT MAX(appNo) FROM hrdcertificate WHERE identityID=r_identityid AND `status`='P');
			SET @appNo = (CASE WHEN r_id=0 THEN @MaxappNo ELSE r_id END);
			SET msg = @appNo;
			CALL sp_approval_insert(7,@appNo,r_identityid,@num1, @msg1); 
		COMMIT;
        END IF;
        
        
     
END $$ 
DELIMITER ; 



DROP PROCEDURE IF EXISTS sp_time_adj_get_submit_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_time_adj_get_submit_request(  
    IN pint_mode INT, 
    IN user_id VARCHAR(30),    
    IN r_id VARCHAR(30),
    IN r_date VARCHAR(30),
    IN r_location VARCHAR(50), 
    IN r_type VARCHAR(30),
    IN r_time VARCHAR(30),
    IN r_reason TEXT,
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 

	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtReason",
				"msg":"',@errorMessage,'"	
			       }'); 
	END;

    SET num = 0;
    SET msg = '';
    
	
	IF (r_date IN ('',NULL)) THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ta_date",
			"msg":"Please pick [Adjustment Date]"	
		       }';
	LEAVE proc_start;
	END IF;	
	
	
	SET @datediff = (SELECT DATEDIFF(r_date,DATE(NOW())));
	SET @dateSuggested = (SELECT DATE_ADD(r_date, INTERVAL (@datediff-3) DAY)); 
	IF (@datediff < 2 ) THEN 
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbl_ta_date",
			"msg":"Application must be submitted at least 2 days before the schedule"	
		       }');
		LEAVE proc_start;
	END IF;

 
 
	SET @fn_check_used_dates = ( SELECT fn_check_used_dates(2,CONCAT('{"taDate" : "',r_date,'","taID" : "',user_id,'"}')));
         
            
        IF (@fn_check_used_dates<>'')THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"lbl_ta_date",
				"msg":"',@fn_check_used_dates,'"	
			       }');  
            LEAVE proc_start;
        END IF; 
	IF (r_type='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_ddl_type",
			"msg":"Please select [Adjustment Type]"	
		       }'; 
	    
	LEAVE proc_start;
	END IF;	
	
	IF (r_location='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_appLocation",
			"msg":"Please select [Location]"	
		       }';
	    
	LEAVE proc_start;
	END IF;	
	 
	
	
	SET @appDetails = CONCAT('{"appNo":"',r_id,'","taType":"',r_type,'", "taID": "',user_id,'", "taDate": "',r_date,'", "taTime": "',r_time,'"}');
	CALL sp_check_application_if_exists(0,2,@appDetails,@num1,@msg1);
	
	IF (@num1=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_ta_date",
			"msg":"',@msg1,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	 
	IF (r_reason='') THEN 
	    SET num = 1;
	    SET msg = '{
			"id":"lbl_txtReason",
			"msg":"Please enter [Reason]"	
		       }'; 
		       
	LEAVE proc_start;
	END IF;	 
	
	
	CALL sp_check_exists_app_valid_for_edit(2,r_id,@num2,@msg2);	 
	IF (@num2=1) THEN   
	
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtReason",
			"msg":"',@msg2,'"	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	IF (pint_mode=1) THEN
		START TRANSACTION; 
		SET @fullname =(SELECT (CONCAT(firstname,' ',middlename,' ',lastname))  FROM identity WHERE identityid=user_id); 
		SET @code=(SELECT CODE  FROM identity WHERE identityid=user_id);
		SET @costcode=(SELECT MAX(costcode)  FROM employeemovement WHERE CODE=@code); 
		SET @depcode=(SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);
		SET @batchid =(SELECT batchid  FROM identity WHERE identityid=user_id);   
		SET @locationname=(SELECT locationname  FROM location WHERE locationcode=r_location); 
		
		SET @costcode=IFNULL(@costcode,0);
		SET @depcode=IFNULL(@depcode,0);
		
		
			
			
		IF (r_id>0) THEN
		
			  
			UPDATE timeadjustmentform
			SET  
			    taDate=r_date
			   ,taType=r_type
			   ,taTime=r_time
			   ,taReason=r_reason
			   ,taStatus='p' 
			   ,location=r_location
			   ,locationName=@locationname
			WHERE taAppNo=r_id;
			
		ELSE 
			INSERT INTO timeadjustmentform (taID,taName,taAppDate,taCosCenter,taDate,taType,taTime,taReason,taStatus,department,location,locationName)
			VALUES (user_id,@fullname,DATE(NOW()),@costcode,r_date,r_type,r_time,r_reason,'P',@depcode,r_location,@locationname);
			
			SET r_id = (SELECT MAX(taAppNo) FROM timeadjustmentform WHERE taID=user_id AND taStatus IN ('P'));
		END IF;
		
		SET msg = r_id;
		 
		CALL sp_approval_insert(2,r_id,user_id,@num, @msg); 
		
		COMMIT;
	END IF; 
    
END $$
DELIMITER ;
