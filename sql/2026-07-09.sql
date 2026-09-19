-- CALL sp_application_info(0,6,'1001220742',0,'P','1991-01-01','',@num,@msg); SELECT @msg
SELECT payrollPeriodFrom,payrollPeriodTo,payrollPeriod FROM v_payrollperiod
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_application_info`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_application_info`( 
    IN pint_mode INT,	
    IN switch INT, 
    IN rAppNo INT, 
    IN rID VARCHAR(30),  
    IN r_decision VARCHAR(3),
    IN dateFrom VARCHAR(30),
    IN dateTo VARCHAR(30),
    OUT num INT,
    OUT msg VARCHAR(300)
)
proc_start:BEGIN 
	SET num = 0;
	SET msg = 'Success';
	
	
	 -- SELECT * FROM documentMaster
         SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch); 
         SET @id =  (CASE   WHEN rAppNo>0 THEN rAppNo    ELSE rID END);	
         SET @IsApproval = (CASE 
				WHEN (pint_mode=1 AND rAppNo=0 AND rID<>'' AND r_decision = 'F') THEN 1
				ELSE 0 
			     END);
         
         
         SET @leftJoin=(CASE 
			  WHEN @document='overtime' THEN 'LEFT JOIN overtimeform t2 on t1.appNo=t2.otAppNo'
		          WHEN @document='leave' THEN 'LEFT JOIN leaveapplicationform t2 on t1.appNo=t2.laAppNo'
		          WHEN @document='timeadjustment' THEN 'LEFT JOIN timeadjustmentform t2 on t	1.appNo=t2.taAppNo'
		          WHEN @document='officialbusiness' THEN 'LEFT JOIN officialbusinessform t2 on t1.appNo=t2.obAppNo'
		          WHEN @document='offset' THEN 'LEFT JOIN offsetform t2 on t1.appNo=t2.osAppNo'
		          WHEN @document='timeentry' THEN 'LEFT JOIN timeentryform t2 on t1.appNo=t2.teAppNo' 
		          WHEN @document='schedulechange' THEN 'LEFT JOIN schedulechange t2 on t1.appNo=t2.scAppNo' 
		          WHEN @document='hrdcert' THEN 'LEFT JOIN hrdcertificate t2 on t1.appNo=t2.appNo' 
		      END);
	
	SET @additionalColumns = (CASE  
					  WHEN @document='offset' THEN ',(SELECT fn_offset_ot_id(osReference,osID)) as osOtAppNo' 
					  ELSE ''
				  END);	      
				    
		      
       SET @appDates=(CASE 
			  WHEN @document='overtime' THEN 't2.otDate as dateFrom,t2.otDate as dateTo'
		          WHEN @document='leave' THEN 't2.laDateFrom as dateFrom,t2.laDateTo as dateTo'
		          WHEN @document='timeadjustment' THEN 't2.taDate as dateFrom,t2.taDate as dateTo'
		          WHEN @document='officialbusiness' THEN 't2.obDateFrom as dateFrom,t2.obDateTo as dateTo'
		          WHEN @document='offset' THEN 't2.osDateFrom as dateFrom,t2.osDateTo as dateTo'
		          WHEN @document='timeentry' THEN 't2.teDate as dateFrom,t2.teDate as dateTo' 
		          -- WHEN @document='schedulechange' THEN 't2.scReqDate as dateFrom,t2.scReqDate as dateTo' 
		          WHEN @document='schedulechange' THEN 't2.scReqDate as dateFrom,t2.scReqDate as dateTo' 
		          WHEN @document='hrdcert' THEN 't2.requestDate as dateFrom,t2.requestDate as dateTo' 
		      END);
		      
		     
		      
         SET @center=(CASE 
			  WHEN @document='overtime' THEN 't2.otCosCenter'
		          WHEN @document='leave' THEN 't2.laCosCenter'
		          WHEN @document='timeadjustment' THEN 't2.taCosCenter'
		          WHEN @document='officialbusiness' THEN 't2.obCosCenter'
		          WHEN @document='offset' THEN 't2.osCosCenter'
		          WHEN @document='timeentry' THEN 't2.teCosCenter' 
		          WHEN @document='schedulechange' THEN 't2.scCosCenter' 
		          WHEN @document='hrdcert' THEN 't2.costCenter' 
		      END);
		      
		      
		      
         SET @appDate=(CASE 
			  WHEN @document='overtime' THEN 't2.otAppDate'
		          WHEN @document='leave' THEN 't2.laAppDate'
		          WHEN @document='timeadjustment' THEN 't2.taAppDate'
		          WHEN @document='officialbusiness' THEN 't2.obAppDate'
		          WHEN @document='offset' THEN 't2.osAppDate'
		          WHEN @document='timeentry' THEN 't2.teAppDate' 
		          WHEN @document='schedulechange' THEN 't2.scReqDate' 
		          WHEN @document='hrdcert' THEN 't2.requestDate' 
		      END);
         
	
	
         SET @appStatus=(CASE 
			  WHEN @document='overtime' THEN 't2.otStatus'
		          WHEN @document='leave' THEN 't2.laStatus'
		          WHEN @document='timeadjustment' THEN 't2.taStatus'
		          WHEN @document='officialbusiness' THEN 't2.obStatus'
		          WHEN @document='offset' THEN 't2.osStatus'
		          WHEN @document='timeentry' THEN 't2.teStatus' 
		          WHEN @document='schedulechange' THEN 't2.scStatus' 
		          WHEN @document='hrdcert' THEN 't2.status' 
		      END);
		   
        
	   
 
	 SET @DateFilter=(CASE 
			  WHEN @document='overtime' THEN 't2.otAppDate'
		          WHEN @document='leave' THEN 't2.laAppDate'
		          WHEN @document='timeadjustment' THEN  't2.taAppDate'
		          WHEN @document='officialbusiness' THEN 't2.obAppDate'
		          WHEN @document='offset' THEN 't2.osAppDate'
		          WHEN @document='timeentry' THEN 't2.teAppDate'
		          WHEN @document='schedulechange' THEN 't2.scAppDate'
		          WHEN @document='hrdcert' THEN 't2.requestDate'
		      END);	
		
		 
	  
	 SET dateFrom=(CASE 
			  WHEN r_decision IN ('P','F') THEN  (SELECT DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) 
			  WHEN dateFrom='' THEN  (SELECT DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
			  ELSE dateFrom 
		       END);  
	 SET dateTo=(CASE WHEN dateTo='' THEN  DATE(NOW()) ELSE dateTo END); 
	 SET dateTo=(CASE WHEN (@document='hrdcert') AND (@IsApproval=1) THEN  DATE_ADD(dateTo, INTERVAL 1 MONTH) ELSE dateTo END); 
	 SET r_decision = (CASE WHEN r_decision='' THEN 'H' ELSE r_decision END);
	  
    	 
	 
	DROP TEMPORARY TABLE IF EXISTS temp_approval;     
	SET @sql = CONCAT(' 	
				CREATE TEMPORARY TABLE temp_approval AS
				SELECT DISTINCT t1.appNo as r_appNo,	t1.document as r_document,',IF(rAppNo>0,'t1.templateCode as r_templateCode,',''),'	t1.templateLineId as r_templateLineId,	t1.id as r_id,	t1.approver as r_approver,	t1.approverName as r_approverName,	t1.decision as r_decision,	t1.remarks as r_remarks, DATE_FORMAT(t1.approvedDate, ''%Y-%m-%d %h:%i:%s %p'') as r_approvedDate,	t1.prevTemplateCode as r_prevTemplateCode
					,t4.txt as r_status
					,t2.*,',@center,' as center 
					,',@appDates,'
					,',@center,' as appDate
					-- ,stdtls.`id` as AuthId 
					',@additionalColumns,'
				FROM approval t1
				 ', @leftJoin, '
				LEFT JOIN (
					SELECT MAX(templateLineId)AS templateLineId,appNo,document
					FROM approval 
					WHERE (CASE WHEN templateLineId=1 AND approver IS NULL THEN id ELSE approver END) IS NOT NULL
					GROUP BY appNo,document 
					  ) t3 ON t1.appNo = t3.appNo AND t3.document=t1.document AND t1.templateLineId = t3.templateLineId 
				LEFT JOIN approvaltemplatestages auth ON t1.`templateCode`=auth.`code` AND t1.`templateLineId`=auth.`lineId`
				LEFT JOIN approvalstages stgs ON auth.`stageCode`=stgs.`stageCode`
				LEFT JOIN approvalstagedetails stdtls ON stgs.`code`=stdtls.`code` -- AND stdtls.`lineId`= t1.`templateLineId`
				LEFT JOIN statusMaster t4 ON ',IF(pint_mode=0,@appStatus,'t1.decision'),' = t4.val
				LEFT JOIN appLinkStatus t5 ON ',IF(pint_mode=0,@appStatus,'t4.val'),' = t5.lStatus
				',(CASE WHEN @IsApproval=1 
					THEN CONCAT('WHERE ',@DateFilter,' BETWEEN ''',dateFrom,''' AND ''',dateTo,''' 
					                        AND stdtls.`id`=''',rID,'''
								AND t1.decision=''',r_decision,'''
								AND t1.document=''',@document,''' 
								',(CASE WHEN r_decision IN ('P','F') THEN CONCAT(' AND ',@appStatus,'<>''D'' ') ELSE '' END),'
								-- AND t3.appNo IS NOT NULL
						   ') 
						    
					ELSE  CONCAT('
						      WHERE (CASE 
								    WHEN ', rAppNo, ' > 0 THEN t1.appNo
								    WHEN ', pint_mode, ' = 0 THEN t1.id
								    WHEN ', pint_mode, ' = 1 THEN t1.approver
							     END)=  ''', @id, ''' 
							     AND t1.document=''',@document,'''
							     ', IF(rAppNo > 0, '', CONCAT('AND ', @DateFilter, ' BETWEEN ''',dateFrom,''' AND ''',dateTo,'''')), '
							     ', IF(rAppNo > 0, '', CONCAT('AND t5.link = ''',r_decision,''' ')), ' 
							     ', IF(pint_mode = 0, 'AND t3.appNo IS NOT NULL', ''), ' 
							    -- AND t3.appNo IS NOT NULL
							    -- ', IF(rAppNo > 0, 'AND t3.appNo IS NOT NULL', ''), ' 
				 		
						    ')
				END),' 
			'); 
	
	-- SELECT @sql; LEAVE proc_start;
	PREPARE stmt FROM @sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;
	
	DROP TEMPORARY TABLE IF EXISTS tempIdentity;
	CREATE TEMPORARY TABLE tempIdentity AS( 
		SELECT `code`,identityId,CONCAT(firstName,' ',middleName,' ',lastName) AS fullName
		      ,batchId,payrollConfigurationCode,paymentFrequency,payrollPeriodID
		FROM identity WHERE identityId IN (SELECT r_id FROM temp_approval)
	  );
	 
	 
 
	 
	SELECT DISTINCT  t1.*
	       ,identity.fullName
	       ,payrollperioddetails.payrollPeriodApproverLocked  AS approverLocked 
	       ,dep.departmentName
	       ,cost.costName 
	FROM temp_approval t1
	LEFT JOIN department dep ON t1.department = dep.departmentCode
	LEFT JOIN costCenter AS cost ON t1.center=cost.costCode 
	LEFT JOIN tempIdentity identity ON t1.r_id=identity.identityId 
	
	LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
	
	
	LEFT JOIN payrollconfiguration ON
	identity.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
	identity.paymentFrequency = 
	(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
	WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
	WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)
	AND YEAR(t1.dateFrom) = payrollperiod.`payrollPeriodYear`
	AND identity.payrollPeriodID = payrollperiod.`payrollPeriodID`
	
	
	LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
	AND payrollperioddetails.payrollPeriodFrom <= t1.dateFrom
	AND payrollperioddetails.payrollPeriodTo >= t1.dateTo  
	;
          
END$$
DELIMITER ;
 