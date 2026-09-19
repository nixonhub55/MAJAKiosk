ALTER TABLE overtimeform ADD IF NOT EXISTS otExtAllowance INT NOT NULL DEFAULT 0;  
ALTER TABLE overtimeapproverhistory ADD COLUMN IF NOT EXISTS   otExtAllowance INT NOT NULL DEFAULT 0 AFTER otToDate;

 

-- CALL sp_overtime_submit_request(0,0,'0601200014','','L','CEB','2026-03-14','2026-03-14','2026-03-14','00:00','07:30','15:30','00:00',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_overtime_submit_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_overtime_submit_request
(  
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
    IN ot_ExtAllowance VARCHAR(15), 
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
	
	
	
	SET @ot_ExtAllowance=(CASE WHEN ot_ExtAllowance='false' THEN 0 ELSE 1 END); 
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
	
	SET @code=(SELECT CODE  FROM identity WHERE identityid=ot_ID); 
	SET @costcode=(SELECT MAX(costcode)  FROM employeemovement WHERE CODE=@code);
	SET @depcode=(SELECT MAX(departmentcode)  FROM employeemovement WHERE CODE=@code); 
	
	IF (IFNULL(@costcode,'')='') THEN    
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtRemarks",
			"msg":"No Cost Center assigned for you. please cotact admin."	
		       }'); 
	LEAVE proc_start;
	END IF;
	
	IF (IFNULL(@depcode,'')='') THEN    
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_txtRemarks",
			"msg":"No Department assigned for you. please cotact admin."	
		       }'); 
	LEAVE proc_start;
	END IF;
	
   
	IF (pint_mode=1) THEN
		
		START TRANSACTION; 
		SET @fullname=(SELECT (CONCAT(firstname,' ',middlename,' ',lastname)) FROM identity WHERE identityid=ot_ID);  
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
				ottodate=ot_to,
				otExtAllowance=@ot_ExtAllowance
			WHERE otAppNo=ot_AppNo;
			
			CALL sp_approval_insert(0,ot_AppNo,ot_ID,@num1, @msg1); 
			
		ELSE
			INSERT INTO overtimeform (otID,otName,otcoscenter,otdate,ottimefrom,ottimeto,otTotHours,othours,otminutes,otReason,otreqdate,department,otbreak,ottype,batchid,location,locationname,otfrdate,ottodate,otAppDate,otExtAllowance) 
			VALUES (ot_ID,@fullname,@costcode,ot_date,ot_time_from,ot_time_to,@ottothours,'0.00','0.00',ot_Reason,DATE(NOW()),@depcode,@otbreak,ot_type,@batchid,UPPER(ot_location),@locationname,ot_from,ot_to,DATE(NOW()),@ot_ExtAllowance);
			
			 
			SET @otAppNo = (SELECT MAX(otAppNo) FROM overtimeform WHERE otID=ot_ID AND otStatus='P'); 
			SET ot_AppNo=@otAppNo;
			CALL sp_approval_insert(0,@otAppNo,ot_ID,@num1, @msg1); 
			
			 
		END IF;	  
			
		SET msg=ot_AppNo;
		COMMIT;
    END IF;
     
	 
END $$
DELIMITER ;