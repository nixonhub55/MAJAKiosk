 
DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_all_leave`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_all_leave`(
    IN pint_mode INT,
    IN app_id INT,
    IN id VARCHAR(30),
    OUT num INT,
    OUT msg VARCHAR(300)
)
BEGIN 
	SET num = 0;
	SET msg = 'Success';
	
	IF (pint_mode=0) THEN
	
		SELECT laAppNo,laID,laName,laCosCenter,laAppDate,laType,laDateTo	
		      ,laTotalDays ,currentBalance AS laBalance,laReason,laStatus,laRemarks ,laNoOfDays	
		      ,laApprover,laApprovedDateTime ,laBalanceCode,department,la.batchId	
		      ,la.location ,la.locationName,dep.departmentCode ,dep.departmentName	
		      ,approverId,approverName,clearanceItems,DefInternalOrder
		      ,cost.costCode,cost.costName,rdoCode,lv.leaveCode,lv.leaveName,lv.leaveCredit,lv.leaveType
		      ,	credits,leaveUsage,leavePolicy,tenure,calendarDays,convertibleToCash	
		      ,leaveReplenish,allowAdvanceLeave,allowToChooseLeave,prevLeaveTypeTag	
		      ,leaveReplenishDate,leaveExpireDate,advanceLeaveCRLimit,accrualFrequency	
		      ,accruedLeavePerMonth,payslipIncluded,maxConvertibleCredits,maxConvertiblePercent
		      ,la.laDateFrom,la.laDateTo,txt AS statusVal
		      ,DATABASE() AS r_srcDb
		FROM leaveapplicationform la
		LEFT JOIN identity idn ON la.laID = idn.identityId
		LEFT JOIN department dep ON la.`department` = dep.`departmentCode`
		LEFT JOIN costcenter cost ON la.`laCosCenter` = cost.`costCode`
		LEFT JOIN `leave` lv ON lv.leaveCode = la.laType
		LEFT JOIN employeeleavebalances bal ON la.laType=bal.leaveCode AND bal.code=idn.code
		LEFT JOIN statusMaster sts ON la.`laStatus` = sts.val
		WHERE la.laID = id AND laStatus IN ('P','F');
		
	END IF; 
	IF (pint_mode=1) THEN
		
		 
		SELECT laAppNo,laID,laName,laCosCenter,laAppDate,laType,laDateTo	
		      ,laTotalDays ,currentBalance AS laBalance,laReason,laStatus ,laRemarks ,laNoOfDays	
		      ,laApprover,laApprovedDateTime ,laBalanceCode,department,la.batchId	
		      ,la.location ,la.locationName,dep.departmentCode ,dep.departmentName	
		      ,approverId,clearanceItems,DefInternalOrder
		      ,cost.costCode,cost.costName,rdoCode,lv.leaveCode,lv.leaveName,lv.leaveCredit,lv.leaveType
		      ,	credits,leaveUsage,leavePolicy,tenure,calendarDays,convertibleToCash	
		      ,leaveReplenish,allowAdvanceLeave,allowToChooseLeave,prevLeaveTypeTag	
		      ,leaveReplenishDate,leaveExpireDate,advanceLeaveCRLimit,accrualFrequency	
		      ,accruedLeavePerMonth,payslipIncluded,maxConvertibleCredits,maxConvertiblePercent
		      ,la.laDateFrom,la.laDateTo
		      ,approval.approverName,approval.`decision`,approval.`approvedDate`,approval.`remarks`
		      ,DATABASE() AS r_srcDb
		FROM leaveapplicationform la
		LEFT JOIN identity idn ON la.laID = idn.identityId
		LEFT JOIN department dep ON la.`department` = dep.`departmentCode`
		LEFT JOIN costcenter cost ON la.`laCosCenter` = cost.`costCode`
		LEFT JOIN `leave` lv ON lv.leaveCode = la.laType
		LEFT JOIN employeeleavebalances bal ON la.laType=bal.leaveCode AND bal.code=idn.code
		
		LEFT JOIN (SELECT MAX(templateLineId)AS lineId,appNo 
		       FROM approval WHERE appNo=app_id  AND document='leave' AND approvedDate IS NOT NULL 
		       )line ON la.laAppNo = line.appNo 
		       
		LEFT JOIN approval ON line.appNo=approval.appNo AND approval.document='leave' AND approval.`templateLineId` = line.lineId
		WHERE laAppNo=app_id; 
		
	END IF; 
END$$
DELIMITER ;

 
-- CALL sp_leave_get_request_list(0,3,'{"srcDB":"mjci_jockey_club"}',@num,@msg); SELECT @msg
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_leave_get_request_list`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_leave_get_request_list`(
    IN pint_mode INT, 
    IN la_appNo INT,
    IN r_Opt TEXT,
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	SET num = 0;
	SET msg = 'Success';
	
	-- SELECT * FROM leaveapplicationlist WHERE id=emp_id; 
	-- DROP TABLE IF EXISTS tmpJson; CREATE TABLE tmpJson AS SELECT r_Opt;
	-- SELECT * FROM tmpJson 
	-- SET @db =  (SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB')) FROM tmpJson);
	SET @db =  IFNULL((SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB'))),DATABASE());
	
	SET @sql = CONCAT('SELECT SUM(laSched) INTO @laSched FROM `',@db,'`.`leaveapplicationlist` WHERE laLstAppNo=',la_appNo,'');
	PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
	
	 
	
	-- SET @laSched=(SELECT SUM(laSched) FROM leaveapplicationlist WHERE laLstAppNo=la_appNo); 
	 SET @sql = CONCAT('
		SELECT t1.*
		      ,(CASE 
				WHEN t2.`holidayDate` IS NOT NULL THEN "Holiday"
				WHEN DAYOFWEEK(laLstDate) IN (1, 7) THEN "Rest Day"
				WHEN laSched<1 THEN "Half Day"
				ELSE "Whole Day" 
			END
			)AS laSchedDesc 
		      ,DAYNAME(laLstDate)AS laLstDateDesc
		      ,',@laSched,' AS TotalLeave
		FROM `',@db,'`.`leaveapplicationlist` t1
		LEFT JOIN `',@db,'`.`holidaysholiday` t2 ON t1.laLstDate=t2.`holidayDate`
		WHERE laLstAppNo=',la_appNo,'
		'); 
		
	--  SELECT @sql;
	 PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
	 
END$$ 
DELIMITER ;


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
    IN ot_ExtAllowance INT, 
    IN ot_ExtAllowanceDetails LONGTEXT,
    IN r_attachedFiles LONGTEXT,  
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	DECLARE step INT DEFAULT 0;
	DECLARE EXIT HANDLER FOR SQLEXCEPTION
	BEGIN
		GET DIAGNOSTICS CONDITION 1 @errorMessage = MESSAGE_TEXT;
		ROLLBACK;
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lbl_txtRemarks",
				"msg":"',@errorMessage,' ->Step#:',step,'"	
			       }'); 
	END;
	
	SET num = 0;
	SET msg = '';
	
	-- DROP TABLE IF EXISTS tblDetails; CREATE TABLE tblDetails AS  SELECT JSON_UNQUOTE(ot_ExtAllowanceDetails) AS ExtAllowanceDetails;
	-- SELECT * FROM tblDetails
	SET step=1;
	SET @ot_ExtAllowance=ot_ExtAllowance; 
	
	SET @lbl_ot_date_from = 'lbl_from_date';
	SET @lbl_ot_date_to = 'lbl_to_date';
	 
	 
	
	SET ot_tot_break=(CASE WHEN ot_tot_break='0.00' THEN '00:00' ELSE ot_tot_break END); 
	SET @fn_check_used_dates = (SELECT fn_check_used_dates(0,CONCAT('{"otFrom" : "',ot_from,'","otTo" : "',ot_to,'","otID" : "',ot_ID,'"}')));
        
        
	SET step=2;	
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
	     
	SET step=3;     
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
	    SET msg = CONCAT('{
			"id":"',@lbl_ot_date_from,'",
			"msg":"Please enter [From Date]"	
		       }');
	   LEAVE proc_start;
	END IF;
	SET step=4;
	
	SET @otExtAllowanceFile = IFNULL(JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(ot_ExtAllowanceDetails),'$.attachmentFileName')),'');
	SET @app_type = (CASE WHEN ot_type='OT' THEN 'overtime' ELSE 'undertime' END);
	SET @filingDateValidation = (SELECT fn_validate_leave_filing(ot_from,DATE(NOW()),@app_type));
	SET @num = IFNULL((SELECT (CASE WHEN exception_filing_allowed=1 THEN 2 ELSE 1 END) FROM filing_window_matrix WHERE app_type = @app_type),1);
	SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);
/*	
	IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 AND @ot_ExtAllowance=0) THEN
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lblfileInput",
				"msg":"This application is outside the standard filling period. Please provide a reason and supporting document for exception approval"	
			       }');  
		LEAVE proc_start;
	END IF;
	
	
	IF (@filingDateValidation='INVALID' AND @otExtAllowanceFile='' AND @ot_ExtAllowance=1) THEN
		SET num = 1;
		SET msg = CONCAT('{
				"id":"lblfileInput",
				"msg":"This application is outside the standard filling period. Please provide a reason and supporting document for exception approval"	
			       }');  
		LEAVE proc_start;
	END IF;
*/
	
	IF (ot_to='') THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"',@lbl_ot_date_to,'",
			"msg":"Please enter [To Date]"	
		       }'); 
	LEAVE proc_start;
	END IF;
        SET step=5;
        IF (@fn_check_used_dates<>'')THEN 
	    SET num = 1;
	    SET msg = CONCAT('{
				"id":"',@lbl_ot_date_from,'",
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
	 
	
	 SET step=6;
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
	  
	SET step=7;
	SET @ottothours=(SELECT fn_ot_total_time_compute(ot_from,ot_to,ot_time_from,ot_time_to,ot_tot_break)); 
	SET @otCompute = @ottothours; 
	 
        SET @otComputeInt = CAST(@otCompute AS FLOAT);
	SET @otMinimumMinues = ROUND(CAST((SELECT minOTHours FROM companySetting) AS FLOAT),2);
	SET @otComputeMinutes=ROUND(CAST((SELECT HOUR(@otCompute) * 60 + MINUTE(@otCompute) AS total_minutes) AS FLOAT),2);
	SET @minTime = LEFT((SELECT SEC_TO_TIME(@otMinimumMinues * 60) AS time_result),8);
	
	 
	
	SET step=8;
	IF (@ot_ExtAllowance=1) THEN	
		SET @ot_ExtAllowanceDetails = (SELECT JSON_UNQUOTE(ot_ExtAllowanceDetails));
		-- SET @ot_ExtAllowanceDetails =(SELECT JSON_UNQUOTE(ExtAllowanceDetails) FROM tblDetails);
		 
		
		SELECT JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.regSched'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.actTimeIn'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.actTimeOut'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.totalAllowance'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentFileName'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentContent'))
		      ,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentFilType'))
	        INTO @regSched,@actTimeIn,@actTimeOut,@totalAllowance,@attachmentFileName,@attachmentContent,@attachmentFilType
		      ;
		
		 
		IF (@regSched='') THEN
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lblregSched",
				"msg":"No DTR found on work date:',ot_date,'"
			       }');
			LEAVE proc_start;
		END IF;
		
		 
		IF (fn_time_5_strings(@actTimeIn) = 0 OR @actTimeIn = '00:00') THEN 
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lblactTimeIn",
				"msg":"Invalid DTR Time-In"
			       }');
			LEAVE proc_start;
		END IF;
		 
		IF (fn_time_5_strings(@actTimeOut) = 0 OR @actTimeOut = '00:00') THEN
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lblactTimeOut",
				"msg":"Invalid DTR Time-Out"
			       }');
			LEAVE proc_start;
		END IF;
		
		IF (CAST(@totalAllowance AS FLOAT) < 250) THEN
			SET num = 1;
			SET msg = CONCAT('{
				"id":"lbltxtTotalAllowance",
				"msg":"Invalid allowance total. total time atleast 3 hours"
			       }');
			LEAVE proc_start;
		END IF;
		
	END IF;
	 
	
	 
	-- SET step=9;
	 
	
	
	
    
     SET step=10;
     --	IF ((@otMinimumMinues>@otComputeMinutes) AND ((DAYOFWEEK(ot_time_from) NOT IN (1,7)) OR (DAYOFWEEK(ot_time_to) NOT IN (1,7))) ) THEN  
     IF (@otMinimumMinues>@otComputeMinutes) THEN  
	    SET num = 1;
	    SET msg = CONCAT('{
			"id":"lbl_appTotalTime",
			"msg":"Overtime total should be greather than or equal ',@minTime,'"	
		       }');
     LEAVE proc_start;
     END IF;
     
 
    SET step=11;
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
	 
	SET step=12;
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
	
	SET step=13;
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
	
	SET step=14;
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
	
	SET step=15;
	IF (pint_mode=1) THEN
		
		START TRANSACTION; 
		SET @fullname=(SELECT (CONCAT(IFNULL(firstname,''),' ',IFNULL(middlename,''),' ',IFNULL(lastname,''))) FROM identity WHERE identityid=ot_ID);  
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
		
		 
		
		IF (@ot_ExtAllowance=1) THEN
			-- TRUNCATE TABLE overtimeExtensionAllowance;
			
			DELETE FROM overtimeExtensionAllowance WHERE otAppNo = ot_AppNo;
			
			INSERT INTO overtimeExtensionAllowance (otAppNo,regSched,actTimeIn,actTimeOut,totalAllowance,attachmentFileName,attachmentContent,attachmentFilType)
			VALUES (ot_AppNo,@regSched,@actTimeIn,@actTimeOut,@totalAllowance,@attachmentFileName,@attachmentContent,@attachmentFilType);
			-- SELECT * FROM overtimeExtensionAllowance
		END IF;
		
		DELETE FROM requestattachments WHERE appNo = ot_AppNo AND document='overtime'; 
		IF (JSON_LENGTH(@uploadedFiles)>0) THEN
			INSERT INTO requestattachments (appNo,document,files)
			VALUES (ot_AppNo,@app_type,@uploadedFiles);
		END IF;
					
		SET msg=ot_AppNo;
		COMMIT;
    END IF;
     
	 
END$$ 
DELIMITER ;

DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_overtime_ext_allo_mapping`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_overtime_ext_allo_mapping`(  
	IN pint_mode INT,
	IN r_data TEXT, 
	OUT num INT,
	OUT msg VARCHAR(300)
)
BEGIN  
	SET num = 0;
	SET msg = 'Success';
	
	 DROP TABLE IF EXISTS tblJson; CREATE TABLE tblJson AS  SELECT r_data;
	 
	 
	IF (pint_mode=1) THEN
	
		SET @r_data=JSON_UNQUOTE(r_data);
		-- SET @r_data=(SELECT JSON_UNQUOTE(r_data) FROM tblJson); 
		SELECT JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.username')),JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.date'))
		INTO @username,@date;
		
		SELECT 'JULY2028_SCHED' AS regSched,'07:00' AS dtrIn,'15:00' AS dtrOut;
	 
	END IF;
	
	IF (pint_mode=2) THEN
		-- CALL sp_portal_overtime_ext_allo_mapping (2,'{"username":1231,"totalTime":"03:30"}',@num,@msg); SELECT @msg;
	
		SET @r_data=JSON_UNQUOTE(r_data);
		-- SET @r_data=(SELECT JSON_UNQUOTE(r_data) FROM tblJson); 
		SELECT JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.username')),JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.totalTime'))
		INTO @username,@totalTime;
		
		SELECT 250 + GREATEST(0, FLOOR(TIME_TO_SEC(@totalTime) / 3600) - 3) * 50 AS total;
		
		-- SELECT ROUND((TIME_TO_SEC(@totalTime) / 3600) * 50,2) AS total;
	 
	END IF;
	 
END$$
DELIMITER ;

DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_ob_application_get_officialbusinesslist`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_ob_application_get_officialbusinesslist`(  
    IN pint_mode INT,   
    IN r_id VARCHAR(30),
    IN r_Opt TEXT, 
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 

-- CALL sp_ob_application_get_officialbusinesslist(0,8,'{"srcDB":"mjci_jockey_club"}',@num,@msg); SELECT @msg
	SET num = 0;
	SET msg = 'Success';

	-- SELECT * FROM leaveapplicationlist WHERE id=emp_id; 
	-- DROP TABLE IF EXISTS tmpJson; CREATE TABLE tmpJson AS SELECT r_Opt;
	-- SELECT * FROM tmpJson 
	-- SET @db =  (SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB')) FROM tmpJson);
	SET @db =  IFNULL((SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB'))),DATABASE()); 
	SET @sql = CONCAT('SELECT *  FROM `',@db,'`.`officialbusinesslist`  WHERE obLstAppNo=',r_id,'  ORDER BY obLstID ASC'); 
	PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
    
END$$ 
DELIMITER ;