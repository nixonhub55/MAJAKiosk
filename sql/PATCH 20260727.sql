DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_ob_application_submit_request`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ob_application_submit_request`(  
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
	
	-- SELECT * FROM temp_table
	SET @InvalidTime = (SELECT 1 FROM temp_table WHERE obLstTimeFrom IN ('00:00') OR obLstTimeTo IN ('00:00') LIMIT 1); 
	SET @InvalidTime_id = (SELECT CONCAT('lbltime_id1',obLstID) FROM temp_table  WHERE obLstTimeFrom IN ('00:00') OR obLstTimeTo IN ('00:00') LIMIT 1); 
	
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
	 
	
	IF (@InvalidTime = 1) THEN
	    SET num = 1;
	    SET msg = CONCAT('{
		"id": "', @InvalidTime_id, '",
		"msg": "Invalid time range"
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
 
    
END$$
DELIMITER ;



-- CALL sp_user_dashboard_settings(0,'0601200169','[]',@num,@msg); SELECT @msg;
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_user_dashboard_settings`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_user_dashboard_settings`(  
	IN pint_mode INT,
	IN r_identityId VARCHAR(30),
	IN r_json_data TEXT,
	OUT num INT,
	OUT msg VARCHAR(300)
)
BEGIN  
	
	
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
	 
	START TRANSACTION; 
	
	 DROP TEMPORARY TABLE IF EXISTS tempUserDash;
	 CREATE TEMPORARY TABLE tempUserDash AS( 
		SELECT DISTINCT SUBSTRING_INDEX(wedgetName, '_For_', 1) AS `titleName`
		       ,SUBSTRING_INDEX(wedgetName, '_For_', -1) AS `HeaderName`	
		       ,IsVisible
		       ,orderNum 
		       -- ,lineId
		        ,(CASE 
			        WHEN SUBSTRING_INDEX(wedgetName, '_For_', -1)='' THEN 1
			        ELSE  ROW_NUMBER() OVER (PARTITION BY SUBSTRING_INDEX(wedgetName, '_For_', -1) )
		          END) AS LineId
		       ,r_identityId AS identityId
		FROM(
			SELECT JSON_UNQUOTE(JSON_EXTRACT(r_json_data, CONCAT('$[', n.n, '].wedgetName'))) AS wedgetName, 
			    JSON_UNQUOTE(JSON_EXTRACT(r_json_data, CONCAT('$[', n.n, '].IsVisible'))) AS IsVisible,
			    JSON_UNQUOTE(JSON_EXTRACT(r_json_data, CONCAT('$[', n.n, '].orderNum'))) AS orderNum,
			    JSON_UNQUOTE(JSON_EXTRACT(r_json_data, CONCAT('$[', n.n, '].lineId'))) AS lineId 
			FROM 
			    (SELECT * FROM v_1krows) n
			WHERE 
			    n.n < JSON_LENGTH(r_json_data)
	    )t1
	);
 
	
	/*
		0 - VIEW
		1 - INSERT
		2 - UPDATE
	*/
	
	
	-- SELECT * FROM user_dashboard_settings WHERE identityId='0601200169'
	-- DELETE FROM user_dashboard_settings WHERE identityId='0601200169'
	-- TRUNCATE TABLE user_dashboard_settings
	 
	IF (pint_mode=0) THEN
	
		IF NOT EXISTS (SELECT *
				FROM user_dashboard_settings
				WHERE identityId = r_identityId
				) THEN
				
				INSERT INTO user_dashboard_settings (identityId,titleName,headerName,lineId,orderNo) 
				SELECT r_identityId,'annonucement','',1,1 UNION ALL
				SELECT r_identityId,'calendar','',1,2 UNION ALL
				SELECT r_identityId,'Overtime/Under Time','ForApproval',1,3 UNION ALL
				SELECT r_identityId,'Leave','ForApproval',2,3 UNION ALL
				SELECT r_identityId,'Offset','ForApproval',3,3 UNION ALL
				SELECT r_identityId,'TimeAdjustment','ForApproval',4,3 UNION ALL
				SELECT r_identityId,'OfficialBusiness','ForApproval',5,3 UNION ALL 
				SELECT r_identityId,'TimeEntry','ForApproval',6,3 UNION ALL
				SELECT r_identityId,'ScheduleChange','ForApproval',7,3 UNION ALL
				SELECT r_identityId,'HRDCertificate','ForApproval',8,3 UNION ALL
				SELECT r_identityId,'Overtime/Under Time','Application',1,4 UNION ALL
				SELECT r_identityId,'Leave','Application',2,4 UNION ALL
				SELECT r_identityId,'Offset','Application',3,4 UNION ALL
				SELECT r_identityId,'TimeAdjustment','Application',4,4 UNION ALL
				SELECT r_identityId,'OfficialBusiness','Application',5,4 UNION ALL
				SELECT r_identityId,'TimeEntry','Application',6,4 UNION ALL
				SELECT r_identityId,'ScheduleChange','Application',7,4 UNION ALL 
				SELECT r_identityId,'HRDCertificate','Application',8,4 UNION ALL 
				SELECT r_identityId,'Overtime/Under Time','ApplicationMonitoringperCut-Off',1,5 UNION ALL
				SELECT r_identityId,'Leave','ApplicationMonitoringperCut-Off',2,5 UNION ALL
				SELECT r_identityId,'Offset','ApplicationMonitoringperCut-Off',3,5 UNION ALL
				SELECT r_identityId,'TimeAdjustment','ApplicationMonitoringperCut-Off',4,5 UNION ALL
				SELECT r_identityId,'OfficialBusiness','ApplicationMonitoringperCut-Off',5,5 UNION ALL
				SELECT r_identityId,'TimeEntry','ApplicationMonitoringperCut-Off',6,5 UNION ALL
				SELECT r_identityId,'ScheduleChange','ApplicationMonitoringperCut-Off',7,5 UNION ALL 
				SELECT r_identityId,'HRDCertificate','ApplicationMonitoringperCut-Off',8,5 UNION ALL 
				 
				SELECT r_identityId,'TotalEmployeeAppReceivedPerCutOff','',1,6 UNION ALL
				
				SELECT r_identityId,'loanOverView','',1,7 UNION ALL
				SELECT r_identityId,'dtrViewPerCutOff','',1,8 UNION ALL
				SELECT r_identityId,'BiometricsData','others',1,9 UNION ALL
				SELECT r_identityId,'LeaveBalances','others',2,10 UNION ALL
				SELECT r_identityId,'EmployeeBiometricsLogs','',1,11 UNION ALL 
				SELECT r_identityId,'EmployeeSchedule','',1,12 UNION ALL
				SELECT r_identityId,'YearToDate','',1,13 ;
				
		END IF;
		
		DROP TEMPORARY TABLE IF EXISTS accessRigths;
		CREATE TEMPORARY TABLE accessRigths AS( 
				SELECT  IFNULL(MAX(approvaltemplates.`leave`),0) AS `leave`,
					IFNULL(MAX(approvaltemplates.`timeEntry`),0) AS timeEntry,
					IFNULL(MAX(approvaltemplates.`scheduleTagging`),0) AS scheduleChange,
					IFNULL(MAX(approvaltemplates.`overtime`),0) AS overtime,
					IFNULL(MAX(approvaltemplates.`offsetTime`),0) AS offsetTime,
					IFNULL(MAX(approvaltemplates.`timeAdjustment`),0) AS timeAdjustment,
					IFNULL(MAX(approvaltemplates.`officialBusiness`),0) AS officialBusiness,
					IFNULL(MAX(approvaltemplates.`percentageallocation`),0) AS percentageallocation,
					IFNULL(MAX(approvaltemplates.`hrdCert`),0) AS hrdCert,
					approvaltemplates.`code`
				FROM approvaltemplateoriginator 
				LEFT JOIN approvaltemplatestages ON
				approvaltemplateoriginator.`code` = approvaltemplatestages.`code`
				LEFT JOIN approvaltemplates ON
				approvaltemplatestages.`code` = approvaltemplates.`code` 
				 
				WHERE approvaltemplateoriginator.id = r_identityId
		);
		
		 -- CALL sp_user_dashboard_settings(0,'ING0072','[]',@num ,@msg);    -- TRUNCATE TABLE user_dashboard_settings
		   SELECT id
		        ,identityId
		        ,headerName
		        ,titleName  
		        ,orderNo
		        ,rowName
		        ,visibility
		        ,NewLine AS lineId
		   FROM(
				SELECT id
				      ,identityId
				      ,headerName
				      ,titleName  
				      ,orderNo
				      ,rowName
				      ,visibility
				     ,ROW_NUMBER() OVER (
						      PARTITION BY (CASE WHEN IFNULL(headerName,'')='' THEN titleName ELSE headerName END)  
						      ORDER BY orderNo,visibility,LineId
						      ) AS NewLine 
				FROM( 
						SELECT id
						      ,identityId
						      ,headerName
						      ,titleName 
						      ,lineId 
						      ,orderNo 
						      ,rowName
						      
						      ,(CASE 
							    WHEN headerName='Application' AND titleName='Overtime/Under Time' THEN (SELECT (CASE WHEN `overtime`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `overtime` ELSE visibility END) END)  FROM accessRigths)
							    WHEN headerName='Application' AND titleName='Leave' THEN (SELECT (CASE WHEN `leave`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `leave` ELSE visibility END) END) FROM accessRigths)
							    WHEN headerName='Application' AND titleName='Offset' THEN (SELECT (CASE WHEN `offsetTime`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `offsetTime` ELSE visibility END) END) FROM accessRigths)
							    WHEN headerName='Application' AND titleName='TimeAdjustment' THEN (SELECT (CASE WHEN `timeAdjustment`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `timeAdjustment` ELSE visibility END) END) FROM accessRigths)
							    WHEN headerName='Application' AND titleName='OfficialBusiness' THEN (SELECT (CASE WHEN `officialBusiness`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `officialBusiness` ELSE visibility END) END)  FROM accessRigths)
							    WHEN headerName='Application' AND titleName='TimeEntry' THEN (SELECT   (CASE WHEN `timeEntry`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `timeEntry` ELSE visibility END) END)  FROM accessRigths)
							    WHEN headerName='Application' AND titleName='ScheduleChange' THEN (SELECT (CASE WHEN `scheduleChange`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `scheduleChange` ELSE visibility END) END)  FROM accessRigths)
							    WHEN headerName='Application' AND titleName='HRDCertificate' THEN (SELECT (CASE WHEN `hrdCert`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `hrdCert` ELSE visibility END) END) FROM accessRigths)
							    ELSE visibility
							END)AS visibility
							
						FROM(     
							SELECT id
							      ,identityId
							      ,headerName
							      ,titleName 
							      ,lineId 
							      ,orderNo
							      ,visibility
							      ,(CASE WHEN IFNULL(headerName,'')='' THEN titleName ELSE headerName END) AS rowName 
							FROM user_dashboard_settings  
							WHERE identityId = r_identityId
						)t1 
					)t1
				)t1
			ORDER BY orderNo,NewLine 
		-- WHERE headerName='Application'
		-- ORDER BY orderNo,NewLine 
		;
		
		
	
	END IF;
	
	
	IF (pint_mode=1) THEN
	
				DELETE FROM user_dashboard_settings WHERE identityId = r_identityId;
				
				INSERT INTO user_dashboard_settings (identityId,titleName,headerName,lineId,orderNo) 
				SELECT r_identityId,'annonucement','',1,1 UNION ALL
				SELECT r_identityId,'calendar','',1,2 UNION ALL
				SELECT r_identityId,'Overtime/Under Time','ForApproval',1,3 UNION ALL
				SELECT r_identityId,'Leave','ForApproval',2,3 UNION ALL
				SELECT r_identityId,'Offset','ForApproval',3,3 UNION ALL
				SELECT r_identityId,'TimeAdjustment','ForApproval',4,3 UNION ALL
				SELECT r_identityId,'OfficialBusiness','ForApproval',5,3 UNION ALL
				SELECT r_identityId,'TimeEntry','ForApproval',6,3 UNION ALL
				SELECT r_identityId,'ScheduleChange','ForApproval',7,3 UNION ALL
				SELECT r_identityId,'HRDCertificate','ForApproval',8,3 UNION ALL
				SELECT r_identityId,'Overtime/Under Time','Application',1,4 UNION ALL
				SELECT r_identityId,'Leave','Application',2,4 UNION ALL
				SELECT r_identityId,'Offset','Application',3,4 UNION ALL
				SELECT r_identityId,'TimeAdjustment','Application',4,4 UNION ALL
				SELECT r_identityId,'OfficialBusiness','Application',5,4 UNION ALL
				SELECT r_identityId,'TimeEntry','Application',6,4 UNION ALL
				SELECT r_identityId,'ScheduleChange','Application',7,4 UNION ALL 
				SELECT r_identityId,'HRDCertificate','Application',8,4 UNION ALL 
				SELECT r_identityId,'Overtime/Under Time','ApplicationMonitoringperCut-Off',1,5 UNION ALL
				SELECT r_identityId,'Leave','ApplicationMonitoringperCut-Off',2,5 UNION ALL
				SELECT r_identityId,'Offset','ApplicationMonitoringperCut-Off',3,5 UNION ALL
				SELECT r_identityId,'TimeAdjustment','ApplicationMonitoringperCut-Off',4,5 UNION ALL
				SELECT r_identityId,'OfficialBusiness','ApplicationMonitoringperCut-Off',5,5 UNION ALL
				SELECT r_identityId,'TimeEntry','ApplicationMonitoringperCut-Off',6,5 UNION ALL
				SELECT r_identityId,'ScheduleChange','ApplicationMonitoringperCut-Off',7,5 UNION ALL 
				SELECT r_identityId,'HRDCertificate','ApplicationMonitoringperCut-Off',8,5 UNION ALL 
				 
				SELECT r_identityId,'TotalEmployeeAppReceivedPerCutOff','',1,6 UNION ALL
				
				SELECT r_identityId,'dtrViewPerCutOff','',1,7 UNION ALL
				SELECT r_identityId,'BiometricsData','others',1,8 UNION ALL
				SELECT r_identityId,'LeaveBalances','others',2,8 UNION ALL
				SELECT r_identityId,'EmployeeBiometricsLogs','',1,9 UNION ALL 
				SELECT r_identityId,'EmployeeSchedule','',1,10 UNION ALL
				SELECT r_identityId,'YearToDate','',1,11 ;
 
	END IF;
	
	
	IF (pint_mode=2) THEN
	
	
			UPDATE user_dashboard_settings t2
			JOIN tempUserDash t1 
					  ON t1.identityId = t2.identityId
					  AND t1.titleName = t2.titleName
					  AND t1.headerName = t2.headerName
			SET t2.orderNo = t1.orderNum
			    ,t2.visibility = t1.IsVisible
			    ,t2.`lineId`=t1.lineId
				;
	 END IF;
	 
	 COMMIT;
	  
END$$ 
DELIMITER ;