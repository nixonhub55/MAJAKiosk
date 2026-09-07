USE `meapeca_test`; 

SET max_recursive_iterations = 1500;

ALTER TABLE department ADD IF NOT EXISTS DefInternalOrder VARCHAR(20);
ALTER TABLE schedulechange MODIFY COLUMN department VARCHAR(20);
DROP TABLE IF EXISTS filing_window_matrix;
ALTER TABLE overtimeform ADD IF NOT EXISTS otExtAllowance INT NOT NULL DEFAULT 0;  
ALTER TABLE overtimeapproverhistory ADD COLUMN IF NOT EXISTS   otExtAllowance INT NOT NULL DEFAULT 0 AFTER otToDate;
ALTER TABLE approvaltemplates ADD COLUMN IF NOT EXISTS  `HRISApprovalDetails` TEXT DEFAULT NULL;
ALTER TABLE approvaltemplates ADD COLUMN IF NOT EXISTS  `PAF_Approval` TINYINT(1) DEFAULT NULL;
ALTER TABLE approvaltemplates ADD COLUMN IF NOT EXISTS  `clearance` TINYINT(1) DEFAULT NULL;
ALTER TABLE employeemovement ADD COLUMN IF NOT EXISTS  allowance DECIMAL(19,2) DEFAULT NULL AFTER `rate`;
ALTER TABLE payrollperioddetails ADD  IF NOT EXISTS nonPayroll TINYINT(1) DEFAULT NULL;

CREATE TABLE IF NOT EXISTS `schedulechangeapproverhistory` (
`scAppNo` INT(11) NOT NULL AUTO_INCREMENT,
`scID` VARCHAR(20) DEFAULT NULL,
`scName` VARCHAR(50) NOT NULL,
`scAppDate` DATE NOT NULL,
`scCosCenter` VARCHAR(50) NOT NULL, 
`scReqDate` DATE NOT NULL,
`scPreviousSched` VARCHAR(20) NOT NULL,
`scSchedule` VARCHAR(20) NOT NULL,
`scPayrollPeriod` VARCHAR(10) DEFAULT NULL,
`scDay` VARCHAR(10) DEFAULT NULL,
`scReason` TEXT NOT NULL,
`scStatus` CHAR(1) NOT NULL DEFAULT 'P',
`department` VARCHAR(20) DEFAULT NULL,
`location` VARCHAR(50) DEFAULT NULL,
`locationName` VARCHAR(50) DEFAULT NULL,
`approverId` VARCHAR(100) DEFAULT NULL,
`approverName` VARCHAR(100) DEFAULT NULL,
`decision` VARCHAR(5) DEFAULT NULL,
`timeStamp` TIMESTAMP NULL DEFAULT NULL,
KEY `scAppNo` (`scAppNo`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


ALTER TABLE schedulechangeapproverhistory MODIFY COLUMN IF EXISTS department VARCHAR(20);


ALTER TABLE identity ADD IF NOT EXISTS windowHours DECIMAL(19,2);
ALTER TABLE identity ADD IF NOT EXISTS workOnHoliday TINYINT;
ALTER TABLE identity ADD IF NOT EXISTS paymentComputation VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS workingDaysInaYear VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS workingHoursInaDay VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS basisOfAbsent VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS payrollConfigurationCode VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS doleSetup VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS workSchedule VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS scheduleCode VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS tempScheduleCode VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS lateConversionCode VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS undertimeConversionCode VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS location VARCHAR(50);
ALTER TABLE identity ADD IF NOT EXISTS requiredFiledOT TINYINT(1);
ALTER TABLE identity ADD IF NOT EXISTS payrollPeriodID VARCHAR(50); 
ALTER TABLE identity ADD IF NOT EXISTS faceDetails TEXT NOT NULL DEFAULT '';
ALTER TABLE identity DROP COLUMN  IF EXISTS faceDetails;
ALTER TABLE users ADD IF NOT EXISTS faceDetails TEXT NOT NULL DEFAULT '';
ALTER TABLE users ADD IF NOT EXISTS access_locked INT(1);
ALTER TABLE users ADD IF NOT EXISTS pw_last_date_changed DATETIME;
ALTER TABLE users ADD IF NOT EXISTS passwords_used VARCHAR(100);
ALTER TABLE users MODIFY COLUMN IF EXISTS access_locked INT(1);


ALTER TABLE identity MODIFY COLUMN IF EXISTS workOnHoliday TINYINT(1); 
ALTER TABLE companySetting MODIFY COLUMN IF EXISTS companyLogoBlob MEDIUMBLOB;  
ALTER TABLE companySetting ADD IF NOT EXISTS authType ENUM('none','ssl','tls','STARTTLS','auto') DEFAULT 'none'; 
ALTER TABLE companySetting ADD IF NOT EXISTS `protocol` VARCHAR(10) DEFAULT NULL;
ALTER TABLE companySetting ADD IF NOT EXISTS `smtpHost` VARCHAR(30) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `smtpPort` INT(5) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `defaultSenderName` VARCHAR(50) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `password` VARCHAR(100) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `kioskEmail` VARCHAR(50) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `ImagePath` VARCHAR(150) DEFAULT NULL; 
ALTER TABLE companySetting ADD IF NOT EXISTS `ImageFile` VARCHAR(50) DEFAULT 'assets/img/default_logo.png'; 
ALTER TABLE companySetting ADD COLUMN IF NOT EXISTS daysPriorToLeave TINYINT(2) DEFAULT 0;

-- ALTER TABLE identity DROP COLUMN faceDetails;

ALTER TABLE companysetting ADD IF NOT EXISTS passwordChangeInitLogon TINYINT(1);
ALTER TABLE companysetting ADD IF NOT EXISTS passwordReuseRestriction TINYINT(4); 
ALTER TABLE companysetting ADD IF NOT EXISTS passwordLength TINYINT(4);
ALTER TABLE companysetting ADD IF NOT EXISTS passwordComplexEnabled TINYINT(1);
ALTER TABLE companysetting ADD IF NOT EXISTS lockedOutDuration INT(11);
ALTER TABLE companysetting ADD IF NOT EXISTS lockedOutRecoveryType ENUM('manual','auto');
ALTER TABLE companysetting ADD IF NOT EXISTS passwordExpiredDays INT(11);
ALTER TABLE companysetting ADD IF NOT EXISTS enableCaptcha TINYINT(1);
ALTER TABLE companysetting ADD IF NOT EXISTS logAttempts INT(11);
ALTER TABLE companysetting ADD IF NOT EXISTS companyLogoBlob VARCHAR(200);


DROP TABLE IF EXISTS overtimeextensionallowance;
CREATE TABLE `overtimeextensionallowance` (
`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
`otAppNo` INT(11) NOT NULL,
`regSched` VARCHAR(100) DEFAULT NULL,
`actTimeIn` VARCHAR(20) DEFAULT NULL,
`actTimeOut` VARCHAR(20) NOT NULL,
`totalTime` VARCHAR(20) DEFAULT NULL,
`otTotal` VARCHAR(20) NOT NULL,
`totalAllowance` FLOAT NOT NULL,
`attachmentFileName` VARCHAR(100) DEFAULT NULL,
`attachmentContent` LONGTEXT DEFAULT NULL,
`attachmentFilType` VARCHAR(15) DEFAULT NULL,
`created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP(),
PRIMARY KEY (`id`),
KEY `idx_action_type` (`otAppNo`),
KEY `idx_created_at` (`created_at`)
) ENGINE=MYISAM DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS `leave_attachments` (
`id` INT(11) NOT NULL AUTO_INCREMENT,
`laAppNo` VARCHAR(30) NOT NULL,
`fileContent` LONGTEXT DEFAULT NULL,
`visibility` INT(11) NOT NULL DEFAULT 1,
PRIMARY KEY (`id`,`laAppNo`)
) ENGINE=INNODB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- DROP TABLE IF EXISTS overtimeExtensionAllowance; 
CREATE TABLE IF NOT EXISTS  overtimeExtensionAllowance (
id BIGINT AUTO_INCREMENT PRIMARY KEY,
otAppNo INT(11) NOT NULL, 
regSched VARCHAR(100) NULL,
actTimeIn VARCHAR(10) NULL,
actTimeOut VARCHAR(10) NOT NULL, 
totalAllowance FLOAT NOT NULL,
attachmentFileName VARCHAR(100), 
attachmentContent LONGTEXT,
attachmentFilType VARCHAR(15), 
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
INDEX idx_action_type (otAppNo),
INDEX idx_created_at (created_at)
)ENGINE=MYISAM;

CREATE TABLE IF NOT EXISTS `requestattachments` (
`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
`appNo` INT(11) NOT NULL,
`document` VARCHAR(100) DEFAULT NULL,
files LONGTEXT,
`created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP(),
PRIMARY KEY (`id`),
KEY `idx_appNo` (`appNo`),
KEY `idx_created_at` (`created_at`)
) ENGINE=MYISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS filing_window_matrix (
id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
app_type ENUM('overtime','leave','timeadjustment','officialbusiness','offset','timeentry','schedulechange','undertime') NOT NULL,

days_before INT NULL,
days_after INT NULL,

days_before_configurable TINYINT(1) NOT NULL DEFAULT 0,
days_after_configurable TINYINT(1) NOT NULL DEFAULT 0,

exception_filing_allowed TINYINT(1) NOT NULL DEFAULT 0,
recommended_handling VARCHAR(255) NULL,

is_active TINYINT(1) NOT NULL DEFAULT 1,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
updated_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
	ON UPDATE CURRENT_TIMESTAMP,

PRIMARY KEY (id),
UNIQUE KEY uq_filing_window_application_type (app_type),
KEY idx_filing_window_active (is_active)
) ENGINE=INNODB
DEFAULT CHARSET=utf8mb4
COLLATE=utf8mb4_unicode_ci;

INSERT INTO filing_window_matrix (
app_type,
days_before,
days_after,
days_before_configurable,
days_after_configurable,
exception_filing_allowed,
recommended_handling,
is_active
)
VALUES
('leave', 2, 2, 0, 0, 1, 'HR-approved exception', 1),
('overtime', 2, 2, 0, 0, 1, 'Manager and HR validation', 1),
('officialbusiness', 2, 2, 0, 0, 1, 'Require reason or attachment', 1),
('timeentry', 2, 2, 0, 0, 1, 'Require missing-log justification', 1),
('schedulechange', NULL, NULL, 1, 1, 1, 'Validate against schedule start', 1),
('offset', 2, 2, 0, 0, 1, 'Validate available offset balance', 1),
('undertime', 0, 2, 1, 0, 1, 'Retroactive filing with approval', 1)
ON DUPLICATE KEY UPDATE
days_before = VALUES(days_before),
days_after = VALUES(days_after),
days_before_configurable = VALUES(days_before_configurable),
days_after_configurable = VALUES(days_after_configurable),
exception_filing_allowed = VALUES(exception_filing_allowed),
recommended_handling = VALUES(recommended_handling),
is_active = VALUES(is_active);



CREATE TABLE IF NOT EXISTS json_tbl (
id INT AUTO_INCREMENT PRIMARY KEY,
json_data JSON
);



-- DROP TABLE IF EXISTS activity_logs; 
CREATE TABLE IF NOT EXISTS  activity_logs (
id BIGINT AUTO_INCREMENT PRIMARY KEY,
username VARCHAR(32) NULL, 
email VARCHAR(100) NULL,
user_type VARCHAR(20) NULL,
action_type VARCHAR(50) NOT NULL, -- e.g., login, insert, update, delete, system_error
description TEXT, -- Detailed info of what happened
module VARCHAR(100) NULL, -- Optional: e.g., "Users", "Payments", "API", "System"
ip_address VARCHAR(45) NULL, -- IPv4/IPv6 of user
user_agent VARCHAR(255) NULL, -- Browser or system info
`status` ENUM('success', 'failed', 'info', 'warning', 'error') DEFAULT 'info',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
INDEX idx_action_type (action_type),
INDEX idx_created_at (created_at)
)ENGINE=MYISAM;


CREATE TABLE IF NOT EXISTS `user_password_logs` (
`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
`username` VARCHAR(20) NOT NULL,
`dt_created` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
`password` VARCHAR(100) DEFAULT NULL,
`status` TINYINT(1) DEFAULT 1,
PRIMARY KEY (`id`)
) ENGINE=INNODB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;


-- DROP TABLE userAuditTrails;
CREATE TABLE IF NOT EXISTS `userAuditTrails` (
`id` INT(100) NOT NULL AUTO_INCREMENT,
`identityId` VARCHAR (30) NOT NULL,
`activity` VARCHAR (100) NOT NULL,
`status` VARCHAR (60) NOT NULL DEFAULT 'success',
`details` VARCHAR (150) NOT NULL DEFAULT '',
`machainDetails` VARCHAR (200) NOT NULL,
`facilityDetails` VARCHAR (150) NOT NULL,
`systemDate` DATETIME DEFAULT CURRENT_TIMESTAMP(),
PRIMARY KEY (`id`,identityId)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


-- DROP TABLE IF EXISTS deletedleaveapplicationlist;
CREATE TABLE IF NOT EXISTS `deletedleaveapplicationlist` (
`laLstAppNo` INT(11) NOT NULL,
`laLstDate` DATE NOT NULL,
`laLstType` VARCHAR(20) NOT NULL,
`laLstDescription` TEXT NOT NULL,
`laLstID` INT(11) NOT NULL,
`id` VARCHAR(20) DEFAULT NULL,
`laSched` DECIMAL(10,6) NOT NULL,
`laLstTimeFrom` VARCHAR(20) DEFAULT NULL,
`laLstTimeTo` VARCHAR(20) DEFAULT NULL,
`laBalAsOf` DECIMAL(10,2) DEFAULT NULL,
`laBalance` DECIMAL(10,2) DEFAULT NULL,
`laUnitType` VARCHAR(10) DEFAULT NULL,
systemDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
KEY `laLstAppNo` (`laLstAppNo`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;



-- DROP TABLE IF EXISTS announcement_viewed;  
CREATE TABLE IF NOT EXISTS  announcement_viewed (
id INT AUTO_INCREMENT, 
postId INT,
identityId VARCHAR(20), 
`status` INT NOT NULL DEFAULT 0,
dateViewed DATETIME DEFAULT CURRENT_TIMESTAMP(),
PRIMARY KEY (id,postId,identityId)
);



CREATE TABLE IF NOT EXISTS `dtrlogsviewcollector` (
`dtrTime` DATETIME ,
`dtrType` VARCHAR (3),
`biometricsId` VARCHAR (60),
`machineID` VARCHAR (60),
`Source` VARCHAR (150)
); 

CREATE TABLE IF NOT EXISTS `portal_mfa` (
`id` INT(100) NOT NULL AUTO_INCREMENT,
`type` VARCHAR(20) NOT NULL,
`code` VARCHAR(100) NOT NULL,
`usedIdBy` VARCHAR(50) NULL,
`useDate` DATETIME NULL,
`systemDate` DATETIME DEFAULT CURRENT_TIMESTAMP(),
`identityId` VARCHAR(50) NOT NULL,
PRIMARY KEY (`id`,`code`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS  max_tbl (
id INT AUTO_INCREMENT PRIMARY KEY,
maxID VARCHAR(30)
);


CREATE TABLE IF NOT EXISTS  `temp_temporarydtr` (
`payrollPeriod` VARCHAR (60),
`payrollPeriodID` VARCHAR (150),
`payrollPeriodType` VARCHAR (45),
`batchId` VARCHAR (150),
`costCode` VARCHAR (60),
`employeeCode` BIGINT (20),
`employeeId` VARCHAR (60),
`employeeName` VARCHAR (300),
`day` VARCHAR (30),
`date` DATE ,
`schedule` VARCHAR (60),
`scheduleType` VARCHAR (60),
`scheduleName` VARCHAR (300),
`schedIn` DATETIME ,
`schedOut` DATETIME ,
`breakHour` INT (3),
`advanceIn` DATETIME ,
`extendedOut` DATETIME ,
`biometricsIn` DATETIME ,
`biometricsOut` DATETIME ,
`equivalentHours` FLOAT ,
`gracePeriod` FLOAT ,
`late` INT (11),
`undertime` INT (11),
`hoursRendered` INT (11),
`excessTime` INT (11),
`workHours` INT (11),
`totalHours` INT (11),
`holidayTagging` VARCHAR (9),
`status` VARCHAR (60),
`overtime` INT (11),
`nightDiff` INT (11),
`nightDiffOvertime` INT (11),
`leave` INT (11),
`rateType` VARCHAR (3),
`absent` INT (1),
`post` BIT (1),
`department` VARCHAR (60),
`leaveType` VARCHAR (60),
`dateInactive` DATE ,
`finalPay` TINYINT (1),
`lwop` INT (11),
`otType` VARCHAR (60),
`schedType` VARCHAR (60),
`jobCategoryCode` VARCHAR (90),
`unpaidhours` INT (11)
); 




CREATE TABLE  IF NOT EXISTS  `posteddtr` (
`payrollPeriod` VARCHAR(30) NOT NULL,
`payrollPeriodID` VARCHAR(50) DEFAULT NULL,
`payrollPeriodType` VARCHAR(15) DEFAULT NULL,
`payrollPeriodMonth` VARCHAR(20) DEFAULT NULL,
`payrollPeriodFrom` DATE DEFAULT NULL,
`payrollPeriodTo` DATE DEFAULT NULL,
`payrollGroup` VARCHAR(50) DEFAULT NULL,
`costCenter` VARCHAR(20) DEFAULT NULL,
`department` VARCHAR(20) DEFAULT NULL,
`employeeCode` BIGINT(20) DEFAULT NULL,
`employeeId` VARCHAR(20) DEFAULT NULL,
`employeeName` VARCHAR(100) DEFAULT NULL,
`day` VARCHAR(30) DEFAULT NULL,
`date` DATE DEFAULT NULL,
`scheduleName` VARCHAR(100) DEFAULT NULL,
`shiftTo` DATETIME DEFAULT NULL,
`shiftFrom` DATETIME DEFAULT NULL,
`biometricsIn` DATETIME DEFAULT NULL,
`biometricsOut` DATETIME DEFAULT NULL,
`regularWorkHour` INT(11) DEFAULT NULL,
`regularNightDiff` INT(11) DEFAULT NULL,
`regularOTHour` INT(11) DEFAULT NULL,
`regularOTNightDiff` INT(11) DEFAULT NULL,
`regularRestDayWorkHour` INT(11) DEFAULT NULL,
`regularRestDayNightDiff` INT(11) DEFAULT NULL,
`regularRestDayOTHour` INT(11) DEFAULT NULL,
`regularRestDayOTNightDiff` INT(11) DEFAULT NULL,
`specialWorkHour` INT(11) DEFAULT NULL,
`specialNightDiff` INT(11) DEFAULT NULL,
`specialOTHour` INT(11) DEFAULT NULL,
`specialOTNightDiff` INT(11) DEFAULT NULL,
`specialRestDayWorkHour` INT(11) DEFAULT NULL,
`specialRestDayNightDiff` INT(11) DEFAULT NULL,
`specialRestDayOTHour` INT(11) DEFAULT NULL,
`specialRestDayOTNightDiff` INT(11) DEFAULT NULL,
`regularLegalWorkHour` INT(11) DEFAULT NULL,
`regularLegalNightDiff` INT(11) DEFAULT NULL,
`regularLegalOTHour` INT(11) DEFAULT NULL,
`regularLegalOTNightDiff` INT(11) DEFAULT NULL,
`regularLegalRestDayWorkHour` INT(11) DEFAULT NULL,
`regularLegalRestDayNightDiff` INT(11) DEFAULT NULL,
`regularLegalRestDayOTHour` INT(11) DEFAULT NULL,
`regularLegalRestDayOTNightDiff` INT(11) DEFAULT NULL,
`doubleWorkHour` INT(11) DEFAULT NULL,
`doubleNightDiff` INT(11) DEFAULT NULL,
`doubleOTHour` INT(11) DEFAULT NULL,
`doubleOTNightDiff` INT(11) DEFAULT NULL,
`doubleRestDayWorkHour` INT(11) DEFAULT NULL,
`doubleRestDayNightDiff` INT(11) DEFAULT NULL,
`doubleRestDayOTHour` INT(11) DEFAULT NULL,
`doubleRestDayOTNightDiff` INT(11) DEFAULT NULL,
`late` INT(11) DEFAULT NULL,
`absent` INT(11) DEFAULT NULL,
`absent_holiday` INT(11) DEFAULT 0,
`leave` INT(11) DEFAULT NULL,
`undertime` INT(11) DEFAULT NULL,
`nightDiff` INT(11) DEFAULT NULL,
`overtime` INT(11) DEFAULT NULL,
`nightDiffOvertime` INT(11) DEFAULT NULL,
`lwop` INT(11) DEFAULT NULL,
`holidayTagging` INT(11) DEFAULT NULL,
`workHours` INT(11) DEFAULT NULL,
`totalHours` INT(11) DEFAULT NULL,
`legalWithPay` INT(1) DEFAULT NULL,
`dateInactive` DATE DEFAULT NULL,
`finalPay` TINYINT(1) DEFAULT NULL,
`overbreak` VARCHAR(30) DEFAULT NULL,
`schedType` VARCHAR(30) DEFAULT NULL,
`jobCategoryCode` VARCHAR(30) DEFAULT NULL,
`unpaidhours` INT(11) DEFAULT NULL,
`contractNumber` BIGINT(20) DEFAULT NULL,
`site` VARCHAR(50) DEFAULT NULL,
`customerCode` VARCHAR(20) DEFAULT NULL,
`customerName` VARCHAR(100) DEFAULT NULL,
`flag` VARCHAR(1) DEFAULT NULL,
`otType` VARCHAR(20) DEFAULT NULL,
KEY `employeeCode_idx` (`employeeCode`),
KEY `employeeId` (`employeeId`),
KEY `day` (`day`),
KEY `payrollPeriod` (`payrollPeriod`),
KEY `posteddtr_idx` (`employeeId`,`day`,`payrollPeriod`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;



CREATE TABLE IF NOT EXISTS  approval2 (
recNo INT(10) AUTO_INCREMENT,
appNo INT(10),
document VARCHAR(20),
templateCode INT(10),
templateLineId INT(10),
id VARCHAR(30),
approver VARCHAR(30),
approverName VARCHAR(100),
decision VARCHAR(30),
remarks VARCHAR(100),
approvedDate DATETIME DEFAULT CURRENT_TIMESTAMP,
prevTemplateCode INT(10),
PRIMARY KEY (recNo,appNo, templateCode, templateLineId, id)
);


CREATE TABLE  IF NOT EXISTS `lmskey` (
`id` INT(100) NOT NULL AUTO_INCREMENT,
`activeKey` VARCHAR(20) NOT NULL,
`validUntil` DATE NOT NULL,
`systemDate` DATETIME DEFAULT CURRENT_TIMESTAMP(),
PRIMARY KEY (`id`,`validUntil`)
) ENGINE=INNODB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;


CREATE TABLE IF NOT EXISTS temp_approval_tbl (
`code`  VARCHAR(30),
lineId INT,
id VARCHAR(30),
stageCode VARCHAR(100)
); 



CREATE TABLE IF NOT EXISTS  otp_tbl (
id INT AUTO_INCREMENT,
email  VARCHAR(50),
OTP VARCHAR(30),
refno  VARCHAR(50),
isUsed INT NOT NULL DEFAULT 0,
dateCreated DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id, email,OTP)
);



CREATE TABLE IF NOT EXISTS tmp_tbl (
id INT AUTO_INCREMENT PRIMARY KEY,
txt_data TEXT
);

-- DROP TABLE IF EXISTS announcement_tbl;
CREATE TABLE IF NOT EXISTS  announcement_tbl (
id INT AUTO_INCREMENT,
style LONGTEXT,
content LONGTEXT,
pSubject VARCHAR(100),
recipients LONGTEXT,
postId VARCHAR(20),
datePosted DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id, postId)
);

ALTER TABLE announcement_tbl ADD  IF NOT EXISTS recipients LONGTEXT;


CREATE TABLE  IF NOT EXISTS announcement_identity (
id INT AUTO_INCREMENT,
aID INT,
postId VARCHAR(20),
identityId VARCHAR(20),
postDate DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
pStatus INT NOT NULL DEFAULT 0,
dateViewed DATETIME NULL,
PRIMARY KEY (id,aID, postId, identityId,pStatus)
);


CREATE TABLE IF NOT EXISTS license_rbp (
	lineId INT(5) NOT NULL AUTO_INCREMENT,
	`limit` VARCHAR(100),
	dt_created DATETIME DEFAULT CURRENT_TIMESTAMP(),
	processBy VARCHAR(30),
	db_name VARCHAR(50) NOT NULL,
	PRIMARY KEY (lineId, db_name)
) ENGINE=INNODB DEFAULT CHARSET=latin1;


/*
INSERT INTO `pf-common`.`license_rbp` (`limit`,dt_created,processBy,db_name)
VALUES ('ZE9sajJSM0VHR2I1eXk2WG1wdTBYQT09',DATE(NOW()),'ftsi','mdb_demo_v4');
SELECT * FROM `pf-common`.`license_rbp`;
*/


ALTER TABLE overtimeform ADD UNIQUE KEY IF NOT EXISTS daily_otID (otID, otAppNo, otDate, otStatus);
ALTER TABLE overtimeform ADD COLUMN IF NOT EXISTS `otType` VARCHAR(10) CHARACTER SET latin1;
ALTER TABLE scheduleshifts ADD COLUMN IF NOT EXISTS autoOt TINYINT(1);


DROP TABLE IF EXISTS `clearance_approvers`;
CREATE TABLE `clearance_approvers` (
`departmentCode` VARCHAR(25) DEFAULT NULL,
`approverId` VARCHAR(10) DEFAULT NULL,
`approverName` VARCHAR(100) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `clearanceform`; 
CREATE TABLE IF NOT EXISTS `clearanceform` (
`cfAppNo` INT(11) NOT NULL AUTO_INCREMENT,
`cfID` VARCHAR(20) DEFAULT NULL,
`cfDeptCode` VARCHAR(10) NOT NULL,
`cfRemarks` VARCHAR(100) DEFAULT NULL,
`cfStatus` VARCHAR(1) DEFAULT NULL,
`cfApprover` VARCHAR(20) DEFAULT NULL,
`cfApproverName` VARCHAR(75) DEFAULT NULL,
`cfClearanceItems` VARCHAR(200) DEFAULT NULL,
`cfApprovedDateTime` DATETIME DEFAULT NULL,
`cfDateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
`cfUserCreated` VARCHAR(20) DEFAULT NULL,
`cfDateModified` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(),
`cfLastUserModified` VARCHAR(20) DEFAULT NULL,
`cfNotifSent` TINYINT(4) DEFAULT 0,
`cfApproverTag` VARCHAR(20) DEFAULT NULL,
`cfAcknowledgeTag` TINYINT(1) DEFAULT NULL,
PRIMARY KEY (`cfAppNo`)
) ENGINE=INNODB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;


DROP TABLE IF EXISTS `clearance_signatories`;
CREATE TABLE IF NOT EXISTS  `clearance_signatories` (
`id` INT(10) NOT NULL,
`departmentCode` VARCHAR(50) DEFAULT NULL,
`signatoryId` VARCHAR(50) DEFAULT NULL,
`signatoryName` VARCHAR(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;



DROP TABLE IF EXISTS `clearance_itemlist`; 
CREATE TABLE IF NOT EXISTS `clearance_itemlist` (
`departmentCode` VARCHAR(20) DEFAULT NULL,
`itemName` VARCHAR(100) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


DROP TABLE IF EXISTS `clearance_informationheader`;
CREATE TABLE IF NOT EXISTS `clearance_informationheader` (
`itemName` VARCHAR(50) NOT NULL,
`itemNumber` INT(5) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;




DROP TABLE IF EXISTS v_portal_overtimeapplication;
DROP VIEW IF EXISTS v_portal_overtimeapplication;
DELIMITER $$ 
CREATE VIEW `v_portal_overtimeapplication` AS  
SELECT `overtimeform`.`otID` AS `otID`,`overtimeform`.`otDate` AS `otDate`,`overtimeform`.`otTimeFrom` AS `otTimeFrom`
	,`overtimeform`.`otTimeTo` AS `otTimeTo`,`overtimeform`.`otType` AS `otType`,IFNULL(`overtimeform`.`otBreak` * 60,0) AS `otBreak`
	,TIMESTAMP(`overtimeform`.`otDate`,STR_TO_DATE(`overtimeform`.`otTimeFrom`,'%H:%i %p')) AS `TimeFrom`
	,TIMESTAMP(IF(STR_TO_DATE(`overtimeform`.`otTimeFrom`,'%H:%i %p') >= STR_TO_DATE(`overtimeform`.`otTimeTo`,'%H:%i %p'),DATE_FORMAT(`overtimeform`.`otDate` + INTERVAL 1 DAY,'%Y-%m-%d'),`overtimeform`.`otDate`),STR_TO_DATE(`overtimeform`.`otTimeTo`,'%H:%i %p')) AS `TimeTo`
	,otTotHours AS otTotalHours
FROM `overtimeform` 
USE INDEX (`daily_otID`) 
WHERE `overtimeform`.`otStatus` = 'A' 

UNION ALL 

SELECT `es`.`employeeId` AS `employeeId`,`es`.`day` AS `day`,`sh`.`shiftFrom` AS `shiftFrom`,`sh`.`shiftTo` AS `shiftTo`
	,'AUTO' AS `otType`,0.00 AS `otBreak`,TIMESTAMP(`es`.`day`,`sh`.`shiftFrom`) AS `TimeFrom`
	,TIMESTAMP(IF(`sh`.`shiftFrom` > `sh`.`shiftTo`,DATE_FORMAT(`es`.`day` + INTERVAL 1 DAY,'%Y-%m-%d'),`es`.`day`),`sh`.`shiftTo`) AS `TimeTo` 
	,0 AS otTotHours
	FROM (
	((`employeedailyschedule` `es` 
	LEFT JOIN `schedules` `sc` ON(`es`.`schedule` = `sc`.`code`)) 
	LEFT JOIN `scheduleshifts` `ss` ON(`sc`.`code` = `ss`.`code`)) 
	LEFT JOIN `shifts` `sh` ON(`sh`.`shiftCode` = `ss`.`shiftCode`)
		) 
	WHERE `ss`.`autoOt` IS NOT NULL AND !(`es`.`day` IN (SELECT `v_holidaydetails`.`holidayDate` FROM `v_holidaydetails`))
	
	$$ 
DELIMITER ;


DROP TABLE IF EXISTS statusMaster; 
CREATE TABLE IF NOT EXISTS statusMaster AS(
SELECT '' AS val ,'' AS txt UNION ALL
SELECT 'A' AS val ,'Approved' AS txt UNION ALL
SELECT 'C' AS val ,'Cancelled Request' AS txt UNION ALL
SELECT 'D' AS val ,'Denied' AS txt UNION ALL
SELECT 'F' AS val ,'Pending' AS txt UNION ALL
SELECT 'P' AS val ,'For Approval' AS txt 
);


DROP TABLE IF EXISTS appLinkStatus;
CREATE TABLE IF NOT EXISTS  appLinkStatus AS( 
SELECT 'A' AS lStatus ,'H' AS link,'History' AS lDesc UNION ALL
SELECT 'C' AS lStatus ,'H' AS link,'History' AS lDesc UNION ALL
SELECT 'D' AS lStatus ,'H' AS link,'History' AS lDesc UNION ALL 
SELECT 'A' AS lStatus ,'A' AS link,'Approved' AS lDesc UNION ALL
SELECT 'C' AS lStatus ,'C' AS link,'Cancelled' AS lDesc UNION ALL
SELECT 'D' AS lStatus ,'D' AS link,'Denied' AS lDesc UNION ALL 
SELECT 'F' AS lStatus ,'F' AS link,'For Approval' AS lDesc UNION ALL
SELECT 'F' AS lStatus ,'P' AS link,'Pinding' AS lDesc UNION ALL
SELECT 'P' AS lStatus ,'P' AS link,'Pinding' AS lDesc  
);




DROP TABLE IF EXISTS documentMaster; 
CREATE TABLE IF NOT EXISTS  documentMaster AS(
SELECT 0 AS dID,'overtime' AS docVal,'Overtime' AS formVal UNION ALL
SELECT 1 AS dID,'leave' AS docVal,'Leave' AS formVal UNION ALL
SELECT 2 AS dID,'timeadjustment' AS docVal,'Time Adjustment' AS formVal UNION ALL
SELECT 3 AS dID,'officialbusiness' AS docVal,'Official Business' AS formVal UNION ALL
SELECT 4 AS dID,'offset' AS docVal,'Offset' AS formVal UNION ALL
SELECT 5 AS dID,'timeentry' AS docVal,'Time Entry' AS formVal  UNION ALL
SELECT 6 AS dID,'schedulechange' AS docVal,'Change Schedule' AS formVal  UNION ALL
SELECT 7 AS dID,'hrdcert' AS docVal,'HDR Certificate' AS formVal 
);

CREATE TABLE IF NOT EXISTS `email_logs` (
`id` BIGINT(20) NOT NULL AUTO_INCREMENT,
`email_from` VARCHAR(300) DEFAULT NULL,
`email_to` VARCHAR(300) DEFAULT NULL,
`subject` VARCHAR(100) DEFAULT NULL,
`content` TEXT DEFAULT NULL,
`email_protocol` VARCHAR(10) DEFAULT NULL,
`email_host` VARCHAR(50) DEFAULT NULL,
`mailer_response` TEXT DEFAULT NULL,
`errorMessage` VARCHAR(500) DEFAULT NULL,
`sysSuggestion` VARCHAR(300) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=MYISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


ALTER TABLE email_logs  ADD COLUMN IF NOT EXISTS errorMessage VARCHAR(500);  
ALTER TABLE email_logs MODIFY COLUMN email_from  VARCHAR(300); 
ALTER TABLE email_logs MODIFY COLUMN email_to  VARCHAR(300); 
ALTER TABLE email_logs  ADD COLUMN IF NOT EXISTS sysSuggestion VARCHAR(300);   
ALTER TABLE email_logs MODIFY COLUMN sysSuggestion VARCHAR(300); 
ALTER TABLE email_logs  ADD COLUMN IF NOT EXISTS sysSuggestion VARCHAR(300); 

ALTER TABLE hrdcertificate  MODIFY COLUMN appNo INT NOT NULL AUTO_INCREMENT,ADD PRIMARY KEY IF NOT EXISTS (appNo);



CREATE TABLE IF NOT EXISTS  user_dashboard_settings(
id INT AUTO_INCREMENT, 
identityId VARCHAR(30),
headerName VARCHAR(50),
titleName VARCHAR(50),
lineId INT,
orderNo INT NOT NULL DEFAULT 1,
visibility INT NOT NULL DEFAULT 1,
PRIMARY KEY (id,identityId)
);

DROP TABLE IF EXISTS timeMaster;
CREATE TABLE IF NOT EXISTS  timeMaster AS( 
	WITH RECURSIVE time_slots AS (
	SELECT CAST('00:00:00' AS TIME) AS time_slot
	UNION ALL
	SELECT ADDTIME(time_slot, '00:01:00')
	FROM time_slots
	WHERE time_slot < '23:59:00'
	)
	SELECT TIME_FORMAT(time_slot, '%H:%i') AS time_slot
	FROM time_slots
); -- SELECT * FROM timeMaster;

DROP TABLE IF EXISTS app_default_mailer;
CREATE TABLE IF NOT EXISTS  app_default_mailer AS(
	SELECT 'smtp' AS protocol 
		,'smtp.gmail.com' AS smtp_host
		,587 AS smtp_port
		,'ft.payfactor@gmail.com' AS smtp_user
		,'dmJib2Qvb1Y5SmtQNHREbERBa3ljSWhHbU1SY1VLK0dCNEdUMUV0K0lEcz0=' AS smtp_pass
		,'tls' AS authType 
);



CREATE TABLE IF NOT EXISTS  `ytd_details` (
`ytdCode` VARCHAR(50) CHARACTER SET latin1 NOT NULL,
`employeeCode` BIGINT(20) NOT NULL,
`identityId` VARCHAR(20) NOT NULL,
`lastname` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL,
`firstname` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL,
`middlename` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL,
`suffixname` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL,
`empStatus` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`MWE` TINYINT(4) DEFAULT NULL,
`yeartax` YEAR(4) DEFAULT NULL,
`costCenter` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`department` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`jobCategory` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`positionCode` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`datehired` DATE DEFAULT NULL,
`dateResigned` DATE DEFAULT NULL,
`monthyRate` DECIMAL(19,2) DEFAULT NULL,
`dailyRate` DECIMAL(19,2) DEFAULT NULL,
`payrollPeriod` VARCHAR(20) CHARACTER SET latin1 NOT NULL,
`payrollPeriodPayDate` DATE DEFAULT NULL,
`payrollPeriodMonth` VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL,
`payrollPeriodTerm` VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL,
`payrollPeriodYear` YEAR(4) DEFAULT NULL,
`payrollPeriodFrom` DATE DEFAULT NULL,
`payrollPeriodTo` DATE DEFAULT NULL,
`payslipBatchCode` VARCHAR(50) CHARACTER SET latin1 DEFAULT NULL,
`basicPay` DECIMAL(19,2) DEFAULT NULL,
`netBasicPay` DECIMAL(19,2) DEFAULT NULL,
`grossPay` DECIMAL(19,2) DEFAULT NULL,
`witholdingTax` DECIMAL(19,2) DEFAULT NULL,
`sss` DECIMAL(19,2) DEFAULT NULL,
`sssEE` DECIMAL(19,2) DEFAULT NULL,
`sssER` DECIMAL(19,2) DEFAULT NULL,
`sssEC` DECIMAL(19,2) DEFAULT NULL,
`sssEE_MPF` DECIMAL(19,2) DEFAULT NULL,
`sssER_MPF` DECIMAL(19,2) DEFAULT NULL,
`hdmfEE` DECIMAL(19,2) DEFAULT NULL,
`hdmfER` DECIMAL(19,2) DEFAULT NULL,
`phicEE` DECIMAL(19,2) DEFAULT NULL,
`phicER` DECIMAL(19,2) DEFAULT NULL,
`phic` DECIMAL(19,2) DEFAULT NULL,
`hdmf` DECIMAL(19,2) DEFAULT NULL,
`deductions` DECIMAL(19,2) DEFAULT NULL,
`netPay` DECIMAL(19,2) DEFAULT NULL,
`payrollType` VARCHAR(20) CHARACTER SET latin1 DEFAULT NULL,
`batchId` VARCHAR(30) CHARACTER SET latin1 DEFAULT NULL,
`source` VARCHAR(50) DEFAULT NULL,
`ytdBasicPay` DECIMAL(19,2) DEFAULT NULL,
`ytdNetBasicPay` DECIMAL(19,2) DEFAULT NULL,
`ytdGrossPay` DECIMAL(19,2) DEFAULT NULL,
`ytdWitholdingTax` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_EE` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_ER` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_EC` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_EE_MPF` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_ER_MPF` DECIMAL(19,2) DEFAULT NULL,
`ytdHDMF_EE` DECIMAL(19,2) DEFAULT NULL,
`ytdHDMF_ER` DECIMAL(19,2) DEFAULT NULL,
`ytdPHIC_EE` DECIMAL(19,2) DEFAULT NULL,
`ytdPHIC_ER` DECIMAL(19,2) DEFAULT NULL,
`ytdSSS_MPF` DECIMAL(19,2) DEFAULT NULL,
`ytdPHIC` DECIMAL(19,2) DEFAULT NULL,
`ytdHDMF` DECIMAL(19,2) DEFAULT NULL,
`ytdDeductions` DECIMAL(19,2) DEFAULT NULL,
`ytdNetPay` DECIMAL(19,2) DEFAULT NULL,
PRIMARY KEY (`ytdCode`,`identityId`,`payrollPeriod`)
) ENGINE=INNODB DEFAULT CHARSET=utf8;




DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_clearance_get_form_list`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clearance_get_form_list`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	SELECT
		d.departmentName AS departmentName,
		c.cfApproverName,
		c.cfStatus,
		c.cfApprovedDateTime,
		c.cfRemarks,
		c.cfClearanceItems
	FROM `clearanceform` c
	LEFT JOIN `department` d ON c.cfDeptCode = d.departmentCode
	WHERE c.cfID = username;
	
END IF;

IF pint_mode = 2 THEN
	SELECT DISTINCT cfAcknowledgeTag 
	FROM `clearanceform` 
	WHERE cfID = username;
END IF;

IF pint_mode = 3 THEN
	
	SELECT COUNT(*) AS `count`
	FROM clearanceform c
	LEFT JOIN department d ON c.cfDeptCode = d.departmentCode WHERE c.cfID = username;
	
END IF;
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_hr`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_hr`(  
IN pint_mode INT,	

OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
		CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', 
		clearanceform.cfID, 
		MAX(clearanceform.cfApprover) AS 'cfApprover', 
		MAX(clearanceform.cfApproverName) AS 'cfApproverName', 
		MAX(clearanceform.cfApprovedDateTime) AS 'cfApprovedDateTime', 
		MAX(clearanceform.cfDateCreated) AS 'cfDateCreated', 
		MAX(clearanceform.cfDateModified) AS 'cfDateModified', 
		MAX(clearanceform.cfRemarks) AS 'cfRemarks', 
		MAX(clearanceform.cfStatus) AS 'cfStatus', 
		MAX(clearanceform.cfAppNo) AS 'cfAppNo'
		FROM 
		clearanceform 
		LEFT JOIN 
		identity 
		ON 
		clearanceform.cfId = identity.identityId
		WHERE clearanceform.cfApprovedDateTime IS NOT NULL
		GROUP BY 
		clearanceform.cfID;

	
END IF;

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approvalHistory`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approvalHistory`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
	DISTINCT CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', clearanceform.cfID, 
	clearanceform.`cfApprover`, clearanceform.`cfApproverName`, clearanceform.`cfApprovedDateTime`, clearanceform.`cfDateCreated`, clearanceform.`cfDateModified`, clearanceform.`cfRemarks`, clearanceform.`cfStatus`, clearanceform.`cfAppNo`
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.cfId = identity.identityId
	WHERE `clearanceform`.`cfApprover` = username
	AND clearanceform.`cfApprovedDateTime` IS NOT NULL;

	
END IF;

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_insert_clearance_status`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_clearance_status`(  
IN pint_mode INT,	
IN _appno VARCHAR(10),
IN _identityId VARCHAR(50),
IN _cfid VARCHAR(50),
IN _cfStatus VARCHAR(5),
IN _cfRemarks VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	UPDATE clearanceform
	SET
		cfRemarks = _cfRemarks,
		cfStatus = _cfStatus,
		cfApprovedDateTime = CURRENT_TIMESTAMP
	WHERE
		cfID = _cfid
	AND
		cfAppNo = _appno
	AND cfApprover = _identityId;
			
END IF;

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approval_details`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approval_details`(  
IN pint_mode INT,	
IN _appno VARCHAR(10),
IN _cfid VARCHAR(10), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT `clearanceform`.*, CONCAT(identity.`firstName`, ' ', identity.`middleName`, ' ', identity.`lastName`) AS 'Name', department.`departmentName`, `cfApprover`, `cfAppNo` = '".$cfAppNo."' AS 'cfAppNo'
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.`cfID` = `identity`.`identityId`
	LEFT JOIN `department`
	ON `department`.`departmentCode` = `clearanceform`.`cfDeptCode`
	WHERE  `clearanceform`.`cfID` = _cfid
	AND `clearanceform`.`cfAppNo` = _appno;
	
END IF;

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approval`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approval`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
	DISTINCT CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', clearanceform.cfID, 
	clearanceform.`cfApprover`, clearanceform.`cfApproverName`, clearanceform.`cfApprovedDateTime`, clearanceform.`cfDateCreated`, clearanceform.`cfDateModified`, clearanceform.`cfRemarks`, clearanceform.`cfStatus`, clearanceform.`cfAppNo`
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.cfId = identity.identityId
	WHERE `clearanceform`.`cfApprover` = username
	AND `clearanceform`.`cfApprovedDateTime` IS NULL;
	
END IF;

END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS  `sp_insert_clearance_form`;
DELIMITER $$ 
CREATE PROCEDURE IF NOT EXISTS `sp_insert_clearance_form`(
IN _employeeId VARCHAR(10), 
IN _username VARCHAR(20)
)
BEGIN		
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	GET DIAGNOSTICS CONDITION 1 
	@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT, @errno = MYSQL_ERRNO;	
	SELECT IFNULL(@errno,0) AS `code`, CONCAT(@p1,'-',@p2) AS message;		
	ROLLBACK;	
END;	

-- COLLECT DATA	
-- Set @username = _username;
SET @batchId = (SELECT batchId FROM identity WHERE identityId = _employeeId);
SET @finalApprover = (SELECT identityid FROM users WHERE userid = @approverHRIS);	
SET @departmentCode = (
	SELECT em.departmentCode FROM employeemovement em
	LEFT JOIN identity idy ON idy.code = em.code
	WHERE idy.identityId = _employeeId
	ORDER BY em.dateEnd DESC LIMIT 1	
);

SET @approverHRIS = (SELECT approverHRIS FROM payrollgroup WHERE payrollGroupCode = @batchId);
	
START TRANSACTION;
-- HOUSE KEEPING
DELETE FROM clearanceform WHERE cfID = @employeeId AND cfStatus IS NULL;


INSERT INTO clearanceform (
	cfID,
	cfDeptCode,
	cfApprover,
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)
SELECT
	_employeeId,
	ca.departmentCode,
	IFNULL(ca.approverId, 'NOT-FOUND'),
	IFNULL(ca.approverName, 'NOT-FOUND'),
	'Turnover List',
	@username,
	'IM'
FROM department d
LEFT JOIN clearance_approvers ca 
	ON ca.departmentCode = d.departmentCode
WHERE d.departmentCode = @departmentCode
AND d.departmentCode NOT IN (
	SELECT cfDeptCode 
	FROM clearanceform 
	WHERE cfID = @employeeId 
	AND cfStatus IS NOT NULL
);






-- INSERT DEPARTMENTS CLEARANCE DATA
INSERT INTO clearanceform (
	cfID,    
	cfDeptCode,  
	cfApprover, 
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)
SELECT 
	_employeeId,
	d.departmentCode,
	IFNULL(ca.approverId,'NOT-FOUND') AS approverId,
	IFNULL(ca.approverName,'NOT-FOUND') AS approverName,
	IFNULL(ci.ItemName,'NO-DATA-AVAILABLE') AS ItemName,
	@username,
	'DH'
FROM department d
LEFT JOIN clearance_approvers ca 
	ON ca.departmentCode = d.departmentCode
LEFT JOIN clearance_itemlist ci
	ON ci.departmentCode = d.departmentCode
WHERE d.departmentCode NOT IN (
		SELECT cfDeptCode 
		FROM clearanceform 
		WHERE cfID = @employeeId 
		AND cfStatus IS NOT NULL
)
AND d.departmentCode <> @departmentCode;

-- INSERT FINAL APPROVER CLEARANCE DATA

INSERT INTO clearanceform (
	cfID,    
	cfDeptCode,  
	cfApprover, 
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)		
SELECT 
	_employeeId,
	em.departmentCode,
	usr.`identityId` AS approverId, 
	CONCAT(idy.`firstName`,' ',idy.`lastName`) AS approverName,
	'Endorsement for final pay computation',
	@username,
	'FA'
FROM `users` usr
LEFT JOIN identity idy ON idy.`identityId` = usr.`identityid`
LEFT JOIN employeemovement em ON em.`code` = idy.`code`
LEFT JOIN vw_rpt_max_employeemovement vw ON vw.Code = em.code AND vw.LineId = em.lineId
WHERE usr.`userid` = @approverHRIS;	

SELECT 0 AS `code`  , 'Employee clearance form created successfully.' AS message;
COMMIT;
END $$
DELIMITER ; 


-- ATD

DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_add_employee_deduction`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_add_employee_deduction`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
IN app_no VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	INSERT INTO employeedeductions (
			`code`,
			`lineId`,
			`deductionType`,
			`terms`,
			`amount`,
			`balance`,
			`dateEffective`,
			`dateEnd`,
			`referenceNumber`,
			`recurring`,
			`loanAmount`,
			`remarks`,
			`hierarchy`
		)
		SELECT
			i.code,
			COALESCE(MAX(e.lineId) + 1, 1) AS lineId,
			p.deductionCode,
			p.terms,
			p.amountDeductedPerPayroll,
			p.totalAmount,
			p.effectiveDate,
			p.lastDateofDeduction,
			p.formNo,
			'N',
			p.totalAmount,
			'Acknowledge ATD',
			r.hierarchy
		FROM
			authoritytodeductform p
			LEFT JOIN identity i ON i.identityId = p.identityId
			LEFT JOIN employeedeductions e ON e.code = i.code
			LEFT JOIN recurringdeduction r ON r.deductionCode = p.deductionCode
		WHERE
			p.appNo = app_no AND p.identityId = identity_id;
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_acknowledge`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_acknowledge`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
IN form_no VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	UPDATE authoritytodeductform SET isAcknowledge ='1', last_user_updated = identity_id WHERE formNo = form_no AND identityId = identity_id;
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_decline`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_decline`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
IN form_no VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	UPDATE authoritytodeductform SET isAcknowledge = '0', last_user_updated = identity_id WHERE formNo = form_no AND identityId = identity_id;
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_get_details`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_get_details`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
IN form_id VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
		p.appNo,
		p.identityId,
		p.formNo,
		p.versionNo,
		p.purpose,
		p.effectiveDate,
		p.totalAmount,
		p.amountDeductedPerMonth,
		p.amountDeductedPerPayroll,
		p.lastDateofDeduction,
		p.terms,
		p.agreement,
		p.signatory1,
		p.signatory2,
		p.isAcknowledge,
		p.dateCreated,
		p.dateModified,
		i.code,
		i.dateHired,
		i.`firstName`,
		i.`middleName`,
		i.`lastName`,
		de.departmentName,
		po.`positionName`,
		p.`contractType`
		FROM 
		authoritytodeductform p 
		
		LEFT JOIN 
		identity i 
		
		ON p.identityId = i.`identityId`
		
		LEFT JOIN
		
		(SELECT `code`, 
			MAX(CASE WHEN dateEffective <= CURDATE() AND (dateEnd IS NULL OR dateEnd >= CURDATE()) THEN departmentCode END) AS department,
			MAX(CASE WHEN dateEffective <= CURDATE() AND (dateEnd IS NULL OR dateEnd >= CURDATE()) THEN `positionCode` END) AS positionCode
		FROM employeemovement
		GROUP BY `code`
		) em ON i.code = em.code 
		
		LEFT JOIN
		`department` de ON de.`departmentCode` = em.department
		
		LEFT JOIN 
		`position` po ON po.`positionCode` = em.positionCode

		WHERE p.identityId = identity_id AND p.formNo = form_id;

END IF;

IF pint_mode = 2 THEN
	SELECT companyName FROM companysetting;

END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_get_list`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_get_list`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	SELECT * FROM authoritytodeductform WHERE identityId = identity_id AND dateModified IS NULL AND isAcknowledge IS NULL;
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_authority_to_deduct_get_list_history`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_authority_to_deduct_get_list_history`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	SELECT * FROM authoritytodeductform  WHERE identityId = identity_id AND dateModified IS NOT NULL AND isAcknowledge IS NOT NULL;
END IF;

END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_check_exists_app_valid_for_edit; 
DELIMITER $$  
CREATE PROCEDURE sp_check_exists_app_valid_for_edit
( 
IN pint_mode INT,	 
IN rAppNo INT,   
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg = 'Success';
-- SELECT * FROM documentmaster

SET @globalMsg = 'Sorry, you cant update details this times.';

IF NOT EXISTS (SELECT * FROM documentMaster) THEN
		SET num = 1;
		SET msg ='Application denied, [Document Master] table is empty. please contact administrator!';
		LEAVE proc_start; 
END IF; 


IF NOT EXISTS (SELECT * FROM appLinkStatus) THEN
		SET num = 1;
		SET msg ='Application denied, [appLinkStatus] table is empty. please contact administrator!';
		LEAVE proc_start; 
END IF; 

IF (pint_mode=0) THEN -- overtime
	
	IF EXISTS (SELECT * FROM overtimeform WHERE  otAppNo=rAppNo AND otStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=1) THEN -- leave
	
	IF EXISTS (SELECT * FROM leaveapplicationform WHERE  laAppNo=rAppNo AND laStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;

	IF (pint_mode=2) THEN -- timeadjustment
	
	IF EXISTS (SELECT * FROM timeadjustmentform WHERE  taAppNo=rAppNo AND taStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=3) THEN -- officialbusiness
	
	IF EXISTS (SELECT * FROM officialbusinessform WHERE  obAppNo=rAppNo AND obStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=4) THEN -- offset
	
	IF EXISTS (SELECT * FROM offsetform WHERE  osAppNo=rAppNo AND osStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=5) THEN -- timeentry
	
	IF EXISTS (SELECT * FROM timeentryform WHERE  teAppNo=rAppNo AND teStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=6) THEN -- schedulechange
	
	IF EXISTS (SELECT * FROM schedulechange WHERE  scAppNo=rAppNo AND scStatus<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;
	
	IF (pint_mode=7) THEN -- hrdcert
	
	IF EXISTS (SELECT * FROM hrdcertificate WHERE  appNo=rAppNo AND `status`<>'P') THEN
		SET num = 1;
		SET msg =@globalMsg;
		LEAVE proc_start; 
	END IF;
	
	END IF;

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_loan_overview; 
DELIMITER $$  
CREATE PROCEDURE sp_loan_overview
( 
IN pint_mode INT,	 
IN rIdentityId VARCHAR(30), 
IN df VARCHAR(30),  
IN dt VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg = 'Success';

SET @code = (SELECT `code` FROM identity WHERE identityId=rIdentityId);
SET df = (CASE WHEN df='' THEN NULL ELSE df END);
SET dt = (CASE WHEN dt='' THEN NULL ELSE dt END);
		
SELECT 
	ed.code
	,ed.deductionType
	,rd.deductionName
	,IFNULL(ed.loanDate,'') AS loanDate
	,IFNULL(ed.loanAmount,0) AS loanAmount
	,IFNULL(ed.interest,0) AS `interest`
	,ed.amount
	,IFNULL(ed.balance,0) AS `balance`
	,ed.dateEffective
	,IFNULL(ed.dateEnd,'')AS dateEnd
FROM employeedeductions ed
LEFT JOIN recurringdeduction rd ON rd.deductionCode = ed.deductionType
WHERE rd.tagging = 'Loan'
	AND ed.`code` = @code
	AND ed.dateEffective BETWEEN IFNULL(df,ed.dateEffective)  AND IFNULL(dt,ed.dateEffective)   
ORDER BY ed.loanDate;

END $$ 
DELIMITER ;


-- CALL sp_kiosk_costumization (1,'mdb4',@num,@msg); SELECT @msg; 
DELIMITER $$  
CREATE PROCEDURE IF NOT EXISTS sp_kiosk_costumization
( 
IN pint_mode INT,	 
IN dbName VARCHAR(50),  
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg = 'Success';


-- Email Notification		
SELECT 'email' AS _name,
	'notification' AS custType,
	JSON_OBJECT(
			'Overtime',(SELECT IFNULL(emailOT,0) FROM companySetting),
			'Time Adjustment',(SELECT IFNULL(emailTA,0) FROM companySetting),
			'Time Entry',(SELECT IFNULL(emailTE,0) FROM companySetting),
			'Leave',(SELECT IFNULL(emailLV,0) FROM companySetting),
			'Official Business',(SELECT IFNULL(emailOB,0) FROM companySetting),
			'Offset',(SELECT IFNULL(emailOS,0) FROM companySetting),
			'HRD Certificate',(SELECT IFNULL(emailHRD,0) FROM companySetting),
			'Change of Schedule',(SELECT IFNULL(emailSched,0) FROM companySetting) 
		) AS val 
-- Add DTR Online
UNION ALL
SELECT 'dtr' AS _name,
	'visibility' AS custType,
	(SELECT IFNULL(enableOnlineDtr,0) FROM companySetting) AS val
	
;


END $$ 
DELIMITER ;





DROP PROCEDURE IF EXISTS sp_portal_update_user_password;  	
DELIMITER $$  
CREATE PROCEDURE sp_portal_update_user_password(
IN pint_mode INT,
IN p_identityId VARCHAR(20),
IN userPassword VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';
IF (pint_mode=0) THEN -- leave

	UPDATE users
	SET 
		`password` = userPassword,
		`pw_last_date_changed` = NOW(),
		`attempts` = 0,
		`passwords_used` = userPassword
	WHERE 
		`identityid` = p_identityId;
		
END IF;

IF (pint_mode=1) THEN -- insert password_use

	UPDATE users
	SET 
		`pw_last_date_changed` = NOW(),
		`passwords_used` = userPassword
	WHERE 
		`identityid` = p_identityId;
			
END IF;

END$$
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_new_password_validation`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_new_password_validation`(
IN  pint_mode INT,  	
IN  r_identity VARCHAR(50),  
IN  orgPass VARCHAR(100), 
IN  nPass VARCHAR(100), 
IN  cPass VARCHAR(100), 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
	SET msg ='Congratiolations!. Your password has been succefully updated';



IF (SELECT IFNULL(passwordComplexEnabled,0) FROM companysetting)=1 THEN

		IF (SELECT PasswordComplexity(orgPass))=0 THEN
		
			SET @passLenth = (SELECT IFNULL(passwordLength,8) FROM companysetting);
			
			SET num = 1;
			SET msg = CONCAT('Invalid password ''',orgPass,'''. Password must contain at least [one lower & upper case],[one number],[one characters] and should be atleast ',@passLenth,' characters');  
			LEAVE proc_start;
			
		END IF;

END IF;


IF (nPass<>cPass) THEN 							 
	SET num = 1;
	SET msg = 'Password does not matched'; 
	LEAVE proc_start;
END IF;  



CALL sp_portal_update_user_password(0,r_identity,nPass,@num,@msg);
CALL sp_portal_insert_user_password_logs(0,r_identity,nPass,@num,@msg);

IF (pint_mode=1) THEN

	UPDATE users SET pStatus='E' WHERE username=r_identity;
END IF;

END$$ 
DELIMITER ;


DELIMITER $$  
-- CALL sp_portal_forgot_password_validation(2,'onnix2559@gmail.com','','','','',@num,@msg); SELECT @msg
DROP PROCEDURE IF EXISTS `sp_portal_forgot_password_validation`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_forgot_password_validation`(
IN  pint_mode INT,  	
IN  r_email VARCHAR(50),
IN  r_OTP VARCHAR(30),
IN  pass1 VARCHAR(100),
IN  pass2 VARCHAR(100),
IN userPassword VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg ='Success'; 

/*VALIDATE EMAIL*/
IF (pint_mode=2) THEN  

	IF (r_email='') THEN -- IF BLANK
		SET num = 1;
		SET msg = 'Please enter your email address'; 
		LEAVE proc_start;
	END IF; 
	
	IF (SELECT r_email REGEXP '^[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,}$')=0 THEN  -- IF EMAIL NOT VALID
		SET num = 1;
		SET msg = CONCAT('You entered [',r_email,']',' wich is invalid email address ');  
		LEAVE proc_start;
	END IF; 
	
	SELECT COUNT(1)FROM identity WHERE emailAddress=r_email  INTO @userCount;
	
	IF (@userCount)<=0 THEN   -- IF EMAIL IS NOT EXISTS
		SET num = 1;
		SET msg = CONCAT(r_email,' is not found in our record!');  
		LEAVE proc_start;
	END IF; 
	
	IF (@userCount)>1 THEN   -- TO MANNY USERS FOR THIS EMAIL
		SET num = 1;
		SET msg = CONCAT('Sorry, ',r_email,' has been used by multiple users. please contact admin!');  
		LEAVE proc_start;
	END IF; 
	
	IF (@userCount)=1 THEN   -- IF USER IS INACTIVE
	SET @identityId = (SELECT identityId FROM identity WHERE emailAddress=r_email);
	IF (SELECT COUNT(1) FROM users WHERE username=@identityId AND pStatus IN ('T') )>=1 THEN
		SET num = 1;
		SET msg = CONCAT('Sorry, ',r_email,' is already INACTIVE in the system!');  
		LEAVE proc_start;
	END IF;
	END IF; 
	
	
	
	SET msg =(SELECT CONCAT(firstName,' ',middleName,' ',lastName) FROM identity WHERE emailAddress=r_email);
END IF; 


/* VALIDATE OTP */
IF (pint_mode=3) THEN  

	IF (r_OTP='') THEN  
								
		SET num = 1;
		SET msg = 'Please enter OTP from your email';  
		LEAVE proc_start;
	END IF;  
	
	IF NOT EXISTS (SELECT 1 FROM otp_tbl WHERE email=r_email AND OTP=r_OTP) THEN
	SET num = 1;
		SET msg = CONCAT('Invalid OTP [',r_OTP,'].',' if you have multi OTP in your email, Reference number can help you to choose the correct one');  
		LEAVE proc_start;
	END IF;  
	
	
	UPDATE  otp_tbl SET isUsed=1 WHERE email=r_email AND OTP=r_OTP;
	
END IF;


/* VALIDATE PASS 1 */
IF (pint_mode=4) THEN  

	IF (pass1='') THEN  
								
		SET num = 1;
		SET msg = 'Please enter new password';  
		LEAVE proc_start;
	END IF;   
	
	SET @PassLimitCount=(SELECT IFNULL(passwordReuseRestriction,8) FROM companySetting);
	SET @indentityId = (SELECT identityId FROM identity WHERE emailAddress=r_email);  
	SET @PassCount = (SELECT COUNT(id) FROM user_password_logs WHERE username=@indentityId AND PASSWORD=userPassword);
	IF (@PassLimitCount<=@PassCount) THEN 
		SET num = 1;
		SET msg = CONCAT('Sorry, you already used this password ',@PassCount,' times. please try another one!');  
		LEAVE proc_start; 
	END IF;
	
	IF (SELECT IFNULL(passwordComplexEnabled,0) FROM companysetting)=1 THEN
	
		
		
		
		IF (SELECT PasswordComplexity(pass1))=0 THEN
		
			SET @passLenth = (SELECT IFNULL(passwordLength,8) FROM companysetting);
			
			SET num = 1;
			SET msg = CONCAT('Invalid password ''',pass1,'''. Password must contain at least [one lower & upper case],[one number],[one characters] and should be atleast ',@passLenth,' characters');  
			LEAVE proc_start;
			
		END IF;
	END IF; 
	
	SET msg = (SELECT identityId FROM identity WHERE emailAddress=r_email);
	
END IF;


/* VALIDATE PASS 2 */
IF (pint_mode=5) THEN  

	IF (pass2='') THEN  
								
		SET num = 1;
		SET msg = 'Please Re-Enter new password for confirmation';  
		LEAVE proc_start;
	END IF;   
	
	IF (SELECT SHA2(pass1, 256)=SHA2(pass2, 256))=0 THEN 
		SET num = 1;
		SET msg = 'Password does not matched';  
		LEAVE proc_start;
	END IF;   
	
	SET @indentityId = (SELECT identityId FROM identity WHERE emailAddress=r_email);
	
	
		CALL sp_portal_update_user_password(0,@indentityId,userPassword,@num,@msg);
		CALL sp_portal_insert_user_password_logs(0,@indentityId,userPassword,@num,@msg);
		
		
END IF;


END$$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_portal_url_maping;
DELIMITER $$  
CREATE PROCEDURE sp_portal_url_maping
(  
IN pint_mode INT, 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

/*
	1 - Report URL
*/

IF (pint_mode=1) THEN
	
	SELECT "http://mdb4.payfactor.ft:86/ReportViewer.aspx?id=" AS url;
END IF;

END $$ 
DELIMITER ;


ALTER TABLE approvaltemplates ADD COLUMN IF NOT EXISTS `percentageallocation` TINYINT(1) DEFAULT NULL;
ALTER TABLE payrollperioddetails ADD COLUMN IF NOT EXISTS `payrollPeriodScheduleTaggingLocked` TINYINT(1) DEFAULT NULL;

-- CALL sp_user_dashboard_settings(0,'12027','[]',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_user_dashboard_settings;
DELIMITER $$  
CREATE PROCEDURE sp_user_dashboard_settings
(  
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


-- SELECT * FROM user_dashboard_settings WHERE identityId='12027'
-- -TRUNCATE TABLE user_dashboard_settings

IF (pint_mode=0) THEN

	IF NOT EXISTS (SELECT *
			FROM user_dashboard_settings
			WHERE identityId = r_identityId
			) THEN
			
			INSERT INTO user_dashboard_settings (identityId,titleName,headerName,lineId,orderNo) 
			SELECT r_identityId,'annonucement','',1,1 UNION ALL
			SELECT r_identityId,'calendar','',1,2 UNION ALL

			SELECT r_identityId,'Overtime','ForApproval',1,3 UNION ALL
			SELECT r_identityId,'Leave','ForApproval',2,3 UNION ALL
			SELECT r_identityId,'Offset','ForApproval',3,3 UNION ALL
			SELECT r_identityId,'TimeAdjustment','ForApproval',4,3 UNION ALL
			SELECT r_identityId,'OfficialBusiness','ForApproval',5,3 UNION ALL
			SELECT r_identityId,'TimeEntry','ForApproval',6,3 UNION ALL
			SELECT r_identityId,'ScheduleChange','ForApproval',7,3 UNION ALL
			SELECT r_identityId,'HRDCertificate','ForApproval',8,3 UNION ALL

			SELECT r_identityId,'Overtime','Application',1,4 UNION ALL
			SELECT r_identityId,'Leave','Application',2,4 UNION ALL
			SELECT r_identityId,'Offset','Application',3,4 UNION ALL
			SELECT r_identityId,'TimeAdjustment','Application',4,4 UNION ALL
			SELECT r_identityId,'OfficialBusiness','Application',5,4 UNION ALL
			SELECT r_identityId,'TimeEntry','Application',6,4 UNION ALL
			SELECT r_identityId,'ScheduleChange','Application',7,4 UNION ALL 
			SELECT r_identityId,'HRDCertificate','Application',8,4 UNION ALL 


			SELECT r_identityId,'Overtime','ApplicationMonitoringperCut-Off',1,5 UNION ALL
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
							WHEN headerName='Application' AND titleName='Overtime' THEN (SELECT (CASE WHEN `overtime`=0 THEN 2 ELSE (CASE WHEN visibility=1 THEN `overtime` ELSE visibility END) END)  FROM accessRigths)
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

			SELECT r_identityId,'Overtime','ForApproval',1,3 UNION ALL
			SELECT r_identityId,'Leave','ForApproval',2,3 UNION ALL
			SELECT r_identityId,'Offset','ForApproval',3,3 UNION ALL
			SELECT r_identityId,'TimeAdjustment','ForApproval',4,3 UNION ALL
			SELECT r_identityId,'OfficialBusiness','ForApproval',5,3 UNION ALL
			SELECT r_identityId,'TimeEntry','ForApproval',6,3 UNION ALL
			SELECT r_identityId,'ScheduleChange','ForApproval',7,3 UNION ALL
			SELECT r_identityId,'HRDCertificate','ForApproval',8,3 UNION ALL

			SELECT r_identityId,'Overtime','Application',1,4 UNION ALL
			SELECT r_identityId,'Leave','Application',2,4 UNION ALL
			SELECT r_identityId,'Offset','Application',3,4 UNION ALL
			SELECT r_identityId,'TimeAdjustment','Application',4,4 UNION ALL
			SELECT r_identityId,'OfficialBusiness','Application',5,4 UNION ALL
			SELECT r_identityId,'TimeEntry','Application',6,4 UNION ALL
			SELECT r_identityId,'ScheduleChange','Application',7,4 UNION ALL 
			SELECT r_identityId,'HRDCertificate','Application',8,4 UNION ALL 


			SELECT r_identityId,'Overtime','ApplicationMonitoringperCut-Off',1,5 UNION ALL
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

END $$ 
DELIMITER ;


-- CALL sp_load_calendar_sched_advanced(0,'2703230912','','',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_load_calendar_sched_advanced; 
DELIMITER $$   
CREATE PROCEDURE sp_load_calendar_sched_advanced(
IN pint_mode INT,  
IN rID VARCHAR(30), 
IN df VARCHAR(30),
IN dt VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  

SET num = 0;
SET msg = 'Success';



SET @rID = (SELECT rID);
	
	DROP TEMPORARY TABLE IF EXISTS temp_v_employeedailyschedule_cal;
	CREATE TEMPORARY TABLE temp_v_employeedailyschedule_cal AS(
		SELECT * FROM v_employeedailyschedule_cal WHERE employeeId=@rID
	);
	


SET df=(SELECT YEAR(df))-3;
SET dt=(SELECT YEAR(dt));

-- SELECT df,dt;

-- OVERTIME
SELECT DISTINCT otStatus AS appStatus, otDate AS appDateFrom, otAppNo AS appNo, otID AS appID,'overtime' AS appDoc,'#EF5016' AS appColor,0 AS switch
FROM overtimeform t1
LEFT JOIN approval t2 ON t1.otAppNo=t2.appNo AND t2.document='overtime'
WHERE otID =rID
	-- AND YEAR(otDate) BETWEEN df AND dt
	AND t2.document IS NOT NULL
	
	UNION ALL
	
	-- LEAVE
SELECT DISTINCT laStatus AS appStatus, laLstDate AS appDateFrom, laAppNo AS appNo, laID AS appID,'leave' AS appDoc,'#5D9023' AS appColor,1 AS switch
FROM leaveapplicationlist t1
LEFT JOIN leaveapplicationform t2 ON t1.laLstAppNo=t2.laAppNo
LEFT JOIN approval t3 ON t1.laLstAppNo=t3.appNo AND t3.document='leave'
WHERE t2.laID =rID
	-- AND YEAR(laLstDate) BETWEEN df AND dt
	AND t3.document IS NOT NULL
	
	
UNION ALL

-- TIME ADJUSTMENT 
SELECT DISTINCT taStatus AS appStatus, taDate AS appDateFrom, taAppNo AS appNo, taID AS appID,'timeadjustment' AS appDoc,'#4B62D1' AS appColor,2 AS switch
FROM timeadjustmentform t1
LEFT JOIN approval t2 ON t1.taAppNo=t2.appNo AND t2.document='timeadjustment'
WHERE  taID =rID
	-- AND YEAR(taDate) BETWEEN df AND dt
	AND t2.document IS NOT NULL
	

UNION ALL

-- OB
SELECT DISTINCT obStatus AS appStatus, obDateFrom AS appDateFrom, obAppNo AS appNo, obID AS appID,'officialbusiness' AS appDoc,'#800080' AS appColor, 3 AS switch
FROM officialbusinessform  t1
LEFT JOIN approval t2 ON t1.obAppNo=t2.appNo AND t2.document='officialbusiness'
WHERE  obID =rID  
	-- AND YEAR(obDateFrom) BETWEEN df AND dt
	AND  obType !='Days'
	AND t2.document IS NOT NULL
	
UNION ALL

SELECT DISTINCT t2.obStatus, t1.obLstDate AS obDateFrom, t1.obLstAppNo AS obAppNo, t2.obID,'officialbusiness' AS appDoc,'#800080' AS appColor,3 AS switch
FROM officialbusinesslist t1
LEFT JOIN officialbusinessform t2 ON t1.`obLstAppNo`=t2.`obAppNo`
LEFT JOIN approval t3 ON t1.obLstAppNo=t3.appNo AND t3.document='officialbusiness'
WHERE t1.`id`=rID 
	-- AND YEAR(obLstDate) BETWEEN df AND dt
	AND t3.document IS NOT NULL
	
	
UNION ALL


-- OFFSET 

SELECT DISTINCT osStatus AS appStatus, osDate AS appDateFrom, osAppNo AS appNo, osID AS appID,'offset' AS appDoc,'#EFDB39' AS appColor,4 AS switch
FROM offsetform t1
LEFT JOIN approval t2 ON t1.osAppNo=t2.appNo AND t2.document='offset'
WHERE  osID =rID
	-- AND YEAR(osDate) BETWEEN df AND dt
	AND t2.document IS NOT NULL 


			
	UNION ALL
	
-- TIME ENTRY 


SELECT DISTINCT teStatus AS appStatus, teDate AS appDateFrom, teAppNo AS appNo, teID AS appID,'timeentry' AS appDoc,'#D7830D' AS appColor,5 AS switch
FROM timeentryform t1
LEFT JOIN approval t2 ON t1.teAppNo=t2.appNo AND t2.document='timeentry'
WHERE  teID =rID
	-- AND YEAR(teDate) BETWEEN df AND dt
	AND t2.document IS NOT NULL
	
UNION ALL

-- SCHEDULE 
SELECT DISTINCT '' AS appStatus, `day` AS appDateFrom
		, v_employeedailyschedule_cal.day AS appNo
		,rID AS appID,CONCAT('Schedule: ',schedules.scheduleCode) AS appDoc,'#171818' AS appColor,6 AS switch
FROM  temp_v_employeedailyschedule_cal v_employeedailyschedule_cal
JOIN   schedules ON v_employeedailyschedule_cal.schedule = schedules.code
WHERE employeeId=rID  
	-- AND YEAR(v_employeedailyschedule_cal.day) BETWEEN df AND dt
GROUP BY 
	v_employeedailyschedule_cal.day, 
	v_employeedailyschedule_cal.employeeId, 
	v_employeedailyschedule_cal.schedule
	
UNION ALL

SELECT DISTINCT scStatus AS appStatus, scReqDate AS appDateFrom, scAppNo AS appNo, scID AS appID,'Schedule Change' AS appDoc,'#EAC231' AS appColor,6 AS switch
FROM schedulechange t1 
WHERE  scID=rID 
	-- AND YEAR(scReqDate) BETWEEN df AND dt

UNION ALL

-- HOLIDAYS

SELECT DISTINCT '' AS appStatus, holidayDate AS appDateFrom, 0 AS appNo, 0 AS appID,CONCAT('Holiday: ',holidayName) AS appDoc,'#F32020' AS appColor,101 AS switch
FROM holidaysholiday
WHERE YEAR(holidayDate) BETWEEN df AND dt


UNION ALL

SELECT DISTINCT '' AS appStatus, holidayDate AS appDateFrom, 0 AS appNo, 0 AS appID,CONCAT('Holiday: ',holidayName) AS appDoc,'#F32020' AS appColor,101 AS switch
FROM  holidaysprofitcenter
JOIN  employeemovement ON employeemovement.costCode = holidaysprofitcenter.profitCenterCode
JOIN  identity ON identity.code = employeemovement.code
WHERE  identity.identityId = rID 
;
	
END $$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_userAuditTrails; 
DELIMITER $$   
CREATE PROCEDURE sp_userAuditTrails(
IN pint_mode INT,   
IN rIdentityId VARCHAR(30),  
IN rActivity VARCHAR(100), 
IN rStatus VARCHAR(30),  
IN rDetails VARCHAR(300),
IN rMachainDetails VARCHAR(200),
IN rFacilityDetails VARCHAR(150),
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
SET msg = 'Success';

/*

	0 - INSERT
*/


IF (pint_mode=0) THEN
	-- -TRUNCATE TABLE userAuditTrails;
	-- SELECT * FROM userAuditTrails 
	-- SELECT * FROM portal_mfa
	-- UPDATE portal_mfa SET usedIdBy=NULL,useDate=NULL,systemDate=NOW() WHERE id=5
	
	SELECT identityId,activity,`status`,details
		,JSON_UNQUOTE(JSON_EXTRACT(machainDetails,'$[0].browser'))  AS browser
		,JSON_UNQUOTE(JSON_EXTRACT(machainDetails,'$[0].ip'))  AS ip_address
		,JSON_UNQUOTE(JSON_EXTRACT(facilityDetails,'$[0].url'))  AS url
		,JSON_UNQUOTE(JSON_EXTRACT(facilityDetails,'$[0].seconds')) AS seconds
	FROM userAuditTrails
	;
	
	
	-- COMMIT;
END IF;

IF (pint_mode=1) THEN
	START TRANSACTION;  
	
		INSERT INTO userAuditTrails (identityId,activity,`status`,details,machainDetails,facilityDetails)
		VALUES (rIdentityId,rActivity,rStatus,rDetails,rMachainDetails,rFacilityDetails); 
	COMMIT;
	LEAVE proc_start;
END IF;

END $$ 
DELIMITER ;




DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_schedule_change`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_schedule_change`(
IN pint_mode INT,
IN appNo INT,  
IN r_scID VARCHAR(30), 
IN r_Day VARCHAR(30),  
IN r_scSchedule VARCHAR(30),
IN r_scReason TEXT,
IN r_attachedFiles LONGTEXT, 
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


SET @app_type = 'schedulechange';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(DATE(NOW()),DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_ddlSchedule'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
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
	
	DELETE FROM requestattachments WHERE appNo = @appNo AND document='schedulechange'; 

	IF (JSON_LENGTH(@uploadedFiles)>0) THEN
		INSERT INTO requestattachments (appNo,document,files)
		VALUES (@appNo,@app_type,@uploadedFiles);
	END IF;


	SET msg=7;
	CALL sp_approval_insert(6,@appNo,r_scID,@num1, @msg1); 
	COMMIT;
END IF; 
END$$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_portal_get_all_approvals_count`;
DELIMITER $$   
CREATE PROCEDURE `sp_portal_get_all_approvals_count`(
IN  pint_mode INT, 
IN  identityId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success'; 


-- SET @year = (SELECT YEAR(DATE(NOW()))); 
DROP TEMPORARY TABLE IF EXISTS validPayrollPeriod ;
CREATE TEMPORARY TABLE validPayrollPeriod AS(
		SELECT payrollperioddetails.`payrollPeriodApproverLocked` AS approverLocked,
			payrollperioddetails.`payrollPeriodKioskLocked` AS periodKioskLocked,
			payrollperioddetails.`payrollPeriodLocked` AS periodLocked,
			payrollperioddetails.`payrollPeriodProcessLocked` AS periodProcessLocked,
			payrollperioddetails.`payrollPeriodScheduleTaggingLocked`  AS periodScheduleTaggingLocked,
			payrollPeriodFrom,payrollPeriodTo
		FROM payrollperioddetails
		-- WHERE YEAR(payrollPeriodFrom) = @year
		); 
	
SET @document = (CASE
			WHEN pint_mode=0 THEN 'overtime'
			WHEN pint_mode=1 THEN 'leave'
			WHEN pint_mode=2 THEN 'timeadjustment'
			WHEN pint_mode=3 THEN 'officialbusiness'
			WHEN pint_mode=4 THEN 'offset'
			ELSE ''
		END); 

DROP TEMPORARY TABLE IF EXISTS temp_all_approval_list_count;
CREATE TEMPORARY TABLE temp_all_approval_list_count AS (
		
		SELECT document,appNo 
		FROM approval 
		
		LEFT JOIN approvaltemplatestages ON approvaltemplatestages.code = approval.templateCode 
					AND approvaltemplatestages.lineId = approval.templateLineId   
					
		LEFT JOIN approvalstages ON approvaltemplatestages.stageCode = approvalstages.stageCode	
		LEFT JOIN approvalstagedetails ON approvalstagedetails.code = approvalstages.code 
	
		WHERE approvalstagedetails.id=identityId
			-- AND approval.document=@document 
			-- SELECT * FROM approvalstagedetails
);


IF (pint_mode=1) THEN 

		SELECT 
		
			(SELECT COUNT(laAppNo) 
			FROM leaveapplicationform t1
			LEFT JOIN validPayrollPeriod t2 
				ON t1.laDateFrom BETWEEN t2.payrollPeriodFrom AND t2.payrollPeriodTo
			WHERE laAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
			AND laAppDate BETWEEN (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
								AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
			) AS laForms,  -- leave
			
			(SELECT COUNT(otAppNo) 
			FROM overtimeform t1  
			LEFT JOIN validPayrollPeriod t2 
				ON t1.otDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE otAppNo IN (SELECT appNo FROM temp_all_approval_list_count) 
			AND otAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
								AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
			) AS otForms,  -- Overtime
			
			(SELECT COUNT(taAppNo)
			FROM timeadjustmentform	t1
			LEFT JOIN validPayrollPeriod t2
				ON t1.taDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE taAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
			AND taAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
									AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
			) AS taForms, -- Time Adjustment
			
			(SELECT COUNT(obAppNo)
			FROM officialbusinessform t1	
			LEFT JOIN validPayrollPeriod t2 
				ON t1.obDateFrom BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE obAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
				AND obAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
										AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
			) AS obForms, -- Official Business
			
			(SELECT COUNT(osAppNo)
			FROM offsetform	t1
			LEFT JOIN validPayrollPeriod t2 
				ON t1.osDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE osAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
				AND osAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
										AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
				) AS osForms, -- Offset
				
				
				(SELECT COUNT(teAppNo)
			FROM timeentryform t1
			LEFT JOIN validPayrollPeriod t2 
				ON t1.teDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE teAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
				AND teAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
										AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
				) AS teForms, -- Time Entry
				
				(SELECT COUNT(scAppNo)
			FROM schedulechange t1
			LEFT JOIN validPayrollPeriod t2 
				ON t1.scAppDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE scAppNo IN (SELECT appNo FROM temp_all_approval_list_count)
				AND scAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
										AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
				) AS scForms, -- Change Schedule
				
				(SELECT COUNT(t1.appNo)
			FROM hrdcertificate t1
			LEFT JOIN validPayrollPeriod t2 
				ON t1.appNo BETWEEN payrollPeriodFrom AND payrollPeriodTo 
			WHERE t1.appNo IN (SELECT appNo FROM temp_all_approval_list_count)
				AND requestDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
										AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod)
				) AS hrdForms 
				
		; 
END IF; 


END$$
DELIMITER ;



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
IN r_attachedFiles LONGTEXT, 
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



DROP TABLE IF EXISTS tblJsonData; CREATE TABLE tblJsonData AS (SELECT r_attachedFiles);
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
		"msg":"Please select [Location]"	
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

SET @app_type = 'leave';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(from_date,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_laFromdate'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
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
	DELETE FROM requestattachments WHERE appNo = la_LstAppNo AND document='leave'; 
	
	IF (JSON_LENGTH(@uploadedFiles)>0) THEN
		INSERT INTO requestattachments (appNo,document,files)
		VALUES (@laAppID,@app_type,@uploadedFiles);
	END IF;

	
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


-- CALL sp_portal_get_posted_dtr_dates (0,'0601200033',@num,@msg); SELECT @msg;
DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_get_posted_dtr_dates`$$ 
CREATE PROCEDURE `sp_portal_get_posted_dtr_dates`(  
IN pint_mode INT, 
IN id VARCHAR(30),  
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN 
	-- SELECT * FROM identity;
		-- SET @code = (SELECT MAX(`code`) AS `code` FROM `payrollperiod`);
		
		SET @code=(
		SELECT `code`
		FROM payrollperiod
		WHERE payrollPeriodID = (SELECT payrollPeriodID
					FROM identity
					WHERE identityId=id)
		); 
		
		SELECT DISTINCT ppd.payrollPeriod, 
		CONCAT(DATE_FORMAT(ppd.payrollPeriodFrom,'%M'),' ',DATE_FORMAT(ppd.payrollPeriodFrom,'%e'),'-',DATE_FORMAT(ppd.payrollPeriodTo,'%e'),', ',YEAR(ppd.payrollPeriodTo)) AS date_range 
		FROM(
		SELECT  *
		FROM v_payrollperiod ppd
		WHERE `code`=@code 
		)ppd
		
	LEFT JOIN (
			SELECT 
				CAST(MIN(dtrTime) AS DATE) AS dateFrom,
				CAST(MAX(dtrTime) AS DATE) AS dateTo
			FROM DtrlogsviewCollector dtr
			WHERE biometricsId = id
			
		) dtr ON ppd.payrollPeriodFrom BETWEEN dtr.dateFrom AND dtr.dateTo
		WHERE ppd.visibleOnList = 1
		AND ppd.payrollPeriodLocked IS NULL; 

END IF; 

END$$
DELIMITER ; 



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_rpt_get_payslip_record`$$ 
CREATE PROCEDURE `sp_rpt_get_payslip_record`(  
IN pint_mode INT, 
IN rId VARCHAR(30),  
IN rDf VARCHAR(30),  
IN rDt VARCHAR(30),  
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';



SET rDf=(CASE WHEN rDf='' THEN '1990-01-01' ELSE rDf END);
SET rDt=(CASE WHEN rDt='' THEN DATE(NOW()) ELSE rDt END);

SELECT 
	employeepayslip.code AS 'code', 
	employeepayslip.identityId AS identityId, 
	employeepayslip.payrollPeriod AS payrollPeriod, 
	employeepayslip.netPay AS netPay,
	IFNULL(employeepayslip.costCenter, employeemovement.`costCode`) AS costCenter, 
	IFNULL(employeepayslip.department, employeemovement.`departmentCode`) AS department,
	CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) AS period, 
	payrollperioddetails.payrollPeriodFrom AS payrollPeriodFrom, 
	payrollperioddetails.payrollPeriodTo AS payrollPeriodTo,
	payrollperioddetails.payrollPeriodPayDate AS payrollPeriodPayDate,
	employeebatchpayslip.status AS STATUS,
	employeebatchpayslip.payrollPeriod,
	employeebatchpayslip.payrollGroup
FROM employeepayslip 
LEFT JOIN  employeebatchpayslip
ON employeepayslip.payslipbatchcode = employeebatchpayslip.payslipbatchcode 

LEFT JOIN payrollperioddetails ON CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) = employeepayslip.payrollPeriod
LEFT JOIN employeemovement ON employeemovement.`code` = employeepayslip.`employeeCode`
LEFT JOIN `vw_rpt_max_employeemovement` ON `vw_rpt_max_employeemovement`.`Code` = employeemovement.`code` 			
WHERE employeepayslip.identityId= rId
AND employeepayslip.payrollPeriod = CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineId) 
AND	employeebatchpayslip.payrollPeriod = employeepayslip.payrollPeriod 
AND employeebatchpayslip.`status`='A'
AND `vw_rpt_max_employeemovement`.`LineId` = employeemovement.`lineId`
AND payrollperioddetails.payrollPeriodFrom BETWEEN rDf AND rDt; 

END$$
DELIMITER ; 


DROP PROCEDURE IF EXISTS sp_email_hist;
DELIMITER $$  
CREATE PROCEDURE sp_email_hist
( 
IN pint_mode INT,	
IN r_email_from VARCHAR(300), 
IN r_email_to VARCHAR(300), 
IN r_subject VARCHAR(100), 
IN r_content VARCHAR(300), 
IN r_email_protocol VARCHAR(50), 
IN r_email_host VARCHAR(50), 
IN r_mailer_response VARCHAR(50), 
IN r_errorMessage VARCHAR(500),  
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SET @sysSuggestion=(CASE 
			WHEN r_errorMessage LIKE '%Failed to authenticate%' THEN 'User may have invalid Email setup in admin side!'
			WHEN r_errorMessage LIKE '%Attempt to read property%' THEN 'Invalid email recipient [Send to] or [Cc to]!'
			WHEN (r_errorMessage LIKE '%Mailer%' AND r_errorMessage LIKE '%is not defined%') THEN 'Invalid port setup!'
			WHEN (r_errorMessage LIKE '%An email must have%' AND r_errorMessage LIKE '%To%Cc%Bcc%') THEN 'Invalid Send email format in source code model!'
			ELSE ''
			END);

-- set @sysSuggestion='';

INSERT INTO email_logs (email_from,email_to,`subject`,content,email_protocol,email_host,mailer_response,errorMessage,sysSuggestion)
SELECT r_email_from,r_email_to,r_subject,r_content,r_email_protocol,r_email_host,r_mailer_response,r_errorMessage,@sysSuggestion;

END $$ 
DELIMITER ;




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
IN r_Opt TEXT,
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start: BEGIN
DECLARE done INT DEFAULT 0;
DECLARE vDB VARCHAR(100);
DECLARE pNeedDB VARCHAR(200) DEFAULT 'manilajockey_v4_test,mjci_jockey_club,mjci_san_lazaro,mjci_land_corp,mjci_vertex_inc';
DECLARE executedQry TEXT DEFAULT '';
DECLARE cur CURSOR FOR  SELECT NAME  FROM `pf-common`.`databases`  WHERE FIND_IN_SET(NAME, pNeedDB) > 0;
DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;
SET num = 0;
SET msg = 'Success';
OPEN cur;
db_loop: LOOP
FETCH cur INTO vDB; 
IF done THEN  LEAVE db_loop;  END IF; 

/* Table 1 */
SET @sql = CONCAT( 'DROP TEMPORARY TABLE IF EXISTS `',  REPLACE(vDB, '`', '``'), '`.`temp_init_approval`' ); 
SET executedQry = CONCAT(executedQry, '\n', @sql, ';');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt; 

/* Table 2 */
SET @sql = CONCAT( 'DROP TEMPORARY TABLE IF EXISTS `',  REPLACE(vDB, '`', '``'), '`.`temp_approval`' ); 
SET executedQry = CONCAT(executedQry, '\n', @sql, ';');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt; 

/* Table 3 */
SET @sql = CONCAT( 'DROP TEMPORARY TABLE IF EXISTS `',  REPLACE(vDB, '`', '``'),  '`.`tempIdentity`'  ); 
SET executedQry = CONCAT(executedQry, '\n', @sql, ';'); 
PREPARE stmt FROM @sql; EXECUTE stmt;  DEALLOCATE PREPARE stmt;

/* Table 4 */
SET @sql = CONCAT( 'DROP TEMPORARY TABLE IF EXISTS `',  REPLACE(vDB, '`', '``'),  '`.`tempstages`'  ); 
SET executedQry = CONCAT(executedQry, '\n', @sql, ';'); 
PREPARE stmt FROM @sql; EXECUTE stmt;  DEALLOCATE PREPARE stmt;
END LOOP; 
CLOSE cur; 


SET @srcDB=IFNULL((SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB'))),'');
-- CALL sp_application_info3(0,1, 1535,0,'F','1991-01-01','','{"srcDB" : "mjci_land_corp"}',@num,@msg); SELECT @msg;


-- SELECT * FROM documentMaster
SET @switch = switch;
SET switch = (CASE WHEN switch=1000 THEN 0 ELSE switch END);
SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch); 
SET @id =  (CASE   WHEN rAppNo>0 THEN rAppNo    ELSE rID END);	
SET @IsApproval = (CASE 
		WHEN (pint_mode=1 AND rAppNo=0 AND rID<>'' AND r_decision = 'F') THEN 1
		ELSE 0 
	     END);



SET @additionalColumns = (CASE  
			  WHEN @document='offset' THEN ',(SELECT fn_offset_ot_id(osReference,osID)) as osOtAppNo' 
			  WHEN @document='overtime' THEN ',(SELECT fn_overtimeExtensionAllowanceDetails(otAppNo)) as otExtAllowDetails' 
			  ELSE ''
		  END);	      
		    
      
SET @speciallwhereclauses = (CASE  
			  WHEN @document='overtime'  AND @switch=0  THEN ' AND otExtAllowance=0' 
			  ELSE ''
		  END);	
      
SET @center=(SELECT fn_accross_db_mapping(9,'',@document,''));   
SET @appDate=(SELECT fn_accross_db_mapping(7,'',@document,''));  
SET @appStatus=(SELECT fn_accross_db_mapping(6,'',@document,'')); 
SET @DateFilter=(SELECT fn_accross_db_mapping(7,'',@document,''));

SET @DateFilter2=(SELECT fn_accross_db_mapping(100,'',@document,''));
SET @appStatus2=(SELECT fn_accross_db_mapping(101,'',@document,'')); 
 
SET dateFrom=(CASE 
	  WHEN r_decision IN ('P','F') THEN  (SELECT DATE_SUB(CURDATE(), INTERVAL 1 YEAR)) 
	  WHEN dateFrom='' THEN  (SELECT DATE_SUB(CURDATE(), INTERVAL 1 MONTH)) 
	  ELSE dateFrom 
       END);  
SET dateTo=(CASE WHEN dateTo='' THEN  DATE(NOW()) ELSE dateTo END); 
SET dateTo=(CASE WHEN (@document='hrdcert') AND (@IsApproval=1) THEN  DATE_ADD(dateTo, INTERVAL 1 MONTH) ELSE dateTo END); 
SET r_decision = (CASE WHEN r_decision='' THEN 'H' ELSE r_decision END);



-- SET @needDB = 'manilajockey_v4_test,mjci_jockey_club,mjci_san_lazaro,mjci_land_corp,mjci_vertex_inc';
-- SET @needDB = 'manilajockey_v4_test,mdb_demo_v4';


SET @sql = CONCAT('CREATE TEMPORARY TABLE temp_init_approval AS ',(SELECT GROUP_CONCAT( 
		    DISTINCT CONCAT('
				   SELECT t1.appNo as r_appNo,	t1.document as r_document,',IF(rAppNo>0,'t1.templateCode as r_templateCode,',''),'	t1.templateLineId as r_templateLineId,	t1.id as r_id,	t1.approver as r_approver,	t1.approverName as r_approverName,	t1.decision as r_decision,	t1.remarks as r_remarks, DATE_FORMAT(t1.approvedDate, ''%Y-%m-%d %h:%i:%s %p'') as r_approvedDate,	t1.prevTemplateCode as r_prevTemplateCode,t1.*, ''', REPLACE(NAME, '''', ''''''),''' AS r_srcDb   
					,t2.*,',@center,' as center,t5.link,t4.txt as r_status
					,',(SELECT fn_accross_db_mapping(8,NAME,@document,'')),'
					,',@center,' as appDate 
					',@additionalColumns,'
					,apprvlStgs.stageCode
				   FROM `', REPLACE(NAME, '`', '``'), '`.`approval` t1  
				   ',(SELECT fn_accross_db_mapping(0,NAME,@document,'t2')),'   
				   ',(SELECT fn_accross_db_mapping(1000,NAME,@document,'')),'  
				LEFT JOIN `', REPLACE(NAME, '`', '``'), '`.`approvaltemplatestages` apprvlStgs ON t1.`templateCode`=apprvlStgs.`code` AND t1.`templateLineId`=apprvlStgs.`lineId` 
				LEFT JOIN `', REPLACE(NAME, '`', '``'), '`.`statusMaster` t4 ON ',IF(pint_mode=0,@appStatus,'t1.decision'),' = t4.val
				LEFT JOIN `', REPLACE(NAME, '`', '``'), '`.`appLinkStatus` t5 ON ',IF(pint_mode=0,@appStatus,'t4.val'),' = t5.lStatus 
				WHERE t1.document="',@document,'" 
				      AND t1.templateCode IS NOT NULL
				      ',@speciallwhereclauses,'
				    ' 
				    ) SEPARATOR ' UNION ALL ' )
	      FROM `pf-common`.`databases`
	      WHERE FIND_IN_SET(NAME, pNeedDB) > 0
	     ));  
	     
-- SELECT  @sql; LEAVE proc_start;
-- CALL sp_application_info3(1,5,0,'280610','F','1991-01-01','','',@num,@msg); SELECT @msg; -- APPROVER
-- CALL sp_application_info3(0,5, 1535,0,'F','1991-01-01','','',@num,@msg); SELECT @msg;


PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- SELECT * FROM temp_init_approval; LEAVE proc_start;
-- CALL sp_application_info3(1,5,0,'280610','F','1991-01-01','','',@num,@msg); SELECT @msg; -- APPROVER


SET @sql =CONCAT('CREATE TEMPORARY TABLE tempstages AS ',(SELECT GROUP_CONCAT(
    CONCAT(
	'
	SELECT t1.`stageCode`,t2.`id` AS authId,t2.`authorizer`,t2.`lineId`
		, ''', REPLACE(NAME, '''', ''''''),''' AS stageDB   
	FROM `', REPLACE(NAME, '`', '``'), '`.`approvalstages` t1
	LEFT JOIN  `', REPLACE(NAME, '`', '``'), '`.`approvalstagedetails`  t2 ON t1.`code`=t2.`code`
	 '
	    )  SEPARATOR ' UNION ALL '
	)
	FROM `pf-common`.`databases`
	 WHERE FIND_IN_SET(NAME, pNeedDB) > 0
   ));
-- SELECT @sql; LEAVE proc_start;
-- CALL sp_application_info3(1,1,0,'280610','F','1991-01-01','','',@num,@msg); SELECT @msg;

PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- SELECT * FROM tempstages; LEAVE proc_start;
-- CALL sp_application_info3(1,5,0,'1234','F','1991-01-01','','',@num,@msg); SELECT @msg;


-- SELECT * FROM tempstages
SET @sql = CONCAT('CREATE TEMPORARY TABLE temp_approval AS 
	SELECT t1.*,authId
	FROM temp_init_approval t1
	LEFT JOIN tempstages auth on t1.`stageCode`=auth.`stageCode` -- AND t1.`templateLineId`=auth.`lineId`
	',(CASE WHEN @IsApproval=1 
				THEN CONCAT('WHERE ',@DateFilter2,' BETWEEN ''',dateFrom,''' AND ''',dateTo,''' 
							AND authId=''',rID,'''
							AND t1.decision=''',r_decision,'''
							AND t1.document=''',@document,''' 
							',(CASE WHEN r_decision IN ('P','F') THEN CONCAT(' AND ',@appStatus2,'<>''D'' ') ELSE '' END),'
							 
					   ') 
					    
			ELSE  CONCAT('
				      WHERE (CASE 
						    WHEN ', rAppNo, ' > 0 THEN t1.appNo
						    WHEN ', pint_mode, ' = 0 THEN t1.id
						    WHEN ', pint_mode, ' = 1 THEN t1.approver
					     END)=  ''', @id, ''' 
					     AND t1.document=''',@document,'''
					     ', IF(rAppNo > 0, '', CONCAT('AND ', @DateFilter2, ' BETWEEN ''',dateFrom,''' AND ''',dateTo,'''')), '
					     ', IF(rAppNo > 0, '', CONCAT('AND t1.link = ''',r_decision,''' ')), ' 
					     ', IF(pint_mode = 0, 'AND t1.appNo IS NOT NULL', ''), ' 
					     ',(CASE WHEN @srcDB<>''  THEN CONCAT('AND r_srcDb = "',@srcDB,'"') ELSE '' END),'
					   
				
				    ')
		END),' 
	'); 
	 
-- SELECT @sql; LEAVE proc_start;
-- CALL sp_application_info3(1,5,0,'1234','F','1991-01-01','','',@num,@msg); SELECT @msg;


PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- SELECT * FROM temp_approval; LEAVE proc_start;
-- CALL sp_application_info3(1,5,0,'1234','F','1991-01-01','','',@num,@msg); SELECT @msg;



SET @sql = CONCAT('CREATE TEMPORARY TABLE tempIdentity AS ',(
SELECT GROUP_CONCAT( DISTINCT
    CONCAT(
	'SELECT i.code,i.identityId,CONCAT(IFNULL(firstName,"")," ",IFNULL(middleName,"")," ",IFNULL(lastName,"")) AS fullName
	,batchId,payrollConfigurationCode,paymentFrequency,payrollPeriodID
	, ''', REPLACE(NAME, '''', ''''''), 
	''' AS _srcDb FROM `', REPLACE(NAME, '`', '``'), '`.`identity` i'
    )
    SEPARATOR ' UNION ALL '
)
FROM `pf-common`.`databases`
 WHERE FIND_IN_SET(NAME, pNeedDB) > 0
));


-- SELECT @sql;
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- FIXING ALL BLANK NAMES
IF (@document = 'leave') THEN

UPDATE temp_approval t1
LEFT JOIN tempIdentity t2  ON t1.r_id = t2.identityId
SET t1.laName = t2.fullName
WHERE IFNULL(t1.laName, '') = '';

END IF;

SELECT DISTINCT  t1.* 
,identity.fullName
,payrollperioddetails.payrollPeriodApproverLocked  AS approverLocked 
,dep.departmentName
,cost.costName 
FROM temp_approval t1
LEFT JOIN department dep ON t1.department = dep.departmentCode
LEFT JOIN costCenter AS cost ON t1.center=cost.costCode 
LEFT JOIN tempIdentity identity ON t1.r_id=identity.identityId AND t1.r_srcDb=identity._srcDb
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
GROUP BY appNo
,(CASE WHEN @IsApproval=1 THEN decision ELSE appNo END) 
,r_srcDb
;
-- CALL sp_application_info(1,5,0,'280610','F','1991-01-01','','',@num,@msg); SELECT @msg; -- APPROVER
-- CALL sp_application_info(1,5,0,'1234','F','1991-01-01','','',@num,@msg); SELECT @msg; -- APPROVER

-- CALL sp_application_info(1,5,0,'280610','A','','','',@num,@msg); SELECT @msg; -- APPROVER HISTORY


-- CALL sp_application_info(0,5,0,'260812','P','','','',@num,@msg); SELECT @msg; -- REQUESTOR
-- CALL sp_application_info(0,1,0,'2219','','','','',@num,@msg); SELECT @msg; -- REQUESTOR HISTORY

-- CALL sp_application_info(0,0,108386,'280610','F','','','{"srcDB" : "mjci_land_corp"}',@num,@msg); SELECT @msg;  -- Click AppNo
-- SELECT * FROM documentMaster
END$$
DELIMITER ;






DROP PROCEDURE IF EXISTS sp_load_schedules; 
DELIMITER $$   
CREATE PROCEDURE sp_load_schedules(
IN pint_mode INT,  
IN rScheduleType VARCHAR(30),  
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  

SET num = 0;
SET msg = 'Success';

SELECT CODE, scheduleCode, scheduleName
FROM schedules
WHERE scheduleType=rScheduleType
;
END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_load_sched_day; 
DELIMITER $$   
CREATE PROCEDURE sp_load_sched_day(
IN pint_mode INT,  
IN rID VARCHAR(30), 
IN rDate VARCHAR(30), 
IN rStatus VARCHAR(1), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  

SET num = 0;
SET msg = 'Success';


	SET @scAppNo= (SELECT MAX(scAppNo) FROM schedulechange WHERE  scID=rID AND scDay=rDate); -- AND rStatus IN ('P','F','D'));  
	SET @scSchedule=(SELECT scSchedule FROM schedulechange WHERE scAppNo=@scAppNo);
	SET @scReason = (SELECT scReason FROM schedulechange WHERE scAppNo=@scAppNo);
	SET @scAppDate = (SELECT scAppDate FROM schedulechange WHERE scAppNo=@scAppNo);
	SET @scStatus = (SELECT scStatus FROM schedulechange WHERE scAppNo=@scAppNo);
	
	
	
	SELECT employeedailyschedule.*
		, schedules.code
		, (CASE WHEN rStatus NOT IN ('') THEN @scSchedule ELSE schedules.scheduleName END)  AS scheduleName
		, (CASE WHEN rStatus NOT IN ('') THEN schedules.scheduleName ELSE '' END)  AS prevSchedule
		, (CASE WHEN rStatus NOT IN ('') THEN @scReason ELSE '' END)  AS scRemarks
		,employeedailyschedule.day
		,IFNULL(@scAppNo,0) AS AppNo
		,IFNULL(@scAppDate,DATE(NOW())) AS AppDate
		,IFNULL(@scStatus,'')AS appStatus 
	FROM employeedailyschedule, schedules
	WHERE employeedailyschedule.employeeId = rID
	AND employeedailyschedule.day = rDate
	AND employeedailyschedule.schedule = schedules.code
	; 

END $$ 
DELIMITER ;


-- CALL sp_get_user_details(0,'so_employee',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_get_user_details;
DELIMITER $$  
CREATE PROCEDURE sp_get_user_details
( 
IN pint_mode INT,	
IN id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN

	SELECT   t1.identityid,t1.usertype,t2.`lastName`,t2.`firstName`,t2.`middleName`,suffix
		,t4.costCode  AS CenterCode,t4.costName
		,t5.departmentCode ,t5.departmentName,location
		,(CASE WHEN t6.id IS NOT NULL THEN 1 ELSE 0 END) AS if_approver
		,t2.emailAddress
		,CONCAT(t2.`lastName`,' ',t2.`firstName`,' ',t2.`middleName`) AS FullName
		,dateHired,contactNo,emailAddress,barangay,street,city,province
		,t1.faceDetails
	FROM users t1
	LEFT JOIN identity t2 ON t1.identityid = t2.identityId
	LEFT JOIN employeemovement t3 ON t2.code=t3.code
	LEFT JOIN costCenter t4 ON t3.costCode=t4.costCode
	LEFT JOIN department t5 ON t3.departmentCode=t5.departmentCode
	LEFT JOIN approvalstagedetails t6 ON t1.username=t6.id
	WHERE t1.username=id OR t1.identityid=id
	-- WHERE t1.identityid=id 
	LIMIT 1
		-- AND t4.costCode IS NOT NULL
	;
	
END IF;


IF (pint_mode=1) THEN

	SELECT * FROM v_user_details WHERE EmpID=id;
	
END IF;

END $$
DELIMITER ; 


-- CALL sp_faceDetails(1,'0601200033','',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_faceDetails; 
DELIMITER $$ 
CREATE PROCEDURE sp_faceDetails
(  
IN pint_mode INT, 
IN r_userId VARCHAR(30),    
IN r_faceDetails TEXT, 
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



/*
IF (r_type IN ('',NULL)) THEN 
	SET num = 1;
	SET msg = '{
		"id":"lbl_ob_ddl",
		"msg":"Please select [OB Type]"	
		}';
LEAVE proc_start;
END IF;	
*/


IF (pint_mode=0) THEN
	-- SELECT * FROM users
	UPDATE  users
	SET faceDetails=r_faceDetails
	WHERE username=r_userId;
	COMMIT;
	
END IF;



IF (pint_mode=1) THEN
	-- TRUNCATE TABLE tmp_tbl; INSERT INTO tmp_tbl (txt_data) VALUES (r_faceDetails);
	
	SELECT *
	FROM users -- WHERE faceDetails<>''
	WHERE faceDetails=r_faceDetails;
	COMMIT;
END IF;


IF (pint_mode=2) THEN
	-- UPDATE users SET faceDetails = '';
	SELECT faceDetails
	FROM users WHERE faceDetails<>'';  
END IF;
	


END $$
DELIMITER ; 


DROP PROCEDURE IF EXISTS sp_get_employee_schedule;  
DELIMITER $$ 
CREATE PROCEDURE sp_get_employee_schedule
(  
IN pint_mode INT, 
IN r_identityId VARCHAR(30), 
IN r_day VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 

SET num = 0;
SET msg = 'Success';



SELECT employeedailyschedule.*, schedules.code, schedules.scheduleName 
FROM employeedailyschedule, schedules
WHERE employeedailyschedule.employeeId = r_identityId
	AND employeedailyschedule.day = r_day
	AND employeedailyschedule.schedule = schedules.code
	;

END $$
DELIMITER ;

ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doleType` VARCHAR(1) DEFAULT 'P';
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleWorkHour` DECIMAL(9,6) DEFAULT NULL; 
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleNightDiff` DECIMAL(9,6) DEFAULT NULL; 
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleOTHour` DECIMAL(9,6) DEFAULT NULL;
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleOTNightDiff` DECIMAL(9,6) DEFAULT NULL;
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleRestDayWorkHour` DECIMAL(9,6) DEFAULT NULL;
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleRestDayNightDiff` DECIMAL(9,6) DEFAULT NULL;
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleRestDayOTHour` DECIMAL(9,6) DEFAULT NULL;
ALTER TABLE dole ADD COLUMN IF NOT EXISTS `doubleRestDayOTNightDiff` DECIMAL(9,6) DEFAULT NULL; 

DROP TABLE IF EXISTS v_employeerate;
DROP VIEW IF EXISTS v_employeerate; 
DELIMITER $$ 
CREATE VIEW `v_employeerate` AS 

SELECT `emp`.`code` AS `employeeCode`,`move`.`lineId` AS `lineId`,`move`.`costCode` AS `costCenter`
	,`move`.`departmentCode` AS `department`,`move`.`laborCode` AS `employmentStatus`,`emp`.`identityId` AS `identityId`
	,`emp`.`taxCode` AS `taxCode`,`emp`.`minimumWage` AS `minimumWage`,`move`.`rateType` AS `rateType`
	,`move`.`cola` AS `cola`,`move`.`rate` AS `rate`,`emp`.`dateHired` AS `dateHIred`,`cs`.`vatRate` AS `vatRate`
	,IF(`move`.`vatRegistered` IS NULL,0.00,ROUND(CASE WHEN `emp`.`paymentComputation` = 'D' THEN `move`.`rate` WHEN `emp`.`paymentFrequency` = 'SM' THEN `move`.`rate` / 2 WHEN `emp`.`paymentFrequency` = 'MO' THEN `move`.`rate` END,2) * (IFNULL(`cs`.`vatRate`,0.00) / 100)) AS `vatAmount`
	,`move`.`vatRegistered` AS `vatRegistered`,ROUND(CASE WHEN `emp`.`paymentComputation` = 'D' THEN `move`.`rate` WHEN `emp`.`paymentFrequency` = 'SM' THEN `move`.`rate` / 2 WHEN `emp`.`paymentFrequency` = 'MO' THEN `move`.`rate` END,2) AS `basicRate`,`emp`.`paymentComputation` AS `paymentComputation`
	,ROUND(CASE WHEN `emp`.`paymentComputation` = 'M' THEN `move`.`rate` * 12 / `emp`.`workingDaysInaYear` / `emp`.`workingHoursInaDay` WHEN `emp`.`paymentComputation` = 'D' THEN `move`.`rate` / `emp`.`workingHoursInaDay` WHEN `emp`.`paymentComputation` = 'H' THEN `move`.`rate` END,2) AS `ratePerHour`
	,ROUND(CASE WHEN `emp`.`paymentComputation` = 'M' THEN `move`.`rate` * 12 / `emp`.`workingDaysInaYear` WHEN `emp`.`paymentComputation` = 'D' THEN `move`.`rate` WHEN `emp`.`paymentComputation` = 'H' THEN `move`.`rate` * `emp`.`workingHoursInaDay` END,2) AS `ratePerDay`
	,ROUND(CASE WHEN `emp`.`paymentComputation` = 'D' THEN `move`.`rate` * `emp`.`workingDaysInaYear` / 12 WHEN `emp`.`paymentComputation` = 'M' THEN `move`.`rate` WHEN `emp`.`paymentComputation` = 'H' THEN `move`.`rate` * `emp`.`workingHoursInaDay` * `emp`.`workingDaysInaYear` / 12 END,2) AS `ratePerMonth`
	,`move`.`dateEffective` AS `dateEffective`,IF(`move`.`dateEnd` = '0000-00-00',NULL,`move`.`dateEnd`) AS `dateEnd`,`emp`.`batchId` AS `payrollGroupCode`,`emp`.`workingDaysInaYear` AS `daysPerYear`,`emp`.`workingDaysInaYear` / 12 AS `daysPerMonth`,IF(`emp`.`paymentFrequency` = 'MO',`emp`.`workingDaysInaYear` / 12,IF(`emp`.`paymentFrequency` = 'SM',`emp`.`workingDaysInaYear` / 12 / 2,`emp`.`workingDaysInaYear` / 12)) AS `daysPerCutOff`
	,`emp`.`workingHoursInaDay` AS `hoursPerDay`,`emp`.`basisOfAbsent` AS `basisOfAbsent`,`emp`.`paymentFrequency` AS `payrollFrequency`,`emp`.`paymentComputation` AS `payrollType`,`emp`.`payrollConfigurationCode` AS `payrollConfigurationCode`,`emp`.`doleSetup` AS `doleSetup`
	,`emp`.`workSchedule` AS `workSchedule`,`emp`.`scheduleCode` AS `scheduleCode`,`emp`.`windowHours` AS `windowHours`,`emp`.`tempScheduleCode` AS `tempScheduleCode`,`emp`.`lateConversionCode` AS `lateConversionCode`
	,`emp`.`undertimeConversionCode` AS `undertimeConversionCode`,`emp`.`location` AS `location`,`emp`.`workOnHoliday` AS `workOnHoliday`,`emp`.`requiredFiledOT` AS `requiredFiledOT`,`dole`.`doleType` AS `doleType`,`emp`.`payrollPeriodID` AS `payrollPeriodID`
	,CASE `emp`.`paymentFrequency` WHEN 'MO' THEN 'Monthly' WHEN 'SM' THEN 'Semi-Monthly' WHEN 'WK' THEN 'Weekly' ELSE 'Daily' END AS `payrollPeriodType`,IFNULL(`dole`.`regularWorkHour`,0.00) AS `regularWorkHourRate`,ROUND(`dole`.`regularNightDiff`,3) AS `regularNightDiffRate`
	,ROUND(`dole`.`regularOTHour`,3) AS `regularOTHourRate`,ROUND(`dole`.`regularOTNightDiff`,3) AS `regularOTNightDiffRate`,ROUND(`dole`.`regularRestDayWorkHour`,3) AS `regularRestDayWorkHourRate`,ROUND(`dole`.`regularRestDayNightDiff`,3) AS `regularRestDayNightDiffRate`
	,ROUND(`dole`.`regularRestDayOTHour`,3) AS `regularRestDayOTHourRate`,ROUND(`dole`.`regularRestDayOTNightDiff`,3) AS `regularRestDayOTNightDiffRate`,ROUND(`dole`.`specialWorkHour`,3) AS `specialWorkHourRate`
	,ROUND(`dole`.`specialNightDiff`,3) AS `specialNightDiffRate`,ROUND(`dole`.`specialOTHour`,3) AS `specialOTHourRate`,ROUND(`dole`.`specialOTNightDiff`,3) AS `specialOTNightDiffRate`,ROUND(`dole`.`specialRestDayWorkHour`,3) AS `specialRestDayWorkHourRate`
	,ROUND(`dole`.`specialRestDayNightDiff`,3) AS `specialRestDayNightDiffRate`,ROUND(`dole`.`specialRestDayOTHour`,3) AS `specialRestDayOTHourRate`,ROUND(`dole`.`specialRestDayOTNightDiff`,3) AS `specialRestDayOTNightDiffRate`
	,ROUND(`dole`.`regularLegalWorkHour`,3) AS `regularLegalWorkHourRate`,ROUND(`dole`.`regularLegalNightDiff`,3) AS `regularLegalNightDiffRate`,ROUND(`dole`.`regularLegalOTHour`,3) AS `regularLegalOTHourRate`,ROUND(`dole`.`regularLegalOTNightDiff`,3) AS `regularLegalOTNightDiffRate`,ROUND(`dole`.`regularLegalRestDayWorkHour`,3) AS `regularLegalRestDayWorkHourRate`,ROUND(`dole`.`regularLegalRestDayNightDiff`,3) AS `regularLegalRestDayNightDiffRate`,ROUND(`dole`.`regularLegalRestDayOTHour`,3) AS `regularLegalRestDayOTHourRate`,ROUND(`dole`.`regularLegalRestDayOTNightDiff`,3) AS `regularLegalRestDayOTNightDiffRate`,ROUND(`dole`.`doubleWorkHour`,3) AS `doubleWorkHourRate`,ROUND(`dole`.`doubleNightDiff`,3) AS `doubleNightDiffRate`,ROUND(`dole`.`doubleOTHour`,3) AS `doubleOTHourRate`,ROUND(`dole`.`doubleOTNightDiff`,3) AS `doubleOTNightDiffRate`,ROUND(`dole`.`doubleRestDayWorkHour`,3) AS `doubleRestDayWorkHourRate`,ROUND(`dole`.`doubleRestDayNightDiff`,3) AS `doubleRestDayNightDiffRate`,ROUND(`dole`.`doubleRestDayOTHour`,3) AS `doubleRestDayOTHourRate`,ROUND(`dole`.`doubleRestDayOTNightDiff`,3) AS `doubleRestDayOTNightDiffRate` 
FROM (((`identity` `emp` JOIN `companysetting` `cs`) 
LEFT JOIN `employeemovement` `move` ON(`move`.`code` = `emp`.`code`)) 
LEFT JOIN `dole` ON(`dole`.`doleSetupCode` = `emp`.`doleSetup`))
$$ 
DELIMITER ;  


ALTER TABLE temporarydtr ADD COLUMN IF NOT EXISTS  `otType` VARCHAR(20) DEFAULT NULL;


DROP TABLE IF EXISTS v_convertedtemporarydtr;
DROP VIEW IF EXISTS v_convertedtemporarydtr;
DELIMITER $$ 
CREATE VIEW `v_convertedtemporarydtr` AS 

SELECT `dtr`.`payrollPeriod` AS `payrollPeriod`,`ppd`.`payrollPeriodMonths` AS `payrollPeriodMonth`,`ppd`.`payrollPeriodFrom` AS `payrollPeriodFrom`,`ppd`.`payrollPeriodTo` AS `payrollPeriodTo`,`dtr`.`batchId` AS `batchId`,`dtr`.`costCode` AS `costCode`,`dtr`.`department` AS `department`,`dtr`.`employeeCode` AS `employeeCode`,`dtr`.`employeeId` AS `employeeId`,`dtr`.`employeeName` AS `employeeName`,`dtr`.`date` AS `date`,`dtr`.`day` AS `day`,`dtr`.`schedIn` AS `schedIn`,`dtr`.`schedOut` AS `schedOut`,`dtr`.`scheduleName` AS `scheduleName`,`dtr`.`biometricsIn` AS `biometricsIn`,`dtr`.`biometricsOut` AS `biometricsOut`,`dtr`.`otType` AS `otType`,IF(IFNULL(`em`.`workOnHoliday`,0) = 1,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) <> 0 AND `dtr`.`leave` > 0) THEN `dtr`.`workHours` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`workHours` ELSE 0 END,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`workHours` ELSE 0 END) AS `regularWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `regularNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`overtime` ELSE 0 END AS `regularOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `regularRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiff` ELSE 0 END AS `regularRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `regularRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`em`.`rateType` = 'M' AND `dtr`.`totalHours` > 0 AND `dtr`.`overtime` = 0,`dtr`.`totalHours`,IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`)) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`totalHours` > 480,480,IF(`dtr`.`totalHours` < 0,0,`dtr`.`totalHours`)) ELSE 0 END AS `specialWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `specialNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `specialOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `specialOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `specialRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `specialRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `specialRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `specialRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`em`.`rateType` = 'M' AND `dtr`.`totalHours` > 0 AND `dtr`.`overtime` = 0,480,IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`)) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`totalHours` > 480,480,IF(`dtr`.`totalHours` < 0,0,`dtr`.`totalHours`)) ELSE 0 END AS `regularLegalWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END AS `regularLegalNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `regularLegalOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularLegalOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `regularLegalRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END AS `regularLegalRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `regularLegalRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularLegalRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,IF(`dtr`.`overtime` < 0,0,`dtr`.`overtime`)) ELSE 0 END AS `doubleWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `doubleNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `doubleOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `doubleOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `doubleRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `doubleRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `doubleRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `doubleRestDayOTNightDiff`,`dtr`.`late` AS `actualLate`,`dtr`.`undertime` AS `actualUndertime`,`lcon1`.`lateType` AS `lateType`,`lcon1`.`lateEquivalent` AS `lateEquivalent`,`ucon1`.`undertimeType` AS `undertimeType`,`ucon1`.`undertimeEquivalent` AS `undertimeEquivalent`,CASE `lcon1`.`lateType` WHEN 'Absent' THEN 0 WHEN 'Undertime' THEN 0 WHEN 'Late' THEN `lcon1`.`lateEquivalent` WHEN 'Absent with Late' THEN `dtr`.`late` - `lcon1`.`lateFrom` ELSE `dtr`.`late` END AS `late`,(CASE `lcon1`.`lateType` WHEN 'Absent' THEN `lcon1`.`lateEquivalent` WHEN 'Absent with Late' THEN `lcon1`.`lateEquivalent` ELSE 0 END) + (CASE `ucon1`.`undertimeType` WHEN 'Absent' THEN `ucon1`.`undertimeEquivalent` WHEN 'Absent with Undertime' THEN `ucon1`.`undertimeEquivalent` ELSE 0 END) + `dtr`.`absent` AS `absent`,`dtr`.`leave` AS `leave`,`dtr`.`lwop` AS `lwop`,(CASE `ucon1`.`undertimeType` WHEN 'Absent' THEN 0 WHEN 'Undertime' THEN `ucon1`.`undertimeEquivalent` WHEN 'Absent with Undertime' THEN `dtr`.`undertime` - `ucon1`.`undertimeFrom` ELSE `dtr`.`undertime` END) + (CASE `lcon1`.`lateType` WHEN 'Undertime' THEN `lcon1`.`lateEquivalent` ELSE 0 END) AS `undertime`,(CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) AS `nightDiff`,`dtr`.`overtime` AS `overtime`,`dtr`.`nightDiffOvertime` AS `nightDiffOvertime`,IFNULL(`dtr`.`holidayTagging`,0) AS `holidayTagging`,`dtr`.`workHours` AS `workHours`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 0 AND `dtr`.`overtime` = 0) THEN 0 ELSE `dtr`.`totalHours` END AS `totalHours`,`dtr`.`dateInactive` AS `dateInactive`,`dtr`.`finalPay` AS `finalPay`,IFNULL(`em`.`windowHours`,0) AS `windowHours`,`em`.`payrollConfigurationCode` AS `payrollConfigurationCode`,`em`.`doleSetup` AS `doleSetup`,`em`.`workSchedule` AS `workSchedule`,`em`.`scheduleCode` AS `scheduleCode`,`em`.`tempScheduleCode` AS `tempScheduleCode`,`em`.`location` AS `location`,`em`.`workOnHoliday` AS `workOnHoliday`,`em`.`requiredFiledOT` AS `requiredFiledOT`,`em`.`doleType` AS `doleType`,`em`.`payrollPeriodID` AS `payrollPeriodID`,`em`.`payrollPeriodType` AS `payrollPeriodType` 
FROM ((((((`temporarydtr` `dtr` 
LEFT JOIN `v_employeerate` `em` ON(`em`.`employeeCode` = `dtr`.`employeeCode` AND `dtr`.`date` BETWEEN `em`.`dateEffective` AND IFNULL(`em`.`dateEnd`,LAST_DAY(CURRENT_TIMESTAMP() + INTERVAL (12 - MONTH(CURRENT_TIMESTAMP())) MONTH)))) LEFT JOIN `payrollperioddetails` `ppd` ON(CONCAT(`ppd`.`code`,'-',`ppd`.`lineId`) = `dtr`.`payrollPeriod`)) LEFT JOIN `lateconversion` `lcon` ON(`lcon`.`lateConversionCode` = `em`.`lateConversionCode`)) LEFT JOIN `lateconversiondetails` `lcon1` ON(`lcon`.`code` = `lcon1`.`code` AND `dtr`.`late` BETWEEN `lcon1`.`lateFrom` AND `lcon1`.`lateTo`)) 
LEFT JOIN `undertimeconversion` `ucon` ON(`ucon`.`undertimeConversionCode` = `em`.`undertimeConversionCode`)) 
LEFT JOIN `undertimeconversiondetails` `ucon1` ON(`ucon`.`code` = `ucon1`.`code` AND `dtr`.`undertime` BETWEEN `ucon1`.`undertimeFrom` AND `ucon1`.`undertimeTo`))$$

DELIMITER ;




DROP TABLE IF EXISTS v_converted_temp_temporarydtr;
DROP VIEW IF EXISTS v_converted_temp_temporarydtr;
DELIMITER $$ 
CREATE VIEW `v_converted_temp_temporarydtr` AS 
SELECT `dtr`.`payrollPeriod` AS `payrollPeriod`,`ppd`.`payrollPeriodMonths` AS `payrollPeriodMonth`,`ppd`.`payrollPeriodFrom` AS `payrollPeriodFrom`,`ppd`.`payrollPeriodTo` AS `payrollPeriodTo`,`dtr`.`batchId` AS `batchId`,`dtr`.`costCode` AS `costCode`,`dtr`.`department` AS `department`,`dtr`.`employeeCode` AS `employeeCode`,`dtr`.`employeeId` AS `employeeId`,`dtr`.`employeeName` AS `employeeName`,`dtr`.`date` AS `date`,`dtr`.`day` AS `day`,`dtr`.`schedIn` AS `schedIn`,`dtr`.`schedOut` AS `schedOut`,`dtr`.`scheduleName` AS `scheduleName`,`dtr`.`biometricsIn` AS `biometricsIn`,`dtr`.`biometricsOut` AS `biometricsOut`,`dtr`.`otType` AS `otType`,IF(IFNULL(`payg`.`workOnHoliday`,0) = 1,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) <> 0 AND `dtr`.`leave` > 0) THEN `dtr`.`workHours` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`workHours` ELSE 0 END,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`workHours` ELSE 0 END) AS `regularWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `regularNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`overtime` ELSE 0 END AS `regularOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `regularRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiff` ELSE 0 END AS `regularRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `regularRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`em`.`rateType` = 'M' AND `dtr`.`totalHours` > 0 AND `dtr`.`overtime` = 0,`dtr`.`totalHours`,IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`)) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`totalHours` > 480,480,IF(`dtr`.`totalHours` < 0,0,`dtr`.`totalHours`)) ELSE 0 END AS `specialWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `specialNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `specialOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `specialOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `specialRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `specialRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `specialRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `specialRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`em`.`rateType` = 'M' AND `dtr`.`totalHours` > 0 AND `dtr`.`overtime` = 0,480,IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`)) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`totalHours` > 480,480,IF(`dtr`.`totalHours` < 0,0,`dtr`.`totalHours`)) ELSE 0 END AS `regularLegalWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END AS `regularLegalNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `regularLegalOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularLegalOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `regularLegalRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END AS `regularLegalRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `regularLegalRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `regularLegalRestDayOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,IF(`dtr`.`overtime` < 0,0,`dtr`.`overtime`)) ELSE 0 END AS `doubleWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `doubleNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%HOLIDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`overtime` ELSE 0 END AS `doubleOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `doubleOTNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` > 480,480,`dtr`.`overtime`) ELSE 0 END AS `doubleRestDayWorkHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END AS `doubleRestDayNightDiff`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`overtime` - 480 > 0,`dtr`.`overtime` - 480,0) ELSE 0 END AS `doubleRestDayOTHour`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END AS `doubleRestDayOTNightDiff`,`dtr`.`late` AS `actualLate`,`dtr`.`undertime` AS `actualUndertime`,`lcon1`.`lateType` AS `lateType`,`lcon1`.`lateEquivalent` AS `lateEquivalent`,`ucon1`.`undertimeType` AS `undertimeType`,`ucon1`.`undertimeEquivalent` AS `undertimeEquivalent`,CASE `lcon1`.`lateType` WHEN 'Absent' THEN 0 WHEN 'Undertime' THEN 0 WHEN 'Late' THEN `lcon1`.`lateEquivalent` WHEN 'Absent with Late' THEN `dtr`.`late` - `lcon1`.`lateFrom` ELSE `dtr`.`late` END AS `late`,(CASE `lcon1`.`lateType` WHEN 'Absent' THEN `lcon1`.`lateEquivalent` WHEN 'Absent with Late' THEN `lcon1`.`lateEquivalent` ELSE 0 END) + (CASE `ucon1`.`undertimeType` WHEN 'Absent' THEN `ucon1`.`undertimeEquivalent` WHEN 'Absent with Undertime' THEN `ucon1`.`undertimeEquivalent` ELSE 0 END) + `dtr`.`absent` AS `absent`,`dtr`.`leave` AS `leave`,`dtr`.`lwop` AS `lwop`,(CASE `ucon1`.`undertimeType` WHEN 'Absent' THEN 0 WHEN 'Undertime' THEN `ucon1`.`undertimeEquivalent` WHEN 'Absent with Undertime' THEN `dtr`.`undertime` - `ucon1`.`undertimeFrom` ELSE `dtr`.`undertime` END) + (CASE `lcon1`.`lateType` WHEN 'Undertime' THEN `lcon1`.`lateEquivalent` ELSE 0 END) AS `undertime`,(CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND `dtr`.`otType` = 'SOT') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 0 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%' AND IFNULL(`dtr`.`otType`,'OT') NOT IN ('SOT','EXT')) THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 30 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN IF(`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime` > 0,`dtr`.`nightDiff` - `dtr`.`nightDiffOvertime`,`dtr`.`nightDiffOvertime` - `dtr`.`nightDiff`) ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) = 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`)  NOT LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiff` ELSE 0 END) + (CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 100 AND UCASE(`dtr`.`scheduleName`) LIKE '%RESTDAY%') THEN `dtr`.`nightDiffOvertime` ELSE 0 END) AS `nightDiff`,`dtr`.`overtime` AS `overtime`,`dtr`.`nightDiffOvertime` AS `nightDiffOvertime`,IFNULL(`dtr`.`holidayTagging`,0) AS `holidayTagging`,`dtr`.`workHours` AS `workHours`,CASE WHEN (IFNULL(`dtr`.`holidayTagging`,0) > 0 AND `dtr`.`overtime` = 0) THEN 0 ELSE `dtr`.`totalHours` END AS `totalHours`,`dtr`.`dateInactive` AS `dateInactive`,`dtr`.`finalPay` AS `finalPay`,IFNULL(`payg`.`windowHours`,0) AS `windowHours` 
FROM ((((((((`temp_temporarydtr` `dtr` LEFT JOIN `v_employeerate` `em` ON(`em`.`employeeCode` = `dtr`.`employeeCode` AND `dtr`.`date` BETWEEN `em`.`dateEffective` AND IFNULL(`em`.`dateEnd`,LAST_DAY(CURRENT_TIMESTAMP() + INTERVAL (12 - MONTH(CURRENT_TIMESTAMP())) MONTH)))) LEFT JOIN `payrollgroup` `payg` ON(`payg`.`payrollGroupCode` = `dtr`.`batchId`)) LEFT JOIN `payrollconfiguration` `pc` ON(`pc`.`payrollConfigurationCode` = `payg`.`payrollConfigurationCode`)) LEFT JOIN `payrollperioddetails` `ppd` ON(CONCAT(`ppd`.`code`,'-',`ppd`.`lineId`) = `dtr`.`payrollPeriod`)) LEFT JOIN `lateconversion` `lcon` ON(`lcon`.`lateConversionCode` = `payg`.`lateConversionCode`)) LEFT JOIN `lateconversiondetails` `lcon1` ON(`lcon`.`code` = `lcon1`.`code` AND `dtr`.`late` BETWEEN `lcon1`.`lateFrom` AND `lcon1`.`lateTo`)) LEFT JOIN `undertimeconversion` `ucon` ON(`ucon`.`undertimeConversionCode` = `payg`.`undertimeConversionCode`)) LEFT JOIN `undertimeconversiondetails` `ucon1` ON(`ucon`.`code` = `ucon1`.`code` AND `dtr`.`undertime` BETWEEN `ucon1`.`undertimeFrom` AND `ucon1`.`undertimeTo`))
-- FROM ((((((((`temporarydtr` `dtr` LEFT JOIN `v_employeerate` `em` ON(`em`.`employeeCode` = `dtr`.`employeeCode` AND `dtr`.`date` BETWEEN `em`.`dateEffective` AND IFNULL(`em`.`dateEnd`,LAST_DAY(CURRENT_TIMESTAMP() + INTERVAL (12 - MONTH(CURRENT_TIMESTAMP())) MONTH)))) LEFT JOIN `payrollgroup` `payg` ON(`payg`.`payrollGroupCode` = `dtr`.`batchId`)) LEFT JOIN `payrollconfiguration` `pc` ON(`pc`.`payrollConfigurationCode` = `payg`.`payrollConfigurationCode`)) LEFT JOIN `payrollperioddetails` `ppd` ON(CONCAT(`ppd`.`code`,'-',`ppd`.`lineId`) = `dtr`.`payrollPeriod`)) LEFT JOIN `lateconversion` `lcon` ON(`lcon`.`lateConversionCode` = `payg`.`lateConversionCode`)) LEFT JOIN `lateconversiondetails` `lcon1` ON(`lcon`.`code` = `lcon1`.`code` AND `dtr`.`late` BETWEEN `lcon1`.`lateFrom` AND `lcon1`.`lateTo`)) LEFT JOIN `undertimeconversion` `ucon` ON(`ucon`.`undertimeConversionCode` = `payg`.`undertimeConversionCode`)) LEFT JOIN `undertimeconversiondetails` `ucon1` ON(`ucon`.`code` = `ucon1`.`code` AND `dtr`.`undertime` BETWEEN `ucon1`.`undertimeFrom` AND `ucon1`.`undertimeTo`))
$$
DELIMITER ;


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
IN r_attachedFiles LONGTEXT, 
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
 
 
SET @app_type = 'officialbusiness';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(r_days_df,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT (CASE WHEN exception_filing_allowed=1 THEN 2 ELSE 1 END) FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET num = 1;
	SET msg = CONCAT('{
			"id":"lblfileInput",
			"msg":"This application is outside the standard filling period. Please provide a reason and supporting document for exception approval"	
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

SET @app_type = 'officialbusiness';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(r_days_df,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
		    END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_ob_from_date'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
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
 
 
SET @app_type = 'officialbusiness';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(r_inout_date,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
		    END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_txtDate'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
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
SET @fullname =(SELECT (CONCAT(IFNULL(firstname,''),' ',IFNULL(middlename,''),' ',IFNULL(lastname,''))) FROM identity WHERE identityid=emp_id); 
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
	    obTimeFrom=IFNULL(r_inout_time,'NA'),
	    obTime=IFNULL(r_inout_time,'NA')
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
		IFNULL(r_inout_time,'NA'),
		IFNULL(r_inout_time,'NA'),
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
DELETE FROM requestattachments WHERE appNo = r_id AND document='officialbusiness'; 

IF (JSON_LENGTH(@uploadedFiles)>0) THEN
	INSERT INTO requestattachments (appNo,document,files)
	VALUES (r_id,@app_type,@uploadedFiles);
END IF;


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



DROP PROCEDURE IF EXISTS sp_get_default_mailer;
DELIMITER $$  
CREATE PROCEDURE sp_get_default_mailer
(  
IN pint_mode INT, 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';



SELECT * FROM app_default_mailer;



END $$ 
DELIMITER ;


-- CALL sp_app_user_info(0,1,5,@num,@msg);
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_app_user_info`$$  
CREATE PROCEDURE `sp_app_user_info`(  
IN pint_mode INT,
IN r_appNo INT,
IN switch INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch);
SET @identityId =(SELECT MIN(id) FROM approval WHERE appNo=r_appNo AND document=@document);
SET @appDate = '';

IF (switch=0) THEN -- overtime
	SET @appDate = (SELECT otAppDate FROM overtimeform WHERE otAppNo=r_appNo);
END IF;

IF (switch=1) THEN -- leave
	SET @appDate = (SELECT laAppDate FROM leaveapplicationform WHERE laAppNo=r_appNo);
END IF;

IF (switch=2) THEN -- Time Adjustment
	SET @appDate = (SELECT taAppDate FROM timeadjustmentform WHERE taAppNo=r_appNo);
END IF;

IF (switch=3) THEN -- Official Business
	SET @appDate = (SELECT obAppDate FROM officialbusinessform WHERE obAppNo=r_appNo);
END IF;

IF (switch=4) THEN -- Offset
	SET @appDate = (SELECT osAppDate FROM offsetform WHERE osAppNo=r_appNo);
END IF;

IF (switch=5) THEN -- Time Entry
	SET @appDate = (SELECT teAppDate FROM timeentryform WHERE teAppNo=r_appNo);
END IF;

IF (switch=6) THEN -- Change Schedule
	SET @appDate = (SELECT scAppDate FROM schedulechange WHERE scAppNo=r_appNo);
END IF;

IF (switch=7) THEN -- HDR Certificate
	SET @appDate = (SELECT requestDate FROM hrdcertificate WHERE appNo=r_appNo);
END IF;

-- SELECT * FROM documentMaster
-- SELECT * FROM `hrdcertificate` WHERE appNo=r_appNo AND document=@document;

SELECT CONCAT(idy.firstName,' ',idy.lastName) AS 'fullName', 
	idy.`emailAddress`, 
	idy.`identityId`,
	@appDate AS appDate
FROM identity idy
WHERE idy.identityId=@identityId;



END$$
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_selected_items_response`$$ 
CREATE DEFINER=`root`@`%` PROCEDURE `sp_selected_items_response`(
IN r_database VARCHAR(100),
IN pint_mode INT,
IN user_id VARCHAR(30),
IN switch INT,
IN r_code VARCHAR(5),
IN items LONGTEXT,
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start: BEGIN
DECLARE i INT DEFAULT 1;
DECLARE loop_count INT DEFAULT 0;
DECLARE thisAppNo INT DEFAULT 0;
DECLARE val INT DEFAULT 0;
DECLARE thisRemarks VARCHAR(100) DEFAULT '';
DECLARE appNos LONGTEXT DEFAULT '';
DECLARE errorMessage TEXT DEFAULT '';
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
GET DIAGNOSTICS CONDITION 1 errorMessage = MESSAGE_TEXT;
ROLLBACK;
SET num = 1;
SET msg = errorMessage;
END;
SET num = 0;
SET msg = '';
/* Validate source database */
IF r_database IS NULL
OR TRIM(r_database) = ''
OR r_database NOT REGEXP '^[A-Za-z0-9_]+$'
THEN
SET num = 1;
SET msg = 'Invalid or missing source database.';
LEAVE proc_start;
END IF;
/* Check whether the database exists */
IF NOT EXISTS (
SELECT 1
FROM information_schema.schemata
WHERE schema_name = r_database
) THEN
SET num = 1;
SET msg = CONCAT(
'Source database does not exist: ',
r_database
);
LEAVE proc_start;
END IF;
/* Validate JSON */
IF items IS NULL
OR JSON_VALID(items) = 0
OR JSON_LENGTH(items) = 0
THEN
SET num = 1;
SET msg = 'No valid applications were selected.';
LEAVE proc_start;
END IF;
DROP TEMPORARY TABLE IF EXISTS tmpJson;
CREATE TEMPORARY TABLE tmpJson (
rowNo INT NOT NULL AUTO_INCREMENT,
appNo INT NOT NULL,
remarks VARCHAR(100) NULL,
PRIMARY KEY (rowNo)
);
INSERT INTO tmpJson (
appNo,
remarks
)
SELECT
CAST(
JSON_UNQUOTE(
JSON_EXTRACT(
    items,
    CONCAT('$[', n.n, '].AppNo')
)
) AS UNSIGNED
) AS appNo,
NULLIF(
JSON_UNQUOTE(
JSON_EXTRACT(
    items,
    CONCAT('$[', n.n, '].remarks')
)
),
'null'
) AS remarks
FROM v_1krows n
WHERE n.n < JSON_LENGTH(items)
AND JSON_UNQUOTE(
JSON_EXTRACT(
items,
CONCAT('$[', n.n, '].AppNo')
)
) IS NOT NULL;
SET loop_count = (
SELECT COUNT(*)
FROM tmpJson
);
IF loop_count = 0 THEN
SET num = 1;
SET msg = 'No valid application numbers were selected.';
DROP TEMPORARY TABLE IF EXISTS tmpJson;
LEAVE proc_start;
END IF;
SET appNos = (
SELECT IFNULL(
GROUP_CONCAT(
appNo
ORDER BY rowNo
SEPARATOR ','
),
''
)
FROM tmpJson
);
SET val = CASE
WHEN r_code IN ('A', '1') THEN 1
WHEN r_code IN ('D', '0') THEN 0
ELSE NULL
END;
IF val IS NULL THEN
SET num = 1;
SET msg = CONCAT(
'Invalid approval response code: ',
IFNULL(r_code, '')
);
DROP TEMPORARY TABLE IF EXISTS tmpJson;
LEAVE proc_start;
END IF;

-- REMOVE THIS
SET num = 0; SET msg = 'OK'; LEAVE proc_start;

START TRANSACTION;
simple_loop: LOOP
SELECT
appNo,
IFNULL(remarks, '')
INTO
thisAppNo,
thisRemarks
FROM tmpJson
WHERE rowNo = i;
/*
* r_database is passed to the child procedure so it updates
* the application inside its actual source database.
*
* Expected sp_for_approval_response parameter order:
*
* 1. r_database
* 2. pint_mode
* 3. switch
* 4. r_id
* 5. user_id
* 6. val
* 7. r_remarks
* 8. OUT num
* 9. OUT msg
*/
CALL sp_for_approval_response(
r_database,
1,
switch,
thisAppNo,
user_id,
val,
thisRemarks,
@responseNum,
@responseMsg
);
/* Stop the whole batch if one application fails */
IF IFNULL(@responseNum, 1) <> 0 THEN
ROLLBACK;
SET num = @responseNum;
SET msg = CONCAT(
'Application No. ',
thisAppNo,
' failed: ',
IFNULL(@responseMsg, 'Unknown error')
);
DROP TEMPORARY TABLE IF EXISTS tmpJson;
LEAVE proc_start;
END IF;
SET i = i + 1;
IF i > loop_count THEN
LEAVE simple_loop;
END IF;
END LOOP simple_loop;
COMMIT;
SET num = 0;
SET msg = CONCAT(
'Applications Nos. [',
appNos,
'] have been successfully ',
CASE
WHEN val = 1 THEN 'approved.'
ELSE 'rejected.'
END
);
DROP TEMPORARY TABLE IF EXISTS tmpJson;
END$$
DELIMITER ;






DROP PROCEDURE IF EXISTS sp_approval_get_authorizer; 
-- CALL sp_approval_get_authorizer(0, 3, '0601200035',6,0,@num,@msg);
DELIMITER $$  
CREATE PROCEDURE sp_approval_get_authorizer
(  
IN pint_mode INT,
IN r_num INT,	 
IN user_id VARCHAR(30),  
IN switch INT, 
IN r_appNo INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch); 

DROP TEMPORARY TABLE IF EXISTS temp_approvers;
CREATE TEMPORARY TABLE temp_approvers AS (
	SELECT	auth.`lineId`, 
		CONCAT(idy.firstName,' ',idy.lastName) AS 'authorizer', 
		idy.`emailAddress`, 
		idy.`identityId`,
		stgs.stageName,
		tmplts.`leave`,tmplts.`dtr`,tmplts.`hrdCert`,tmplts.`nonmonetized`,tmplts.`officialBusiness`,
		tmplts.`offsetTime`,tmplts.`overtime`,tmplts.`scheduleChange`,tmplts.`scheduleTagging`,tmplts.`timeAdjustment`,tmplts.`timeEntry` 
	FROM approvaltemplateoriginator  
	LEFT JOIN approvaltemplatestages ON  approvaltemplateoriginator.code = approvaltemplatestages.code 
	LEFT JOIN approvalstages stgs ON approvaltemplatestages.`stageCode`=stgs.stageCode
	LEFT JOIN approvalstagedetails auth ON stgs.code=auth.code
	LEFT JOIN approvaltemplates tmplts ON approvaltemplatestages.`code`=tmplts.code
	LEFT JOIN `identity` idy ON auth.`id` = idy.`identityId`
	WHERE approvaltemplateoriginator.id=user_id
		AND approvaltemplatestages.`lineId`=r_num 
);



-- SELECT * FROM documentMaster
SET @templateCode=(SELECT templateCode FROM approval WHERE appNo=r_appNo AND id=user_id AND document=@document AND templateLineId=r_num);
SET @stageCode=(SELECT stageCode FROM approvaltemplatestages WHERE `code`=@templateCode AND lineId=(r_num-1));
SET @stageName=(SELECT stageName FROM approvalstages WHERE stageCode=@stageCode);


	SELECT lineId,authorizer,emailAddress,identityId,stageName,IFNULL(@stageName,'Unknown') AS PrevstageName
	FROM temp_approvers
	WHERE (CASE 
	WHEN switch=0 THEN overtime
	WHEN switch=1 THEN `leave`
	WHEN switch=2 THEN timeAdjustment
	WHEN switch=3 THEN officialBusiness
	WHEN switch=4 THEN offsetTime
	WHEN switch=5 THEN timeEntry
	-- WHEN switch=6 THEN scheduleChange
	WHEN switch=6 THEN scheduleTagging
	WHEN switch=7 THEN hrdCert 
	END) IS NOT NULL;
	
	
	


END $$ 
DELIMITER ;


-- CALL sp_get_next_authorizer(0,5,2,@num,@msg);
DROP PROCEDURE IF EXISTS sp_get_next_authorizer; 
DELIMITER $$  
CREATE PROCEDURE sp_get_next_authorizer
(  
IN pint_mode INT,
IN switch INT,	 
IN rAppNo VARCHAR(30),    
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

-- SELECT * FROM documentMaster
SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch); 
SET @ID = (SELECT MIN(ID) FROM approval WHERE appNo=rAppNo AND document=@document);
SET @lineID = (SELECT MIN(templateLineId) FROM approval WHERE appNo=rAppNo AND document=@document AND decision='F');



	CALL sp_approval_get_authorizer(0,@lineID,@ID,switch,rAppNo,@num ,@msg);   
	

END $$ 
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
IN r_attachedFiles LONGTEXT, 
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
	


SET @app_type = 'timeentry';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(r_teDate,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_tedate'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
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


SET @fullname=(SELECT (CONCAT(IFNULL(firstname,''),' ',IFNULL(middlename,''),' ',IFNULL(lastname,''))) FROM identity WHERE identityid=r_ID); 
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
	DELETE FROM requestattachments WHERE appNo = r_teAppNo AND document='timeentry'; 
	
	
	SET @maxAppNo = IFNULL((SELECT MAX(teAppNo) FROM timeentryform WHERE teID=r_ID),0); 
	SET msg = (CASE WHEN r_teAppNo=0 THEN CONCAT('New time entry Request has been successfully sent with application No.',@maxAppNo) ELSE CONCAT('Time entry application No.',@maxAppNo,' has been successfully Re-Sent') END);
	SET r_teAppNo =(CASE WHEN r_teAppNo=0 THEN @maxAppNo ELSE r_teAppNo END); 
	
	
	IF (JSON_LENGTH(@uploadedFiles)>0) THEN
		INSERT INTO requestattachments (appNo,document,files)
		VALUES (@maxAppNo,@app_type,@uploadedFiles);
	END IF;



	
	CALL sp_approval_insert(5,r_teAppNo,r_ID,@num1, @msg1); 
	SET msg = @maxAppNo; 
	-- SET msg = ((SELECT CONCAT('Time Entry Request has been successfully sent with application No.',@maxAppNo))); 
	COMMIT;
END IF;	 	
END$$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_get_employee_schedules;
DELIMITER $$  
CREATE PROCEDURE sp_get_employee_schedules
(  
IN pint_mode INT,
IN r_identityId VARCHAR(30), 
IN df VARCHAR(30), 
IN dt VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Successss';




SET df=(CASE WHEN df='' THEN DATE(NOW()) ELSE df END);
SET dt=(CASE WHEN dt='' THEN DATE(NOW()) ELSE dt END);




SELECT  employeedailyschedule.`day`, 
	employeedailyschedule.`employeeId`, 
	CONCAT(idy.`lastName`, ' ', idy.`firstName`, ' ', IFNULL(idy.`middleName`,'')) AS 'employeeName', 
	schedules.`scheduleName`

	FROM employeedailyschedule

	LEFT JOIN identity idy ON idy.`identityId` = employeedailyschedule.employeeId

	LEFT JOIN approvaltemplateoriginator ON
	approvaltemplateoriginator.id = employeedailyschedule.employeeId

	LEFT JOIN schedules ON employeedailyschedule.schedule = schedules.code

	LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code

	LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode

	LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code

	WHERE approvalstagedetails.id = r_identityId  AND employeedailyschedule.`day` BETWEEN df AND dt
	-- WHERE approvalstagedetails.id = '0601200109'    AND employeedailyschedule.`day` BETWEEN '2020-01-21' AND '2020-01-21'
		
	GROUP BY schedules.`scheduleName`, employeedailyschedule.`employeeId`, employeedailyschedule.`day`
	ORDER BY employeedailyschedule.`day` ASC
	;


END $$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_emp_ytd_tax_years; 
DELIMITER $$  
CREATE PROCEDURE sp_emp_ytd_tax_years
(  
IN pint_mode INT,    
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 

SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN

	SELECT DISTINCT payrollPeriodYear AS `taxYear` 
	FROM employeepayslip
	WHERE payrollPeriodYear IS NOT NULL 
	ORDER BY payrollPeriodYear DESC;
END IF;

END $$
DELIMITER ;


-- CALL sp_overtime_submit_request(0,0,'0601200014','','L','CEB','2026-03-14','2026-03-14','2026-03-14','00:00','07:30','15:30','00:00',@num,@msg); SELECT @msg;
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

IF (@ot_ExtAllowance=1) THEN
	
	SET @ot_ExtAllowanceDetails = (SELECT JSON_UNQUOTE(ot_ExtAllowanceDetails));
	SET @regSched = IFNULL(JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.regSched')),'');

	IF ( @regSched IN ('','null')) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lblregSched",
			"msg":"No DTR Found!"	
			}');
		LEAVE proc_start;
	END IF;

	SET ot_time_from = (LEFT(DATE_FORMAT( STR_TO_DATE(ot_time_from, '%h:%i:%s %p'),  '%H:%i:%s'),5)); 
	SET ot_time_to = (LEFT(DATE_FORMAT( STR_TO_DATE(ot_time_to, '%h:%i:%s %p'),  '%H:%i:%s'),5)); 

END IF; 

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
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 AND @ot_ExtAllowance=0) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_ot_date'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
			}');  
	LEAVE proc_start;
END IF;


IF (@filingDateValidation='INVALID' AND @otExtAllowanceFile='' AND @ot_ExtAllowance=1) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_otWorkDate'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
			}');  
	LEAVE proc_start;
END IF;


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
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.totalTime'))
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.otTotal'))
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.totalAllowance'))
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentFileName'))
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentContent'))
		,JSON_UNQUOTE(JSON_EXTRACT(@ot_ExtAllowanceDetails,'$.attachmentFilType'))
		INTO @regSched,@actTimeIn,@actTimeOut,@totalTime,@otTotal,@totalAllowance,@attachmentFileName,@attachmentContent,@attachmentFilType
		;
	
	
	IF (CAST(@totalAllowance AS FLOAT) < 250) THEN
		SET num = 1;
		SET msg = CONCAT('{
			"id":"lbltxtTotalAllowance",
			"msg":"Invalid allowance total. total time atleast 3 hours ',@totalAllowance,'"
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
		
		INSERT INTO overtimeExtensionAllowance (otAppNo,regSched,actTimeIn,actTimeOut,totalTime,otTotal,totalAllowance,attachmentFileName,attachmentContent,attachmentFilType)
		VALUES (ot_AppNo,@regSched,@actTimeIn,@actTimeOut,@totalTime,@otTotal,@totalAllowance,@attachmentFileName,@attachmentContent,@attachmentFilType);
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




DROP PROCEDURE IF EXISTS sp_check_application_if_exists; 
DELIMITER $$  
CREATE PROCEDURE sp_check_application_if_exists
( 
IN pint_mode INT,	
IN switch INT, 
IN JsonDetails JSON, 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 

-- LEAVE proc_start;
SET num = 0;
SET msg = '';

SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch); 

/*
TRUNCATE TABLE json_tbl;	
INSERT INTO json_tbl (json_data)
VALUES (JsonDetails);   


-- SELECT * FROM documentMaster 
*/

IF (@document='overtime') THEN
	
	SET @appNo = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.appNo')));
	SET @otID = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otID')));
	SET @otDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otDate')));
	SET @otFrDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otFrDate')));
	SET @otToDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otToDate'))); 
	SET @otFrDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otFrDate')));
	SET @otToDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.otToDate'))); 
	SET @fromTime = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.fromTime')));
	SET @toTime = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.toTime'))); 
	
	
	-- SELECT * FROM overtimeform WHERE otID='0601200128' AND otAppDate='2025-04-16'
	SET msg =(
		SELECT CONCAT('Sorry, you already submitted same overtime application details on ',otAppDate,'. kindly check your request or history. thank you!')
		FROM overtimeform
		WHERE otID=@otID 
			AND otDate=@otDate 
			AND otFrDate=@otFrDate 
			AND otToDate=@otToDate
			AND otTimeFrom=@fromTime
			AND otTimeTo=@toTime
			AND otStatus NOT IN ('C','D')
			AND otAppNo<>@appNo
		LIMIT 1
		);
	SET num = (CASE WHEN msg<>'' THEN 1 ELSE 0 END);
	
	LEAVE proc_start;
END IF;	



IF (@document='timeadjustment') THEN
	
	SET @taType = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.taType')));
	SET @taID = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.taID')));
	SET @taDate = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.taDate')));
	SET @taTime = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.taTime'))); 
	SET @appNo = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.appNo'))); 
	
	-- SELECT * FROM timeadjustmentform 
	-- SELECT @taID,@taDate,@taTime,JsonDetails;
	
	SET msg =(
		SELECT CONCAT('Sorry, you already submitted same time adjustment application details on ',taAppDate,'. kindly check your request or history. thank you!')
		FROM timeadjustmentform
		WHERE taID=@taID 
			AND taType=@taType 
			AND taDate=@taDate 
			AND taTime=@taTime  
			AND taStatus NOT IN ('C')
			AND taAppNo<>@appNo
		LIMIT 1
		);
	
	SET num = (CASE WHEN msg<>'' THEN 1 ELSE 0 END); 
	LEAVE proc_start;
END IF;


IF (pint_mode=1 AND @document='officialbusiness') THEN  -- IN/OUT

	SET @obID = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.obID')));
	SET @obType = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.obType')));
	SET @obDateFrom = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.obDateFrom')));
	SET @obDateTo = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.obDateTo'))); 
	SET @obTimeFrom = (SELECT JSON_UNQUOTE(JSON_EXTRACT(JsonDetails, '$.obTimeFrom'))); 
	
	
	-- SELECT @obID,@obType,@obDateFrom,@obDateTo,@obTimeFrom;
	SET msg =(
	SELECT CONCAT('Sorry, you already submitted same official business details on ',obAppDate,'. kindly check your request or history. thank you!') 
	FROM officialbusinessform 
	WHERE obID=@obID
		AND obType = @obType
		AND obDateFrom=@obDateFrom
		AND obDateTo=@obDateTo
		AND obTimeFrom=@obTimeFrom
		AND obStatus NOT IN ('P','C')
	LIMIT 1
	);
	
	SET num = (CASE WHEN msg<>'' THEN 1 ELSE 0 END); 
	
	LEAVE proc_start;
END IF;


IF (pint_mode=0 AND @document='officialbusiness') THEN  -- DAYS 
	
	SET @json_data =  JsonDetails; 
	DROP TEMPORARY TABLE IF EXISTS temp_table;  
	CREATE TEMPORARY TABLE temp_table AS (
	SELECT *
	FROM(
		SELECT   
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].id'))) AS id,
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstAppNo'))) AS obLstAppNo, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstDate'))) AS obLstDate, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstTimeFrom'))) AS obLstTimeFrom, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstTimeTo'))) AS obLstTimeTo, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstTotHours'))) AS obLstTotHours, 
			-- JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLstID'))) AS obLstID, 
			(n.n+1) AS obLstID, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].obLocation'))) AS obLocation, 
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].location'))) AS location,
			JSON_UNQUOTE(JSON_EXTRACT(@json_data, CONCAT('$[', n.n, '].locationName'))) AS locationName 
		FROM 
			(SELECT * FROM v_1krows) n
		WHERE 
			n.n < JSON_LENGTH(@json_data)
		)t1
	);
	
	SET msg =(	
		SELECT CONCAT('Sorry, official business date ',t1.obLstDate,' [',DAYNAME(t1.obLstDate),'] with time in from:',t1.obLstTimeFrom,' to ',t1.obLstTimeTo,' is already exists. kinly check your request or history!')  
		FROM temp_table t1
		LEFT JOIN officialbusinesslist t2 ON t1.id=t2.`id`
						AND t1.obLstDate=t2.`obLstDate`
						AND t1.obLstTimeFrom=t2.obLstTimeFrom
						AND t1.obLstTimeTo=t2.obLstTimeTo
			LEFT JOIN officialbusinessform t3 ON t2.obLstAppNo=t3.obAppNo AND t3.obStatus NOT IN ('P','C')
		WHERE t2.id IS NOT NULL AND t3.obAppNo IS NOT NULL
		LIMIT 1
		);
		SET num = (CASE WHEN msg<>'' THEN 1 ELSE 0 END); 
	
	LEAVE proc_start;
END IF;

END $$ 
DELIMITER ; 



DROP FUNCTION IF EXISTS fn_ot_total_time_compute; 
DELIMITER $$  
CREATE FUNCTION fn_ot_total_time_compute (dateFrom VARCHAR(30),dateTo VARCHAR(30),timeIn  VARCHAR(5),timeOut  VARCHAR(5),totalBreak VARCHAR(5))
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
DECLARE result VARCHAR(30) DEFAULT '00:00';

IF (
dateFrom='' 
OR dateTo='' 
OR timeIn='' 
OR timeOut='' 
OR totalBreak=''
) THEN

RETURN result;

END IF;



SET result=(SELECT 
CONCAT(
	FLOOR(TIMESTAMPDIFF(MINUTE, 
	CONCAT(dateFrom, ' ',timeIn), 
	CONCAT(dateTo, ' ', timeOut)
	) / 60), ':', 
	LPAD(TIMESTAMPDIFF(MINUTE, 
	CONCAT(dateFrom, ' ', timeIn), 
	CONCAT(dateTo, ' ', timeOut)
	) % 60, 2, '0')
));

SET result = (SELECT SEC_TO_TIME(TIME_TO_SEC(result) - TIME_TO_SEC(totalBreak)));

RETURN LEFT(result,5);

END$$ 
DELIMITER ;

DROP FUNCTION IF EXISTS fn_time_5_strings; 
DELIMITER $$  
CREATE FUNCTION fn_time_5_strings (timeFormat VARCHAR(5))
RETURNS INT
DETERMINISTIC
BEGIN
	DECLARE result INT DEFAULT 0;

	
	
	SET result=IFNULL((SELECT 1 FROM timeMaster WHERE time_slot = timeFormat),0);
	
	RETURN result;

END$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_delete_application_form; 
DELIMITER $$  
CREATE PROCEDURE sp_delete_application_form
( 
IN pint_mode INT,
IN switch_no INT,
IN r_appNo INT, 
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
SET msg = '';

-- SELECT * FROM documentMaster
SET @facility = 'Unknown';

START TRANSACTION; 

IF (switch_no=1) THEN /*LEAVE*/ 
	SET @facility = 'Leave application';
	UPDATE leaveapplicationform SET laStatus='C' WHERE laAppNo=r_appNo;
	UPDATE approval SET decision='C' WHERE appNo=r_appNo AND document='leave';
	
	
	SET @EmpID = (SELECT laID FROM leaveapplicationform WHERE laAppNo=r_appNo);
	SET @laType = (SELECT laType FROM leaveapplicationform WHERE laAppNo=r_appNo);
	SET @laTotalDays=(SELECT laTotalDays FROM leaveapplicationform WHERE laAppNo=r_appNo); 

	SET @code =(SELECT `code` FROM identity WHERE identityID=@EmpID);  
	UPDATE employeeleavebalances SET currentBalance=currentBalance+@laTotalDays WHERE `code`=@code AND leaveCode=@laType;
	UPDATE   leaveapplicationform SET laStatus='C' WHERE laAppNo=r_appNo;
	
END IF;


IF (switch_no=4) THEN /*OFFSET*/ 
	SET @facility = 'Offset application';
	UPDATE offsetform SET osStatus='C' WHERE osAppNo=r_appNo;
	UPDATE approval SET decision='C' WHERE appNo=r_appNo AND document='offset';
	
END IF;

IF (switch_no=6) THEN /*SCHEDULE*/ 
	SET @facility = 'Schedule application';
	UPDATE schedulechange SET scStatus='C' WHERE scAppNo=r_appNo;
	UPDATE approval SET decision='C' WHERE appNo=r_appNo AND document='schedulechange';
	
END IF;


IF (switch_no=7) THEN /*HDR Certificate*/ 
	SET @facility = 'HDR Certificate application';
	UPDATE hrdcertificate SET `status`='C' WHERE appNo=r_appNo;
	UPDATE approval SET decision='C' WHERE appNo=r_appNo AND document='hrdcert';
	
END IF; 

SET msg=CONCAT(@facility,' No.',r_appNo,' has been successfully canceled');

COMMIT;

END $$
DELIMITER ; 


DROP PROCEDURE IF EXISTS sp_time_adj_get_submit_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_time_adj_get_submit_request
(  
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


DROP FUNCTION IF EXISTS time_ago;
DELIMITER $$ 
CREATE FUNCTION time_ago(p_datetime DATETIME)
RETURNS VARCHAR(50)
DETERMINISTIC
BEGIN
DECLARE v_seconds INT;
DECLARE v_minutes INT;
DECLARE v_hours INT;
DECLARE v_days INT;
DECLARE v_months INT;
DECLARE v_years INT;

SET v_seconds = TIMESTAMPDIFF(SECOND, p_datetime, NOW());
IF v_seconds < 60 THEN
	RETURN CONCAT(v_seconds, ' second', IF(v_seconds = 1, '', 's'), ' ago');
END IF;

SET v_minutes = TIMESTAMPDIFF(MINUTE, p_datetime, NOW());
IF v_minutes < 60 THEN
	RETURN CONCAT(v_minutes, ' minute', IF(v_minutes = 1, '', 's'), ' ago');
END IF;

SET v_hours = TIMESTAMPDIFF(HOUR, p_datetime, NOW());
IF v_hours < 24 THEN
	RETURN CONCAT(v_hours, ' hour', IF(v_hours = 1, '', 's'), ' ago');
END IF;

SET v_days = TIMESTAMPDIFF(DAY, p_datetime, NOW());
IF v_days < 30 THEN
	RETURN CONCAT(v_days, ' day', IF(v_days = 1, '', 's'), ' ago');
END IF;

SET v_months = TIMESTAMPDIFF(MONTH, p_datetime, NOW());
IF v_months < 12 THEN
	RETURN CONCAT(v_months, ' month', IF(v_months = 1, '', 's'), ' ago');
END IF;

SET v_years = TIMESTAMPDIFF(YEAR, p_datetime, NOW());
RETURN CONCAT(v_years, ' year', IF(v_years = 1, '', 's'), ' ago');
END$$
DELIMITER ;

DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_all_approvals`$$ 
CREATE PROCEDURE `sp_portal_get_all_approvals`(
IN  pint_mode INT, 
IN  identityId VARCHAR(20),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success'; 

-- SELECT * FROM documentMaster
-- SET @year = (SELECT YEAR(DATE(NOW()))); 
DROP TEMPORARY TABLE IF EXISTS validPayrollPeriod ;
CREATE TEMPORARY TABLE validPayrollPeriod AS(
		SELECT payrollperioddetails.`payrollPeriodApproverLocked` AS approverLocked,
			payrollperioddetails.`payrollPeriodKioskLocked` AS periodKioskLocked,
			payrollperioddetails.`payrollPeriodLocked` AS periodLocked,
			payrollperioddetails.`payrollPeriodProcessLocked` AS periodProcessLocked,
			payrollperioddetails.`payrollPeriodScheduleTaggingLocked`  AS periodScheduleTaggingLocked,
			payrollPeriodFrom,payrollPeriodTo
		FROM payrollperioddetails
		-- WHERE YEAR(payrollPeriodFrom) = @year
		); 
	
SET @document = (CASE
			WHEN pint_mode=0 THEN 'overtime'
			WHEN pint_mode=1 THEN 'leave'
			WHEN pint_mode=2 THEN 'timeadjustment'
			WHEN pint_mode=3 THEN 'officialbusiness'
			WHEN pint_mode=4 THEN 'offset'
			WHEN pint_mode=5 THEN 'timeentry'
			WHEN pint_mode=6 THEN 'schedulechange'
			WHEN pint_mode=7 THEN 'hrdcert'
			ELSE ''
		END); -- SELECT DISTINCT document FROM approval WHERE document='schedulechange'

DROP TEMPORARY TABLE IF EXISTS temp_all_approval_list;
CREATE TEMPORARY TABLE temp_all_approval_list AS (
		
		SELECT document,appNo  
		FROM approval 
		
		LEFT JOIN approvaltemplatestages ON approvaltemplatestages.code = approval.templateCode 
					AND approvaltemplatestages.lineId = approval.templateLineId   
					
		LEFT JOIN approvalstages ON approvaltemplatestages.stageCode = approvalstages.stageCode	
		LEFT JOIN approvalstagedetails ON approvalstagedetails.code = approvalstages.code 
	
		WHERE approvalstagedetails.id=identityId
			AND approval.document=@document 
);




IF (pint_mode=0) THEN -- OVERTIME

		SELECT 
			COUNT(CASE WHEN otStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN otStatus = 'P' OR otStatus = 'F' OR otStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN otStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN otStatus = 'A' THEN 1 END) AS approve
	FROM overtimeform t1  
	LEFT JOIN validPayrollPeriod t2 ON t1.otDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE otAppNo IN (SELECT appNo FROM temp_all_approval_list) 
		AND otAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
		
			
END IF;   



IF (pint_mode=1) THEN -- LEAVE


		SELECT 
			COUNT(CASE WHEN laStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN laStatus = 'P' OR laStatus = 'F' OR laStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN laStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN laStatus = 'A' THEN 1 END) AS approve
		FROM leaveapplicationform t1
		LEFT JOIN validPayrollPeriod t2 
			ON t1.laDateFrom BETWEEN t2.payrollPeriodFrom AND t2.payrollPeriodTo
		WHERE laAppNo IN (SELECT appNo FROM temp_all_approval_list)
			AND laAppDate BETWEEN (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) 
							AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);

	
END IF; 

IF (pint_mode=2) THEN -- TIME ADJUSTMENT

		SELECT 
			COUNT(CASE WHEN taStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN taStatus = 'P' OR taStatus = 'F' OR taStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN taStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN taStatus = 'A' THEN 1 END) AS approve
	FROM timeadjustmentform	t1
	LEFT JOIN validPayrollPeriod t2 ON t1.taDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE taAppNo IN (SELECT appNo FROM temp_all_approval_list)
		AND taAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF; 


IF (pint_mode=3) THEN -- OFFICIAL BUISNESS

		SELECT 
			COUNT(CASE WHEN obStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN obStatus = 'P' OR obStatus = 'F' OR obStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN obStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN obStatus = 'A' THEN 1 END) AS approve
	FROM officialbusinessform t1	
	LEFT JOIN validPayrollPeriod t2 ON t1.obDateFrom BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE obAppNo IN (SELECT appNo FROM temp_all_approval_list)
		AND obAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF;



IF (pint_mode=4) THEN -- OFFSET

	SELECT 
			COUNT(CASE WHEN osStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN osStatus = 'P' OR osStatus = 'F' OR osStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN osStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN osStatus = 'A' THEN 1 END) AS approve
	FROM offsetform	t1
	LEFT JOIN validPayrollPeriod t2 ON t1.osDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE osAppNo IN (SELECT appNo FROM temp_all_approval_list)
		AND osAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF; 


IF (pint_mode=5) THEN -- TIME ENTRY

	SELECT 
			COUNT(CASE WHEN teStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN teStatus = 'P' OR teStatus = 'F' OR teStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN teStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN teStatus = 'A' THEN 1 END) AS approve
	FROM timeentryform	t1
	LEFT JOIN validPayrollPeriod t2 ON t1.teDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE teAppNo IN (SELECT appNo FROM temp_all_approval_list)
		AND teAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF; 


IF (pint_mode=6) THEN -- SCHEDULE CHANGE

	SELECT 
			COUNT(CASE WHEN scStatus = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN scStatus = 'P' OR scStatus = 'F' OR scStatus IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN scStatus = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN scStatus = 'A' THEN 1 END) AS approve
	FROM schedulechange	t1
	LEFT JOIN validPayrollPeriod t2 ON t1.scReqDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE scAppNo IN (SELECT appNo FROM temp_all_approval_list)
		AND scAppDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF; 


IF (pint_mode=7) THEN -- HRD CERTIFICATE

	SELECT 
			COUNT(CASE WHEN t1.status = 'D' THEN 1 END) AS decline,
			COUNT(CASE WHEN t1.status = 'P' OR t1.status = 'F' OR t1.status IS NULL THEN 1 END) AS pending,
			COUNT(CASE WHEN t1.status = 'C' THEN 1 END) AS cancel,
			COUNT(CASE WHEN t1.status = 'A' THEN 1 END) AS approve
	FROM hrdCertificate t1
	LEFT JOIN validPayrollPeriod t2 ON t1.requestDate BETWEEN payrollPeriodFrom AND payrollPeriodTo 
	WHERE t1.appNo IN (SELECT appNo FROM temp_all_approval_list)
		AND t1.requestDate BETWEEN  (SELECT MIN(payrollPeriodFrom) FROM validPayrollPeriod) AND (SELECT MAX(payrollPeriodTo) FROM validPayrollPeriod);
	
END IF; 


END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_approver_get_priviledge; 
DELIMITER $$  
CREATE PROCEDURE sp_approver_get_priviledge
(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';


		
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

WHERE approvaltemplateoriginator.id = username;



END $$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_leave_balance`$$ 
CREATE PROCEDURE `sp_portal_get_leave_balance`(  
IN pint_mode INT, 
IN identityId VARCHAR(30),  
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN   
	
	SELECT e.*, l.leaveName
	FROM employeeleavebalances e
	INNER JOIN identity i ON e.code = i.code
	INNER JOIN `leave` l ON e.leaveCode = l.leaveCode
	WHERE i.identityId = identityId;
END IF;
END$$ 
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_for_approval_response`$$ 
CREATE DEFINER=`root`@`%` PROCEDURE `sp_for_approval_response`(
IN r_database VARCHAR(100),
IN pint_mode INT,
IN switch INT,
IN r_id VARCHAR(30),
IN user_id VARCHAR(30),
IN val VARCHAR(30),
IN r_remarks VARCHAR(200),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start: BEGIN
DECLARE v_document VARCHAR(100) DEFAULT NULL;
DECLARE v_approval_id VARCHAR(30) DEFAULT NULL;
DECLARE v_line_id INT DEFAULT NULL;
DECLARE v_next_record INT DEFAULT 0;
DECLARE v_fullname VARCHAR(200) DEFAULT '';
DECLARE v_status1 VARCHAR(5) DEFAULT '';
DECLARE v_status2 VARCHAR(5) DEFAULT '';
DECLARE v_form_table VARCHAR(100) DEFAULT NULL;
DECLARE v_history_table VARCHAR(100) DEFAULT NULL;
DECLARE v_status_column VARCHAR(100) DEFAULT NULL;
DECLARE v_appno_column VARCHAR(100) DEFAULT NULL;
DECLARE v_employee_id VARCHAR(30) DEFAULT NULL;
DECLARE v_total_days DECIMAL(15,4) DEFAULT 0;
DECLARE v_leave_type VARCHAR(30) DEFAULT NULL;
DECLARE v_employee_code VARCHAR(30) DEFAULT NULL;
DECLARE v_equivalent_hours DECIMAL(15,4) DEFAULT NULL;
DECLARE v_database_allowed INT DEFAULT 0;
DECLARE v_error_message TEXT DEFAULT '';
/*
* Roll back the transaction if any SQL error occurs.
*/
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
GET DIAGNOSTICS CONDITION 1
v_error_message = MESSAGE_TEXT;
ROLLBACK;
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'lbl_txtReason',
'msg', CONCAT(
'Approval for application No. ',
IFNULL(r_id, ''),
' failed. ',
LEFT(IFNULL(v_error_message, 'Unknown database error.'), 150)
)
);
END;
SET num = 0;
SET msg = '';
/*
* Validate the database parameter.
*/
IF r_database IS NULL
OR TRIM(r_database) = ''
OR r_database NOT REGEXP '^[A-Za-z0-9_]+$'
THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', 'Invalid or missing source database.'
);
LEAVE proc_start;
END IF;
/*
* Confirm that the physical database exists.
*/
IF NOT EXISTS (
SELECT 1
FROM information_schema.schemata
WHERE schema_name = r_database
) THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'Source database does not exist: ',
r_database
)
);
LEAVE proc_start;
END IF;
/*
* Confirm that the database is registered.
*
* pf-common.databases columns:
* code, name, db_owner
*
* The database name is stored in `name`.
*/
SELECT COUNT(*)
INTO v_database_allowed
FROM `pf-common`.`databases`
WHERE `name` = r_database;
IF v_database_allowed = 0 THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'Database ',
r_database,
' is not registered in pf-common.databases.'
)
);
LEAVE proc_start;
END IF;
/*
* Validate procedure mode.
*/
IF pint_mode NOT IN (0, 1) OR pint_mode IS NULL THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', 'Invalid procedure mode.'
);
LEAVE proc_start;
END IF;
/*
* Validate the document switch.
*
* 0 = Overtime
* 1 = Leave
* 2 = Time Adjustment
* 3 = Official Business
* 4 = Offset
* 5 = Time Entry
* 6 = Schedule Change
*/
IF switch NOT BETWEEN 0 AND 6 OR switch IS NULL THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'Invalid document switch: ',
IFNULL(switch, '')
)
);
LEAVE proc_start;
END IF;
/*
* Validate approval response.
*
* 0 = Reject
* 1 = Approve
*/
IF val IS NULL OR val NOT IN ('0', '1') THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'Approval for application No. ',
r_id,
' failed. Invalid approval response.'
)
);
LEAVE proc_start;
END IF;
/*
* Shared prepared-statement parameters.
*/
SET @param_switch = switch;
SET @param_app_no = r_id;
SET @param_user_id = user_id;
/*
* Get the document name from documentMaster.
*/
SET @source_document = NULL;
SET @sql_document = CONCAT(
'SELECT MIN(docVal) ',
'INTO @source_document ',
'FROM `', r_database, '`.`documentMaster` ',
'WHERE dID = ?'
);
PREPARE stmt_document
FROM @sql_document;
EXECUTE stmt_document
USING @param_switch;
DEALLOCATE PREPARE stmt_document;
SET v_document = @source_document;
IF v_document IS NULL OR TRIM(v_document) = '' THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'No document configuration was found for switch ',
switch,
' in database ',
r_database,
'.'
)
);
LEAVE proc_start;
END IF;
SET @param_document = v_document;
/*
* Get the application owner or first approval ID.
*/
SET @source_approval_id = NULL;
SET @sql_approval_id = CONCAT(
'SELECT MIN(id) ',
'INTO @source_approval_id ',
'FROM `', r_database, '`.`approval` ',
'WHERE appNo = ? ',
'AND document = ?'
);
PREPARE stmt_approval_id
FROM @sql_approval_id;
EXECUTE stmt_approval_id
USING
@param_app_no,
@param_document;
DEALLOCATE PREPARE stmt_approval_id;
SET v_approval_id = @source_approval_id;
IF v_approval_id IS NULL OR TRIM(v_approval_id) = '' THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'No approval record was found for application No. ',
r_id,
' in database ',
r_database,
'.'
)
);
LEAVE proc_start;
END IF;
/*
* Get the current approval line from the source database.
*/
SET @source_line_id = NULL;
SET @param_approval_id = v_approval_id;
SET @sql_line_id = CONCAT(
'SELECT `',
r_database,
'`.`f_get_app_lineId`(?, ?, ?) ',
'INTO @source_line_id'
);
PREPARE stmt_line_id
FROM @sql_line_id;
EXECUTE stmt_line_id
USING
@param_app_no,
@param_approval_id,
@param_document;
DEALLOCATE PREPARE stmt_line_id;
SET v_line_id = @source_line_id;
IF v_line_id IS NULL THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'btn1',
'msg', CONCAT(
'No pending approval stage was found for application No. ',
r_id,
'.'
)
);
LEAVE proc_start;
END IF;
/*
* Determine whether another approval stage exists.
*/
SET @source_next_record = 0;
SET @param_line_id = v_line_id;
SET @sql_next_record = CONCAT(
'SELECT COUNT(*) ',
'INTO @source_next_record ',
'FROM `', r_database, '`.`approval` ',
'WHERE appNo = ? ',
'AND templateLineId > ? ',
'AND document = ?'
);
PREPARE stmt_next_record
FROM @sql_next_record;
EXECUTE stmt_next_record
USING
@param_app_no,
@param_line_id,
@param_document;
DEALLOCATE PREPARE stmt_next_record;
SET v_next_record = IFNULL(@source_next_record, 0);
/*
* Mode 0: validation only.
*/
IF pint_mode = 0 THEN
IF val = '0'
AND TRIM(IFNULL(r_remarks, '')) = ''
THEN
SET num = 1;
SET msg = JSON_OBJECT(
'id', 'lbltxtReject',
'msg', CONCAT(
    'Approval for ',
    v_document,
    ' application No. ',
    r_id,
    ' failed. You cannot reject the request without rejection remarks.'
)
);
LEAVE proc_start;
END IF;
SET num = 0;
SET msg = '';
LEAVE proc_start;
END IF;
/*
* Mode 1: process approval.
*/
START TRANSACTION;
/*
* Get approver information from the selected database.
*/
SET @approver_json = NULL;
SET @sql_approver_information = CONCAT(
'CALL `sp_approver_information`(?, @approver_json)'
);
PREPARE stmt_approver_information
FROM @sql_approver_information;
EXECUTE stmt_approver_information
USING @param_user_id;
DEALLOCATE PREPARE stmt_approver_information;
SET v_fullname = IFNULL(
JSON_UNQUOTE(
JSON_EXTRACT(
@approver_json,
'$.fullname'
)
),
''
);
/*
* Approved applications do not require remarks.
*/
SET r_remarks = CASE
WHEN val = '1' THEN NULL
ELSE r_remarks
END;
/*
* Final decision:
*
* A = Approved
* D = Declined
*/
SET v_status2 = CASE
WHEN val = '1' THEN 'A'
ELSE 'D'
END;
/*
* Application form status:
*
* F = Has another approval stage
* A = Fully approved
* D = Declined
*/
SET v_status1 = CASE
WHEN v_next_record > 0
AND v_status2 = 'A'
THEN 'F'
ELSE v_status2
END;
/*
* Assign the application and history tables based on switch.
*/
CASE switch
WHEN 0 THEN
SET v_form_table = 'overtimeform';
SET v_history_table = 'overtimeapproverhistory';
SET v_status_column = 'otStatus';
SET v_appno_column = 'otAppNo';
WHEN 1 THEN
SET v_form_table = 'leaveapplicationform';
SET v_history_table = 'leaveapproverhistory';
SET v_status_column = 'laStatus';
SET v_appno_column = 'laAppNo';
WHEN 2 THEN
SET v_form_table = 'timeadjustmentform';
SET v_history_table = 'timeadjustmentapproverhistory';
SET v_status_column = 'taStatus';
SET v_appno_column = 'taAppNo';
WHEN 3 THEN
SET v_form_table = 'officialbusinessform';
SET v_history_table = 'officialbusinessapproverhistory';
SET v_status_column = 'obStatus';
SET v_appno_column = 'obAppNo';
WHEN 4 THEN
SET v_form_table = 'offsetform';
SET v_history_table = 'offsetapproverhistory';
SET v_status_column = 'osStatus';
SET v_appno_column = 'osAppNo';
WHEN 5 THEN
SET v_form_table = 'timeentryform';
SET v_history_table = 'timeentryapproverhistory';
SET v_status_column = 'teStatus';
SET v_appno_column = 'teAppNo';
WHEN 6 THEN
SET v_form_table = 'schedulechange';
SET v_history_table = 'schedulechangeapproverhistory';
SET v_status_column = 'scStatus';
SET v_appno_column = 'scAppNo';
END CASE;
SET @param_status1 = v_status1;
SET @param_status2 = v_status2;
SET @param_fullname = v_fullname;
SET @param_remarks = r_remarks;
/*
* Update the application status.
*/
SET @sql_update_form = CONCAT(
'UPDATE `', r_database, '`.`', v_form_table, '` ',
'SET `', v_status_column, '` = ? ',
'WHERE `', v_appno_column, '` = ?'
);
PREPARE stmt_update_form
FROM @sql_update_form;
EXECUTE stmt_update_form
USING
@param_status1,
@param_app_no;
DEALLOCATE PREPARE stmt_update_form;
/*
* Insert the application into its approver history table.
*/
SET @sql_history = CONCAT(
'INSERT INTO `', r_database, '`.`', v_history_table, '` ',
'SELECT f.*, ?, ?, ?, CURDATE() ',
'FROM `', r_database, '`.`', v_form_table, '` f ',
'WHERE f.`', v_appno_column, '` = ?'
);
PREPARE stmt_history
FROM @sql_history;
EXECUTE stmt_history
USING
@param_user_id,
@param_fullname,
@param_status1,
@param_app_no;
DEALLOCATE PREPARE stmt_history;
/*
* Additional leave processing.
*/
IF switch = 1 THEN
SET @leave_employee_id = NULL;
SET @leave_total_days = 0;
SET @leave_type = NULL;
SET @leave_equivalent_hours = NULL;
/*
* Get leave application information.
*/
SET @sql_leave_information = CONCAT(
'SELECT ',
'laID, ',
'laTotalDays, ',
'laType, ',
'1 ',
'INTO ',
'@leave_employee_id, ',
'@leave_total_days, ',
'@leave_type, ',
'@leave_equivalent_hours ',
'FROM `', r_database, '`.`leaveapplicationform` ',
'WHERE laAppNo = ? ',
'LIMIT 1'
);
PREPARE stmt_leave_information
FROM @sql_leave_information;
EXECUTE stmt_leave_information
USING @param_app_no;
DEALLOCATE PREPARE stmt_leave_information;
SET v_employee_id = @leave_employee_id;
SET v_total_days = IFNULL(@leave_total_days, 0);
SET v_leave_type = @leave_type;
SET v_equivalent_hours = @leave_equivalent_hours;
/*
* Get the employee code.
*/
SET @employee_code = NULL;
SET @param_employee_id = v_employee_id;
SET @sql_employee_code = CONCAT(
'SELECT MIN(`code`) ',
'INTO @employee_code ',
'FROM `', r_database, '`.`identity` ',
'WHERE identityId = ?'
);
PREPARE stmt_employee_code
FROM @sql_employee_code;
EXECUTE stmt_employee_code
USING @param_employee_id;
DEALLOCATE PREPARE stmt_employee_code;
SET v_employee_code = @employee_code;
SET @param_employee_code = v_employee_code;
SET @param_leave_type = v_leave_type;
SET @param_total_days = v_total_days;
SET @param_equivalent_hours = v_equivalent_hours;
/*
* Return the leave credit when rejected.
*/
IF v_status2 = 'D' THEN
SET @sql_leave_balance = CONCAT(
'UPDATE `', r_database, '`.`employeeleavebalances` ',
'SET currentBalance = currentBalance + ',
    'CASE ',
	'WHEN ? IS NULL THEN ? ',
	'ELSE ? ',
    'END ',
'WHERE `code` = ? ',
'AND leaveCode = ?'
);
PREPARE stmt_leave_balance
FROM @sql_leave_balance;
EXECUTE stmt_leave_balance
USING
@param_equivalent_hours,
@param_total_days,
@param_equivalent_hours,
@param_employee_code,
@param_leave_type;
DEALLOCATE PREPARE stmt_leave_balance;
/*
* Make sure the rejected leave remains declined.
*/
SET @sql_decline_leave = CONCAT(
'UPDATE `', r_database, '`.`leaveapplicationform` ',
'SET laStatus = ''D'' ',
'WHERE laAppNo = ?'
);
PREPARE stmt_decline_leave
FROM @sql_decline_leave;
EXECUTE stmt_decline_leave
USING @param_app_no;
DEALLOCATE PREPARE stmt_decline_leave;
ELSE
/*
* Preserve the original approved-leave balance behavior.
*/
SET @sql_leave_balance = CONCAT(
'UPDATE `', r_database, '`.`employeeleavebalances` ',
'SET leaveBalance = currentBalance ',
'WHERE `code` = ? ',
'AND leaveCode = ?'
);
PREPARE stmt_leave_balance
FROM @sql_leave_balance;
EXECUTE stmt_leave_balance
USING
@param_employee_code,
@param_leave_type;
DEALLOCATE PREPARE stmt_leave_balance;
END IF;
END IF;
/*
* Save the decision for the current approval stage.
*/
SET @sql_update_approval = CONCAT(
'UPDATE `', r_database, '`.`approval` ',
'SET decision = ?, ',
'approver = ?, ',
'approverName = ?, ',
'remarks = ?, ',
'approvedDate = CURDATE() ',
'WHERE document = ? ',
'AND appNo = ? ',
'AND templateLineId = ?'
);
PREPARE stmt_update_approval
FROM @sql_update_approval;
EXECUTE stmt_update_approval
USING
@param_status2,
@param_user_id,
@param_fullname,
@param_remarks,
@param_document,
@param_app_no,
@param_line_id;
DEALLOCATE PREPARE stmt_update_approval;
/*
* Activate the next stage only when approved.
*
* A rejected application must not activate the next approver.
*/
IF v_status2 = 'A' AND v_next_record > 0 THEN
SET @param_next_line_id = v_line_id + 1;
SET @sql_next_approval = CONCAT(
'UPDATE `', r_database, '`.`approval` ',
'SET decision = ''F'' ',
'WHERE document = ? ',
'AND appNo = ? ',
'AND templateLineId = ?'
);
PREPARE stmt_next_approval
FROM @sql_next_approval;
EXECUTE stmt_next_approval
USING
@param_document,
@param_app_no,
@param_next_line_id;
DEALLOCATE PREPARE stmt_next_approval;
END IF;
SET num = 0;
SET msg = JSON_OBJECT(
'id', '',
'msg', CONCAT(
v_document,
' application No. ',
r_id,
' successfully ',
CASE
WHEN val = '0' THEN 'rejected'
ELSE 'approved'
END,
'!'
)
);
COMMIT;
END$$
DELIMITER ;




DROP PROCEDURE IF EXISTS sp_get_document_info; 
DELIMITER $$  
CREATE PROCEDURE sp_get_document_info
(  
IN pint_mode INT,
IN switch INT,	     
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';


SELECT * FROM documentMaster WHERE dID=switch;


END $$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_hrd_cert_approval; 
DELIMITER $$  
CREATE PROCEDURE sp_hrd_cert_approval
( 
IN pint_mode INT,
IN r_identityid VARCHAR(30),
IN r_appNo VARCHAR(100),	 
IN certFile VARCHAR(100),  
IN r_decision INT,
IN r_remarks VARCHAR(100), 
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
			"id":"lblremarks",
			"msg":" Application No.',r_appNo,' failed to approve. ',@errorMessage,'"	
			}'); 
END;

SET num = 0;
SET msg = '';	



IF ((certFile='') AND (r_decision=1))THEN 
	SET num = 1;
	SET msg = CONCAT('{
		"id":"lblfileCert",
		"msg":"Application No.',r_appNo,' failed to approve. No certificate file selected!"	
		}');  
		LEAVE proc_start;
	END IF; 
	
	
	IF (r_decision IN ('','0'))THEN 
	SET num = 1;
	SET msg = CONCAT('{
		"id":"lbldllStatus",
		"msg":"Application No.',r_appNo,' failed to approve. Please select status"	
		}');  
		LEAVE proc_start;
	END IF; 
	
	
	IF (TRIM(r_remarks) IN ('') AND r_decision=2)THEN 
	SET num = 1;
	SET msg = CONCAT('{
		"id":"lblremarks",
		"msg":"Application No.',r_appNo,' failed to approve. Please enter remarks"	
		}');  
		LEAVE proc_start;
	END IF; 


SET @dec = (CASE  WHEN r_decision='1' THEN 'A'  WHEN r_decision='2' THEN 'D'  ELSE '0' END); 
SET @remarks = (CASE  WHEN r_decision IN (0,1) THEN NULL ELSE r_remarks END); 

	
IF (pint_mode=1) THEN

	START TRANSACTION; 
	
	CALL sp_approver_information(r_identityid,@j_object);  
	SET @fullname=(JSON_UNQUOTE(JSON_EXTRACT(@j_object, '$.fullname'))); 

	SET @document = 'hrdcert';
	SET @thisID = r_appNo; 
	SET @identity = (SELECT MIN(ID) FROM approval WHERE appNo=r_appNo AND document=@document); 
	SET @lineId=(SELECT f_get_app_lineId(@thisID,@identity,@document)); 
	
	
		UPDATE hrdcertificate SET `status`=@dec WHERE appNo=r_appNo;
	
		
	UPDATE approval 
	SET decision=@dec,
		approver=r_identityid,
		approverName=@fullname,
		remarks=@remarks,
		approvedDate=DATE(NOW())
	WHERE document=@document 
		AND appNo=r_appNo
		AND templateLineId=@lineId;
		
	
	UPDATE approval 
	SET decision='F'
	WHERE document=@document 
		AND appNo=r_appNo
		AND templateLineId=(@lineId+1);
		/*  
		SET msg = CONCAT('{
		"id":"lblremarks",
		"msg":"Application No.',r_appNo,' has been successfully ',(CASE WHEN r_decision='1' THEN 'approved' ELSE 'rejected' END),'"	
		}');  
		*/
	COMMIT;
END IF;

	

END $$ 
DELIMITER ; 

DELIMITER $$  
DROP FUNCTION IF EXISTS `f_get_app_lineId`$$ 
CREATE FUNCTION `f_get_app_lineId`
(
rAppNo INT,
rID VARCHAR(30),
r_document VARCHAR(30)
) 	
RETURNS INT(11)
BEGIN
DECLARE ThisLineID INT; 
	
	SET ThisLineID = (SELECT MIN(templateLineId) FROM approval WHERE appNo=rAppNo AND ID = rID AND document=r_document AND decision='F'); 
	
	RETURN ThisLineID;
END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_hrd_cert_submit; 
DELIMITER $$  
CREATE PROCEDURE sp_hrd_cert_submit
( 
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


DROP PROCEDURE IF EXISTS sp_approval_insert; 
DELIMITER $$  
CREATE PROCEDURE sp_approval_insert
(  
IN pint_mode INT,	
IN app_id VARCHAR(30),  
IN user_id VARCHAR(30),
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
SET @docs = (SELECT docVal FROM documentMaster WHERE dID = pint_mode);
-- SELECT * FROM documentMaster
IF (pint_mode=0) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`overtime` = 1'
					,@num1
					,@msg1
					);
	END IF;
	
	
	IF (pint_mode=1) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`leave` = 1'
					,@num1
					,@msg1
					);
	END IF;
	
	IF (pint_mode=2) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`timeAdjustment` = 1'
					,@num1
					,@msg1
					);
	END IF;
	
	IF (pint_mode=3) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`officialBusiness` = 1'
					,@num1
					,@msg1
					);
	END IF;
	
	IF (pint_mode=4) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`offsetTime` = 1 '
					,@num1
					,@msg1
					);
	END IF;
	
	
IF (pint_mode=5) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`timeEntry` = 1 '
					,@num1
					,@msg1
					);
END IF;

IF (pint_mode=6) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`scheduleTagging` = 1'
					,@num1
					,@msg1
					);
END IF;

IF (pint_mode=7) THEN 
	CALL sp_approval_get_for_approval(0
					,user_id
					,'JOIN approvaltemplates ON approvaltemplates.code = approvaltemplatestages.code AND approvaltemplates.`hrdCert` = 1'
					,@num1
					,@msg1
					);
END IF;

DELETE FROM approval WHERE appNo=app_id AND document=@docs;


INSERT INTO approval (appNo,templateCode,templateLineId,id,document,decision)
SELECT app_id,CODE,lineId,id,@docs,(CASE WHEN lineId>1 THEN 'P' ELSE 'F' END) AS decision
FROM temp_approval_tbl	
WHERE id=user_id;
COMMIT;
END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_approval_get_for_approval; 
DELIMITER $$  
CREATE PROCEDURE sp_approval_get_for_approval
(  
IN pint_mode INT,	 
IN user_id VARCHAR(30),  
IN fileter VARCHAR(300),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';


DELETE FROM temp_approval_tbl WHERE id=user_id;

SET @query = CONCAT('
		INSERT INTO temp_approval_tbl(code,lineId,id,stageCode)
		SELECT approvaltemplateoriginator.code,
			approvaltemplatestages.lineId,
			approvaltemplateoriginator.id, 
			approvaltemplatestages.stageCode AS stageCode
		FROM approvaltemplateoriginator 
				
		LEFT JOIN approvaltemplatestages ON  approvaltemplateoriginator.code = approvaltemplatestages.code
		',fileter,'  
		WHERE approvaltemplateoriginator.id=''',user_id,''' 
		');
PREPARE stmt FROM @query; 
EXECUTE stmt; 
DEALLOCATE PREPARE stmt;

SELECT * 
FROM temp_approval_tbl WHERE id=user_id;

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_get_approver_scop;
DELIMITER $$  
CREATE PROCEDURE sp_get_approver_scop
( 
IN pint_mode INT,	
IN r_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


/*
	0 - GET THE LIST OF USER WHO ASSIGNED APPROVAL TEMPLATES
	1 - GET THE LIST OF USER WHO IS UNDER FOR HIS AUTHORIZATION
	2 - CHECK USER AUTHORIZER
	3 - CHECK TEMPLATE DETAILS

*/

IF (pint_mode=0) THEN

	SELECT DISTINCT t2.code,t1.`templateName`,t4.`id`,t4.`user`,t5.`stageName`,t6.`id` AS AuthorizerId,t6.`authorizer`,t6.`department`
		,t3.lineId,t2.leave,t2.overtime,t2.officialBusiness,t2.offsetTime,t2.timeAdjustment,t2.timeEntry,t2.scheduleTagging
	FROM `approvaltemplates` t1 
	LEFT JOIN approvaltemplates t2 ON t1.`code`=t2.`code`
	LEFT JOIN approvaltemplatestages t3 ON t1.`code`=t3.`code`
	LEFT JOIN approvaltemplateoriginator t4 ON t1.`code`=t4.`code`
	LEFT JOIN approvalstages t5 ON t3.`stageCode`=t5.stageCode
	LEFT JOIN approvalstagedetails t6 ON t5.`code`=t6.`code`
	WHERE t4.`id` IS NOT NULL AND  t6.`id` IS NOT NULL
	ORDER BY t1.`templateName`,t6.`department`,t6.`id`,t4.`user`;

END IF;



IF (pint_mode=1) THEN	
	
	SELECT  DISTINCT t2.code,t1.`templateName`,t4.`id`,t4.`user`,t5.`stageName`,t6.`id` AS AuthorizerId,t6.`authorizer`,t6.`department`
		,t3.lineId,t2.leave,t2.overtime,t2.officialBusiness,t2.offsetTime,t2.timeAdjustment,t2.timeEntry,t2.scheduleTagging
	FROM `approvaltemplates` t1 
	LEFT JOIN approvaltemplates t2 ON t1.`code`=t2.`code`
	LEFT JOIN approvaltemplatestages t3 ON t1.`code`=t3.`code`
	LEFT JOIN approvaltemplateoriginator t4 ON t1.`code`=t4.`code`
	LEFT JOIN approvalstages t5 ON t3.`stageCode`=t5.stageCode
	LEFT JOIN approvalstagedetails t6 ON t5.`code`=t6.`code`
	WHERE t6.`id` = r_id
		AND t4.id IS NOT NULL
	ORDER BY t1.`templateName`,t6.`department`,t6.`id`,t4.`user`;
	
END IF;


IF (pint_mode=2) THEN	
	
	SELECT  DISTINCT t2.code,t1.`templateName`,t4.`id`,t4.`user`,t5.`stageName`,t6.`id` AS AuthorizerId,t6.`authorizer`,t6.`department`
		,t3.lineId,t2.leave,t2.overtime,t2.officialBusiness,t2.offsetTime,t2.timeAdjustment,t2.timeEntry,t2.scheduleTagging
	FROM `approvaltemplates` t1 
	LEFT JOIN approvaltemplates t2 ON t1.`code`=t2.`code`
	LEFT JOIN approvaltemplatestages t3 ON t1.`code`=t3.`code`
	LEFT JOIN approvaltemplateoriginator t4 ON t1.`code`=t4.`code`
	LEFT JOIN approvalstages t5 ON t3.`stageCode`=t5.stageCode
	LEFT JOIN approvalstagedetails t6 ON t5.`code`=t6.`code`
	WHERE t4.id=r_id
		AND t6.id IS NOT NULL
	ORDER BY t1.`templateName`,t6.`department`,t6.`id`,t4.`user`;
	
END IF;



IF (pint_mode=3) THEN	
	
	SELECT DISTINCT  t2.code,t1.`templateName`,t4.`id`,t4.`user`,t5.`stageName`,t6.`id` AS AuthorizerId,t6.`authorizer`,t6.`department`
		,t3.lineId,t2.leave,t2.overtime,t2.officialBusiness,t2.offsetTime,t2.timeAdjustment,t2.timeEntry,t2.scheduleTagging
	FROM `approvaltemplates` t1 
	LEFT JOIN approvaltemplates t2 ON t1.`code`=t2.`code`
	LEFT JOIN approvaltemplatestages t3 ON t1.`code`=t3.`code`
	LEFT JOIN approvaltemplateoriginator t4 ON t1.`code`=t4.`code`
	LEFT JOIN approvalstages t5 ON t3.`stageCode`=t5.stageCode
	LEFT JOIN approvalstagedetails t6 ON t5.`code`=t6.`code`
	WHERE t1.`templateName`=r_id
		AND t6.id IS NOT NULL 
		AND t4.id IS NOT NULL
	ORDER BY t1.`templateName`,t6.`department`,t6.`id`,t4.`user`;
	
END IF;

END $$
DELIMITER ; 


DROP PROCEDURE IF EXISTS sp_get_locations; 
DELIMITER $$   
CREATE PROCEDURE sp_get_locations
( 
IN pint_mode INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN

	SELECT *
	FROM(
		SELECT '' AS locationCode,'' AS locationName UNION ALL	
		SELECT * FROM location	
	)t1
	ORDER BY locationName;
END IF;



IF (pint_mode=1) THEN

	SELECT *
	FROM(
		SELECT 0 AS _code,'' AS locationCode,'' AS locationName UNION ALL	
		SELECT   1 AS _code,locationCode,locationName FROM location 
	)t1
	ORDER BY _code,locationName; 
	
END IF;


IF (pint_mode=2) THEN

	SELECT *
	FROM(
		SELECT 0 AS _code,'' AS locationCode,'' AS locationName UNION ALL	
		SELECT   1 AS _code,locationCode,locationName FROM location UNION ALL
		SELECT   2 AS _code,'Others','Others' 
	)t1
	ORDER BY _code,locationName; 
	
END IF;

END $$
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_offset_submit_request`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_offset_submit_request`( 
IN pint_mode INT,
IN r_osAppNo INT,
IN r_osID VARCHAR(30),  
IN r_osTimeFrom VARCHAR(30), 
IN r_osTimeTo VARCHAR(30), 
IN r_osDateFrom VARCHAR(30), 
IN r_osDateTo VARCHAR(30), 
IN r_osReason TEXT,  
IN r_Reference VARCHAR(100),
IN r_location VARCHAR(30), 
IN r_attachedFiles LONGTEXT, 
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
SET @from = (SUBSTRING(r_Reference, 7, 19));
SET @to=(SUBSTRING(r_Reference, 30, 19));

-- SET @IsRefnoValid = (SELECT fn_offset_get_ref_list(1,r_osID,@from,@to));

IF (r_osDateFrom='') THEN
	SET num = 1;
	SET msg = '{
		"id":"lbl_offset_from_date",
		"msg":"Please pick [Offset Date From]"	
		}';
LEAVE proc_start;
END IF;	



SET @app_type = 'offset';
SET @filingDateValidation = (SELECT fn_validate_leave_filing(r_osDateFrom,DATE(NOW()),@app_type));
SET @num = IFNULL((SELECT exception_filing_allowed FROM filing_window_matrix WHERE app_type = @app_type),1);
SET @uploadedFiles = JSON_UNQUOTE(r_attachedFiles);

IF (@filingDateValidation='INVALID' AND JSON_LENGTH(@uploadedFiles)=0 ) THEN
	SET @msg = (CASE 
			WHEN @num=1 THEN 'This application is outside the standard filling period. Please provide a reason and supporting document for exception approval'
			ELSE 'This application is outside the standard filling period.'
			END);
	SET @lbl = (CASE  WHEN @num=1 THEN 'lblfileInput' ELSE 'lbl_offset_from_date'  END);
	SET num = 1;
	SET msg = CONCAT('{
			"id":"',@lbl,'",
			"msg":"',@msg,'"	
			}');  
	LEAVE proc_start;
END IF;


IF (r_osDateTo='') THEN
	SET num = 1;
	SET msg = '{
		"id":"lbl_offset_to_date",
		"msg":"Please pick [Offset Date To]"	
		}';
		
LEAVE proc_start;
END IF;	


IF (r_location='') THEN
	SET num = 1;
	SET msg = '{
		"id":"lbl_appLocation",
		"msg":"Please enter [Location]"	
		}';
		
LEAVE proc_start;
END IF;	 


IF (r_osReason='') THEN 
	SET num = 1;
	SET msg = '{
		"id":"lbl_txtRemarks",
		"msg":"Please enter [Remarks]"	
		}'; 	       
LEAVE proc_start;
END IF;	



IF (r_Reference='') THEN 
	SET num = 1;
	SET msg = '{
		"id":"lbl_txtRefNo",
		"msg":"Please select [Reference DTR]"	
		}';
LEAVE proc_start;
END IF;	

CALL sp_check_exists_app_valid_for_edit(4,r_osAppNo,@num2,@msg2);	 
IF (@num2=1) THEN   

	SET num = 1;
	SET msg = CONCAT('{
		"id":"lbl_txtRemarks",
		"msg":"',@msg2,'"	
		}'); 
LEAVE proc_start;
END IF;


IF ((SELECT fn_offset_get_ref_list(1,r_osID,@from,@to)) IN ('0',0)) THEN  
SET num = 1;
SET msg = '{
	"id":"lbl_txtRefNo",
	"msg":"Inavlid [Reference DTR]"	
	}';	       
LEAVE proc_start;
END IF;	



IF (pint_mode=1) THEN    
	START TRANSACTION; 
	SET @fullname=(SELECT (CONCAT(firstname,' ',middlename,' ',lastname))  FROM identity WHERE identityid=r_osID); 
	SET @code =(SELECT CODE  FROM identity WHERE identityid=r_osID);  
	SET @costcode=( SELECT MAX(costcode) FROM employeemovement WHERE CODE=@code);
	SET @depcode=( SELECT MAX(departmentcode) FROM employeemovement WHERE CODE=@code);
	SET @batchid=(SELECT batchid FROM identity WHERE identityid=r_osID);  
	SET @locationname=(SELECT locationname FROM location WHERE locationcode=r_location); 
	
	SET @costcode=IFNULL(@costcode,0);
	SET @depcode=IFNULL(@depcode,0);
	
	IF (r_osAppNo>0) THEN
	
		UPDATE offsetform
		SET  osID=r_osID
			,osDate=r_osDateFrom
			,osTimeFrom=r_osTimeFrom
			,osTimeTo=r_osTimeTo
			,osDateFrom=r_osDateFrom
			,osDateTo=r_osDateTo
			,osReason=r_osReason
			,osStatus='P'
			,osReference=r_Reference
			,location=r_location
			,locationName=@locationname
		WHERE osAppNo=r_osAppNo;
	
	ELSE
		
		INSERT INTO offsetform (osID,osName,osCosCenter,osDate,osAppDate,osType,osTimeFrom,osTimeTo,osDateFrom,osDateTo,osReason,osStatus,department,osReference,location,locationName)
		VALUES (r_osID,@fullname,@costcode,r_osDateFrom,DATE(NOW()),'HOURS',r_osTimeFrom,r_osTimeTo,r_osDateFrom,r_osDateTo,r_osReason,'P',@depcode,r_Reference,r_location,@locationname);
		
		SET @osAppNo = (SELECT MAX(osAppNo) FROM offsetform WHERE osID=r_osID AND osStatus='P');
		SET r_osAppNo=@osAppNo;
		CALL sp_approval_insert(4,@osAppNo,r_osID,@num1, @msg1); 
	
	END IF; 
	
	DELETE FROM requestattachments WHERE appNo = r_osAppNo AND document='offset'; 

	IF (JSON_LENGTH(@uploadedFiles)>0) THEN
		INSERT INTO requestattachments (appNo,document,files)
		VALUES (r_osAppNo,@app_type,@uploadedFiles);
	END IF;

	SET msg=r_osAppNo;
	COMMIT;
END IF; 	 
END$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_get_user_leave_type;  
DELIMITER $$   
CREATE PROCEDURE sp_get_user_leave_type(
IN pintMode INT,
IN Id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SELECT 0 AS CODE,Id AS  identityId,'' AS leaveCode,'' AS leaveName 
UNION ALL
SELECT identity.`code`, identity.`identityId`, employeeleavebalances.`leaveCode` AS leaveCode, `leave`.`leaveName` AS leaveName
FROM identity 
LEFT JOIN employeeleavebalances ON employeeleavebalances.code = identity.code
LEFT JOIN `leave` ON employeeleavebalances.`leaveCode` = `leave`.`leaveCode`
WHERE identityId = Id
AND employeeleavebalances.leaveBalance IS NOT NULL
AND employeeleavebalances.leaveCode IS NOT NULL
AND IFNULL(validUntil,DATE(NOW()))>=DATE(NOW())
;


END $$
DELIMITER ;

DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_get_security_settings`$$ 
CREATE PROCEDURE `sp_portal_get_security_settings`(
IN pint_mode INT,

OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


IF (pint_mode=0) THEN -- complexity

	SELECT passwordComplexEnabled FROM companysetting;
	
END IF;


IF (pint_mode=1) THEN -- captcha

	SELECT enableCaptcha FROM companysetting;
		
END IF;


IF (pint_mode=2) THEN -- password length

	SELECT passwordLength FROM companysetting;

END IF;


IF (pint_mode=3) THEN -- password reuse 

	SELECT passwordReuseRestriction FROM companysetting;

END IF;


IF (pint_mode=4) THEN -- password passwordChangeInitLogon

	SELECT passwordChangeInitLogon FROM companysetting;
	
END IF;


IF (pint_mode=5) THEN -- password expired days

	SELECT passwordExpiredDays FROM companysetting;

END IF;


IF (pint_mode=6) THEN -- lockedOutRecoveryType 

	SELECT lockedOutRecoveryType FROM companysetting;

END IF;


IF (pint_mode=7) THEN -- lockedOutDuration

	SELECT lockedOutDuration FROM companysetting;

END IF;


IF (pint_mode=8) THEN -- logAttempts

	-- SELECT IFNULL(logAttempts,6)-1 AS logAttempts FROM companysetting;
	SELECT IFNULL(logAttempts,6) AS logAttempts FROM companysetting;

END IF; 

END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_get_user_per_department;
DELIMITER $$  
CREATE PROCEDURE sp_get_user_per_department
( 
IN pint_mode INT,	
IN department VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SELECT t2.lineId,t1.identityId,CONCAT(t1.firstName,' ',t1.middleName,' ',t1.lastName)AS Fullname,t3.departmentName 
FROM identity t1
LEFT JOIN(
	SELECT MAX(lineId) AS lineId,`code`,costCode,departmentCode
	FROM employeemovement
	GROUP BY `code` 
	)t2 ON t1.`code`=t2.code
LEFT JOIN department t3 ON t2.departmentCode=t3.departmentCode
LEFT JOIN costCenter t4 ON t2.costCode=t4.`costCode`
WHERE t3.departmentCode=(CASE WHEN department='' THEN t3.departmentCode ELSE department END)
-- and t1.identityId='1011210214'
GROUP BY t1.identityId,CONCAT(t1.firstName,' ',t1.middleName,' ',t1.lastName),t3.departmentName 

;

END $$
DELIMITER ; 


-- CALL sp_get_payrollperiod_kiosk(1,'00001',@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_get_payrollperiod_kiosk;  
DELIMITER $$ 
CREATE PROCEDURE sp_get_payrollperiod_kiosk
(  
IN pint_mode INT, 
IN p_identityId VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 

SET num = 0;
SET msg = 'Success';

/*
-- SELECT '' as 'from','' as 'to' from identity WHERE identityId='A';

SELECT *
FROM(
	SELECT '1960-01-01' AS `from`,'1960-01-01' AS `to` UNION ALL
	SELECT DATE_FORMAT(payrollperioddetails.payrollPeriodFrom, '%d/%m/%Y') AS 'from', 
		DATE_FORMAT(payrollperioddetails.payrollPeriodTo, '%d/%m/%Y') AS 'to'
	FROM identity 
	
	LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode

	LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

	LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
	WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
	WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

	LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code

	WHERE identity.identityId = p_identityId 
		AND payrollperioddetails.payrollPeriodKioskLocked IS NULL
	)t1
-- ORDER BY payrollperioddetails.payrollPeriodFrom; 
WHERE `from` IS NOT NULL
ORDER BY `from`;
*/

SELECT DATE_FORMAT(payrollperioddetails.payrollPeriodFrom, '%d/%m/%Y') AS 'from', 
	DATE_FORMAT(payrollperioddetails.payrollPeriodTo, '%d/%m/%Y') AS 'to'
FROM identity 

-- LEFT JOIN payrollgroup ON
-- identity.batchId = payrollgroup.payrollGroupCode

-- LEFT JOIN payrollconfiguration ON
-- payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

LEFT JOIN payrollperiod ON
identity.paymentFrequency = 
(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END) AND identity.`payrollPeriodID` =  payrollperiod.`payrollPeriodID`

LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code

WHERE identity.identityId = p_identityId
	AND payrollperioddetails.payrollPeriodKioskLocked IS NULL
	AND payrollperioddetails.payrollPeriodFrom IS NOT NULL;
		
		
END $$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_load_calendar_sched; 
DELIMITER $$   
CREATE PROCEDURE sp_load_calendar_sched(
IN pint_mode INT, 
IN switch INT,
IN rID VARCHAR(30), 
IN df VARCHAR(30),
IN dt VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  

SET num = 0;
SET msg = 'Success';

SET @docs = (SELECT FormVal FROM documentMaster WHERE dID = switch);
SET @docs1 = (SELECT docVal FROM documentMaster WHERE dID = switch);

-- SELECT * FROM documentMaster

IF (switch=0) THEN -- OT
	
		SELECT DISTINCT otStatus AS appStatus, otDate AS appDateFrom, otAppNo AS appNo, otID AS appID,@docs AS appDoc,'#EF5016' AS appColor
		FROM overtimeform t1
		LEFT JOIN approval t2 ON t1.otAppNo=t2.appNo AND t2.document=@docs1
	WHERE otID =rID
		AND otDate BETWEEN df AND dt
		AND t2.document IS NOT NULL;
END IF;


IF (switch=1) THEN -- LEAVE
	
	SELECT DISTINCT laStatus AS appStatus, laLstDate AS appDateFrom, laAppNo AS appNo, laID AS appID,@docs AS appDoc,'#5D9023' AS appColor 
	FROM leaveapplicationlist t1
	LEFT JOIN leaveapplicationform t2 ON t1.laLstAppNo=t2.laAppNo
	LEFT JOIN approval t3 ON t1.laLstAppNo=t3.appNo AND t3.document=@docs1
	WHERE t2.laID =rID
		AND laLstDate BETWEEN df AND dt
		AND t3.document IS NOT NULL;
		
END IF;


IF (switch=2) THEN -- TIME ADJUSTMENT
	
	
	SELECT DISTINCT taStatus AS appStatus, taDate AS appDateFrom, taAppNo AS appNo, taID AS appID,@docs AS appDoc,'#4B62D1' AS appColor 
	FROM timeadjustmentform t1
	LEFT JOIN approval t2 ON t1.taAppNo=t2.appNo AND t2.document=@docs1
	WHERE  taID =rID
		AND taDate BETWEEN df AND dt
		AND t2.document IS NOT NULL
		;
		
END IF;


IF (switch=3) THEN -- OB
	

	SELECT DISTINCT obStatus AS appStatus, obDateFrom AS appDateFrom, obAppNo AS appNo, obID AS appID,@docs AS appDoc,'#800080' AS appColor
	FROM officialbusinessform  t1
	LEFT JOIN approval t2 ON t1.obAppNo=t2.appNo AND t2.document=@docs1
	WHERE  obID =rID 
		AND obDateFrom>=df
		AND  obDateFrom<=dt
			AND  obType !='Days'
		AND t2.document IS NOT NULL
		
	UNION ALL
	
	SELECT DISTINCT t2.obStatus, t1.obLstDate AS obDateFrom, t1.obLstAppNo AS obAppNo, t2.obID,@docs AS appDoc,'#800080' AS appColor
	FROM officialbusinesslist t1
	LEFT JOIN officialbusinessform t2 ON t1.`obLstAppNo`=t2.`obAppNo`
	LEFT JOIN approval t3 ON t1.obLstAppNo=t3.appNo AND t3.document=@docs1
	WHERE t1.`id`=rID
		AND t1.obLstDate>=df
		AND t1.obLstDate<=dt
		AND t3.document IS NOT NULL
		; 
	
END IF;

IF (switch=4) THEN -- OFFSET 
	
	SELECT DISTINCT osStatus AS appStatus, osDate AS appDateFrom, osAppNo AS appNo, osID AS appID,@docs AS appDoc,'#EFDB39' AS appColor
	FROM offsetform t1
	LEFT JOIN approval t2 ON t1.osAppNo=t2.appNo AND t2.document=@docs1
	WHERE  osID =rID
		AND osDate BETWEEN df AND dt
		AND t2.document IS NOT NULL;
		
END IF;

IF (switch=5) THEN -- TIME ENTRY 
	
	
	SELECT DISTINCT teStatus AS appStatus, teDate AS appDateFrom, teAppNo AS appNo, teID AS appID,@docs AS appDoc,'#D7830D' AS appColor
	FROM timeentryform t1
	LEFT JOIN approval t2 ON t1.teAppNo=t2.appNo AND t2.document=@docs1
	WHERE  teID =rID
		AND teDate BETWEEN df AND dt
		AND t2.document IS NOT NULL
		;
		
END IF;

IF (switch=6) THEN  -- SCHEDULE
	
	SET @rID = (SELECT rID);
	
	DROP TEMPORARY TABLE IF EXISTS temp_v_employeedailyschedule_cal;
	CREATE TEMPORARY TABLE temp_v_employeedailyschedule_cal AS(
		SELECT * FROM v_employeedailyschedule_cal WHERE employeeId=@rID
	);
	
	
	-- SELECT DISTINCT '' AS appStatus, `day` AS appDateFrom, 0 AS appNo, 0 AS appID,CONCAT('Schedule: ',schedules.scheduleCode) AS appDoc,'#171818' AS appColor
	SELECT DISTINCT '' AS appStatus, `day` AS appDateFrom
			, v_employeedailyschedule_cal.day AS appNo
			,rID AS appID,CONCAT('Schedule: ',schedules.scheduleCode) AS appDoc,'#171818' AS appColor
	FROM  temp_v_employeedailyschedule_cal v_employeedailyschedule_cal
	JOIN   schedules ON v_employeedailyschedule_cal.schedule = schedules.code
	WHERE employeeId=rID  
		AND v_employeedailyschedule_cal.day BETWEEN df AND dt
	GROUP BY 
		v_employeedailyschedule_cal.day, 
		v_employeedailyschedule_cal.employeeId, 
		v_employeedailyschedule_cal.schedule
		
	UNION ALL
	
	SELECT DISTINCT scStatus AS appStatus, scReqDate AS appDateFrom, scAppNo AS appNo, scID AS appID,'Schedule Change' AS appDoc,'#EAC231' AS appColor
	FROM schedulechange t1 
	WHERE scReqDate BETWEEN df AND dt
		AND scID=rID 
	; 
END IF;


IF (switch=101) THEN

	SELECT DISTINCT '' AS appStatus, holidayDate AS appDateFrom, 0 AS appNo, 0 AS appID,CONCAT('Holiday: ',holidayName) AS appDoc,'#F32020' AS appColor
	FROM holidaysholiday
	WHERE holidayDate BETWEEN df AND dt
	
	
	UNION ALL
	
	SELECT DISTINCT '' AS appStatus, holidayDate AS appDateFrom, 0 AS appNo, 0 AS appID,CONCAT('Holiday: ',holidayName) AS appDoc,'#F32020' AS appColor
	FROM  holidaysprofitcenter
	JOIN  employeemovement ON employeemovement.costCode = holidaysprofitcenter.profitCenterCode
	JOIN  identity ON identity.code = employeemovement.code
	WHERE  holidaysprofitcenter.holidayDate BETWEEN df AND dt
		AND identity.identityId = rID
	;
END IF; 


END $$ 
DELIMITER ; 

ALTER TABLE payrollperiod ADD COLUMN IF NOT EXISTS `payrollPeriodID` VARCHAR(50) DEFAULT NULL;

DROP TABLE IF EXISTS v_employeedailyschedule_cal;
DROP VIEW IF EXISTS v_employeedailyschedule_cal;		 
DELIMITER $$
CREATE VIEW `v_employeedailyschedule_cal` AS  

SELECT `payrollperioddetails`.`code`                  AS `code`,
`payrollperioddetails`.`lineId`                AS `lineId`,
`v_employeedailyschedule`.`payrollPeriod`      AS `payrollPeriod`,
`v_employeedailyschedule`.`payrollPeriodMonth` AS `payrollPeriodMonth`,
`v_employeedailyschedule`.`payrollPeriodFrom`  AS `payrollPeriodFrom`,
`v_employeedailyschedule`.`payrollPeriodTo`    AS `payrollPeriodTo`,
`v_employeedailyschedule`.`employeeId`         AS `employeeId`,
`v_employeedailyschedule`.`employeeName`       AS `employeeName`,
`v_employeedailyschedule`.`costCenter`         AS `costCenter`,
`v_employeedailyschedule`.`department`         AS `department`,
`v_employeedailyschedule`.`col`                AS `col`,
`v_employeedailyschedule`.`day`                AS `day`,
`v_employeedailyschedule`.`schedule`           AS `schedule`,
`v_employeedailyschedule`.`scheduleName`       AS `scheduleName`,
`v_employeedailyschedule`.`workOnHoliday`      AS `workOnHoliday`,
`v_employeedailyschedule`.`windowHours`        AS `windowHours` 
FROM v_employeedailyschedule 
LEFT JOIN identity  ON v_employeedailyschedule.`employeeId`=identity.`identityId`
LEFT JOIN payrollperiod  ON payrollperiod.`payrollPeriodID`=identity.`payrollPeriodID`
LEFT JOIN payrollperioddetails ON `payrollperioddetails`.`code` = `payrollperiod`.`code`
WHERE `v_employeedailyschedule`.`employeeId` = `identity`.`identityId` 
$$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS `sp_portal_get_dtr_logs`;  -- NEW
DELIMITER $$  
CREATE PROCEDURE `sp_portal_get_dtr_logs`(  
IN pint_mode INT, 
IN identityId VARCHAR(20), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN 

	DELETE FROM dtrlogs_employee WHERE identityId = identityId;

END IF;

IF (pint_mode=1) THEN 

	SELECT `identity`.`identityId` AS identityid,
			`dtrlogs`.`machineID` AS machineID,
			`dtrlogs`.`biometricsId` AS biometricsId,
			`dtrlogs`.`dtrTime` AS dtrtime,
			DATE_FORMAT(dtrTime, '%Y-%m-%d') `date`, 
			DATE_FORMAT(dtrTime,'%H:%i:%s') `time`,
			`dtrlogs`.`dtrType` AS dtrType,
			`dtrlogs`.`geolocation` AS location
	FROM `dtrlogs`
	INNER JOIN `employeebiometrics` ON `employeebiometrics`.`bioId`=`biometricsId` AND `employeebiometrics`.`machineId`=`dtrlogs`.`machineID`
	INNER JOIN `identity` ON `identity`.`code` = `employeebiometrics`.`code`
	WHERE `identity`.`identityId` = identityId;

END IF;
END$$ 
DELIMITER ;
	
DROP PROCEDURE IF EXISTS sp_employee_bio_logs; 
DELIMITER $$   
CREATE PROCEDURE sp_employee_bio_logs(
IN pint_mode INT, 
IN r_identityId VARCHAR(30), 
IN df VARCHAR(30),
IN dt VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  

SET num = 0;
SET msg = 'Success';

SET df=(CASE WHEN df='' THEN  DATE_ADD(CURDATE(), INTERVAL 1 MONTH) ELSE df END);
SET dt=(CASE WHEN dt='' THEN  DATE(NOW()) ELSE dt END);


SELECT `identity`.`identityId` AS identityid,
	`identity`.`firstName` AS firstName,
	`identity`.`lastName` AS lastName,
	`dtrlogs`.`machineID` AS machineid,
	`dtrlogs`.`biometricsId` AS biometricsid,
	`dtrlogs`.`dtrTime` AS dtrtime,
	DATE_FORMAT(dtrTime, '%Y-%m-%d') DATE, 
	DATE_FORMAT(dtrTime,'%H:%i:%s') TIME,
	`dtrlogs`.`dtrType` AS dtrtype 
FROM `dtrlogs`
INNER JOIN `employeebiometrics` ON `employeebiometrics`.`bioId`=`biometricsId` AND `employeebiometrics`.`machineId`=`dtrlogs`.`machineID`
INNER JOIN `identity` ON `identity`.`code` = `employeebiometrics`.`code`

LEFT JOIN approvaltemplateoriginator ON identity.`identityId` = approvaltemplateoriginator.`id`
LEFT JOIN approvaltemplatestages ON approvaltemplateoriginator.`code` = approvaltemplatestages.`code`
LEFT JOIN approvalstages ON approvaltemplatestages.`stageCode` = approvalstages.`stageCode`
LEFT JOIN approvalstagedetails ON approvalstages.`code` = approvalstagedetails.`code`

WHERE approvalstagedetails.`id` = r_identityId 
	AND CONVERT(dtrTime,DATE) BETWEEN df AND dt;

END $$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_dtr_logs_insert; 
DELIMITER $$  
CREATE PROCEDURE sp_dtr_logs_insert(
IN pint_mode INT,
IN dtrType VARCHAR(30),
IN dtr_identityId VARCHAR(30),
IN geo VARCHAR(200),
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
			"id":"ddlDTRTypelbl",
			"msg":"',@errorMessage,'"	
			}'); 
END;

SET num = 0;
SET msg = '';

SET @code = IFNULL((SELECT `code` FROM identity WHERE identityId=dtr_identityId),'0');

IF NOT EXISTS (SELECT 1 FROM employeebiometrics WHERE `code`=@code) THEN
-- SELECT * FROM employeebiometrics
	SET num = 1;
	SET msg = CONCAT('{
			"id":"ddlDTRTypelbl",
			"msg":"Ops!, you dont have biometric setup in our system! please contact your Super Visor"	
			}');  
	LEAVE proc_start;	

END IF;

IF (geo="") THEN

	SET num = 1;
	SET msg = CONCAT('{
			"id":"dtrLocationLbl",
			"msg":"Invalid Location"	
			}');  
	LEAVE proc_start;	

END IF; 

IF (dtrType NOT IN ('I','O')) THEN

	SET num = 1;
	SET msg = CONCAT('{
			"id":"ddlDTRTypelbl",
			"msg":"Please select DTR Type"	
			}');  
	LEAVE proc_start;	

END IF;


IF (pint_mode=1) THEN
	START TRANSACTION; 
	SET @dtrTime = NOW();
	INSERT INTO `dtrlogs` (`dtrTime`, `dtrType`, `biometricsId`, `machineID`, `geolocation`)
	SELECT @dtrTime,dtrType, ebio.bioId, ebio.machineId,geo
	FROM employeebiometrics ebio
	LEFT JOIN identity idy ON ebio.code = idy.code
	WHERE idy.identityId = dtr_identityId;
	
	SET msg = CONCAT('DTR has been successfully saved with dtr time:',@dtrTime);
	
	COMMIT;
END IF;

END $$ 
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

DELIMITER $$  
DROP FUNCTION IF EXISTS `f_get_app_authorizer`$$ 
CREATE 
FUNCTION `f_get_app_authorizer`
( 
tempCode VARCHAR(30),
Line_Id INT

) RETURNS VARCHAR(30)
BEGIN

SET @stageCode = (SELECT stageCode FROM approvaltemplatestages WHERE `code`=tempCode AND lineId=Line_Id);
SET @authCode = (SELECT `code` FROM approvalstages WHERE stageCode  =  @stageCode);
SET @id = (SELECT id FROM approvalstagedetails WHERE `code`=@authCode AND lineId=Line_Id);


RETURN @id;
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


-- CALL sp_get_holidaysholiday(0,@num,@msg); SELECT @msg;
DROP PROCEDURE IF EXISTS sp_get_holidaysholiday; 
DELIMITER $$  
CREATE PROCEDURE sp_get_holidaysholiday
( 
IN pint_mode INT,	 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SET @year =( SELECT YEAR(MAX(holidayDate))-1 FROM holidaysholiday);

SELECT holidayDate,holidayName FROM holidaysholiday WHERE YEAR(holidayDate)>=@year;

END $$ 
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


DROP PROCEDURE IF EXISTS sp_leave_days_options; 
DELIMITER $$  
CREATE PROCEDURE sp_leave_days_options
( 
IN pint_mode INT,	
IN df VARCHAR(30),
IN dt VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

DROP TEMPORARY TABLE IF EXISTS selectedDays;
CREATE TEMPORARY TABLE selectedDays AS(

		SELECT holidayDate AS daysDate,holidayName  AS daysName
		FROM holidaysholiday
		WHERE holidayDate BETWEEN df AND dt 		 
	
);

SELECT * FROM selectedDays;	  
END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_leave_get_balance; 
DELIMITER $$  
CREATE PROCEDURE sp_leave_get_balance
( 
IN pint_mode INT,	
IN emp_id VARCHAR(30), 
IN la_Type VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SET @code = (SELECT `code` FROM identity WHERE identityId=emp_id); 

IF (pint_mode=0) THEN

	SET @Total = IFNULL((SELECT SUM(laTotalDays) FROM leaveapplicationform WHERE laID=emp_id AND laType=laType AND laStatus='P'),0);  
	SET msg = (SELECT currentBalance FROM employeeleavebalances WHERE `code`=@code  AND leaveCode=la_Type);
	SELECT (CASE WHEN msg<0 THEN '0:00' ELSE msg END) AS balance; 
	
END IF; 

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_overtime_delete; 
DELIMITER $$   
CREATE PROCEDURE sp_overtime_delete
( 
IN pintMode INT, 	
IN ot_AppNo VARCHAR(30),  
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
UPDATE overtimeform SET otStatus='C' WHERE otAppNo=ot_AppNo; 
UPDATE approval SET decision='C' WHERE appNo=ot_AppNo AND document='overtime';
SET msg = CONCAT('Overtime application No.',ot_AppNo,' has been successfully canceled');
COMMIT;

END $$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_ob_application_cancel; 
DELIMITER $$ 
CREATE PROCEDURE sp_ob_application_cancel
(  
IN pint_mode INT,    
IN r_obAppNo VARCHAR(30), 
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
UPDATE officialbusinessform SET obStatus='C' WHERE obAppNo=r_obAppNo; 
UPDATE approval SET decision='C' WHERE appNo=r_obAppNo AND document='officialbusiness';
SET msg = CONCAT('Official business application No',r_obAppNo,' has been successfully canceled');
COMMIT;


END $$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_time_adj_cancel_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_time_adj_cancel_request
(  
IN pint_mode INT,  
IN ta_AppNo INT,    
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
UPDATE timeadjustmentform SET taStatus='C'  WHERE taAppNo=ta_AppNo; 
UPDATE approval SET decision='C' WHERE appNo=ta_AppNo AND document='timeadjustment';
COMMIT;

END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_timeentry_delete_request;  
DELIMITER $$ 
CREATE PROCEDURE sp_timeentry_delete_request
(  
IN pint_mode INT,  
IN te_AppNo INT,    
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
UPDATE timeentryform SET teStatus='C'  WHERE teAppNo=te_AppNo;  
UPDATE approval SET decision='C' WHERE appNo=te_AppNo AND document = 'timeentry';
SET msg = CONCAT('Time entry application No.',te_AppNo,' has been successfully canceled'); 
COMMIT;

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_request_get_history; 
DELIMITER $$ 
CREATE PROCEDURE sp_request_get_history
(  
IN pint_mode INT,     
IN approver_id VARCHAR(30),
IN requster_id VARCHAR(30),
IN id INT, 
IN appDateFrom VARCHAR(30),
IN appDateTo VARCHAR(30),
IN appStatus VARCHAR(1),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 

SET num = 0;
SET msg = 'Success';


SET @df = (CASE WHEN appDateFrom='' THEN DATE_SUB(DATE(NOW()), INTERVAL 1 MONTH) ELSE appDateFrom END);
SET @dt = (CASE WHEN appDateTo='' THEN DATE(NOW()) ELSE appDateTo END); 

-- SET msg = CONCAT(@df,' - ',@dt);

IF (pint_mode=0) THEN -- OVERTIME

IF (approver_id>0) THEN 

	SELECT *
	FROM overtimeapproverhistory
	WHERE approverId=approver_id 
		AND otAppNo=(CASE WHEN id>0 THEN id ELSE otAppNo END)
		AND otAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;

END IF;

IF (requster_id>0) THEN

	SELECT *
	FROM overtimeapproverhistory
	WHERE otID=requster_id 
		AND otAppNo=(CASE WHEN id>0 THEN id ELSE otAppNo END)
		AND otAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;
END IF;

END IF;



IF (pint_mode=1) THEN -- LEAVE

IF (approver_id>0) THEN

	SELECT *
	FROM leaveapproverhistory
	WHERE approverId=approver_id 
		AND laAppNo=(CASE WHEN id>0 THEN id ELSE laAppNo END)
		AND laAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;

END IF;



IF (requster_id>0) THEN

	SELECT *
	FROM leaveapproverhistory
	WHERE laID=requster_id 
		AND laAppNo=(CASE WHEN id>0 THEN id ELSE laAppNo END)
		AND laAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;
END IF;

END IF;

IF (pint_mode=2) THEN -- TIME ADJUSTMENT

IF (approver_id>0) THEN

	SELECT *
	FROM timeadjustmentapproverhistory
	WHERE approverId=approver_id 
		AND taAppNo=(CASE WHEN id>0 THEN id ELSE taAppNo END)
		AND taAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;

END IF;



IF (requster_id>0) THEN

	SELECT *
	FROM timeadjustmentapproverhistory
	WHERE taID=requster_id 
			AND taAppNo=(CASE WHEN id>0 THEN id ELSE taAppNo END)
		AND taAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;
END IF;

END IF;

IF (pint_mode=3) THEN -- OFFICIAL BUSINESS

IF (approver_id>0) THEN

	SELECT *
	FROM officialbusinessapproverhistory
	WHERE approverId=approver_id 
		AND obAppNo=(CASE WHEN id>0 THEN id ELSE obAppNo END)
		AND obAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;

END IF;



IF (requster_id>0) THEN

	SELECT *
	FROM officialbusinessapproverhistory
	WHERE obID=requster_id 
			AND obAppNo=(CASE WHEN id>0 THEN id ELSE obAppNo END)
		AND obAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;
END IF;

END IF;



IF (pint_mode=4) THEN -- OFFSET

IF (approver_id>0) THEN

	SELECT *
	FROM offsetapproverhistory
	WHERE approverId=approver_id 
		AND osAppNo=(CASE WHEN id>0 THEN id ELSE osAppNo END)
		AND osAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;

END IF;



IF (requster_id>0) THEN

	SELECT *
	FROM offsetapproverhistory
	WHERE osID=requster_id 
			AND osAppNo=(CASE WHEN id>0 THEN id ELSE osAppNo END)
		AND osAppDate BETWEEN  @df AND @dt
		AND decision IN (CASE WHEN appStatus='' THEN decision ELSE appStatus END)
	ORDER BY `timeStamp` DESC;
END IF;

END IF;

END $$
DELIMITER ; 


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_get_approval`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_approval`( 
IN pint_mode INT,
IN switch INT,	
IN r_appNo VARCHAR(50), 
IN r_Opt TEXT,
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start: BEGIN 

SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch);
SET r_appNo = (CASE WHEN r_appNo LIKE '%N/A%' THEN 0 ELSE r_appNo END);

-- SELECT * FROM documentMaster
-- CALL sp_get_approval(0,3,21,'{"srcDB":"mjci_land_corp"}',@num,@msg); SELECT @msg;

-- DROP TABLE IF EXISTS tmpJson; CREATE TABLE tmpJson AS SELECT r_Opt;
-- SELECT * FROM tmpJson 
-- SET @db =  (SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB')) FROM tmpJson);
SET @db =  IFNULL((SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_Opt),'$.srcDB'))),DATABASE());


SET @pNeedDB =  'manilajockey_v4_test,mjci_jockey_club,mjci_san_lazaro,mjci_land_corp,mjci_vertex_inc';

DROP TEMPORARY TABLE IF EXISTS tempAllstages;
SET @sql =CONCAT('CREATE TEMPORARY TABLE tempAllstages AS ',(SELECT GROUP_CONCAT(
	    CONCAT(
		'
		SELECT t1.`stageCode`,t1.`stageName`,t2.`id` AS authId,t2.`authorizer`,t2.`lineId`
			, ''', REPLACE(NAME, '''', ''''''),''' AS stageDB   
		FROM `', REPLACE(NAME, '`', '``'), '`.`approvalstages` t1
		LEFT JOIN  `', REPLACE(NAME, '`', '``'), '`.`approvalstagedetails`  t2 ON t1.`code`=t2.`code`
		 '
		    )  SEPARATOR ' UNION ALL '
		)
		FROM `pf-common`.`databases`
		 WHERE FIND_IN_SET(NAME, @pNeedDB) > 0
	   ));
-- SELECT @sql; LEAVE proc_start;
-- CALL sp_application_info3(1,1,0,'280610','F','1991-01-01','','',@num,@msg); SELECT @msg;
  
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt; 

DROP TEMPORARY TABLE IF EXISTS approvalHist;
CREATE TEMPORARY TABLE approvalHist AS
SELECT  DISTINCT  tempAllstages.stageName AS Stage,
approval.approverName,
approval.decision,
approval.approvedDate, 
approval.remarks, 
templateLineId,
CONCAT("STAGE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:",stageName," <br> CHECKED BY&nbsp;&nbsp:  ",IFNULL(approverName,"")," <br> DECISION&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  ",IFNULL(decision,""),"<br> APPROVED DATE:  ",IFNULL(approvedDate,"")," <br> REMARKS&nbsp;&nbsp;&nbsp;&nbsp;:",IFNULL(approval.remarks,""))AS hoverMesaage,
(CASE 
	WHEN approval.approverName IS NULL THEN "incompleted" ELSE "completed" 
  END)AS IsComplete,
  (CASE 
	WHEN IFNULL(approval.decision,"")="A" THEN "completed" 
	WHEN IFNULL(approval.decision,"")="D" THEN "rejected" 
	ELSE "incompleted"  
  END)AS class 
FROM approval
LEFT JOIN  `approvaltemplatestages` ON approval.templateCode = approvaltemplatestages.code AND approval.templateLineId = approvaltemplatestages.lineId
LEFT JOIN `tempAllstages` ON approvaltemplatestages.stageCode = tempAllstages.stageCode
WHERE appNo = r_appNo AND  document=@document;


SELECT Stage,
approverName,
decision,
approvedDate,
remarks,
templateLineId,
(CASE 
	WHEN IFNULL(t2.decs,'')='D' THEN 'Not submitted on approver'
	WHEN approverName IS NULL THEN CONCAT('Pending for ',Stage,'...') 
	ELSE hoverMesaage END
  )AS hoverMesaage,
ROW_NUMBER() OVER () AS row_num,
IsComplete,
class,t2.line,t2.decs
FROM approvalHist t1
LEFT JOIN (SELECT templateLineId AS line,decision AS decs FROM approvalHist) t2 ON (t1.templateLineId-1)=t2.line
GROUP BY templateLineId,decision
ORDER BY t1.templateLineId;

END$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_check_payroll_period_status;
DELIMITER $$ 
CREATE PROCEDURE sp_check_payroll_period_status
(  
IN pint_mode INT,	 
IN user_id VARCHAR(30), 
IN appNo INT,  
IN switch INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  


DECLARE date_from DATE;
DECLARE date_to DATE; 

SET num = 0;
SET msg = 'Success';

IF (switch=0) THEN -- OVERTIME
	
	SET date_from=(SELECT otDate FROM overtimeform WHERE otAppNo=appNo);
	SET date_to=(SELECT otDate FROM overtimeform WHERE otAppNo=appNo); 

END IF;

IF (switch=1) THEN -- LEAVE
	
	SET date_from=(SELECT laAppDate FROM leaveapplicationform WHERE laAppNo=appNo);
	SET date_to=(SELECT laAppDate FROM leaveapplicationform WHERE laAppNo=appNo);  

END IF;

IF (switch=2) THEN -- TIMEADJUSTMENT
	
	SET date_from=(SELECT taDate FROM timeadjustmentform WHERE taAppNo=appNo);
	SET date_to=(SELECT taDate FROM timeadjustmentform WHERE taAppNo=appNo);  

END IF;

IF (switch=4) THEN -- OFFSET
	
	SET date_from=(SELECT osDate FROM offsetform WHERE osAppNo=appNo);
	SET date_to=(SELECT osDate FROM offsetform WHERE osAppNo=appNo); 

END IF;



SELECT IFNULL(payrollperioddetails.`payrollPeriodApproverLocked`,0) AS approverLocked,
	payrollperioddetails.`payrollPeriodKioskLocked` AS periodKioskLocked,
	payrollperioddetails.`payrollPeriodLocked` AS periodLocked,
	payrollperioddetails.`payrollPeriodProcessLocked` AS periodProcessLocked,
	payrollperioddetails.`payrollPeriodScheduleTaggingLocked`  AS periodScheduleTaggingLocked,
	payrollPeriodFrom,payrollPeriodTo,date_from,date_to
FROM identity 
LEFT JOIN payrollgroup ON
identity.batchId = payrollgroup.payrollGroupCode

LEFT JOIN payrollconfiguration ON
payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

LEFT JOIN payrollperiod ON payrollconfiguration.paymentFrequency = 
			(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code

WHERE identity.identityId = user_id 
	AND payrollperioddetails.payrollPeriodKioskLocked = '1' 
	AND payrollperioddetails.payrollPeriodFrom <= date_from
	AND payrollperioddetails.payrollPeriodTo >= date_to
	
	UNION ALL
	
	SELECT 0 AS approverLocked,
	0 AS periodKioskLocked,
		0  AS periodLocked,
		0  AS periodProcessLocked,
		0   AS periodScheduleTaggingLocked,
		'1991-01-01' AS payrollPeriodFrom,
		'1991-01-01' AS payrollPeriodTo,
		date_from,
		date_to;


END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_for_approval_get_all_detail;  	
DELIMITER $$  
CREATE PROCEDURE sp_for_approval_get_all_detail
(
IN  pint_mode INT, 
IN  user_id VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success'; 



SET @document = (CASE
			WHEN pint_mode=0 THEN 'overtime'
			WHEN pint_mode=1 THEN 'leave'
			WHEN pint_mode=2 THEN 'timeadjustment'
			WHEN pint_mode=3 THEN 'officialbusiness'
			WHEN pint_mode=4 THEN 'offset'
			ELSE ''
		END); 


DROP TEMPORARY TABLE IF EXISTS tempApproval;
CREATE TEMPORARY TABLE tempApproval AS(

		SELECT approval.templateCode,
			approval.templateLineId,
			approval.appNo,approval.id AS appIdentityId 
		FROM approvaltemplateoriginator

		LEFT JOIN approval ON
		approvaltemplateoriginator.id = approval.id

		LEFT JOIN approvaltemplatestages ON
		approvaltemplatestages.code = approval.templateCode AND
		approvaltemplatestages.lineId = approval.templateLineId AND
		approvaltemplateoriginator.code = approvaltemplatestages.code

		LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode

		LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code

		

		WHERE  approval.document = @document AND
			approvalstagedetails.id =user_id AND approval.decision = 'F'  
);


IF (@document='overtime') THEN

	DROP TEMPORARY TABLE IF EXISTS tempApproval2;
	CREATE TEMPORARY TABLE tempApproval2 AS(
		SELECT overtimeform.*,templateCode,templateLineId,appNo,appIdentityId
			,overtimeform.`otDate` AS appDate,otCosCenter AS costCenter 
		FROM tempApproval t1 
		LEFT JOIN overtimeform ON overtimeform.otAppNo = t1.appNo
		); 
END IF;


IF (@document='offset') THEN

	DROP TEMPORARY TABLE IF EXISTS tempApproval2;
	CREATE TEMPORARY TABLE tempApproval2 AS(
		SELECT offsetform.*,templateCode,templateLineId,appNo,appIdentityId
			,offsetform.`osDate` AS appDate,osCosCenter AS costCenter 
		FROM tempApproval t1 
		LEFT JOIN offsetform ON offsetform.osAppNo = t1.appNo
		); 
END IF;


IF (@document='leave') THEN

	DROP TEMPORARY TABLE IF EXISTS tempApproval2;
	CREATE TEMPORARY TABLE tempApproval2 AS(
		SELECT leaveapplicationform.*,templateCode,templateLineId,appNo,appIdentityId
			,leaveapplicationform.`laAppDate` AS appDate,laCosCenter AS costCenter 
		FROM tempApproval t1 
		LEFT JOIN leaveapplicationform ON leaveapplicationform.laAppNo = t1.appNo
		); 
END IF;

	IF (@document='timeadjustment') THEN

	DROP TEMPORARY TABLE IF EXISTS tempApproval2;
	CREATE TEMPORARY TABLE tempApproval2 AS(
		SELECT timeadjustmentform.*,templateCode,templateLineId,appNo,appIdentityId
			,timeadjustmentform.`taDate` AS appDate,taCosCenter AS costCenter 
		FROM tempApproval t1 
		LEFT JOIN timeadjustmentform ON timeadjustmentform.taAppNo = t1.appNo
		); 
END IF;

	IF (@document='officialbusiness') THEN

	DROP TEMPORARY TABLE IF EXISTS tempApproval2;
	CREATE TEMPORARY TABLE tempApproval2 AS(
		SELECT officialbusinessform.*,templateCode,templateLineId,appNo,appIdentityId
			,officialbusinessform.`obAppDate` AS appDate,obCosCenter AS costCenter 
		FROM tempApproval t1 
		LEFT JOIN officialbusinessform ON officialbusinessform.obAppNo = t1.appNo
		); 
END IF;


SELECT t1.*,
	dep.`departmentName`,
	cost.`costName`, 
	payrollperioddetails.payrollPeriodApproverLocked  AS approverLocked
FROM tempApproval2 t1

LEFT JOIN department dep ON
dep.`departmentCode` = t1.`department`

LEFT JOIN costcenter cost ON
cost.`costCode` = t1.`costCenter`

LEFT JOIN identity ON
t1.appIdentityId = identity.identityId


LEFT JOIN payrollgroup ON
identity.batchId = payrollgroup.payrollGroupCode


LEFT JOIN payrollconfiguration ON
identity.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

LEFT JOIN payrollperiod ON
identity.paymentFrequency = 
(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)
AND YEAR(t1.appDate) = payrollperiod.`payrollPeriodYear`
AND identity.payrollPeriodID = payrollperiod.`payrollPeriodID`


LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code

AND payrollperioddetails.payrollPeriodFrom <= t1.appDate
AND payrollperioddetails.payrollPeriodTo >= t1.appDate


WHERE   t1.appNo IS NOT NULL
	GROUP BY t1.appNo
;


END $$ 
DELIMITER ;

DROP TABLE IF EXISTS v_application_max_line;		
DROP VIEW IF EXISTS v_application_max_line;
DELIMITER $$  
CREATE  VIEW `v_application_max_line` AS 



SELECT MAX(templateLineId)AS templateLineId,appNo,document
FROM approval 
WHERE (CASE WHEN templateLineId=1 AND approver IS NULL THEN id ELSE approver END) IS NOT NULL
GROUP BY appNo,document;


$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_timeentry_load_request; 
DELIMITER $$  
CREATE PROCEDURE sp_timeentry_load_request
( 
IN pint_mode INT,	 
IN r_teAppNo INT, 
IN r_ID VARCHAR(30),  
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg = 'Success';


/*
	0 - Requester
	1-  Approver
*/


IF (pint_mode=0) THEN
	
	IF (r_teAppNo=0) THEN 
		
		SELECT t1.*,t5.departmentName,t6.costName,t7.appNo,t7.templateCode
			,IFNULL(t8.decision,t1.teStatus) AS appStatus,t9.txt
		FROM timeentryform  t1
		LEFT JOIN identity t2 ON t1.teID=t2.identityId
		LEFT JOIN v_employee_max_line t3 ON t2.code=t3.code
		LEFT JOIN employeemovement t4 ON t4.code=t3.code AND t4.lineId=t3.lineId
			LEFT JOIN department t5 ON t5.departmentCode=t4.departmentCode
			LEFT JOIN costCenter t6 ON t6.costCode=t4.costCode
			LEFT JOIN v_application_max_line t7 ON t1.teAppNo=t7.appNo AND t7.document='timeentry'
			LEFT JOIN approval t8 ON t7.appNo=t7.appNo AND t7.document=t8.document AND t7.templateCode=t8.templateCode AND t7.templateLineId=IFNULL(t8.templateLineId,1) 
			LEFT JOIN statusMaster t9 ON t9.val=IFNULL(t8.decision,t1.teStatus)
		WHERE t1.teID = r_ID; 
		
	END IF;
	
END IF;
END $$ 
DELIMITER ;


DROP TABLE IF EXISTS v_employee_max_line;
DROP VIEW IF EXISTS v_employee_max_line;
DELIMITER $$  
CREATE  VIEW `v_employee_max_line` AS 



SELECT MAX(lineId)AS lineId,`code` 
FROM employeemovement 
WHERE (departmentCode IS NOT NULL OR costCode IS NOT NULL) 
GROUP BY `code`


$$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_for_approval_get_all;  	
DELIMITER $$  
CREATE PROCEDURE sp_for_approval_get_all
(
IN  pint_mode INT, 
IN  user_id VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


SET @document=(
		CASE 
			WHEN pint_mode=0 THEN 'overtime'
			WHEN pint_mode=1 THEN 'leave'
			WHEN pint_mode=2 THEN 'timeadjustment'
			WHEN pint_mode=3 THEN 'officialbusiness'
			WHEN pint_mode=4 THEN 'offset'
		END
		);


DROP TEMPORARY TABLE IF EXISTS temp_approval;
CREATE TEMPORARY TABLE temp_approval(
	id INT AUTO_INCREMENT,
	appNo INT,
	document VARCHAR(30),
	templateCode VARCHAR(30),
	templateLineId INT,
	PRIMARY KEY (id,appNo,templateCode,templateLineId)
);
	
	INSERT INTO temp_approval (appNo,document,templateCode,templateLineId)
SELECT appNo,document,templateCode,templateLineId  
FROM approval 
WHERE decision IN ('P','F')
	AND document=@document;
	
SELECT * 
FROM temp_approval
WHERE document=@document;


END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_overtime_get_request; 
DELIMITER $$   
CREATE PROCEDURE sp_overtime_get_request
( 
IN pintMode INT, 	
IN ot_ID     VARCHAR(30),
IN ot_appNo INT, 	
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF pintMode=0 THEN
	SELECT otAppNo,otID,otName,
			otAppDate, otCosCenter,otDate,otTimeFrom,
		otTimeTo,otTotHours,otHours,otMinutes,otReason,
		otReqDate,otStatus,txt AS statausVal,otReason, otApprover,
		otApprovedDateTime,department,otType,
		batchId,location,locationName,otFrDate,otToDate
		,(CONCAT((CASE WHEN CHAR_LENGTH(SUBSTRING_INDEX(otBreak, '.', 1))<=1 THEN CONCAT('0',SUBSTRING_INDEX(otBreak, '.', 1)) ELSE SUBSTRING_INDEX(otBreak, '.', 1) END),':',SUBSTRING_INDEX(otBreak, '.', -1))) AS otBreak
	FROM overtimeform 
	LEFT JOIN statusMaster sts ON overtimeform.`otStatus` = sts.val
	WHERE otID=ot_ID AND otStatus IN ('P','F');
	
ELSEIF pintMode=1 THEN 

	SELECT otAppNo,otID,otName,
		otAppDate,
		costCenter.`costName` AS otCosCenter,
		otDate,otTimeFrom,
		otTimeTo,otTotHours,otHours,otMinutes,otReason,
		otReqDate,otStatus,otReason, otApprover,
		otApprovedDateTime,
		department.`departmentName` AS department,
		otType,
		batchId,location,locationName,otFrDate,otToDate
			,(CONCAT((CASE WHEN CHAR_LENGTH(SUBSTRING_INDEX(otBreak, '.', 1))<=1 THEN CONCAT('0',SUBSTRING_INDEX(otBreak, '.', 1)) ELSE SUBSTRING_INDEX(otBreak, '.', 1) END),':',SUBSTRING_INDEX(otBreak, '.', -1))) AS otBreak
		-- ,otBreak
		,approval.approverName,approval.approvedDate,approval.decision,approval.remarks,txt AS statausVal
	FROM overtimeform
	LEFT JOIN costCenter ON overtimeform.otCosCenter = costCenter.`costCode`
	LEFT JOIN department ON overtimeform.department = department.`departmentCode`   
	LEFT JOIN approval ON overtimeform.otAppNo=approval.appNo AND approval.document='overtime'
	LEFT JOIN statusMaster sts ON overtimeform.`otStatus` = sts.val
	WHERE otAppNo=ot_appNo;
	
	ELSEIF (pintMode=2) THEN
	
	SELECT t2.remarks,t2.approvedDate,t2.decision,t2.approverName
		,t1.otAppNo,t1.otID,t1.otName,t1.otAppDate,otCosCenter,otDate,otTimeFrom,otTimeTo,otTotHours,otHours,otMinutes,otReason,otReqDate,otRemarks,department,otBreak,otType,location,locationName,`timeStamp`
	FROM overtimeapproverhistory t1 
	LEFT JOIN (SELECT MAX(templateLineId)AS lineId,appNo 
		FROM approval WHERE appNo=ot_appNo  AND document='overtime' AND approvedDate IS NOT NULL 
		)line ON t1.otAppNo = line.appNo  
	LEFT JOIN approval t2 ON line.appNo=t2.appNo AND t2.document='overtime' AND t2.templateLineId=line.lineId
	WHERE   otAppNo=ot_appNo;
	
	
ELSE 
	SELECT otAppNo,otID,otName,
		otAppDate, otCosCenter,otDate,otTimeFrom,
		otTimeTo,otTotHours,otHours,otMinutes,otReason,
		otReqDate,otStatus,txt AS statausVal,otReason, otApprover,
		otApprovedDateTime,department,otType,
		batchId,location,locationName,otFrDate,otToDate
		,(CONCAT((CASE WHEN CHAR_LENGTH(SUBSTRING_INDEX(otBreak, '.', 1))<=1 THEN CONCAT('0',SUBSTRING_INDEX(otBreak, '.', 1)) ELSE SUBSTRING_INDEX(otBreak, '.', 1) END),':',SUBSTRING_INDEX(otBreak, '.', -1))) AS otBreak
	FROM overtimeform 
	LEFT JOIN statusMaster sts ON overtimeform.`otStatus` = sts.val
	WHERE otID=ot_ID AND otAppNo=ot_appNo  AND otStatus='P';
	
END IF;

END $$ 
DELIMITER ;


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


	
DROP PROCEDURE IF EXISTS sp_offset_get_details; 
DELIMITER $$ 
CREATE PROCEDURE sp_offset_get_details
( 
IN pint_mode INT,
IN emp_id VARCHAR(30),
IN r_id INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN

	SELECT t1.*,txt AS statausVal
	FROM offsetform t1
	LEFT JOIN statusMaster sts ON t1.`osStatus` = sts.val
	WHERE osID=emp_id AND osStatus IN ('P','F')
	ORDER BY osAppNo DESC;
	
END IF;

IF (pint_mode=1) THEN

SELECT *, LEFT(osTimeFrom,5)AS osTimeFrom2, LEFT(osTimeTo,5)AS osTimeTo2
,approval.approverName,approval.approvedDate,approval.decision,approval.remarks
FROM offsetform
LEFT JOIN (SELECT MAX(templateLineId)AS lineId,appNo 
		FROM approval WHERE appNo=r_id  AND document='offset' AND approvedDate IS NOT NULL 
		)line ON offsetform.osAppNo = line.appNo 
LEFT JOIN approval ON line.appNo=approval.appNo AND approval.document='offset' AND approval.`templateLineId`=line.lineId
WHERE osAppNo=r_id;
	
END IF;


END $$
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_time_adj_get_all_request; 
DELIMITER $$ 
CREATE PROCEDURE sp_time_adj_get_all_request
(  
IN pint_mode INT, 
IN user_id VARCHAR(30),   
IN ta_AppNo INT,    
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


IF (ta_AppNo=0) THEN

	SELECT t1.*,txt AS statusVal
	FROM timeadjustmentform t1
	LEFT JOIN statusMaster sts ON t1.`taStatus` = sts.val
	WHERE taID=user_id AND taStatus IN ('P','F')
	ORDER BY taAppNo DESC;
	
ELSE 

	SELECT *
		,approval.approverName,approval.approvedDate,approval.decision,approval.remarks
	FROM timeadjustmentform ta
	LEFT JOIN department dep ON ta.`department` = dep.`departmentCode`
	LEFT JOIN costcenter cost ON ta.`taCosCenter` = cost.`costCode` 
	LEFT JOIN (SELECT MAX(templateLineId)AS lineId,appNo 
		FROM approval WHERE appNo=ta_AppNo  AND document='timeadjustment' AND approvedDate IS NOT NULL 
		)line ON ta.taAppNo = line.appNo
	LEFT JOIN approval ON ta.taAppNo=approval.appNo AND approval.document='timeadjustment' AND approval.`templateLineId`=line.lineId
	WHERE taAppNo=ta_AppNo;
	
END IF;

END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_portal_mfa_activation; 
DELIMITER $$   
CREATE PROCEDURE sp_portal_mfa_activation
(  
IN pint_mode INT,  
IN rIdentityId VARCHAR(50),     
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

-- SELECT TRUE AS IsActive;
SELECT FALSE AS IsActive;

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_portal_mfa; 
DELIMITER $$   
CREATE PROCEDURE sp_portal_mfa
(  
IN pint_mode INT, 
IN rType VARCHAR(30),  
IN rCode VARCHAR(100),
IN rIdentityId VARCHAR(50),     
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN
-- -TRUNCATE TABLE portal_mfa;
-- UPDATE portal_mfa SET usedIdBy=NULL,useDate=NULL,systemDate=NOW() WHERE id=5

SELECT * 
FROM portal_mfa
WHERE `code`=rCode AND usedIdBy IS NULL
;

END IF;


IF (pint_mode=1) THEN 
INSERT INTO portal_mfa (`type`,`code`,identityId)
VALUES (rType,rCode,rIdentityId); 
END IF;

IF (pint_mode=2) THEN

IF EXISTS (SELECT 1  FROM portal_mfa WHERE `code`=rCode AND usedIdBy IS NOT NULL ) THEN
	SET num = 1;
	SET msg = 'OTP is already used'; 
ELSEIF EXISTS (SELECT 1 FROM portal_mfa  WHERE `code`=rCode  AND usedIdBy IS NULL  AND (TIMESTAMPDIFF(SECOND,systemDate,NOW()))>60) THEN
	SET num = 1;
	SET msg = 'OTP is already expired'; 
ELSEIF EXISTS (SELECT 1  FROM portal_mfa WHERE `code`=rCode AND usedIdBy IS NULL ) THEN
	SET num = 0;
	SET msg = 'OK';
	
	UPDATE portal_mfa SET usedIdBy=rIdentityId,useDate= DATE(NOW()) 
	WHERE `code`=rCode AND usedIdBy IS NULL;
	
ELSE 
	SET num = 1;
	SET msg = 'Invalid OTP Code';
END IF;

END IF;

END $$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_ob_application_get_all_request; 
DELIMITER $$   
CREATE PROCEDURE sp_ob_application_get_all_request
(  
IN pint_mode INT, 
IN r_id INT,
IN id VARCHAR(30),     
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (r_id=0) THEN

SELECT t1.*,txt AS statusVal 
FROM officialbusinessform t1
LEFT JOIN statusMaster sts ON t1.`obStatus` = sts.val
WHERE obID=id 
AND obStatus IN ('P','F');
ELSE 

SELECT * 
	,approval.approverName,approval.approvedDate,approval.decision,approval.remarks
FROM officialbusinessform ob
LEFT JOIN department dep ON ob.`department` = dep.`departmentCode`
LEFT JOIN costcenter cost ON ob.`obCosCenter` = cost.`costCode` 
LEFT JOIN approval ON ob.obAppNo=approval.appNo AND approval.document='officialbusiness'
WHERE obAppNo=r_id;
	
END IF;  

END $$ 
DELIMITER ;

DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_insert_user_password_logs`$$
CREATE PROCEDURE `sp_portal_insert_user_password_logs`(
IN pint_mode INT,
IN identityId VARCHAR(20),
IN userPassword VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 


SET num = 0;
SET msg = 'Success';
IF (pint_mode=0) THEN -- select count

	INSERT INTO user_password_logs (username, dt_created, `password`) VALUES (identityId, NOW(),userPassword);
				
END IF;

IF (pint_mode=1) THEN -- update pStatus


	UPDATE users SET pStatus = 'E' WHERE username = identityId;
				
END IF;


END$$
DELIMITER ;

DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_update_user_password`$$ 
CREATE PROCEDURE `sp_portal_update_user_password`(
IN pint_mode INT,
IN p_identityId VARCHAR(20),
IN userPassword VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';
IF (pint_mode=0) THEN -- leave

	UPDATE users
	SET 
		`password` = userPassword,
		`pw_last_date_changed` = NOW(),
		`attempts` = 0,
		`passwords_used` = userPassword
	WHERE 
		`identityid` = p_identityId;
		
END IF;

IF (pint_mode=1) THEN -- insert password_use

	UPDATE users
	SET 
		`pw_last_date_changed` = NOW(),
		`passwords_used` = userPassword
	WHERE 
		`identityid` = p_identityId;
			
END IF;

END$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_approval_appNo_details;
DELIMITER $$  
CREATE PROCEDURE sp_approval_appNo_details
( 
IN pint_mode INT,	
IN r_appNo VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


SELECT *  FROM approval WHERE appNo=r_appNo;

END $$ 
DELIMITER ; 



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_rpt_get_employee_nthmonth`$$ 
CREATE PROCEDURE `sp_rpt_get_employee_nthmonth`(
IN pint_mode INT,
IN id VARCHAR(100),
IN df VARCHAR(30),
IN dt VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

SET df=(CASE WHEN df='' THEN '1900-01-01' ELSE df END); 
SET dt=(CASE WHEN dt='' THEN DATE(NOW()) ELSE dt END); 

	IF (pint_mode=0) THEN
	SELECT * 
	FROM employee13thmonthpay 
	WHERE identityId = id 
		AND STATUS = 'A'
		AND payoutdate BETWEEN df AND dt;
END IF; 

END$$
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_employee_nthmonth`$$ 
CREATE PROCEDURE `sp_get_employee_nthmonth`(
IN pint_mode INT,
IN id VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


IF (pint_mode=0) THEN
	SELECT * 
	FROM employee13thmonthpay 
	WHERE identityId = id AND STATUS = 'A';
END IF;


IF (pint_mode=1) THEN
	SELECT * 
	FROM employee13thmonthpay 
	WHERE `code`=id;
END IF;

END$$
DELIMITER ;

DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_signatories`$$ 
CREATE PROCEDURE `sp_get_signatories`(
IN pint_mode INT, 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


SELECT * FROM signatories;

END$$
DELIMITER ;



-- CALL sp_pf_common_sub_app_license (0,'','mdb_demo_v4',@num,@msg);
DROP PROCEDURE IF EXISTS sp_pf_common_sub_app_license; -- 
DELIMITER $$  
CREATE PROCEDURE sp_pf_common_sub_app_license  
(  
IN rMode INT,	  
IN appName VARCHAR(100), 
IN dbName VARCHAR(50),	 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN   
/*

	0 - SELECT
*/

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

SET num=0;
SET msg='Success';

/* 
SELECT title AS appName
	,(CASE 
		WHEN title LIKE '%RECRUITMENT%BUSINESS%' THEN 'open_rbp'
		WHEN title LIKE '%TRAINING%DEVELOPMENT%' THEN 'open_lms'
	END)AS route
	,(CASE 
		WHEN title LIKE '%RECRUITMENT%BUSINESS%' THEN 'fa-solid fa-user-plus'
		WHEN title LIKE '%TRAINING%DEVELOPMENT%' THEN 'fas fa-graduation-cap'
	END)AS icon
FROM `pf-common`.`menus`
WHERE url IS NOT NULL AND title NOT IN ('RESOURCES','DASHBOARD');
*/

SELECT title AS appName
	,(CASE 
		WHEN title LIKE '%RECRUITMENT%BUSINESS%' THEN 'open_rbp'
		WHEN title LIKE '%TRAINING%DEVELOPMENT%' THEN 'open_lms'
	END)AS route
	,(CASE 
		WHEN title LIKE '%RECRUITMENT%BUSINESS%' THEN 'fa-solid fa-user-plus'
		WHEN title LIKE '%TRAINING%DEVELOPMENT%' THEN 'fas fa-graduation-cap'
	END)AS icon
FROM `pf-common`.`menus`
WHERE db_owner=  DATABASE()
AND   url IS NOT NULL AND title NOT IN ('RESOURCES','DASHBOARD');
END $$ 
DELIMITER ;		


DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_lms_license`$$ 
CREATE PROCEDURE `sp_get_lms_license`(
IN pint_mode INT, 
IN dbName VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success'; 

IF NOT EXISTS(SELECT *FROM `pf-common`.`license_lms` WHERE db_name = dbName) THEN
	
	SELECT 0 AS num;
ELSE

	SET @parentId = ( SELECT MAX(id) FROM `pf-common`.`menus`);
	
	
	INSERT INTO `pf-common`.menus (parent_id, title, url, icon, permission_key, target, sort_order) 
	SELECT *
	FROM(	
		SELECT @parentId, 'TRAINING & DEVELOPMENT' AS menuName, 'http://learningcenter.payfactor.ft/', NULL, 'Resources.LearningCenter.show', '_blank', 2
	)t1
	WHERE menuName NOT IN (SELECT title FROM `pf-common`.menus);
	
	SELECT 1 AS num;
END IF;


END$$
DELIMITER ;


DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_rbp_license`$$ 
CREATE PROCEDURE `sp_get_rbp_license`(
IN pint_mode INT, 
IN dbName VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success'; 

IF NOT EXISTS(SELECT * FROM `pf-common`.`license_rbp` WHERE db_name = dbName) THEN 
	
	
	SELECT 0 AS num;
ELSE
	SET @parentId = ( SELECT MAX(id) FROM `pf-common`.`menus`);
	
	
	INSERT INTO `pf-common`.menus (parent_id, title, url, icon, permission_key, target, sort_order) 
	SELECT *
	FROM(	
		SELECT @parentId, 'RECRUITMENT BUSINESS PROCESS' AS menuName, 'http://rbp.payfactor.ft/', NULL, 'Resources.Recruitment.show', '_blank', 3 
	)t1
	WHERE menuName NOT IN (SELECT title FROM `pf-common`.menus);
	
	SELECT 1 AS num;
END IF;


END$$
DELIMITER ;


DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_get_payslip_param`$$ 
CREATE PROCEDURE `sp_get_payslip_param`(
IN id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';


SELECT identity.batchId AS batchId, groupauthorization.username AS username 
FROM identity, groupauthorization 
WHERE identity.identityId = id
	AND groupauthorization.payrollGroup = identity.batchId 
	LIMIT 1;

END$$
DELIMITER ;

DROP TABLE IF EXISTS v_1krows;
DELIMITER $$  
DROP VIEW IF EXISTS `v_1krows` $$ 
CREATE VIEW `v_1krows` AS 

		SELECT 0 AS n UNION ALL
		SELECT 1 AS n UNION ALL
		SELECT 2 AS n UNION ALL
		SELECT 3 AS n UNION ALL
		SELECT 4 AS n UNION ALL
		SELECT 5 AS n UNION ALL
		SELECT 6 AS n UNION ALL
		SELECT 7 AS n UNION ALL
		SELECT 8 AS n UNION ALL
		SELECT 9 AS n UNION ALL
		SELECT 10 AS n UNION ALL
		SELECT 11 AS n UNION ALL
		SELECT 12 AS n UNION ALL
		SELECT 13 AS n UNION ALL
		SELECT 14 AS n UNION ALL
		SELECT 15 AS n UNION ALL
		SELECT 16 AS n UNION ALL
		SELECT 17 AS n UNION ALL
		SELECT 18 AS n UNION ALL
		SELECT 19 AS n UNION ALL
		SELECT 20 AS n UNION ALL
		SELECT 21 AS n UNION ALL
		SELECT 22 AS n UNION ALL
		SELECT 23 AS n UNION ALL
		SELECT 24 AS n UNION ALL
		SELECT 25 AS n UNION ALL
		SELECT 26 AS n UNION ALL
		SELECT 27 AS n UNION ALL
		SELECT 28 AS n UNION ALL
		SELECT 29 AS n UNION ALL
		SELECT 30 AS n UNION ALL
		SELECT 31 AS n UNION ALL
		SELECT 32 AS n UNION ALL
		SELECT 33 AS n UNION ALL
		SELECT 34 AS n UNION ALL
		SELECT 35 AS n UNION ALL
		SELECT 36 AS n UNION ALL
		SELECT 37 AS n UNION ALL
		SELECT 38 AS n UNION ALL
		SELECT 39 AS n UNION ALL
		SELECT 40 AS n UNION ALL
		SELECT 41 AS n UNION ALL
		SELECT 42 AS n UNION ALL
		SELECT 43 AS n UNION ALL
		SELECT 44 AS n UNION ALL
		SELECT 45 AS n UNION ALL
		SELECT 46 AS n UNION ALL
		SELECT 47 AS n UNION ALL
		SELECT 48 AS n UNION ALL
		SELECT 49 AS n UNION ALL
		SELECT 50 AS n UNION ALL
		SELECT 51 AS n UNION ALL
		SELECT 52 AS n UNION ALL
		SELECT 53 AS n UNION ALL
		SELECT 54 AS n UNION ALL
		SELECT 55 AS n UNION ALL
		SELECT 56 AS n UNION ALL
		SELECT 57 AS n UNION ALL
		SELECT 58 AS n UNION ALL
		SELECT 59 AS n UNION ALL
		SELECT 60 AS n UNION ALL
		SELECT 61 AS n UNION ALL
		SELECT 62 AS n UNION ALL
		SELECT 63 AS n UNION ALL
		SELECT 64 AS n UNION ALL
		SELECT 65 AS n UNION ALL
		SELECT 66 AS n UNION ALL
		SELECT 67 AS n UNION ALL
		SELECT 68 AS n UNION ALL
		SELECT 69 AS n UNION ALL
		SELECT 70 AS n UNION ALL
		SELECT 71 AS n UNION ALL
		SELECT 72 AS n UNION ALL
		SELECT 73 AS n UNION ALL
		SELECT 74 AS n UNION ALL
		SELECT 75 AS n UNION ALL
		SELECT 76 AS n UNION ALL
		SELECT 77 AS n UNION ALL
		SELECT 78 AS n UNION ALL
		SELECT 79 AS n UNION ALL
		SELECT 80 AS n UNION ALL
		SELECT 81 AS n UNION ALL
		SELECT 82 AS n UNION ALL
		SELECT 83 AS n UNION ALL
		SELECT 84 AS n UNION ALL
		SELECT 85 AS n UNION ALL
		SELECT 86 AS n UNION ALL
		SELECT 87 AS n UNION ALL
		SELECT 88 AS n UNION ALL
		SELECT 89 AS n UNION ALL
		SELECT 90 AS n UNION ALL
		SELECT 91 AS n UNION ALL
		SELECT 92 AS n UNION ALL
		SELECT 93 AS n UNION ALL
		SELECT 94 AS n UNION ALL
		SELECT 95 AS n UNION ALL
		SELECT 96 AS n UNION ALL
		SELECT 97 AS n UNION ALL
		SELECT 98 AS n UNION ALL
		SELECT 99 AS n UNION ALL
		SELECT 100 AS n UNION ALL
		SELECT 101 AS n UNION ALL
		SELECT 102 AS n UNION ALL
		SELECT 103 AS n UNION ALL
		SELECT 104 AS n UNION ALL
		SELECT 105 AS n UNION ALL
		SELECT 106 AS n UNION ALL
		SELECT 107 AS n UNION ALL
		SELECT 108 AS n UNION ALL
		SELECT 109 AS n UNION ALL
		SELECT 110 AS n UNION ALL
		SELECT 111 AS n UNION ALL
		SELECT 112 AS n UNION ALL
		SELECT 113 AS n UNION ALL
		SELECT 114 AS n UNION ALL
		SELECT 115 AS n UNION ALL
		SELECT 116 AS n UNION ALL
		SELECT 117 AS n UNION ALL
		SELECT 118 AS n UNION ALL
		SELECT 119 AS n UNION ALL
		SELECT 120 AS n UNION ALL
		SELECT 121 AS n UNION ALL
		SELECT 122 AS n UNION ALL
		SELECT 123 AS n UNION ALL
		SELECT 124 AS n UNION ALL
		SELECT 125 AS n UNION ALL
		SELECT 126 AS n UNION ALL
		SELECT 127 AS n UNION ALL
		SELECT 128 AS n UNION ALL
		SELECT 129 AS n UNION ALL
		SELECT 130 AS n UNION ALL
		SELECT 131 AS n UNION ALL
		SELECT 132 AS n UNION ALL
		SELECT 133 AS n UNION ALL
		SELECT 134 AS n UNION ALL
		SELECT 135 AS n UNION ALL
		SELECT 136 AS n UNION ALL
		SELECT 137 AS n UNION ALL
		SELECT 138 AS n UNION ALL
		SELECT 139 AS n UNION ALL
		SELECT 140 AS n UNION ALL
		SELECT 141 AS n UNION ALL
		SELECT 142 AS n UNION ALL
		SELECT 143 AS n UNION ALL
		SELECT 144 AS n UNION ALL
		SELECT 145 AS n UNION ALL
		SELECT 146 AS n UNION ALL
		SELECT 147 AS n UNION ALL
		SELECT 148 AS n UNION ALL
		SELECT 149 AS n UNION ALL
		SELECT 150 AS n UNION ALL
		SELECT 151 AS n UNION ALL
		SELECT 152 AS n UNION ALL
		SELECT 153 AS n UNION ALL
		SELECT 154 AS n UNION ALL
		SELECT 155 AS n UNION ALL
		SELECT 156 AS n UNION ALL
		SELECT 157 AS n UNION ALL
		SELECT 158 AS n UNION ALL
		SELECT 159 AS n UNION ALL
		SELECT 160 AS n UNION ALL
		SELECT 161 AS n UNION ALL
		SELECT 162 AS n UNION ALL
		SELECT 163 AS n UNION ALL
		SELECT 164 AS n UNION ALL
		SELECT 165 AS n UNION ALL
		SELECT 166 AS n UNION ALL
		SELECT 167 AS n UNION ALL
		SELECT 168 AS n UNION ALL
		SELECT 169 AS n UNION ALL
		SELECT 170 AS n UNION ALL
		SELECT 171 AS n UNION ALL
		SELECT 172 AS n UNION ALL
		SELECT 173 AS n UNION ALL
		SELECT 174 AS n UNION ALL
		SELECT 175 AS n UNION ALL
		SELECT 176 AS n UNION ALL
		SELECT 177 AS n UNION ALL
		SELECT 178 AS n UNION ALL
		SELECT 179 AS n UNION ALL
		SELECT 180 AS n UNION ALL
		SELECT 181 AS n UNION ALL
		SELECT 182 AS n UNION ALL
		SELECT 183 AS n UNION ALL
		SELECT 184 AS n UNION ALL
		SELECT 185 AS n UNION ALL
		SELECT 186 AS n UNION ALL
		SELECT 187 AS n UNION ALL
		SELECT 188 AS n UNION ALL
		SELECT 189 AS n UNION ALL
		SELECT 190 AS n UNION ALL
		SELECT 191 AS n UNION ALL
		SELECT 192 AS n UNION ALL
		SELECT 193 AS n UNION ALL
		SELECT 194 AS n UNION ALL
		SELECT 195 AS n UNION ALL
		SELECT 196 AS n UNION ALL
		SELECT 197 AS n UNION ALL
		SELECT 198 AS n UNION ALL
		SELECT 199 AS n UNION ALL
		SELECT 200 AS n UNION ALL
		SELECT 201 AS n UNION ALL
		SELECT 202 AS n UNION ALL
		SELECT 203 AS n UNION ALL
		SELECT 204 AS n UNION ALL
		SELECT 205 AS n UNION ALL
		SELECT 206 AS n UNION ALL
		SELECT 207 AS n UNION ALL
		SELECT 208 AS n UNION ALL
		SELECT 209 AS n UNION ALL
		SELECT 210 AS n UNION ALL
		SELECT 211 AS n UNION ALL
		SELECT 212 AS n UNION ALL
		SELECT 213 AS n UNION ALL
		SELECT 214 AS n UNION ALL
		SELECT 215 AS n UNION ALL
		SELECT 216 AS n UNION ALL
		SELECT 217 AS n UNION ALL
		SELECT 218 AS n UNION ALL
		SELECT 219 AS n UNION ALL
		SELECT 220 AS n UNION ALL
		SELECT 221 AS n UNION ALL
		SELECT 222 AS n UNION ALL
		SELECT 223 AS n UNION ALL
		SELECT 224 AS n UNION ALL
		SELECT 225 AS n UNION ALL
		SELECT 226 AS n UNION ALL
		SELECT 227 AS n UNION ALL
		SELECT 228 AS n UNION ALL
		SELECT 229 AS n UNION ALL
		SELECT 230 AS n UNION ALL
		SELECT 231 AS n UNION ALL
		SELECT 232 AS n UNION ALL
		SELECT 233 AS n UNION ALL
		SELECT 234 AS n UNION ALL
		SELECT 235 AS n UNION ALL
		SELECT 236 AS n UNION ALL
		SELECT 237 AS n UNION ALL
		SELECT 238 AS n UNION ALL
		SELECT 239 AS n UNION ALL
		SELECT 240 AS n UNION ALL
		SELECT 241 AS n UNION ALL
		SELECT 242 AS n UNION ALL
		SELECT 243 AS n UNION ALL
		SELECT 244 AS n UNION ALL
		SELECT 245 AS n UNION ALL
		SELECT 246 AS n UNION ALL
		SELECT 247 AS n UNION ALL
		SELECT 248 AS n UNION ALL
		SELECT 249 AS n UNION ALL
		SELECT 250 AS n UNION ALL
		SELECT 251 AS n UNION ALL
		SELECT 252 AS n UNION ALL
		SELECT 253 AS n UNION ALL
		SELECT 254 AS n UNION ALL
		SELECT 255 AS n UNION ALL
		SELECT 256 AS n UNION ALL
		SELECT 257 AS n UNION ALL
		SELECT 258 AS n UNION ALL
		SELECT 259 AS n UNION ALL
		SELECT 260 AS n UNION ALL
		SELECT 261 AS n UNION ALL
		SELECT 262 AS n UNION ALL
		SELECT 263 AS n UNION ALL
		SELECT 264 AS n UNION ALL
		SELECT 265 AS n UNION ALL
		SELECT 266 AS n UNION ALL
		SELECT 267 AS n UNION ALL
		SELECT 268 AS n UNION ALL
		SELECT 269 AS n UNION ALL
		SELECT 270 AS n UNION ALL
		SELECT 271 AS n UNION ALL
		SELECT 272 AS n UNION ALL
		SELECT 273 AS n UNION ALL
		SELECT 274 AS n UNION ALL
		SELECT 275 AS n UNION ALL
		SELECT 276 AS n UNION ALL
		SELECT 277 AS n UNION ALL
		SELECT 278 AS n UNION ALL
		SELECT 279 AS n UNION ALL
		SELECT 280 AS n UNION ALL
		SELECT 281 AS n UNION ALL
		SELECT 282 AS n UNION ALL
		SELECT 283 AS n UNION ALL
		SELECT 284 AS n UNION ALL
		SELECT 285 AS n UNION ALL
		SELECT 286 AS n UNION ALL
		SELECT 287 AS n UNION ALL
		SELECT 288 AS n UNION ALL
		SELECT 289 AS n UNION ALL
		SELECT 290 AS n UNION ALL
		SELECT 291 AS n UNION ALL
		SELECT 292 AS n UNION ALL
		SELECT 293 AS n UNION ALL
		SELECT 294 AS n UNION ALL
		SELECT 295 AS n UNION ALL
		SELECT 296 AS n UNION ALL
		SELECT 297 AS n UNION ALL
		SELECT 298 AS n UNION ALL
		SELECT 299 AS n UNION ALL
		SELECT 300 AS n UNION ALL
		SELECT 301 AS n UNION ALL
		SELECT 302 AS n UNION ALL
		SELECT 303 AS n UNION ALL
		SELECT 304 AS n UNION ALL
		SELECT 305 AS n UNION ALL
		SELECT 306 AS n UNION ALL
		SELECT 307 AS n UNION ALL
		SELECT 308 AS n UNION ALL
		SELECT 309 AS n UNION ALL
		SELECT 310 AS n UNION ALL
		SELECT 311 AS n UNION ALL
		SELECT 312 AS n UNION ALL
		SELECT 313 AS n UNION ALL
		SELECT 314 AS n UNION ALL
		SELECT 315 AS n UNION ALL
		SELECT 316 AS n UNION ALL
		SELECT 317 AS n UNION ALL
		SELECT 318 AS n UNION ALL
		SELECT 319 AS n UNION ALL
		SELECT 320 AS n UNION ALL
		SELECT 321 AS n UNION ALL
		SELECT 322 AS n UNION ALL
		SELECT 323 AS n UNION ALL
		SELECT 324 AS n UNION ALL
		SELECT 325 AS n UNION ALL
		SELECT 326 AS n UNION ALL
		SELECT 327 AS n UNION ALL
		SELECT 328 AS n UNION ALL
		SELECT 329 AS n UNION ALL
		SELECT 330 AS n UNION ALL
		SELECT 331 AS n UNION ALL
		SELECT 332 AS n UNION ALL
		SELECT 333 AS n UNION ALL
		SELECT 334 AS n UNION ALL
		SELECT 335 AS n UNION ALL
		SELECT 336 AS n UNION ALL
		SELECT 337 AS n UNION ALL
		SELECT 338 AS n UNION ALL
		SELECT 339 AS n UNION ALL
		SELECT 340 AS n UNION ALL
		SELECT 341 AS n UNION ALL
		SELECT 342 AS n UNION ALL
		SELECT 343 AS n UNION ALL
		SELECT 344 AS n UNION ALL
		SELECT 345 AS n UNION ALL
		SELECT 346 AS n UNION ALL
		SELECT 347 AS n UNION ALL
		SELECT 348 AS n UNION ALL
		SELECT 349 AS n UNION ALL
		SELECT 350 AS n UNION ALL
		SELECT 351 AS n UNION ALL
		SELECT 352 AS n UNION ALL
		SELECT 353 AS n UNION ALL
		SELECT 354 AS n UNION ALL
		SELECT 355 AS n UNION ALL
		SELECT 356 AS n UNION ALL
		SELECT 357 AS n UNION ALL
		SELECT 358 AS n UNION ALL
		SELECT 359 AS n UNION ALL
		SELECT 360 AS n UNION ALL
		SELECT 361 AS n UNION ALL
		SELECT 362 AS n UNION ALL
		SELECT 363 AS n UNION ALL
		SELECT 364 AS n UNION ALL
		SELECT 365 AS n UNION ALL
		SELECT 366 AS n UNION ALL
		SELECT 367 AS n UNION ALL
		SELECT 368 AS n UNION ALL
		SELECT 369 AS n UNION ALL
		SELECT 370 AS n UNION ALL
		SELECT 371 AS n UNION ALL
		SELECT 372 AS n UNION ALL
		SELECT 373 AS n UNION ALL
		SELECT 374 AS n UNION ALL
		SELECT 375 AS n UNION ALL
		SELECT 376 AS n UNION ALL
		SELECT 377 AS n UNION ALL
		SELECT 378 AS n UNION ALL
		SELECT 379 AS n UNION ALL
		SELECT 380 AS n UNION ALL
		SELECT 381 AS n UNION ALL
		SELECT 382 AS n UNION ALL
		SELECT 383 AS n UNION ALL
		SELECT 384 AS n UNION ALL
		SELECT 385 AS n UNION ALL
		SELECT 386 AS n UNION ALL
		SELECT 387 AS n UNION ALL
		SELECT 388 AS n UNION ALL
		SELECT 389 AS n UNION ALL
		SELECT 390 AS n UNION ALL
		SELECT 391 AS n UNION ALL
		SELECT 392 AS n UNION ALL
		SELECT 393 AS n UNION ALL
		SELECT 394 AS n UNION ALL
		SELECT 395 AS n UNION ALL
		SELECT 396 AS n UNION ALL
		SELECT 397 AS n UNION ALL
		SELECT 398 AS n UNION ALL
		SELECT 399 AS n UNION ALL
		SELECT 400 AS n UNION ALL
		SELECT 401 AS n UNION ALL
		SELECT 402 AS n UNION ALL
		SELECT 403 AS n UNION ALL
		SELECT 404 AS n UNION ALL
		SELECT 405 AS n UNION ALL
		SELECT 406 AS n UNION ALL
		SELECT 407 AS n UNION ALL
		SELECT 408 AS n UNION ALL
		SELECT 409 AS n UNION ALL
		SELECT 410 AS n UNION ALL
		SELECT 411 AS n UNION ALL
		SELECT 412 AS n UNION ALL
		SELECT 413 AS n UNION ALL
		SELECT 414 AS n UNION ALL
		SELECT 415 AS n UNION ALL
		SELECT 416 AS n UNION ALL
		SELECT 417 AS n UNION ALL
		SELECT 418 AS n UNION ALL
		SELECT 419 AS n UNION ALL
		SELECT 420 AS n UNION ALL
		SELECT 421 AS n UNION ALL
		SELECT 422 AS n UNION ALL
		SELECT 423 AS n UNION ALL
		SELECT 424 AS n UNION ALL
		SELECT 425 AS n UNION ALL
		SELECT 426 AS n UNION ALL
		SELECT 427 AS n UNION ALL
		SELECT 428 AS n UNION ALL
		SELECT 429 AS n UNION ALL
		SELECT 430 AS n UNION ALL
		SELECT 431 AS n UNION ALL
		SELECT 432 AS n UNION ALL
		SELECT 433 AS n UNION ALL
		SELECT 434 AS n UNION ALL
		SELECT 435 AS n UNION ALL
		SELECT 436 AS n UNION ALL
		SELECT 437 AS n UNION ALL
		SELECT 438 AS n UNION ALL
		SELECT 439 AS n UNION ALL
		SELECT 440 AS n UNION ALL
		SELECT 441 AS n UNION ALL
		SELECT 442 AS n UNION ALL
		SELECT 443 AS n UNION ALL
		SELECT 444 AS n UNION ALL
		SELECT 445 AS n UNION ALL
		SELECT 446 AS n UNION ALL
		SELECT 447 AS n UNION ALL
		SELECT 448 AS n UNION ALL
		SELECT 449 AS n UNION ALL
		SELECT 450 AS n UNION ALL
		SELECT 451 AS n UNION ALL
		SELECT 452 AS n UNION ALL
		SELECT 453 AS n UNION ALL
		SELECT 454 AS n UNION ALL
		SELECT 455 AS n UNION ALL
		SELECT 456 AS n UNION ALL
		SELECT 457 AS n UNION ALL
		SELECT 458 AS n UNION ALL
		SELECT 459 AS n UNION ALL
		SELECT 460 AS n UNION ALL
		SELECT 461 AS n UNION ALL
		SELECT 462 AS n UNION ALL
		SELECT 463 AS n UNION ALL
		SELECT 464 AS n UNION ALL
		SELECT 465 AS n UNION ALL
		SELECT 466 AS n UNION ALL
		SELECT 467 AS n UNION ALL
		SELECT 468 AS n UNION ALL
		SELECT 469 AS n UNION ALL
		SELECT 470 AS n UNION ALL
		SELECT 471 AS n UNION ALL
		SELECT 472 AS n UNION ALL
		SELECT 473 AS n UNION ALL
		SELECT 474 AS n UNION ALL
		SELECT 475 AS n UNION ALL
		SELECT 476 AS n UNION ALL
		SELECT 477 AS n UNION ALL
		SELECT 478 AS n UNION ALL
		SELECT 479 AS n UNION ALL
		SELECT 480 AS n UNION ALL
		SELECT 481 AS n UNION ALL
		SELECT 482 AS n UNION ALL
		SELECT 483 AS n UNION ALL
		SELECT 484 AS n UNION ALL
		SELECT 485 AS n UNION ALL
		SELECT 486 AS n UNION ALL
		SELECT 487 AS n UNION ALL
		SELECT 488 AS n UNION ALL
		SELECT 489 AS n UNION ALL
		SELECT 490 AS n UNION ALL
		SELECT 491 AS n UNION ALL
		SELECT 492 AS n UNION ALL
		SELECT 493 AS n UNION ALL
		SELECT 494 AS n UNION ALL
		SELECT 495 AS n UNION ALL
		SELECT 496 AS n UNION ALL
		SELECT 497 AS n UNION ALL
		SELECT 498 AS n UNION ALL
		SELECT 499 AS n UNION ALL
		SELECT 500 AS n UNION ALL
		SELECT 501 AS n UNION ALL
		SELECT 502 AS n UNION ALL
		SELECT 503 AS n UNION ALL
		SELECT 504 AS n UNION ALL
		SELECT 505 AS n UNION ALL
		SELECT 506 AS n UNION ALL
		SELECT 507 AS n UNION ALL
		SELECT 508 AS n UNION ALL
		SELECT 509 AS n UNION ALL
		SELECT 510 AS n UNION ALL
		SELECT 511 AS n UNION ALL
		SELECT 512 AS n UNION ALL
		SELECT 513 AS n UNION ALL
		SELECT 514 AS n UNION ALL
		SELECT 515 AS n UNION ALL
		SELECT 516 AS n UNION ALL
		SELECT 517 AS n UNION ALL
		SELECT 518 AS n UNION ALL
		SELECT 519 AS n UNION ALL
		SELECT 520 AS n UNION ALL
		SELECT 521 AS n UNION ALL
		SELECT 522 AS n UNION ALL
		SELECT 523 AS n UNION ALL
		SELECT 524 AS n UNION ALL
		SELECT 525 AS n UNION ALL
		SELECT 526 AS n UNION ALL
		SELECT 527 AS n UNION ALL
		SELECT 528 AS n UNION ALL
		SELECT 529 AS n UNION ALL
		SELECT 530 AS n UNION ALL
		SELECT 531 AS n UNION ALL
		SELECT 532 AS n UNION ALL
		SELECT 533 AS n UNION ALL
		SELECT 534 AS n UNION ALL
		SELECT 535 AS n UNION ALL
		SELECT 536 AS n UNION ALL
		SELECT 537 AS n UNION ALL
		SELECT 538 AS n UNION ALL
		SELECT 539 AS n UNION ALL
		SELECT 540 AS n UNION ALL
		SELECT 541 AS n UNION ALL
		SELECT 542 AS n UNION ALL
		SELECT 543 AS n UNION ALL
		SELECT 544 AS n UNION ALL
		SELECT 545 AS n UNION ALL
		SELECT 546 AS n UNION ALL
		SELECT 547 AS n UNION ALL
		SELECT 548 AS n UNION ALL
		SELECT 549 AS n UNION ALL
		SELECT 550 AS n UNION ALL
		SELECT 551 AS n UNION ALL
		SELECT 552 AS n UNION ALL
		SELECT 553 AS n UNION ALL
		SELECT 554 AS n UNION ALL
		SELECT 555 AS n UNION ALL
		SELECT 556 AS n UNION ALL
		SELECT 557 AS n UNION ALL
		SELECT 558 AS n UNION ALL
		SELECT 559 AS n UNION ALL
		SELECT 560 AS n UNION ALL
		SELECT 561 AS n UNION ALL
		SELECT 562 AS n UNION ALL
		SELECT 563 AS n UNION ALL
		SELECT 564 AS n UNION ALL
		SELECT 565 AS n UNION ALL
		SELECT 566 AS n UNION ALL
		SELECT 567 AS n UNION ALL
		SELECT 568 AS n UNION ALL
		SELECT 569 AS n UNION ALL
		SELECT 570 AS n UNION ALL
		SELECT 571 AS n UNION ALL
		SELECT 572 AS n UNION ALL
		SELECT 573 AS n UNION ALL
		SELECT 574 AS n UNION ALL
		SELECT 575 AS n UNION ALL
		SELECT 576 AS n UNION ALL
		SELECT 577 AS n UNION ALL
		SELECT 578 AS n UNION ALL
		SELECT 579 AS n UNION ALL
		SELECT 580 AS n UNION ALL
		SELECT 581 AS n UNION ALL
		SELECT 582 AS n UNION ALL
		SELECT 583 AS n UNION ALL
		SELECT 584 AS n UNION ALL
		SELECT 585 AS n UNION ALL
		SELECT 586 AS n UNION ALL
		SELECT 587 AS n UNION ALL
		SELECT 588 AS n UNION ALL
		SELECT 589 AS n UNION ALL
		SELECT 590 AS n UNION ALL
		SELECT 591 AS n UNION ALL
		SELECT 592 AS n UNION ALL
		SELECT 593 AS n UNION ALL
		SELECT 594 AS n UNION ALL
		SELECT 595 AS n UNION ALL
		SELECT 596 AS n UNION ALL
		SELECT 597 AS n UNION ALL
		SELECT 598 AS n UNION ALL
		SELECT 599 AS n UNION ALL
		SELECT 600 AS n UNION ALL
		SELECT 601 AS n UNION ALL
		SELECT 602 AS n UNION ALL
		SELECT 603 AS n UNION ALL
		SELECT 604 AS n UNION ALL
		SELECT 605 AS n UNION ALL
		SELECT 606 AS n UNION ALL
		SELECT 607 AS n UNION ALL
		SELECT 608 AS n UNION ALL
		SELECT 609 AS n UNION ALL
		SELECT 610 AS n UNION ALL
		SELECT 611 AS n UNION ALL
		SELECT 612 AS n UNION ALL
		SELECT 613 AS n UNION ALL
		SELECT 614 AS n UNION ALL
		SELECT 615 AS n UNION ALL
		SELECT 616 AS n UNION ALL
		SELECT 617 AS n UNION ALL
		SELECT 618 AS n UNION ALL
		SELECT 619 AS n UNION ALL
		SELECT 620 AS n UNION ALL
		SELECT 621 AS n UNION ALL
		SELECT 622 AS n UNION ALL
		SELECT 623 AS n UNION ALL
		SELECT 624 AS n UNION ALL
		SELECT 625 AS n UNION ALL
		SELECT 626 AS n UNION ALL
		SELECT 627 AS n UNION ALL
		SELECT 628 AS n UNION ALL
		SELECT 629 AS n UNION ALL
		SELECT 630 AS n UNION ALL
		SELECT 631 AS n UNION ALL
		SELECT 632 AS n UNION ALL
		SELECT 633 AS n UNION ALL
		SELECT 634 AS n UNION ALL
		SELECT 635 AS n UNION ALL
		SELECT 636 AS n UNION ALL
		SELECT 637 AS n UNION ALL
		SELECT 638 AS n UNION ALL
		SELECT 639 AS n UNION ALL
		SELECT 640 AS n UNION ALL
		SELECT 641 AS n UNION ALL
		SELECT 642 AS n UNION ALL
		SELECT 643 AS n UNION ALL
		SELECT 644 AS n UNION ALL
		SELECT 645 AS n UNION ALL
		SELECT 646 AS n UNION ALL
		SELECT 647 AS n UNION ALL
		SELECT 648 AS n UNION ALL
		SELECT 649 AS n UNION ALL
		SELECT 650 AS n UNION ALL
		SELECT 651 AS n UNION ALL
		SELECT 652 AS n UNION ALL
		SELECT 653 AS n UNION ALL
		SELECT 654 AS n UNION ALL
		SELECT 655 AS n UNION ALL
		SELECT 656 AS n UNION ALL
		SELECT 657 AS n UNION ALL
		SELECT 658 AS n UNION ALL
		SELECT 659 AS n UNION ALL
		SELECT 660 AS n UNION ALL
		SELECT 661 AS n UNION ALL
		SELECT 662 AS n UNION ALL
		SELECT 663 AS n UNION ALL
		SELECT 664 AS n UNION ALL
		SELECT 665 AS n UNION ALL
		SELECT 666 AS n UNION ALL
		SELECT 667 AS n UNION ALL
		SELECT 668 AS n UNION ALL
		SELECT 669 AS n UNION ALL
		SELECT 670 AS n UNION ALL
		SELECT 671 AS n UNION ALL
		SELECT 672 AS n UNION ALL
		SELECT 673 AS n UNION ALL
		SELECT 674 AS n UNION ALL
		SELECT 675 AS n UNION ALL
		SELECT 676 AS n UNION ALL
		SELECT 677 AS n UNION ALL
		SELECT 678 AS n UNION ALL
		SELECT 679 AS n UNION ALL
		SELECT 680 AS n UNION ALL
		SELECT 681 AS n UNION ALL
		SELECT 682 AS n UNION ALL
		SELECT 683 AS n UNION ALL
		SELECT 684 AS n UNION ALL
		SELECT 685 AS n UNION ALL
		SELECT 686 AS n UNION ALL
		SELECT 687 AS n UNION ALL
		SELECT 688 AS n UNION ALL
		SELECT 689 AS n UNION ALL
		SELECT 690 AS n UNION ALL
		SELECT 691 AS n UNION ALL
		SELECT 692 AS n UNION ALL
		SELECT 693 AS n UNION ALL
		SELECT 694 AS n UNION ALL
		SELECT 695 AS n UNION ALL
		SELECT 696 AS n UNION ALL
		SELECT 697 AS n UNION ALL
		SELECT 698 AS n UNION ALL
		SELECT 699 AS n UNION ALL
		SELECT 700 AS n UNION ALL
		SELECT 701 AS n UNION ALL
		SELECT 702 AS n UNION ALL
		SELECT 703 AS n UNION ALL
		SELECT 704 AS n UNION ALL
		SELECT 705 AS n UNION ALL
		SELECT 706 AS n UNION ALL
		SELECT 707 AS n UNION ALL
		SELECT 708 AS n UNION ALL
		SELECT 709 AS n UNION ALL
		SELECT 710 AS n UNION ALL
		SELECT 711 AS n UNION ALL
		SELECT 712 AS n UNION ALL
		SELECT 713 AS n UNION ALL
		SELECT 714 AS n UNION ALL
		SELECT 715 AS n UNION ALL
		SELECT 716 AS n UNION ALL
		SELECT 717 AS n UNION ALL
		SELECT 718 AS n UNION ALL
		SELECT 719 AS n UNION ALL
		SELECT 720 AS n UNION ALL
		SELECT 721 AS n UNION ALL
		SELECT 722 AS n UNION ALL
		SELECT 723 AS n UNION ALL
		SELECT 724 AS n UNION ALL
		SELECT 725 AS n UNION ALL
		SELECT 726 AS n UNION ALL
		SELECT 727 AS n UNION ALL
		SELECT 728 AS n UNION ALL
		SELECT 729 AS n UNION ALL
		SELECT 730 AS n UNION ALL
		SELECT 731 AS n UNION ALL
		SELECT 732 AS n UNION ALL
		SELECT 733 AS n UNION ALL
		SELECT 734 AS n UNION ALL
		SELECT 735 AS n UNION ALL
		SELECT 736 AS n UNION ALL
		SELECT 737 AS n UNION ALL
		SELECT 738 AS n UNION ALL
		SELECT 739 AS n UNION ALL
		SELECT 740 AS n UNION ALL
		SELECT 741 AS n UNION ALL
		SELECT 742 AS n UNION ALL
		SELECT 743 AS n UNION ALL
		SELECT 744 AS n UNION ALL
		SELECT 745 AS n UNION ALL
		SELECT 746 AS n UNION ALL
		SELECT 747 AS n UNION ALL
		SELECT 748 AS n UNION ALL
		SELECT 749 AS n UNION ALL
		SELECT 750 AS n UNION ALL
		SELECT 751 AS n UNION ALL
		SELECT 752 AS n UNION ALL
		SELECT 753 AS n UNION ALL
		SELECT 754 AS n UNION ALL
		SELECT 755 AS n UNION ALL
		SELECT 756 AS n UNION ALL
		SELECT 757 AS n UNION ALL
		SELECT 758 AS n UNION ALL
		SELECT 759 AS n UNION ALL
		SELECT 760 AS n UNION ALL
		SELECT 761 AS n UNION ALL
		SELECT 762 AS n UNION ALL
		SELECT 763 AS n UNION ALL
		SELECT 764 AS n UNION ALL
		SELECT 765 AS n UNION ALL
		SELECT 766 AS n UNION ALL
		SELECT 767 AS n UNION ALL
		SELECT 768 AS n UNION ALL
		SELECT 769 AS n UNION ALL
		SELECT 770 AS n UNION ALL
		SELECT 771 AS n UNION ALL
		SELECT 772 AS n UNION ALL
		SELECT 773 AS n UNION ALL
		SELECT 774 AS n UNION ALL
		SELECT 775 AS n UNION ALL
		SELECT 776 AS n UNION ALL
		SELECT 777 AS n UNION ALL
		SELECT 778 AS n UNION ALL
		SELECT 779 AS n UNION ALL
		SELECT 780 AS n UNION ALL
		SELECT 781 AS n UNION ALL
		SELECT 782 AS n UNION ALL
		SELECT 783 AS n UNION ALL
		SELECT 784 AS n UNION ALL
		SELECT 785 AS n UNION ALL
		SELECT 786 AS n UNION ALL
		SELECT 787 AS n UNION ALL
		SELECT 788 AS n UNION ALL
		SELECT 789 AS n UNION ALL
		SELECT 790 AS n UNION ALL
		SELECT 791 AS n UNION ALL
		SELECT 792 AS n UNION ALL
		SELECT 793 AS n UNION ALL
		SELECT 794 AS n UNION ALL
		SELECT 795 AS n UNION ALL
		SELECT 796 AS n UNION ALL
		SELECT 797 AS n UNION ALL
		SELECT 798 AS n UNION ALL
		SELECT 799 AS n UNION ALL
		SELECT 800 AS n UNION ALL
		SELECT 801 AS n UNION ALL
		SELECT 802 AS n UNION ALL
		SELECT 803 AS n UNION ALL
		SELECT 804 AS n UNION ALL
		SELECT 805 AS n UNION ALL
		SELECT 806 AS n UNION ALL
		SELECT 807 AS n UNION ALL
		SELECT 808 AS n UNION ALL
		SELECT 809 AS n UNION ALL
		SELECT 810 AS n UNION ALL
		SELECT 811 AS n UNION ALL
		SELECT 812 AS n UNION ALL
		SELECT 813 AS n UNION ALL
		SELECT 814 AS n UNION ALL
		SELECT 815 AS n UNION ALL
		SELECT 816 AS n UNION ALL
		SELECT 817 AS n UNION ALL
		SELECT 818 AS n UNION ALL
		SELECT 819 AS n UNION ALL
		SELECT 820 AS n UNION ALL
		SELECT 821 AS n UNION ALL
		SELECT 822 AS n UNION ALL
		SELECT 823 AS n UNION ALL
		SELECT 824 AS n UNION ALL
		SELECT 825 AS n UNION ALL
		SELECT 826 AS n UNION ALL
		SELECT 827 AS n UNION ALL
		SELECT 828 AS n UNION ALL
		SELECT 829 AS n UNION ALL
		SELECT 830 AS n UNION ALL
		SELECT 831 AS n UNION ALL
		SELECT 832 AS n UNION ALL
		SELECT 833 AS n UNION ALL
		SELECT 834 AS n UNION ALL
		SELECT 835 AS n UNION ALL
		SELECT 836 AS n UNION ALL
		SELECT 837 AS n UNION ALL
		SELECT 838 AS n UNION ALL
		SELECT 839 AS n UNION ALL
		SELECT 840 AS n UNION ALL
		SELECT 841 AS n UNION ALL
		SELECT 842 AS n UNION ALL
		SELECT 843 AS n UNION ALL
		SELECT 844 AS n UNION ALL
		SELECT 845 AS n UNION ALL
		SELECT 846 AS n UNION ALL
		SELECT 847 AS n UNION ALL
		SELECT 848 AS n UNION ALL
		SELECT 849 AS n UNION ALL
		SELECT 850 AS n UNION ALL
		SELECT 851 AS n UNION ALL
		SELECT 852 AS n UNION ALL
		SELECT 853 AS n UNION ALL
		SELECT 854 AS n UNION ALL
		SELECT 855 AS n UNION ALL
		SELECT 856 AS n UNION ALL
		SELECT 857 AS n UNION ALL
		SELECT 858 AS n UNION ALL
		SELECT 859 AS n UNION ALL
		SELECT 860 AS n UNION ALL
		SELECT 861 AS n UNION ALL
		SELECT 862 AS n UNION ALL
		SELECT 863 AS n UNION ALL
		SELECT 864 AS n UNION ALL
		SELECT 865 AS n UNION ALL
		SELECT 866 AS n UNION ALL
		SELECT 867 AS n UNION ALL
		SELECT 868 AS n UNION ALL
		SELECT 869 AS n UNION ALL
		SELECT 870 AS n UNION ALL
		SELECT 871 AS n UNION ALL
		SELECT 872 AS n UNION ALL
		SELECT 873 AS n UNION ALL
		SELECT 874 AS n UNION ALL
		SELECT 875 AS n UNION ALL
		SELECT 876 AS n UNION ALL
		SELECT 877 AS n UNION ALL
		SELECT 878 AS n UNION ALL
		SELECT 879 AS n UNION ALL
		SELECT 880 AS n UNION ALL
		SELECT 881 AS n UNION ALL
		SELECT 882 AS n UNION ALL
		SELECT 883 AS n UNION ALL
		SELECT 884 AS n UNION ALL
		SELECT 885 AS n UNION ALL
		SELECT 886 AS n UNION ALL
		SELECT 887 AS n UNION ALL
		SELECT 888 AS n UNION ALL
		SELECT 889 AS n UNION ALL
		SELECT 890 AS n UNION ALL
		SELECT 891 AS n UNION ALL
		SELECT 892 AS n UNION ALL
		SELECT 893 AS n UNION ALL
		SELECT 894 AS n UNION ALL
		SELECT 895 AS n UNION ALL
		SELECT 896 AS n UNION ALL
		SELECT 897 AS n UNION ALL
		SELECT 898 AS n UNION ALL
		SELECT 899 AS n UNION ALL
		SELECT 900 AS n UNION ALL
		SELECT 901 AS n UNION ALL
		SELECT 902 AS n UNION ALL
		SELECT 903 AS n UNION ALL
		SELECT 904 AS n UNION ALL
		SELECT 905 AS n UNION ALL
		SELECT 906 AS n UNION ALL
		SELECT 907 AS n UNION ALL
		SELECT 908 AS n UNION ALL
		SELECT 909 AS n UNION ALL
		SELECT 910 AS n UNION ALL
		SELECT 911 AS n UNION ALL
		SELECT 912 AS n UNION ALL
		SELECT 913 AS n UNION ALL
		SELECT 914 AS n UNION ALL
		SELECT 915 AS n UNION ALL
		SELECT 916 AS n UNION ALL
		SELECT 917 AS n UNION ALL
		SELECT 918 AS n UNION ALL
		SELECT 919 AS n UNION ALL
		SELECT 920 AS n UNION ALL
		SELECT 921 AS n UNION ALL
		SELECT 922 AS n UNION ALL
		SELECT 923 AS n UNION ALL
		SELECT 924 AS n UNION ALL
		SELECT 925 AS n UNION ALL
		SELECT 926 AS n UNION ALL
		SELECT 927 AS n UNION ALL
		SELECT 928 AS n UNION ALL
		SELECT 929 AS n UNION ALL
		SELECT 930 AS n UNION ALL
		SELECT 931 AS n UNION ALL
		SELECT 932 AS n UNION ALL
		SELECT 933 AS n UNION ALL
		SELECT 934 AS n UNION ALL
		SELECT 935 AS n UNION ALL
		SELECT 936 AS n UNION ALL
		SELECT 937 AS n UNION ALL
		SELECT 938 AS n UNION ALL
		SELECT 939 AS n UNION ALL
		SELECT 940 AS n UNION ALL
		SELECT 941 AS n UNION ALL
		SELECT 942 AS n UNION ALL
		SELECT 943 AS n UNION ALL
		SELECT 944 AS n UNION ALL
		SELECT 945 AS n UNION ALL
		SELECT 946 AS n UNION ALL
		SELECT 947 AS n UNION ALL
		SELECT 948 AS n UNION ALL
		SELECT 949 AS n UNION ALL
		SELECT 950 AS n UNION ALL
		SELECT 951 AS n UNION ALL
		SELECT 952 AS n UNION ALL
		SELECT 953 AS n UNION ALL
		SELECT 954 AS n UNION ALL
		SELECT 955 AS n UNION ALL
		SELECT 956 AS n UNION ALL
		SELECT 957 AS n UNION ALL
		SELECT 958 AS n UNION ALL
		SELECT 959 AS n UNION ALL
		SELECT 960 AS n UNION ALL
		SELECT 961 AS n UNION ALL
		SELECT 962 AS n UNION ALL
		SELECT 963 AS n UNION ALL
		SELECT 964 AS n UNION ALL
		SELECT 965 AS n UNION ALL
		SELECT 966 AS n UNION ALL
		SELECT 967 AS n UNION ALL
		SELECT 968 AS n UNION ALL
		SELECT 969 AS n UNION ALL
		SELECT 970 AS n UNION ALL
		SELECT 971 AS n UNION ALL
		SELECT 972 AS n UNION ALL
		SELECT 973 AS n UNION ALL
		SELECT 974 AS n UNION ALL
		SELECT 975 AS n UNION ALL
		SELECT 976 AS n UNION ALL
		SELECT 977 AS n UNION ALL
		SELECT 978 AS n UNION ALL
		SELECT 979 AS n UNION ALL
		SELECT 980 AS n UNION ALL
		SELECT 981 AS n UNION ALL
		SELECT 982 AS n UNION ALL
		SELECT 983 AS n UNION ALL
		SELECT 984 AS n UNION ALL
		SELECT 985 AS n UNION ALL
		SELECT 986 AS n UNION ALL
		SELECT 987 AS n UNION ALL
		SELECT 988 AS n UNION ALL
		SELECT 989 AS n UNION ALL
		SELECT 990 AS n UNION ALL
		SELECT 991 AS n UNION ALL
		SELECT 992 AS n UNION ALL
		SELECT 993 AS n UNION ALL
		SELECT 994 AS n UNION ALL
		SELECT 995 AS n UNION ALL
		SELECT 996 AS n UNION ALL
		SELECT 997 AS n UNION ALL
		SELECT 998 AS n UNION ALL
		SELECT 999 AS n  

$$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_portal_get_consumed_leave;  	
DELIMITER $$  
CREATE PROCEDURE sp_portal_get_consumed_leave
(
IN  la_Type VARCHAR(30),  	
IN  laCode VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num=0;
SET msg='SUCCESS';

SET @ActivePeriod = (SELECT MAX(CODE) FROM payrollperiod);

DROP TEMPORARY TABLE IF EXISTS PeriodStartEnd;
CREATE TEMPORARY TABLE PeriodStartEnd AS(
	SELECT periodStart,periodEnd
	FROM payrollperiod
	WHERE CODE = @ActivePeriod
);

SET @identity = (SELECT identityId FROM identity WHERE `code`=laCode);


SELECT IFNULL(SUM(laTotalDays),0) AS laTotalDays
FROM leaveapplicationform  t1
WHERE t1.laID=@identity 
	AND t1.laType=la_Type
	AND t1.laStatus='A'
	AND t1.laDateFrom BETWEEN (SELECT periodStart FROM PeriodStartEnd) AND (SELECT periodEnd FROM PeriodStartEnd);

END $$ 
DELIMITER ;

-- CALL sp_portal_get_user_password_logs(1,'0601200033',0,@num,@msg); SELECT @msg
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_user_password_logs`$$ 
CREATE PROCEDURE `sp_portal_get_user_password_logs`(
IN pint_mode INT,
IN identityId VARCHAR(20),
IN userPassword VARCHAR(100),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';
IF (pint_mode=0) THEN -- select count

	SELECT COUNT(*) AS passwordCount FROM user_password_logs
		WHERE username = identityId AND `password` = userPassword;
		
END IF;

IF (pint_mode=1) THEN -- leave

		SELECT MAX(dt_created) AS dateCreated
		FROM `user_password_logs` 
		WHERE user_password_logs.username = identityId 
			AND `password` = (
					SELECT passwords_used 
					FROM `users` 
					WHERE username = identityId
					);

END IF; 
END$$ 
DELIMITER ;


/*
DELIMITER $$ 
CREATE VIEW IF NOT EXISTS `pf-common`.`v_kiosk_database_host` 
AS 
			
	
SELECT 
`t1`.`code` AS `code`,
`t1`.`name` AS `name`,
`t1`.`db_owner` AS `db_owner`,
`t1`.`hostName` AS `hostName` 
FROM

(SELECT 
	`pf-common`.`databases`.`code` AS `code`,
	`pf-common`.`databases`.`name` AS `name`,
	`pf-common`.`databases`.`db_owner` AS `db_owner`,
	
	CASE
	
	WHEN `pf-common`.`databases`.`db_owner` = 'materials_solutions_inc' 
	THEN 'msipf' 
	WHEN `pf-common`.`databases`.`db_owner` LIKE '%cass%' 
	THEN 'casspf' 
	WHEN `pf-common`.`databases`.`db_owner` LIKE '%mdb%' 
	THEN 'mdb4' 
	END AS `hostName` 
FROM
	`pf-common`.`databases`) `t1` 
WHERE `t1`.`name` <> 'materials_solutions_inc_test' 
$$ 
DELIMITER ;
*/


/*
DROP TABLE IF EXISTS `pf-common`.`v_kiosk_latestcompanysettings_update`;
DROP VIEW IF EXISTS `pf-common`.`v_kiosk_latestcompanysettings_update`;
DELIMITER $$ 
CREATE VIEW `pf-common`.`v_kiosk_latestcompanysettings_update` 
AS 

SELECT *
FROM(
	SELECT TABLE_SCHEMA AS db_name, TABLE_NAME AS tbl_name, UPDATE_TIME AS updateTime
	FROM information_schema.TABLES
	WHERE TABLE_NAME = 'companysetting'
	ORDER BY UPDATE_TIME DESC
)t1
LEFT JOIN `pf-common`.`v_kiosk_database_host` t2 ON t1.db_name = `name`
-- WHERE `hostName` = 'pf' 
;
$$ 
DELIMITER ;
*/


DROP TABLE IF EXISTS v_user_details;
DROP VIEW IF EXISTS v_user_details;
DELIMITER $$ 
CREATE VIEW `v_user_details` 
AS 

SELECT
	`t0`.`code`            AS `EmpCode`,
	`t5`.`identityId`      AS `EmpID`,
	`t0`.`rate`            AS `Rate`,
	`t0`.`positionCode`    AS `PositionCode`,
	`t1`.`positionName`    AS `PositionName`,
	`t0`.`dateEffective`   AS `dateEffective`,
	`t0`.`dateEnd`         AS `dateEnd`,
	`t0`.`costCode`        AS `costCode`,
	`t2`.`costName`        AS `costName`,
	`t0`.`departmentCode`  AS `departmentCode`,
	`t3`.`departmentName`  AS `departmentName`,
	`t0`.`laborCode`       AS `laborCode`,
	`t4`.`laborName`       AS `laborName`,
	`t0`.`jobCategoryCode` AS `jobCategoryCode`,
	`t6`.`jobCategoryName` AS `jobCategoryName`,
	`t0`.`lineId`          AS `LineId`,
	`t0`.`rateType`        AS `rateType`,
	(CASE WHEN t7.id>0 THEN 1 ELSE 0 END) AS if_approver
FROM ((((((`employeemovement` `t0`
	LEFT JOIN `position` `t1`
	ON (CONVERT(`t0`.`positionCode` USING utf8) = `t1`.`positionCode`))
	LEFT JOIN `costcenter` `t2`
	ON (CONVERT(`t0`.`costCode` USING utf8) = `t2`.`costCode`))
	LEFT JOIN `department` `t3`
	ON (CONVERT(`t0`.`departmentCode` USING utf8) = `t3`.`departmentCode`))
	LEFT JOIN `labor` `t4`
	ON (CONVERT(`t0`.`laborCode` USING utf8) = `t4`.`laborCode`))
	LEFT JOIN `identity` `t5`
	ON (`t0`.`code` = `t5`.`code`))
LEFT JOIN `jobcategory` `t6`
	ON (CONVERT(`t0`.`jobCategoryCode` USING utf8) = `t6`.`jobCategoryCode`)
	LEFT JOIN approvalstagedetails t7 ON t5.identityId=t7.id
	)
ORDER BY `t0`.`code`$$

DELIMITER ;


DROP PROCEDURE IF EXISTS `sp_portal_process_dtr_logs`;
DELIMITER $$ 
CREATE PROCEDURE `sp_portal_process_dtr_logs`(  
IN pint_mode INT, 
IN in_identityId VARCHAR(20),  
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

IF (pint_mode=0) THEN 
	START TRANSACTION; 
	INSERT INTO dtrlogs_employee
	SELECT 
		i.identityId AS identityid,
		d.machineID AS machineid,
		d.biometricsId AS biometricsid,
		d.dtrTime AS dtrtime,
		CAST(d.dtrTime AS DATE) AS DATE, 
		CAST(d.dtrTime AS TIME) AS TIME,
		d.dtrType AS dtrtype,
		d.geolocation AS location
	FROM dtrlogs d
	INNER JOIN employeebiometrics e ON e.bioId = d.biometricsId AND e.machineId = d.machineID
	INNER JOIN identity i ON i.code = e.code
	WHERE i.identityId = in_identityId;

	COMMIT; 
END IF;

END$$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_portal_otp;  	
DELIMITER $$  
CREATE PROCEDURE sp_portal_otp
(
IN  pint_mode INT,  	
IN  r_email VARCHAR(50),
IN  r_refno VARCHAR(50),
IN  r_OTP VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 
SET num = 0;
SET msg ='Success'; 

/*
0 -  INSERT
1 -  RETRIVE
2 -  UPDATE
*/
/*VALIDATE EMAIL*/
IF (pint_mode=0) THEN  

	IF EXISTS (SELECT 1 FROM otp_tbl WHERE email=r_email) THEN
		UPDATE otp_tbl SET OTP=r_OTP,refno=r_refno,isUsed=0,dateCreated=DATE(NOW()) WHERE email=r_email;
		LEAVE proc_start;
	END IF;
	
	INSERT INTO otp_tbl (email,OTP,refno)
	VALUES (r_email,r_OTP,r_refno);
END IF;  
END $$ 
DELIMITER ; 


DROP FUNCTION IF EXISTS PasswordComplexity; 
DELIMITER $$ 
CREATE FUNCTION PasswordComplexity(PASSWORD VARCHAR(255)) 
RETURNS BOOLEAN
DETERMINISTIC
BEGIN

DECLARE has_lower INT DEFAULT 0;
DECLARE has_upper INT DEFAULT 0;
DECLARE has_number INT DEFAULT 0;
DECLARE has_special INT DEFAULT 0;
DECLARE valid_length INT DEFAULT 0;

SET @passLenth = (SELECT IFNULL(passwordLength,8) FROM companysetting);

-- Check for minimum password length (e.g., at least 8 characters)
SET valid_length = IF(LENGTH(PASSWORD) >= @passLenth, 1, 0);

-- Check for at least one lowercase letter
SET has_lower = IF(PASSWORD REGEXP BINARY'[a-z]', 1, 0);

-- Check for at least one uppercase letter
SET has_upper = IF(PASSWORD REGEXP BINARY'[A-Z]', 1, 0);

-- Check for at least one number
SET has_number = IF(PASSWORD REGEXP '[0-9]', 1, 0);

-- Check for at least one special character
SET has_special = IF(PASSWORD REGEXP '[$@#&!]', 1, 0);

-- Return TRUE if all conditions are met, otherwise FALSE
RETURN valid_length AND has_lower AND has_upper AND has_number AND has_special;


END $$
DELIMITER ;



DROP TABLE IF EXISTS v_announcement_users; 
DROP VIEW IF EXISTS v_announcement_users;
DELIMITER $$ 
CREATE VIEW `v_announcement_users` AS 
	WITH RECURSIVE cte AS(
	SELECT 0 AS n
	UNION ALL
	SELECT n+1 FROM cte
	WHERE n + 1 < (SELECT MAX(JSON_LENGTH(CONCAT('["',REPLACE(recipients,",",'","'),'"]'))) AS userArray FROM announcement_tbl)
	)SELECT t1.id,JSON_UNQUOTE(JSON_EXTRACT(CONCAT('["',REPLACE(recipients,",",'","'),'"]'),CONCAT('$[',n,']'))) AS userId
	FROM announcement_tbl t1
	LEFT JOIN cte t2 ON t1.id>0  
	$$  
DELIMITER ;


-- 0601200033 sp_portal_announcement old
-- CALL sp_portal_announcement(1,0,0,0,0,0,'0601200033',@num,@msg); SELECT @msg
DROP PROCEDURE IF EXISTS sp_portal_announcement;  
DELIMITER $$  
CREATE PROCEDURE sp_portal_announcement(
IN pint_mode INT, 
IN pId INT,   
IN p_style VARCHAR(200), 
IN p_Subject VARCHAR(100),
IN p_content LONGTEXT,
IN p_recipients LONGTEXT,
IN p_identityId VARCHAR(20),
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
SET msg = '';

/*
0 - INSERT
1 - SELECT  
2 - DELETE 
*/

IF (pint_mode=0) THEN 
	-- SELECT * FROM announcement_tbl
	INSERT INTO announcement_tbl (style,content,pSubject,recipients,postId)
	VALUES (p_style,p_content,p_Subject,p_recipients,p_identityId);
	SET @maxId = (SELECT MAX(id) FROM announcement_tbl WHERE postId=p_identityId);
	SET msg = CONCAT('Announcement has been successfully posted with id No.',@maxId);
	
END IF;


IF (pint_mode=1) THEN 
	
	START TRANSACTION; 
	IF (pId>0) THEN
		
		-- -TRUNCATE TABLE announcement_viewed;
		-- SELECT * FROM announcement_viewed
		-- SELECT * FROM announcement_tbl
		IF NOT EXISTS (SELECT * FROM announcement_viewed WHERE postId=pId AND identityId=p_identityId) THEN
			INSERT INTO announcement_viewed (postId,identityId)
			VALUES (pId,p_identityId);
		END IF;
		
		SET msg = CONCAT('Announcement post No.',pId,' has been successfully viewed');
	
		SELECT *
		FROM announcement_tbl
		WHERE id=pId; 
	ELSE 
	
	
		-- SELECT * FROM v_announcement_users
		
		
		SELECT t1.id,content,pSubject,datePosted,CONCAT(firstName,' ',middleName,' ',lastName)AS fullname
			,(SELECT time_ago(t1.datePosted)) AS time_ago
		FROM announcement_tbl t1
		LEFT JOIN announcement_viewed t2 ON t1.id=t2.id AND t2.identityId=p_identityId
		LEFT JOIN identity t3 ON t1.postId=t3.identityId
		LEFT JOIN v_announcement_users t4 ON t1.id=t4.id
		WHERE t4.userId = p_identityId AND t2.identityId IS NULL
		
		;
	
	END IF;
	COMMIT;
END IF; 
END $$ 
DELIMITER ;





DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_user_status`$$ 
CREATE PROCEDURE `sp_portal_get_user_status`(
IN pint_mode INT,
IN identityId VARCHAR(20),
IN pStatus VARCHAR (5),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN -- pStatus

	SELECT pStatus FROM users WHERE identityId = identityId;

END IF;

IF (pint_mode=1) THEN -- pStatus update

	UPDATE users
	SET 
		`pStatus` = pStatus
	WHERE 
		`identityid` = identityId;

END IF;


END$$
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_all_pending_applications`$$ 
CREATE PROCEDURE `sp_portal_get_all_pending_applications`(
IN pint_mode INT,
IN identityId VARCHAR(20),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN -- leave

	SELECT * FROM leaveapplicationform la
		LEFT JOIN department dep ON la.`department` = dep.`departmentCode`
		LEFT JOIN costcenter cost ON la.`laCosCenter` = cost.`costCode`
		LEFT JOIN `leave` lv ON lv.leaveCode = la.laType
		WHERE la.laID = identityId AND laStatus='P';
		
END IF;


IF (pint_mode=1) THEN -- overtime

	SELECT * FROM overtimeform 
		WHERE otID = identityId AND otStatus='P';
		
END IF;


IF (pint_mode=2) THEN -- officialbusiness

	SELECT * FROM officialbusinessform
		WHERE obID = identityId AND obStatus='P';

END IF;


IF (pint_mode=3) THEN -- offset
	SELECT * FROM offsetform
		WHERE osID = identityId AND osStatus='P';
END IF;


IF (pint_mode=4) THEN -- timeadjustment
	SELECT *FROM timeadjustmentform
		WHERE taID=user_id AND taStatus='P';
END IF; 

END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_initialize_logsview_per_id`$$ 
CREATE PROCEDURE `sp_portal_initialize_logsview_per_id`(
IN _payrollPeriod VARCHAR(20),
IN _identityId VARCHAR(50)
)
BEGIN
DECLARE _dateFrom DATE;
DECLARE _dateTo DATE;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	GET DIAGNOSTICS CONDITION 1
	@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT, @errno = MYSQL_ERRNO;
	ROLLBACK;	
	INSERT INTO processlogs(payrollPeriod, payrollGroup, `status`, `remarks`,`processBy`)
	VALUES('PERIOD-COVERED', 'ALL GROUPS','DTR Collection Failed.',CONCAT(@p1,'-',@p2),'SYSTEM');
	SELECT IFNULL(@errno,999) AS `code`  ,CONCAT(@p1,'-',@p2) AS message, @p1 AS `sqlstate`;
END;
START TRANSACTION;
SET @startTime := NOW(6);
SELECT payrollPeriodFrom INTO _dateFrom 
FROM v_payrollperiod
WHERE payrollPeriod = _payrollPeriod;

SELECT LAST_DAY(_dateFrom) INTO _dateTo;		
SET @batchId := (SELECT DISTINCT batchId FROM identity WHERE identityId = _identityId);	
DELETE FROM dtrlogs WHERE dtrTime IS NULL;	
	
DROP TEMPORARY TABLE IF EXISTS kiosklogsCollector_per_id;
CREATE TEMPORARY TABLE IF NOT EXISTS kiosklogsCollector_per_id (
	EmpId VARCHAR(20),
	kDate DATE,
	kType VARCHAR(5),
	kIn VARCHAR(5),
	kOut VARCHAR(5),
	Source VARCHAR(50)
) ENGINE=MEMORY;

INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID EmpId,taDate kDate,taType kType,taTime kIn, '' kOut,'TIME ADJUSTMENT' Source  
FROM `timeadjustmentform` 
WHERE taType = 'in' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo AND taID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID,taDate,taType,'' kIn,taTime,'TIME ADJUSTMENT' Source  
FROM `timeadjustmentform` 
WHERE taType = 'out' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo AND taID = _identityId;


INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'in',obTimeFrom ,'' kOut,'OFFICIAL BUSINESS' Source  
FROM `officialbusinessform` 
WHERE obType = 'in' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'out','' kIn ,obTimeTo,'OFFICIAL BUSINESS' Source  
FROM `officialbusinessform` WHERE obType = 'out' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
		
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,`obLstDate`,'in' kType,`obLstTimeFrom`,'' kOut,'OFFICIAL BUSINESS' Source 
FROM `officialbusinessform` ob LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` 
WHERE ob.obType='days' AND ob.obStatus = 'A' AND obLstDate BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) `obLstDate`,'out' kType,'' kIn,`obLstTimeTo`,'OFFICIAL BUSINESS' Source 
FROM `officialbusinessform` ob 
LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` 
WHERE ob.obType='days' AND ob.obStatus = 'A' AND IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,`teTime`,'','TIME ENTRY' Source FROM `timeentryform` 
WHERE `teType` = 'IN' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo AND `teID` = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,'',`teTime`,'TIME ENTRY' Source 
FROM `timeentryform` 
WHERE `teType` = 'OUT' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo AND `teID` = _identityId;
	
-- HOUSE KEEPING
DELETE DtrlogsviewCollector.* FROM DtrlogsviewCollector
INNER JOIN employeebiometrics ON DtrlogsviewCollector.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;

/* -- COMMENTED BY RBC:-) NOV-22-2023
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	identity.`identityId`,
	dtr.`machineID`,
	'DTR' AS Source
FROM dtrlogs dtr
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;*/

/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MINIMUM TIME-IN - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	-- identity.`identityId`,
	dtr.biometricsId,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MIN(machineID) 'machineID', MIN(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'I'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'I' AND identity.`identityId` = _identityId;

/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MINIMUM TIME-OUT - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */		
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	-- identity.`identityId`,		
	dtr.biometricsId,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MAX(machineID) 'machineID', MAX(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'O'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'O' AND identity.`identityId` = _identityId;	

/* ===========================================================================	
END OF INITILIZE DTR LOGS - GET ONLY MAXIMUM TIME-OUT - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */	
	
INSERT INTO DtrlogsviewCollector(dtrTime,dtrType,biometricsId,machineID,Source)
SELECT 
	TIMESTAMP(kiosk.`kDate`, STR_TO_DATE(IF(kiosk.`kIn` = '',kiosk.`kOut`,kiosk.`kIn`), '%H:%i:%00')) AS dtrTime
	,UPPER(LEFT(kiosk.`kType`,1)) AS `dtrType`
	,kiosk.`EmpId`
	,'KIOSK'
	,kiosk.source
FROM kiosklogsCollector_per_id kiosk;
	
SET @executionTime := (SELECT REPLACE(TIME_FORMAT(TIMEDIFF(@startTime, NOW(6)),'%T'),'-',''));
INSERT INTO processlogs(payrollPeriod,payrollGroup,`status`,noOfRecords,`remarks`,processBy,processDuration)
SELECT _payrollPeriod, @batchId, 'AUTO DTR COLLECTION',COUNT(DISTINCT biometricsId), CONCAT('DTR Collection Successful. - ',COUNT(DISTINCT biometricsId), ' Records Affected'), 'SYSTEM', @executionTime 
FROM DtrlogsviewCollector 
INNER JOIN employeebiometrics ON DtrlogsviewCollector.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;
	
COMMIT;		


END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_portal_dtr_vew_per_cutoff_process`$$ 
CREATE PROCEDURE `sp_portal_dtr_vew_per_cutoff_process`(
IN _payrollPeriod VARCHAR(20),
IN _identityId VARCHAR(50),
OUT num INT,
	OUT msg VARCHAR(300)
)
processBlock: BEGIN



DECLARE __payrollPeriodID 	VARCHAR(50);
DECLARE __payrollPeriodType	VARCHAR(15);

SET num = 0;
SET msg = 'Success';

SELECT pg.`payrollPeriodID`, pg.`payrollType`  
INTO __payrollPeriodID,__payrollPeriodType 	
FROM identity idy
LEFT JOIN `payrollgroup` pg ON pg.payrollGroupCode = idy.batchId
WHERE idy.identityId = _identityId;

	
CALL sp_portal_initialize_logsview_per_id(_payrollPeriod, _identityId);	 



SET @nextPeriod := (SELECT CONCAT(a.`code`,'-',a.lineId) AS payrollperiod 
			FROM payrollperioddetails a
			JOIN payrollperiod b ON a.`code` = b.`code`
			WHERE a.payrollPeriodFrom = (SELECT DATE_ADD(payrollperiodTo, INTERVAL 1 DAY) FROM payrollperioddetails WHERE CONCAT(`code`,'-',lineId) = _payrollPeriod)
			AND b.`payrollPeriodType` = (SELECT c.payrollPeriodType FROM payrollperiod c JOIN payrollperioddetails d ON c.`code` = d.`code` WHERE  CONCAT(d.`code`,'-',d.lineId) = _payrollPeriod)
			);

	DROP TEMPORARY TABLE IF EXISTS `temp_dtr_employeedata`;
CREATE TEMPORARY TABLE `temp_dtr_employeedata` AS(
	SELECT
	id.`code` AS employeeCode
	,id.`identityId` AS employeeId
	,CONCAT(IFNULL(id.`lastName`,''),', '
	,IFNULL(id.`firstName`,''),' '
	,IFNULL(id.`middleName`,'')) AS employeeName
	,id.`batchId` AS payrollGroup
	,id.`paymentType`
	,pg.`payrollConfigurationCode`
	,pc.`paymentComputation`
	,pc.`paymentFrequency`
	,CONCAT(ppd.`code`,'-',ppd.`lineId`) AS payrollPeriod
	,ppd.payrollPeriodID
	,ppd.`code` AS payrollPeriodCode
	,ppd.`payrollPeriodMonths` AS payrollPeriodMonth
	,ppd.`payrollPeriodFrom`
	,ppd.`payrollPeriodTo`
	,ppd.`payrollPeriodPayDate`
	,ppd.`payrollPeriodTerms`
	,es.`schedule`
	,es.`costCenter`
	,es.`department`
	,es.`col`
	,es.`day` AS `date`
	,pg.`workOnHoliday`
	,pg.`windowHours`
	,pg.`workSchedule`
	,em.`laborCode`
	,la.`active`
	,`shifts`.`lineId` AS `shiftNo`
	,IF(IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' AND IFNULL(`sched`.`scheduleName`,'') <> '',0,IFNULL(`shifts`.`advanceHours`,0)) AS `advanceHours`
	,IF(IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' AND IFNULL(`sched`.`scheduleName`,'') <> '',0,IFNULL(`shifts`.`extendedHours`,0)) AS `extendedHours`
	,CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' AND IFNULL(`sched`.`scheduleName`,'') <> ''
		THEN  'HOLIDAY'
		ELSE IFNULL(`sched`.`scheduleName`,'Restday')
	END AS `scheduleName`
	,`sched`.`scheduleType` AS `scheduleType`
	,CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' AND IFNULL(`sched`.`scheduleName`,'') <> ''
		THEN 0 
		ELSE IFNULL(`shiftsPerSched`.`equivalentHoursPerSched`,0) 
	END AS `equivalentHours`
	,CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' AND IFNULL(`sched`.`scheduleName`,'') <> ''
	THEN NULL
	ELSE `shift`.`withLate`
	END AS `withLate`
	,`shifts`.`deduct`
	,IFNULL(`shift`.`gracePeriod`,0) AS `gracePeriod`
	,`hol`.`code` AS `holidayCode`		
	,IFNULL(CASE 
	WHEN `shifts`.`lineId` = 1 THEN 
		CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
			THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00') 
			ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00')) 
		END
	WHEN `shifts`.`lineId` = 2 THEN 
		IF(`shifts2`.shiftFrom IS NULL
		, CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
			THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
			ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END
		, IF(`shifts2`.shiftFrom >= `shifts1`.shiftFrom
			,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
				ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END
			,  DATE_ADD(CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
				ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END, INTERVAL 1 DAY)
			))
		
	WHEN `shifts`.`lineId` = 3 THEN 
		IF(`shifts3`.shiftFrom IS NULL
		,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
			THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
			ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END
		,  IF(`shifts3`.shiftFrom >= `shifts1`.shiftFrom
			,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
				ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END
			,  DATE_ADD(CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')
				ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftFrom`,'00:00:00'))
			END, INTERVAL 1 DAY)
			))
	END,CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' 00:00:00')) AS `schedIn1`		  
	,IFNULL(CASE 
	WHEN `shifts`.`lineId` = 1 THEN 
		CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
			THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
			ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
		END
	WHEN `shifts`.`lineId` = 2 THEN 
		IF(`shifts2`.shiftTo IS NULL
			,   CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
				ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
				END
			,   IF(`shifts2`.shiftTo >= `shifts1`.shiftFrom
			,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
				ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
			END
			,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
				ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE DATE_ADD(CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')),INTERVAL 1 DAY) END)
			END
			))
		WHEN `shifts`.`lineId` = 3 THEN 
		IF(`shifts3`.shiftTo IS NULL
			, CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
				THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
				ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
			END
			,  IF(`shifts3`.shiftTo >= `shifts1`.shiftFrom
				,  CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
					THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
					ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
				END
				,  DATE_ADD(CASE WHEN IFNULL(`hday`.`holidayTagging`,0) > 0 AND IFNULL(pg.workOnHoliday,'') = '' 
					THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') 
					ELSE (CASE WHEN (IFNULL(REPLACE(`shifts`.`shiftFrom`,':',''),0) >= IFNULL(REPLACE(`shifts`.`shiftTo`,':',''),0)) THEN CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) ELSE CONCAT(DATE_FORMAT(es.`day`,'%Y-%m-%d'),' ',IFNULL(`shifts`.`shiftTo`,'00:00:00')) END)
				END, INTERVAL 1 DAY)
				))
	END, CONCAT(DATE_FORMAT((es.`day` + INTERVAL 1 DAY),'%Y-%m-%d'),' 00:00:00') ) AS `schedOut1`		
	,TIMESTAMPDIFF(
	HOUR,
	CONCAT(
		DATE_FORMAT(es.`day`, '%Y-%m-%d'),
		' ',
		IFNULL(
		`shifts`.`shiftFrom`,
		'00:00:00'
		)
	),
	(
		CASE
		WHEN (
		IFNULL(
		REPLACE(`shifts`.`shiftFrom`, ':', ''),
		0
		) >= IFNULL(
		REPLACE(`shifts`.`shiftTo`, ':', ''),
		0
		)
		) 
		THEN CONCAT(
		DATE_FORMAT(
		(es.`day` + INTERVAL 1 DAY),
		'%Y-%m-%d'
		),
		' ',
		IFNULL(`shifts`.`shiftTo`, '00:00:00')
		) 
		ELSE CONCAT(
		DATE_FORMAT(es.`day`, '%Y-%m-%d'),
		' ',
		IFNULL(`shifts`.`shiftTo`, '00:00:00')
		) 
		END
	)
	) - IFNULL(`shift`.`equivalentHours`,0) AS breakHour 
	,SUM(IFNULL(`hday`.`holidayTagging`,0)) AS `holidayTagging` 
	,COUNT(`hday`.`holidayName`) AS `holidayCount`
	,CASE WHEN em.`laborCode` IN ('IA') THEN em.`dateEffective`  ELSE NULL END AS `dateInactive`
	,id.`dateHired`	      
	,id.`finalPay`
	,IF(shifts.autoOt IS NOT NULL,'AUTO','REG') AS 'schedType'
FROM identity id USE INDEX(PRIMARY)
LEFT JOIN (
		SELECT
			es.`payrollPeriod`
			,es.`payrollPeriodMonth`
			,es.`payrollPeriodFrom`
			,es.`payrollPeriodTo`
			,es.`employeeId`
			,es.`employeeName`
			,es.`costCenter`
			,es.`department`
			,es.`col`
			,es.`day`
			,es.`schedule`
			,es.`scheduleName`
		FROM employeedailyschedule es USE INDEX (idx_payrollperiod_employeeid_schedule)
		LEFT JOIN identity idy ON es.employeeId = idy.identityId
		LEFT JOIN payrollGroup pg ON idy.batchId = pg.payrollGroupCode
		WHERE es.`payrollPeriod` = _payrollPeriod
		AND pg.`workSchedule` NOT IN ('Fixed','Flexi')
		AND idy.identityId = _identityId
		UNION ALL
		SELECT 
			(CONCAT(ppd.`code`,'-', ppd.`lineId`)) AS payrollPeriod
			,ppd.`payrollPeriodMonths` `payrollPeriodMonth`
			,ppd.`payrollPeriodFrom`
			,ppd.`payrollPeriodTo`
			,id.`identityId` AS employeeId
			,(CONCAT(IFNULL(id.`lastName`,''),', ',IFNULL(id.`firstName`,''),' ',IFNULL(id.`middleName`,''))) AS  `employeeName`
			,IFNULL(em.`costCode`,t1.costCode) AS costCenter
			,IFNULL(em.`departmentCode`,t1.departmentCode) AS department
			,(CONCAT('day',cal.`day` + 1)) `col`
			,DATE_ADD(ppd.`payrollPeriodFrom`,INTERVAL cal.`day` DAY) AS `day`
			,(CASE WHEN sr.`day` IS NULL THEN sc.`code` ELSE -1 END) `schedule`
			,(CASE WHEN sr.`day` IS NULL THEN sc.`scheduleName` ELSE 'RESTDAY' END) `scheduleName`
		FROM payrollperioddetails ppd JOIN calendar cal JOIN identity id
		LEFT JOIN payrollperiod pp ON pp.`code` = ppd.`code` 
		LEFT JOIN `payrollgroup` pg ON id.`batchId` = pg.`payrollGroupCode`
		LEFT JOIN payrollconfiguration pc ON pc.`payrollConfigurationCode` = pg.`payrollConfigurationCode` 
		LEFT JOIN schedules sc ON sc.`scheduleCode` = pg.`scheduleCode`
		LEFT JOIN schedulerestday sr ON sc.`code` = sr.`code` AND CAST(DAYNAME(DATE_ADD(ppd.`payrollPeriodFrom`,INTERVAL cal.`day` DAY)) AS CHAR) = sr.`day` 
		LEFT JOIN employeemovement em ON em.`code` = id.`code` AND DATE_ADD(ppd.`payrollPeriodFrom`,INTERVAL cal.`day` DAY) BETWEEN em.`dateEffective` AND IFNULL(em.`dateEnd`,NOW())
		LEFT JOIN (
			SELECT 
				em1.`code` AS employeeCode
				,em1.costCode
				,em1.departmentCode
				,em1.jobCategoryCode
				,em1.positionCode 
			FROM employeemovement em1
			INNER JOIN vw_rpt_max_employeemovement vw ON vw.Code = em1.`code` AND vw.LineId = em1.`lineId` 
		) t1 ON t1.employeeCode = id.`code`		
		WHERE DATE_ADD(ppd.`payrollPeriodFrom`,INTERVAL cal.`day` DAY) <= ppd.`payrollPeriodTo` 
		AND pg.`workSchedule` IN ('Fixed','Flexi') 
		AND DATE_ADD(ppd.`payrollPeriodFrom`,INTERVAL cal.`day` DAY) >= id.`dateHired`
		AND (CONCAT(ppd.`code`,'-', ppd.`lineId`)) = _payrollPeriod
		) es ON  es.`employeeId` = id.`identityId`
LEFT JOIN payrollgroup pg ON id.`batchId` = pg.`payrollGroupCode`
LEFT JOIN payrollconfiguration pc ON pg.`payrollConfigurationCode` = pc.`payrollConfigurationCode`
LEFT JOIN v_payrollperiod ppd ON ppd.payrollPeriod = _payrollPeriod
LEFT JOIN `schedules` `sched` ON IF(id.`dateHired` <= es.`day`, es.`schedule`,NULL) = `sched`.`code`
LEFT JOIN `scheduleshifts` `shifts` ON`sched`.`code` = `shifts`.`code`
LEFT JOIN `scheduleshifts` `shifts1` ON`sched`.`code` = `shifts1`.`code` AND `shifts1`.lineId = 1
LEFT JOIN `scheduleshifts` `shifts2` ON`sched`.`code` = `shifts2`.`code` AND `shifts2`.lineId = 2
LEFT JOIN `scheduleshifts` `shifts3` ON`sched`.`code` = `shifts3`.`code` AND `shifts3`.lineId = 3
LEFT JOIN (SELECT `code`, lineId, shiftCode, shiftName, shiftFrom, shiftTo, SUM(equivalentHours) AS 'equivalentHoursPerSched' FROM `scheduleshifts` WHERE autoOt IS NULL GROUP BY `code`) `shiftsPerSched` ON `sched`.`code` = `shiftsPerSched`.`code`
LEFT JOIN `shifts` `shift` ON`shift`.`shiftCode` = `shifts`.`shiftCode` 
LEFT JOIN `holidays` `hol` ON `hol`.`holidayYear` = YEAR(es.`day`)
LEFT JOIN `v_holidaydetails` `hday` ON `hday`.`code` = `hol`.`code` AND `hday`.`holidayDate` = es.`day` AND ((`hday`.`profitCenterCode` = es.`costCenter` OR `hday`.`profitCenterCode` = pg.location) OR `hday`.`profitCenterCode` IS NULL)
LEFT JOIN `employeemovement` em ON em.`code` = id.`code` AND es.`day` BETWEEN em.`dateEffective` AND IFNULL(em.`dateEnd`, ppd.`payrollPeriodTo`)
LEFT JOIN `labor` la ON em.`laborCode` = la.`laborCode`
WHERE CONCAT(ppd.`code`,'-',ppd.`lineId`) = _payrollPeriod -- LIMIT 100000
AND id.`dateHired` <= IFNULL(es.`payrollPeriodTo`, ppd.payrollPeriodTo)
AND CASE WHEN `la`.`active` IS NULL AND em.`dateEffective` <= ppd.`payrollPeriodFrom` THEN 0  ELSE 1 END = 1	
AND id.identityId = _identityId	
GROUP BY 
	CONCAT(ppd.`code`,'-',ppd.`lineId`)
	,id.`code` 
	,es.`employeeId`
	,es.`day`
	,es.`schedule`
	,id.`batchId`
	,`shifts`.`lineId`
);
	
	
	DROP TEMPORARY TABLE IF EXISTS `temp_posteddtr`;
	CREATE TEMPORARY TABLE `temp_posteddtr` AS(
	SELECT
	_payrollPeriod AS payrollPeriod-- dtr.`payrollPeriod`
	,__payrollPeriodID
	,__payrollPeriodType
	,dtr.`payrollPeriodMonth`
	,dtr.`payrollPeriodFrom`
	,dtr.`payrollPeriodTo`
	,dtr.`batchId`
	,dtr.`costCode`
	,dtr.`department`
	,dtr.`employeeCode`
	,dtr.`employeeId`
	,dtr.`employeeName`
	,dtr.`date`
	,dtr.`day`
	,dtr.`schedIn` AS shiftFrom
	,dtr.`schedOut` AS shiftTo
	,dtr.`scheduleName`
	,dtr.`biometricsIn`
	,dtr.`biometricsOut`
	,dtr.`regularWorkHour`
	,dtr.`regularNightDiff`
	,dtr.`regularOTHour`
	,dtr.`regularOTNightDiff`
	,dtr.`regularRestDayWorkHour`
	,dtr.`regularRestDayNightDiff`
	,dtr.`regularRestDayOTHour`
	,dtr.`regularRestDayOTNightDiff`
	,dtr.`specialWorkHour`
	,dtr.`specialNightDiff`
	,dtr.`specialOTHour`
	,dtr.`specialOTNightDiff`
	,dtr.`specialRestDayWorkHour`
	,dtr.`specialRestDayNightDiff`
	,dtr.`specialRestDayOTHour`
	,dtr.`specialRestDayOTNightDiff`
	,dtr.`regularLegalWorkHour`
	,dtr.`regularLegalNightDiff`
	,dtr.`regularLegalOTHour`
	,dtr.`regularLegalOTNightDiff`
	,dtr.`regularLegalRestDayWorkHour`
	,dtr.`regularLegalRestDayNightDiff`
	,dtr.`regularLegalRestDayOTHour`
	,dtr.`regularLegalRestDayOTNightDiff`
	,dtr.`doubleWorkHour`
	,dtr.`doubleNightDiff`
	,dtr.`doubleOTHour`
	,dtr.`doubleOTNightDiff`
	,dtr.`doubleRestDayWorkHour`
	,dtr.`doubleRestDayNightDiff`
	,dtr.`doubleRestDayOTHour`
	,dtr.`doubleRestDayOTNightDiff`
	-- ,IF((dtr.`leave` + dtr.lwop) >= 480,0, dtr.`late`) `late`
	,CASE WHEN (dtr.`leave` + dtr.lwop) >= 480 THEN 0 
		-- WHEN (dtr.`leave` + dtr.lwop) > 0 AND dtr.`late` > 0 AND dtr.`totalHours` >= 240 AND `undertime` <= 0 THEN 0
		WHEN (dtr.`leave` + dtr.lwop) >= 240 AND dtr.`late` >= 240 AND dtr.`totalHours` >= 240 AND `undertime` <= 0 THEN 0 -- ADDED 2022-11-29 RBC
		WHEN (dtr.`leave` + dtr.lwop) >= 240 AND dtr.`late` >= 240 THEN 0
		WHEN (dtr.`leave` + dtr.lwop) > 0 AND dtr.`late` > 0 AND dtr.`totalHours` >= 240 AND `undertime` <= 0 THEN IF(DATE_ADD(dtr.`schedIn`, INTERVAL (dtr.`windowHours` * 60) MINUTE) < dtr.`biometricsIn`, dtr.`late`, 0)
		ELSE dtr.`late`
	END `late`
	,CASE WHEN (dtr.`leave` + dtr.lwop) >= 480 THEN 0
		WHEN dtr.absent = 0 THEN 0
		WHEN dtr.absent >= (dtr.`leave` + dtr.lwop) THEN dtr.absent - (dtr.`leave` + dtr.lwop)
		WHEN dtr.absent <= (dtr.`leave` + dtr.lwop) THEN 0
		ELSE dtr.absent
	END `absent`
	,0 AS absent_holiday
	,dtr.`leave`
	,dtr.`lwop`
	,CASE WHEN (dtr.`leave` + dtr.lwop) >= 480 THEN 0
		WHEN (dtr.`leave` + dtr.lwop) > 0 AND dtr.`undertime` > 0 AND dtr.`totalHours` >= 240 AND `absent` = 0 THEN 0
		WHEN (dtr.`leave` + dtr.lwop) > 0 AND dtr.`undertime` > 0 AND dtr.`totalHours` >= 240 AND `absent` > 0 THEN 0
		WHEN (dtr.`leave` + dtr.lwop) > 0 AND dtr.`undertime` > 0 AND dtr.`totalHours` < 240 AND dtr.`absent` = 0 THEN 0
		ELSE dtr.`undertime`
	END `undertime`
	,dtr.`nightDiff`
	,dtr.`overtime`
	,dtr.`nightDiffOvertime`
	,dtr.`holidayTagging`
	,dtr.`workHours`
	,dtr.`totalHours`
	,dtr.`dateInactive`
	,dtr.`finalPay`
	,dtr.`otType` 
FROM v_converted_temp_temporarydtr dtr
WHERE dtr.`payrollPeriod` = _payrollPeriod
AND dtr.`employeeId` = _identityId
	);
	
	


SET @_identityId = _identityId;
	DROP TEMPORARY TABLE IF EXISTS `temp_v_overtimeApplication`;
	CREATE TEMPORARY TABLE `temp_v_overtimeApplication` AS(
	SELECT * FROM v_portal_overtimeapplication WHERE otID=@_identityId        
	);

	-- NEW CONDITION RBC:-) 3/24/2021
UPDATE temp_posteddtr
	SET absent_holiday = absent
WHERE payrollPeriod = _payrollPeriod
AND `employeeId` = _identityId
AND holidayTagging > 0
AND absent > 0
AND scheduleName NOT LIKE '%RESTDAY%';	

UPDATE temp_posteddtr
	SET absent = 0
WHERE payrollPeriod = _payrollPeriod
AND `employeeId` = _identityId
AND holidayTagging > 0
AND absent > 0
AND scheduleName NOT LIKE '%RESTDAY%';	
-- END OF NEW CONDITION RBC:-) 3/24/2021


	SELECT DISTINCT
	dtr.payrollPeriod,
	dtr.employeeCode,
	dtr.employeeId,
	dtr.`day` AS days_of_week,
	IF(dtr.holidayTagging > 0 AND dtr.workHours > 0 , 'HOLIDAY', IF(dtr.holidayTagging = 0 AND dtr.workHours = 0, 'REST DAY',
		CONCAT(DATE_FORMAT(dtr.`shiftFrom`, "%r"),' - ',DATE_FORMAT(dtr.`shiftTo`, "%r")))) AS shift,	
	DATE_FORMAT(dtr.`date`, '%m/%d/%Y') AS `date`,
	IFNULL(DATE_FORMAT(dtr.`biometricsIn`, "%r"),'') AS timeIN,
	IFNULL(DATE_FORMAT(dtr.`biometricsOut`, "%r"),'') AS timeOUT,
	CASE 
		WHEN dtr.`biometricsIn` IS NULL AND dtr.`biometricsOut` IS NOT NULL THEN 'NO' 
		WHEN dtr.`biometricsIn` IS NOT NULL AND dtr.`biometricsOut` IS NULL THEN 'NO'
		WHEN dtr.`holidayTagging` = 0 AND dtr.`workHours` = 0 THEN 'RD'
		WHEN dtr.`holidayTagging` > 0 THEN 'HOL'
		-- WHEN dtr.`holidayTagging` > 0 AND dtr.`legalWithPay` > 0 THEN 'HOL'
		WHEN IFNULL(dtr.`totalHours`,0) > 0 AND dtr.`leave` = 0 THEN 'WRK'
		WHEN dtr.`leave` > 0 THEN lv.leaveName
		WHEN dtr.`absent` > 0 AND IFNULL(dtr.`totalHours`,0) = 0 THEN 'ABS'
		WHEN dtr.lwop > 0 THEN 'LWOP'
		ELSE 'UNKNOWN'
	END AS `remarks`,
	CASE
		WHEN dtr.`leave` > 0 AND dtr.absent > 0 THEN ''
		WHEN dtr.`leave` > 0 AND dtr.absent = 0 THEN ''
		WHEN dtr.`leave` = 0 AND dtr.absent > 0 THEN ''
		WHEN dtr.`holidayTagging` = 0 AND dtr.`workHours` = 0 AND dtr.`biometricsIn` IS NULL AND dtr.`biometricsOut` IS NULL THEN ''
		WHEN dtr.`holidayTagging` > 0 AND dtr.`biometricsIn` IS NULL AND dtr.`biometricsOut` IS NULL THEN ''
		WHEN dtr.late > 0 THEN IF(dtr.regularWorkHour > 0, ROUND((dtr.regularWorkHour - dtr.late)/60/8,2),'')
		ELSE ROUND((dtr.regularWorkHour)/60/8,2)	
	END AS `reg_work_days`,	
		
	CASE
		WHEN dtr.`leave` > 0 AND dtr.absent > 0 THEN ''
		WHEN dtr.`leave` > 0 AND dtr.absent = 0 THEN ''
		WHEN dtr.`leave` = 0 AND dtr.absent > 0 THEN ''
		WHEN dtr.`holidayTagging` = 0 AND dtr.`workHours` = 0 AND dtr.`biometricsIn` IS NULL AND dtr.`biometricsOut` IS NULL THEN ''
		WHEN dtr.`holidayTagging` > 0 AND dtr.`biometricsIn` IS NULL AND dtr.`biometricsOut` IS NULL THEN ''		
		WHEN dtr.late > 0 THEN IF(dtr.regularWorkHour > 0, ROUND((dtr.regularWorkHour - dtr.late)/60,2), '')
		ELSE ROUND((dtr.regularWorkHour)/60,2)	
	END AS `reg_work_hrs`,
	
	IF(dtr.absent > 0, ROUND(dtr.absent/60/8,2), '') AS `absent_days`,
	IF(dtr.absent > 0, ROUND(dtr.absent/60,2), '') AS `absent_hrs`,
	IF(dtr.leave > 0, ROUND(dtr.leave/60/8,2), '') AS `lwp_days`,
	IF(dtr.leave > 0, ROUND(dtr.leave/60,2), '') AS `lwp_hrs`,
	IF(dtr.lwop > 0, ROUND(dtr.lwop/60/8,2), '') AS `lwop_days`,
	IF(dtr.lwop > 0, ROUND(dtr.lwop/60,2), '') AS `lwop_hrs`,
		
	IF(dtr.late > 0, ROUND(dtr.late/60,2), '') AS `late_hrs`,
	IF(dtr.undertime > 0, ROUND(dtr.undertime/60,2), '') AS `undertime_hrs`,
	
	-- regular OT
	IF(dtr.regularOTHour > 0, ROUND(dtr.regularOTHour/60,2), '') AS `reg_ot_hrs`,
	IF(dtr.regularOTNightDiff > 0, ROUND(dtr.regularOTNightDiff/60,2), '') AS `reg_nd_ot_hrs`,
	
		IF(dtr.regularLegalWorkHour > 0, IF(ROUND(dtr.regularLegalWorkHour/60,2) <= 8, ROUND(dtr.regularLegalWorkHour/60,2), ''), '') AS `legal_ot_8hrs`,	
	IF(dtr.regularLegalOTHour > 0, ROUND(dtr.regularLegalOTHour/60,2), '') AS `legal_ot_exceeds_8hrs`, 	
	IF(dtr.regularLegalOTNightDiff > 0, ROUND(dtr.regularLegalOTNightDiff/60,2), '') AS `legal_nd_ot_hrs`,
	
	IF(dtr.regularLegalRestDayWorkHour > 0, IF(ROUND(dtr.regularLegalRestDayWorkHour/60,2) <= 8, ROUND(dtr.regularLegalRestDayWorkHour/60,2), ''), '') AS `legal_rd_ot_8hrs`,	
	IF(dtr.regularLegalRestDayOTHour > 0, ROUND(dtr.regularLegalRestDayOTHour/60,2), '') AS `legal_rd_ot_exceeds_8hrs`, 	
	IF(dtr.regularLegalRestDayOTNightDiff > 0, ROUND(dtr.regularLegalRestDayOTNightDiff/60,2), '') AS `legal_rd_nd_ot_hrs`,
		
	IF(dtr.regularRestDayWorkHour > 0, IF(ROUND(dtr.regularRestDayWorkHour/60,2) <= 8, ROUND(dtr.regularRestDayWorkHour/60,2), ''), '') AS `reg_rd_ot_8hrs`,	
	IF(dtr.regularRestDayOTHour > 0, ROUND(dtr.regularRestDayOTHour/60,2), '') AS `reg_rd_ot_exceeds_8hrs`,
	IF(dtr.regularRestDayOTNightDiff > 0, ROUND(dtr.regularRestDayOTNightDiff/60,2), '') AS `reg_rd_nd_ot_hrs`,
	
	IF(dtr.specialWorkHour > 0, IF(ROUND(dtr.specialWorkHour/60,2) <= 8, ROUND(dtr.specialWorkHour/60,2), ''), '') AS `spcl_ot_8hrs`,	
	IF(dtr.specialOTHour > 0, ROUND(dtr.specialOTHour/60,2), '') AS `spcl_ot_exceeds_8hrs`,	
	IF(dtr.specialOTNightDiff > 0, ROUND(dtr.specialOTNightDiff/60,2), '') AS `spcl_nd_ot_hrs`,
		

	IF(dtr.specialRestDayWorkHour > 0, IF(ROUND(dtr.specialRestDayWorkHour/60,2) <= 8, ROUND(dtr.specialRestDayWorkHour/60,2), ''), '') AS `spcl_rd_ot_8hrs`,	
	IF(dtr.specialRestDayOTHour > 0, ROUND(dtr.specialRestDayOTHour/60,2), '') AS `spcl_rd_ot_exceeds_8hrs`,
	IF(dtr.specialRestDayNightDiff > 0, ROUND(dtr.specialRestDayNightDiff/60,2), '') AS `spcl_rd_nd_ot_hrs`,
	
	IF(IFNULL(ota.otTotalHours,0) >= 8, 1, '') AS `cto_days`,
	CASE WHEN IFNULL(ota.otTotalHours,0) >= 4 AND IFNULL(ota.otTotalHours,0) < 8 THEN IFNULL(ota.otTotalHours,0) WHEN IFNULL(ota.otTotalHours,0) < 4 THEN '' END AS `cto_hrs`		
FROM temp_posteddtr dtr
LEFT JOIN v_leaveapplication la ON la.`laID` = dtr.`employeeId` AND la.`laLstDate` = dtr.`date`
LEFT JOIN temp_v_overtimeApplication ota ON ota.`otID` = dtr.`employeeId` AND ota.`otDate` = dtr.`date` AND ota.otType = 'Accum-OT'
LEFT JOIN `leave` lv ON lv.leaveCode = la.laType 
ORDER BY dtr.`date`; 

END$$
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_initialize_logsview`$$ 
CREATE PROCEDURE `sp_portal_initialize_logsview`(
IN pMode TINYINT -- 0 for manual, 1 - automatic
)
BEGIN
DECLARE _dateFrom DATE;
DECLARE _dateTo DATE;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	GET DIAGNOSTICS CONDITION 1
	@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT, @errno = MYSQL_ERRNO;
	ROLLBACK;	
	INSERT INTO processlogs(payrollPeriod, payrollGroup, `status`, `remarks`,`processBy`)
	VALUES('PERIOD-COVERED', 'ALL GROUPS','DTR Collection Failed.',CONCAT(@p1,'-',@p2),'SYSTEM');
	SELECT IFNULL(@errno,999) AS `code`  ,CONCAT(@p1,'-',@p2) AS message, @p1 AS `sqlstate`;
END;
START TRANSACTION;
SET @startTime := NOW(6);
IF pMode = 1 THEN
	SELECT DATE_ADD(DATE_ADD(LAST_DAY(CURRENT_DATE()), INTERVAL 1 DAY), INTERVAL -1 MONTH) INTO _dateFrom;
	SELECT LAST_DAY(CURRENT_DATE()) INTO _dateTo;
ELSE
	SELECT MIN(dtrTime) INTO _dateFrom FROM dtrlogs;
	SELECT MAX(dtrTime) INTO _dateTo FROM dtrlogs;
END IF;
DROP TABLE IF EXISTS kiosklogsCollector;
CREATE TABLE kiosklogsCollector (
	EmpId VARCHAR(20),
	kDate DATE,
	kType VARCHAR(5),
	kIn VARCHAR(5),
	kOut VARCHAR(5),
	Source VARCHAR(50)
);
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID EmpId,taDate kDate,taType kType,taTime kIn, '' kOut,'TIME ADJUSTMENT' Source  FROM `timeadjustmentform` WHERE taType = 'in' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID,taDate,taType,'' kIn,taTime,'TIME ADJUSTMENT' Source  FROM `timeadjustmentform` WHERE taType = 'out' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'in',obTimeFrom ,'' kOut,'OFFICIAL BUSINESS' Source  FROM `officialbusinessform` WHERE obType = 'in' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'out','' kIn ,obTimeTo,'OFFICIAL BUSINESS' Source  FROM `officialbusinessform` WHERE obType = 'out' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,`obLstDate`,'in' kType,`obLstTimeFrom`,'' kOut,'OFFICIAL BUSINESS' Source FROM `officialbusinessform` ob LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` WHERE ob.obType='days' AND ob.obStatus = 'A' AND obLstDate BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) `obLstDate`,'out' kType,'' kIn,`obLstTimeTo`,'OFFICIAL BUSINESS' Source FROM `officialbusinessform` ob LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` WHERE ob.obType='days' AND ob.obStatus = 'A' AND IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,`teTime`,'','TIME ENTRY' Source FROM `timeentryform` WHERE `teType` = 'IN' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo;
INSERT INTO kiosklogsCollector (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,'',`teTime`,'TIME ENTRY' Source FROM `timeentryform` WHERE `teType` = 'OUT' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo;


-- HOUSE KEEPING
DELETE FROM DtrlogsviewCollector
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo;



/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MINIMUM TIME-IN - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	identity.`identityId`,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MIN(machineID) 'machineID', MIN(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'I'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'I';

/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MAXIMUM TIME-OUT - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */		
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	identity.`identityId`,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MAX(machineID) 'machineID', MAX(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'O'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'O';	


INSERT INTO DtrlogsviewCollector(dtrTime,dtrType,biometricsId,machineID,Source)
SELECT 
	TIMESTAMP(kiosk.`kDate`, STR_TO_DATE(IF(kiosk.`kIn` = '',kiosk.`kOut`,kiosk.`kIn`), '%H:%i:%00')) AS dtrTime
	,UPPER(LEFT(kiosk.`kType`,1)) AS `dtrType`
	,kiosk.`EmpId`
	,'KIOSK'
	,kiosk.source
FROM kiosklogsCollector kiosk;
	
SET @executionTime := (SELECT REPLACE(TIME_FORMAT(TIMEDIFF(@startTime, NOW(6)),'%T'),'-',''));
INSERT INTO processlogs(payrollPeriod,payrollGroup,`status`,noOfRecords,`remarks`,processBy,processDuration)
SELECT 'PERIOD-COVERED', 'ALL GROUPS', 'AUTO DTR COLLECTION',COUNT(DISTINCT biometricsId), CONCAT('DTR Collection Successful. - ',COUNT(DISTINCT biometricsId), ' Records Affected'), 'SYSTEM', @executionTime 
FROM DtrlogsviewCollector 
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo;
	
COMMIT;		


END$$
DELIMITER ;

DROP EVENT IF EXISTS auto_dtr_collection_process;
DELIMITER $$ 
CREATE EVENT `auto_dtr_collection_process`
ON SCHEDULE EVERY 1 HOUR 
STARTS CURRENT_TIMESTAMP 
ON COMPLETION PRESERVE 
DO CALL sp_portal_initialize_logsview (1)$$ 
DELIMITER ;




DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_approver_information`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_approver_information`(  
IN user_id VARCHAR(30),   
OUT j_object JSON
)
BEGIN 
-- CALL sp_approver_information('1912',@json); SELECT @json
SET @fullname = (SELECT CONCAT(IFNULL(firstName,''),' ',IFNULL(middlename,''),' ',IFNULL(lastName,'')) FROM identity WHERE identityId=user_id);
SET @code = (SELECT `code` FROM identity WHERE identityId=user_id);
SET @costCode=(SELECT MAX(DISTINCT costCode) FROM employeemovement WHERE `code`=@code AND costCode IS NOT NULL);
SET @departmentCode=(SELECT MAX(DISTINCT departmentCode) FROM employeemovement WHERE `code`=@code AND departmentCode IS NOT NULL);


SET j_object = (SELECT JSON_OBJECT('fullname', @fullname, 
			   'costCode', @costCode, 
			   'departmentCode', @departmentCode)
       );

END$$ 
DELIMITER ;
-- SELECT identityId,CONCAT(firstName,' ',middlename,' ',lastName) FROM identity





-- CALL sp_offset_get_ref_list(0,'0601200008',@num,@msg);SELECT @msg;
DROP PROCEDURE IF EXISTS sp_offset_get_ref_list; 
DELIMITER $$  
CREATE PROCEDURE sp_offset_get_ref_list
( 
IN pint_mode INT,
IN emp_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF (pint_mode=0) THEN
	-- SELECT *,excessTime FROM temp_temporarydtr WHERE `overtime` = 0 AND excessTime > 0
	
	SELECT pd.`date`, pd.`day`, pd.`biometricsIn`, pd.`biometricsOut` 
	FROM temp_temporarydtr pd
		JOIN  		
		(
		SELECT DISTINCT pdtr.`payrollPeriod`,identity.identityId 
		FROM `posteddtr` pdtr
		
		LEFT JOIN identity ON identity.`code` = pdtr.`employeeCode`

		LEFT JOIN payrollgroup ON identity.batchId = payrollgroup.payrollGroupCode

		LEFT JOIN payrollconfiguration ON payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

		LEFT JOIN payrollperiod ON payrollconfiguration.paymentFrequency = 
										(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
										WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
										WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

		LEFT JOIN payrollperioddetails ON payrollperiod.code = payrollperioddetails.code
						AND CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineid) = pdtr.`payrollPeriod`
		
		WHERE identity.identityId = emp_id
		
		ORDER BY payrollperioddetails.`payrollPeriodFrom`  
		) a ON a.`payrollPeriod` = pd.`payrollPeriod` 
	AND pd.`overtime` = 0
	AND pd.excessTime > 0
	AND pd.`employeeId` = emp_id ;
	
END IF;


END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_leave_delete;  
DELIMITER $$  
CREATE PROCEDURE sp_leave_delete(
IN pint_mode INT, 
IN la_AppNo INT, 
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



SET @EmpID = (SELECT laID FROM leaveapplicationform WHERE laAppNo=la_AppNo);
SET @laType = (SELECT laType FROM leaveapplicationform WHERE laAppNo=la_AppNo);
SET @laTotalDays=(SELECT laTotalDays FROM leaveapplicationform WHERE laAppNo=la_AppNo); 

SET @code =(SELECT `code` FROM identity WHERE identityID=@EmpID);  

START TRANSACTION; 
UPDATE employeeleavebalances SET currentBalance=currentBalance+@laTotalDays WHERE `code`=@code AND leaveCode=@laType;
UPDATE   leaveapplicationform SET laStatus='C' WHERE laAppNo=la_AppNo;
COMMIT;

END $$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS sp_emp_ytd_get_details; 
DELIMITER $$  
CREATE PROCEDURE sp_emp_ytd_get_details
(  
IN pint_mode INT,  
IN user_id VARCHAR(30),
IN r_year INT,    
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 

SET num = 0;
SET msg = 'Success';

SELECT 
	ytd.employeeCode
	,ytd.identityId
	,CONCAT(ytd.lastname,', ', ytd.firstname) AS employeeName
	,la.laborName AS empStatus
	,IF(ytd.MWE = 1, 'Yes', 'No') AS isMWE
	,ytd.yeartax AS yearTax
	,cc.costName
	,dept.departmentName
	,pos.positionName 
	,ytd.datehired
	,ytd.dateResigned
	,IFNULL(ytd.monthyRate,0) monthyRate
	,IFNULL(ytd.dailyRate,0) dailyRate
	,ytd.payrollPeriod
	,IFNULL(ytd.basicPay,0) AS basicPay
	,IFNULL(ytd.netBasicPay,0) netBasicPay
	,IFNULL(earnings.taxableEarnings,0) + IFNULL(`taxableAmount`,0) taxableEarnings
	,IFNULL(earnings.nonTaxableEarnings,0) nonTaxableEarnings
	,IFNULL(ytd.grossPay,0) grossPay
	,IFNULL(ytd.witholdingTax,0) AS taxWitheld
	,IFNULL(ytd.sss,0) sss
	,IFNULL(ytd.phic,0) phic
	,IFNULL(ytd.hdmf,0) hdmf
	,IFNULL(ytd.deductions,0) deductions
	,IFNULL(ytd.netPay,0) netPay
	,ytd.source
FROM ytd_details ytd
LEFT JOIN labor la ON la.laborcode = ytd.empStatus
LEFT JOIN costcenter cc ON cc.costCode = ytd.costCenter
LEFT JOIN department dept ON dept.departmentCode = ytd.department
LEFT JOIN `position` pos ON pos.positionCode = ytd.positionCode
LEFT JOIN (
	SELECT 
		t1.ytdCode
		,IFNULL(SUM(CASE WHEN ae.`taxable` = 1 THEN t1.`amount` ELSE 0.00 END),0) AS `taxableEarnings`
		,IFNULL(SUM(CASE WHEN ae.`taxable` IS NULL THEN t1.`amount` ELSE 0.00 END),0) AS `nonTaxableEarnings`
	FROM ytd_earnings_details t1
	LEFT JOIN additionalearning ae ON ae.earningCode = t1.earningCode
	WHERE t1.identityId = user_id AND t1.payrollPeriodYear = r_year
	GROUP BY t1.ytdCode
) earnings ON earnings.ytdCode = ytd.ytdCode
LEFT JOIN (
	SELECT ep.code
		,SUM(IFNULL(ep.overtime,0) + IFNULL(ep.nightDiff,0) + IFNULL(ep.holidayPay,0)) AS `taxableAmount` 
	FROM employeepayslip ep
	WHERE ep.identityId = user_id AND ep.payrollPeriodYear = r_year
	GROUP BY ep.code			
) ep ON ep.code = ytd.ytdCode			      
WHERE ytd.identityId = user_id AND ytd.yearTax =r_year ORDER BY LENGTH(ytd.payrollPeriod), ytd.payrollPeriod;	


END $$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_emp_ytd_get_summary; 
DELIMITER $$  
CREATE PROCEDURE sp_emp_ytd_get_summary
(  
IN pint_mode INT,  
IN user_id VARCHAR(30),
IN r_year INT,    
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 

SET num = 0;
SET msg = 'Success';

SELECT 
			ytd.identityId
			,IFNULL(MAX(ytdBasicPay),0) AS totalBasicPay
			,IFNULL(MAX(ytdNetBasicPay),0) AS totalNetBasicPay
			,IFNULL(earnings.taxableEarnings,0) + IFNULL(ep.`taxableAmount` ,0) AS totalTaxableEarnings
			,IFNULL(earnings.nonTaxableEarnings,0) AS totalNonTaxableEarnings
			,IFNULL(MAX(ytdGrossPay),0) AS totalGrossPay
			,IFNULL(MAX(ytdWitholdingTax),0) AS totalTaxWithheld
			,IFNULL(MAX(ytdSSS),0) AS totalSSS
			,IFNULL(MAX(ytdPHIC),0) AS totalPHIC
			,IFNULL(MAX(ytdHDMF),0) AS totalHDMF
			,IFNULL(MAX(ytdSSS) + MAX(ytdPHIC) + MAX(ytdHDMF),0) AS totalStatutory
			,IFNULL(MAX(ytdDeductions),0) AS totalDeduction
			,IFNULL(MAX(ytdNetPay),0) AS totalNetPay	
		FROM ytd_details ytd
		LEFT JOIN (
			SELECT   
				t1.identityId
				,t1.payrollPeriodYear
				,SUM(CASE WHEN ae.`taxable` = 1 THEN t1.`amount` ELSE 0.00 END) AS `taxableEarnings`
				,SUM(CASE WHEN ae.`taxable` IS NULL THEN t1.`amount` ELSE 0.00 END) AS `nonTaxableEarnings`
			FROM ytd_earnings_details t1
			LEFT JOIN additionalearning ae ON ae.earningCode = t1.earningCode
			WHERE t1.identityId = user_id AND t1.payrollPeriodYear = r_year
			GROUP BY t1.identityId, t1.payrollPeriodYear
		) earnings ON earnings.identityId = ytd.identityId    
		LEFT JOIN (
			SELECT ep.identityId
				,SUM(IFNULL(ep.overtime,0) + IFNULL(ep.nightDiff,0) + IFNULL(ep.holidayPay,0)) AS `taxableAmount` 
			FROM employeepayslip ep
			WHERE ep.identityId = user_id AND ep.payrollPeriodYear = r_year	
		) ep ON ep.identityId = ytd.identityId 			 
		WHERE ytd.identityId = user_id AND ytd.yearTax = r_year
		GROUP BY ytd.identityId;

END $$ 
DELIMITER ;



DROP FUNCTION IF EXISTS fn_offset_get_ref_list;
DELIMITER $$ 
CREATE FUNCTION fn_offset_get_ref_list
(
pint_mode INT
,user_id VARCHAR(30)
,bioTimeIn VARCHAR(30)
,bioTimeOut VARCHAR(30)
) 
RETURNS INT
DETERMINISTIC
BEGIN
DECLARE result INT;


DROP TEMPORARY TABLE IF EXISTS tmlTbl; 
CREATE TEMPORARY TABLE tmlTbl AS (
	SELECT pd.`date`, pd.`day`, pd.`biometricsIn`, pd.`biometricsOut` FROM `posteddtr` pd
	JOIN  		
		(
		SELECT DISTINCT pdtr.`payrollPeriod` FROM `posteddtr` pdtr
		LEFT JOIN identity ON identity.`code` = pdtr.`employeeCode`

		LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode

		LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

		LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
		WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
		WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

		LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
		AND CONCAT(payrollperioddetails.code,'-',payrollperioddetails.lineid) = pdtr.`payrollPeriod`
		
		WHERE identity.identityId = user_id
		
		ORDER BY payrollperioddetails.`payrollPeriodFrom`  
		) a ON a.`payrollPeriod` = pd.`payrollPeriod` 
	AND pd.`overtime` > 0
	AND pd.`employeeId` = user_id 
	);


SET result=(SELECT EXISTS (SELECT 1 FROM tmlTbl WHERE biometricsIn=bioTimeIn AND biometricsOut=bioTimeOut ));

RETURN result;
END$$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_time_adj_get_disabled_array;   
DELIMITER $$ 
CREATE PROCEDURE sp_time_adj_get_disabled_array(
IN pint_mode INT, 
IN id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';



SELECT payrollperioddetails.payrollPeriodFrom AS `from`, 
		payrollperioddetails.payrollPeriodTo AS `to` 
	FROM identity

	LEFT JOIN payrollgroup ON identity.batchId = payrollgroup.payrollGroupCode

	LEFT JOIN payrollconfiguration ON payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode

	LEFT JOIN payrollperiod ON payrollconfiguration.paymentFrequency = 
								(CASE WHEN payrollperiod.PayrollPeriodType='Semi-Monthly' THEN 'SM' 
								WHEN payrollperiod.PayrollPeriodType='Monthly' THEN 'MO'
								WHEN payrollperiod.PayrollPeriodType='Weekly' THEN 'WK' END)

	LEFT JOIN payrollperioddetails ON payrollperiod.code = payrollperioddetails.code

	WHERE identity.identityId = id 
		AND payrollperioddetails.payrollPeriodKioskLocked IS NULL 
		;

END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_get_user_iformation; 
DELIMITER $$ 
CREATE PROCEDURE sp_get_user_iformation(
IN pint_mode INT,
IN id VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF pint_mode = 0 THEN /*OVERTIME*/
	
	SELECT * FROM identity WHERE identityid=id;
	
END IF; 
END $$ 
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_get_users; 
DELIMITER $$ 
CREATE PROCEDURE sp_get_users(
IN Id INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF Id = 0 THEN
	SET num = 1;
	SET msg = 'Invalid ID'; 
ELSEIF (SELECT COUNT(*) FROM users WHERE identityid = Id) = 0 THEN
	SET num = 1;
	SET msg = 'No record found'; 
ELSE
	SELECT identityid, firstName, lastName
	FROM users
	WHERE identityid = Id;
END IF;
END $$
DELIMITER ;


DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_get_failed_login`$$ 
CREATE PROCEDURE `sp_portal_get_failed_login`(
IN pint_mode INT,
IN p_identity VARCHAR(20),
IN passwords VARCHAR(100),  			
IN in_database VARCHAR(100),
IN in_attempt INT,
IN in_ip VARCHAR(300),
IN in_access INT,
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';
IF (pint_mode=0) THEN -- select failed login

	-- select * FROM `pf-common`.`user_failed_logins` where identityId = identityId;
	SELECT COUNT(*) AS attempts, MAX(attempted_at) AS last_date_attempt, IFNULL(MAX(logAttempts),0) AS logAttempts FROM `pf-common`.`user_failed_logins` WHERE username = p_identity ;
	
END IF;

IF (pint_mode=1) THEN -- insert failed login

	INSERT INTO `pf-common`.`user_failed_logins` (username, `password`, `database` ,logAttempts, ip_address) 
	VALUES (p_identity, passwords, in_database, in_attempt, in_ip);
END IF;

IF (pint_mode=2) THEN -- select access lock and attempt

	SELECT IFNULL(access_locked,0) AS access_locked, lastAttempt, attempts FROM users WHERE username = p_identity;
END IF;

IF (pint_mode=3) THEN -- INSERT access lock and attempt

	UPDATE users
	SET 
		`lastAttempt` = NOW(),
		`attempts` = in_attempt,
		`access_locked` = in_access
	WHERE 
		`identityid` = p_identity;
	
	
END IF;

IF (pint_mode=4) THEN -- get last login attempt
	
	SELECT * 
	FROM `pf-common`.`user_failed_logins` 
	WHERE username = p_identity 
		AND ip_address = in_ip  
	ORDER BY attempted_at 
	DESC LIMIT 1; 
	
	/*
	SELECT * 
	FROM `pf-common`.`user_failed_logins` 
	WHERE username = p_identity 
		AND ip_address = in_ip  
	ORDER BY attempted_at 
	LIMIT 1 OFFSET 1;
	*/
	
END IF;

IF (pint_mode=5) THEN -- DELETE LOGS SUCCESS LOGIN

	DELETE FROM `pf-common`.`user_failed_logins` WHERE username = p_identity AND ip_address = in_ip;
	UPDATE users SET attempts = 0, lastAttempt = NULL, access_locked = NULL WHERE username = p_identity;
	
END IF;

	IF (pint_mode=6) THEN -- update pStatus


	UPDATE users SET pStatus = 'E' WHERE username = p_identity;
	
END IF;


END$$
DELIMITER ;


DROP PROCEDURE IF EXISTS sp_lms_url; 
DELIMITER $$  
CREATE PROCEDURE sp_lms_url
(  
IN pint_mode INT,	 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success'; 

IF NOT EXISTS(SELECT * FROM lmsKey WHERE validUntil>=DATE(NOW())) THEN

	SET @newKey = (SELECT SUBSTRING(CONCAT(SHA1(RAND()), SHA1(NOW())), 1, 10)); 
	INSERT INTO lmsKey (activeKey,validUntil)
	VALUES (@newKey,DATE(NOW()) + INTERVAL 1 DAY); 

END IF;

SET @newKey=(SELECT activeKey FROM lmsKey WHERE validUntil>=DATE(NOW()) LIMIT 1);

SELECT 'http://192.168.1.9:8000' AS url
	,'http://mdb4.payfactor.ft:8080/mdb/' adminURL
	,@newKey AS newKey;

END $$ 
DELIMITER ;


-- CALL sp_kiosk_lookups(0,@num,@msg); 
DELIMITER $$  
CREATE PROCEDURE IF NOT EXISTS sp_kiosk_lookups
(  
IN pint_mode INT,	 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 

SET num = 0;
SET msg = 'Success'; 


SET @error_msg = '';

-- COLUMNS 
	DROP TEMPORARY TABLE IF EXISTS pf_columns; 
	CREATE TEMPORARY TABLE pf_columns AS (	
		SELECT *
		FROM(  
			-- department
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'department'
			
			UNION ALL
			
			-- identity
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'identity'
		
			UNION ALL
			
			-- users
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'users'
			
			UNION ALL
			
			-- companysetting
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'companysetting' 
			
			UNION ALL
			
			-- companysetting
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'announcement_tbl' 
			
			UNION ALL
			-- email_logs
			SELECT  COLUMN_NAME,   COLUMN_TYPE,TABLE_NAME
			FROM information_schema.COLUMNS
			WHERE TABLE_SCHEMA = DATABASE()
			AND TABLE_NAME = 'email_logs' 

		)t1
		
	);
	
	DROP TEMPORARY TABLE IF EXISTS kiosk_columns; 
	CREATE TEMPORARY TABLE kiosk_columns AS (
		SELECT 'DefInternalOrder' AS COLUMN_NAME,'VARCHAR(20)' AS COLUMN_TYPE, 'department' AS TABLE_NAME UNION ALL
		
		SELECT 'windowHours' AS COLUMN_NAME,'DECIMAL(19,2)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'workOnHoliday' AS COLUMN_NAME,'TINYINT(1)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'paymentComputation' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'workingDaysInaYear' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'workingHoursInaDay' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'basisOfAbsent' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'payrollConfigurationCode' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'doleSetup' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'workSchedule' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'scheduleCode' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'tempScheduleCode' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'lateConversionCode' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'undertimeConversionCode' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'location' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		SELECT 'requiredFiledOT' AS COLUMN_NAME,'TINYINT(1)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL 
		SELECT 'payrollPeriodID' AS COLUMN_NAME,'VARCHAR(50)' AS COLUMN_TYPE, 'identity' AS TABLE_NAME UNION ALL
		
		SELECT 'authType' AS COLUMN_NAME,"ENUM('none','ssl','tls','STARTTLS','auto')" AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		
		SELECT 'passwordChangeInitLogon' AS COLUMN_NAME,'TINYINT(1)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'passwordReuseRestriction' AS COLUMN_NAME,'TINYINT(4)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'passwordLength' AS COLUMN_NAME,'TINYINT(4)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'passwordComplexEnabled' AS COLUMN_NAME,'TINYINT(1)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'lockedOutDuration' AS COLUMN_NAME,'INT(11)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'lockedOutRecoveryType' AS COLUMN_NAME,"ENUM('manual','auto')" AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'passwordExpiredDays' AS COLUMN_NAME,'INT(11)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'enableCaptcha' AS COLUMN_NAME,'TINYINT(1)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'logAttempts' AS COLUMN_NAME,'INT(11)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'companyLogoBlob' AS COLUMN_NAME,'MEDIUMBLOB' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		SELECT 'protocol' AS COLUMN_NAME,'VARCHAR(10)' AS COLUMN_TYPE, 'companysetting' AS TABLE_NAME UNION ALL
		
		SELECT 'faceDetails' AS COLUMN_NAME,'TEXT' AS COLUMN_TYPE, 'users' AS TABLE_NAME  UNION ALL
		
		
		SELECT 'errorMessage' AS COLUMN_NAME,'VARCHAR(500)' AS COLUMN_TYPE, 'email_logs' AS TABLE_NAME  UNION ALL
		SELECT 'sysSuggestion' AS COLUMN_NAME,'VARCHAR(300)' AS COLUMN_TYPE, 'email_logs' AS TABLE_NAME  UNION ALL
		SELECT 'sysSuggestion' AS COLUMN_NAME,'VARCHAR(300)' AS COLUMN_TYPE, 'email_logs' AS TABLE_NAME  UNION ALL 
		
		SELECT 'access_locked' AS COLUMN_NAME,'INT(1)' AS COLUMN_TYPE, 'users' AS TABLE_NAME  UNION ALL 
		SELECT 'pw_last_date_changed' AS COLUMN_NAME,'DATETIME' AS COLUMN_TYPE, 'users' AS TABLE_NAME  UNION ALL 
		SELECT 'passwords_used' AS COLUMN_NAME,'VARCHAR(100)' AS COLUMN_TYPE, 'users' AS TABLE_NAME  UNION ALL 
		
		SELECT 'recipients' AS COLUMN_NAME,'LONGTEXT' AS COLUMN_TYPE, 'announcement_tbl' AS TABLE_NAME  
	);
	
	
	SELECT CONCAT(@error_msg,GROUP_CONCAT(CONCAT('Theres a problem with "',t1.COLUMN_NAME,'" column in "',t1.TABLE_NAME,'" table. May it not exists or column type is not updated!') SEPARATOR '</br><hr>'),'</br>') INTO @error_msg
	FROM kiosk_columns t1
	LEFT JOIN pf_columns t2 ON t1.COLUMN_NAME = t2.COLUMN_NAME 
				AND t1.COLUMN_TYPE=t2.COLUMN_TYPE 
				AND t1.TABLE_NAME=t2.TABLE_NAME
	WHERE t2.COLUMN_NAME IS NULL;
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;
	
-- TABLES 
	DROP TEMPORARY TABLE IF EXISTS pf_tables; 
	CREATE TEMPORARY TABLE pf_tables AS (	
		SELECT  TABLE_NAME AS tbl
		FROM information_schema.TABLES
		WHERE TABLE_SCHEMA = DATABASE() 
	);
	
	
	DROP TEMPORARY TABLE IF EXISTS kiosk_tables; 
	CREATE TEMPORARY TABLE kiosk_tables AS (	
		SELECT *
		FROM(
			SELECT  'activity_logs' AS tbl UNION ALL
			SELECT  'userAuditTrails' AS tbl UNION ALL
			SELECT  'announcement_viewed' AS tbl UNION ALL
			SELECT  'dtrlogsviewcollector' AS tbl UNION ALL
			SELECT  'portal_mfa' AS tbl UNION ALL
			SELECT  'max_tbl' AS tbl UNION ALL
			SELECT  'temp_temporarydtr' AS tbl UNION ALL
			SELECT  'posteddtr' AS tbl UNION ALL
			SELECT  'approval2' AS tbl UNION ALL
			SELECT  'lmskey' AS tbl UNION ALL
			SELECT  'temp_approval_tbl' AS tbl UNION ALL
			SELECT  'otp_tbl' AS tbl UNION ALL
			SELECT  'tmp_tbl' AS tbl UNION ALL
			SELECT  'announcement_tbl' AS tbl UNION ALL
			SELECT  'announcement_identity' AS tbl UNION ALL 
			SELECT  'statusMaster' AS tbl UNION ALL 
			SELECT  'appLinkStatus' AS tbl UNION ALL 
			SELECT  'documentMaster' AS tbl UNION ALL 
			SELECT  'schedulechangeapproverhistory' AS tbl UNION ALL
			SELECT  'license_rbp' AS tbl 
		)t1
	);
	
	
	SELECT IFNULL(CONCAT(@error_msg,GROUP_CONCAT(CONCAT('Table name "',t1.tbl,'" is missing!') SEPARATOR '</br><hr>'),'</br>'),'') INTO @error_msg
	FROM kiosk_tables t1
	LEFT JOIN pf_tables t2 ON t1.tbl=t2.tbl
	WHERE t2.tbl IS NULL;
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;
	
-- VIEWS

	DROP TEMPORARY TABLE IF EXISTS pf_views; 
	CREATE TEMPORARY TABLE pf_views AS (
		SELECT  TABLE_NAME AS vw
		FROM information_schema.VIEWS
		WHERE TABLE_SCHEMA = DATABASE()
	);
	
	DROP TEMPORARY TABLE IF EXISTS kiosk_views; 
	CREATE TEMPORARY TABLE kiosk_views AS (
		SELECT *
		FROM( 
			SELECT 'v_portal_overtimeapplication' AS vw UNION ALL
			SELECT 'v_employeerate' AS vw UNION ALL
			SELECT 'v_convertedtemporarydtr' AS vw UNION ALL
			SELECT 'v_converted_temp_temporarydtr' AS vw UNION ALL
			SELECT 'v_employeedailyschedule_cal' AS vw UNION ALL
			SELECT 'v_application_max_line' AS vw UNION ALL
			SELECT 'v_employee_max_line' AS vw UNION ALL
			SELECT 'v_1krows' AS vw UNION ALL
			SELECT 'v_user_details' AS vw UNION ALL
			SELECT 'v_announcement_users' AS vw UNION ALL
			SELECT 'v_portal_exists_date_appilcation' AS vw 
			)t1
	);
	
	SELECT IFNULL(CONCAT(@error_msg,GROUP_CONCAT(CONCAT('View name "',t1.vw,'" is missing!') SEPARATOR '</br><hr>'),'</br>'),'') INTO @error_msg  
	FROM kiosk_views t1
	LEFT JOIN pf_views t2 ON t1.vw=t2.vw
	WHERE t2.vw IS NULL;
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;
	
-- FUNCTIONS
	DROP TEMPORARY TABLE IF EXISTS pf_functions; 
	CREATE TEMPORARY TABLE pf_functions AS (
		SELECT  ROUTINE_NAME AS func
		FROM information_schema.ROUTINES
		WHERE ROUTINE_SCHEMA  = DATABASE()
	);
	
	DROP TEMPORARY TABLE IF EXISTS kiosk_functions; 
	CREATE TEMPORARY TABLE kiosk_functions AS (
		SELECT *
		FROM(
			SELECT 'fn_ot_total_time_compute' AS func UNION ALL
			SELECT 'fn_time_5_strings' AS func UNION ALL
			SELECT 'time_ago' AS func UNION ALL
			SELECT 'f_get_app_lineId' AS func UNION ALL
			SELECT 'f_get_app_authorizer' AS func UNION ALL
			SELECT 'PasswordComplexity' AS func UNION ALL
			SELECT 'fn_offset_get_ref_list' AS func UNION ALL
			SELECT 'fn_check_used_dates' AS func 
		)t1 
	);
	
	
	SELECT  IFNULL(CONCAT(@error_msg,GROUP_CONCAT(CONCAT('Function name "',t1.func,'" is missing!') SEPARATOR '</br><hr>'),'</br>'),'') INTO @error_msg  
	FROM kiosk_functions t1 LEFT JOIN pf_functions t2 ON t1.func=t2.func
	WHERE t2.func IS NULL;
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;



-- STORE PROCEDURES	


	DROP TEMPORARY TABLE IF EXISTS pf_stored_proc; 
	CREATE TEMPORARY TABLE pf_stored_proc AS (
		SELECT  ROUTINE_NAME AS proc
		FROM information_schema.ROUTINES
		WHERE ROUTINE_SCHEMA  = DATABASE()
		AND ROUTINE_TYPE = 'PROCEDURE'
	);
	
	DROP TEMPORARY TABLE IF EXISTS kiosk_stored_proc; 
	CREATE TEMPORARY TABLE kiosk_stored_proc AS ( 
		SELECT *
		FROM(
			SELECT 'sp_kiosk_costumization' AS proc UNION ALL
			SELECT 'sp_portal_update_user_password' AS proc UNION ALL
			SELECT 'sp_check_exists_app_valid_for_edit' AS proc UNION ALL
			SELECT 'sp_loan_overview' AS proc UNION ALL
			SELECT 'sp_portal_new_password_validation' AS proc UNION ALL
			SELECT 'sp_portal_forgot_password_validation' AS proc UNION ALL
			SELECT 'sp_portal_url_maping' AS proc UNION ALL
			SELECT 'sp_user_dashboard_settings' AS proc UNION ALL
			SELECT 'sp_load_calendar_sched_advanced' AS proc UNION ALL
			SELECT 'sp_userAuditTrails' AS proc UNION ALL
			SELECT 'sp_schedule_change' AS proc UNION ALL
			SELECT 'sp_portal_get_all_approvals_count' AS proc UNION ALL
			SELECT 'sp_leave_submit_application' AS proc UNION ALL
			SELECT 'sp_portal_get_posted_dtr_dates' AS proc UNION ALL
			SELECT 'sp_rpt_get_payslip_record' AS proc UNION ALL
			SELECT 'sp_email_hist' AS proc UNION ALL
			SELECT 'sp_application_info' AS proc UNION ALL
			SELECT 'sp_load_schedules' AS proc UNION ALL
			SELECT 'sp_load_sched_day' AS proc UNION ALL
			SELECT 'sp_get_user_details' AS proc UNION ALL
			SELECT 'sp_faceDetails' AS proc UNION ALL
			SELECT 'sp_get_employee_schedule' AS proc UNION ALL
			SELECT 'sp_ob_application_submit_request' AS proc UNION ALL
			SELECT 'sp_get_default_mailer' AS proc UNION ALL
			SELECT 'sp_app_user_info' AS proc UNION ALL
			SELECT 'sp_selected_items_response' AS proc UNION ALL
			SELECT 'sp_approval_get_authorizer' AS proc UNION ALL
			SELECT 'sp_get_next_authorizer' AS proc UNION ALL
			SELECT 'sp_timeentry_submit_request' AS proc UNION ALL
			SELECT 'sp_get_employee_schedules' AS proc UNION ALL
			SELECT 'sp_emp_ytd_tax_years' AS proc UNION ALL
			SELECT 'sp_overtime_submit_request' AS proc UNION ALL
			SELECT 'sp_check_application_if_exists' AS proc UNION ALL
			SELECT 'sp_delete_application_form' AS proc UNION ALL
			SELECT 'sp_time_adj_get_submit_request' AS proc UNION ALL
			SELECT 'sp_portal_get_all_approvals' AS proc UNION ALL
			SELECT 'sp_approver_get_priviledge' AS proc UNION ALL
			SELECT 'sp_portal_get_leave_balance' AS proc UNION ALL
			SELECT 'sp_for_approval_response' AS proc UNION ALL
			SELECT 'sp_get_document_info' AS proc UNION ALL
			SELECT 'sp_hrd_cert_approval' AS proc UNION ALL
			SELECT 'sp_hrd_cert_submit' AS proc UNION ALL
			SELECT 'sp_approval_insert' AS proc UNION ALL
			SELECT 'sp_approval_get_for_approval' AS proc UNION ALL
			SELECT 'sp_get_approver_scop' AS proc UNION ALL
			SELECT 'sp_get_locations' AS proc UNION ALL
			SELECT 'sp_offset_submit_request' AS proc UNION ALL
			SELECT 'sp_get_user_leave_type' AS proc UNION ALL
			SELECT 'sp_portal_get_security_settings' AS proc UNION ALL
			SELECT 'sp_get_user_per_department' AS proc UNION ALL
			SELECT 'sp_get_payrollperiod_kiosk' AS proc UNION ALL 
			SELECT 'sp_load_calendar_sched' AS proc UNION ALL
			SELECT 'sp_portal_get_dtr_logs' AS proc UNION ALL
			SELECT 'sp_employee_bio_logs' AS proc UNION ALL
			SELECT 'sp_dtr_logs_insert' AS proc UNION ALL
			SELECT 'sp_dropdown_fill' AS proc UNION ALL
			SELECT 'sp_ob_application_get_officialbusinesslist' AS proc UNION ALL
			SELECT 'sp_get_holidaysholiday' AS proc UNION ALL
			SELECT 'sp_leave_get_request_list' AS proc UNION ALL
			SELECT 'sp_leave_days_options' AS proc UNION ALL
			SELECT 'sp_leave_get_balance' AS proc UNION ALL
			SELECT 'sp_overtime_delete' AS proc UNION ALL
			SELECT 'sp_ob_application_cancel' AS proc UNION ALL
			SELECT 'sp_time_adj_cancel_request' AS proc UNION ALL
			SELECT 'sp_timeentry_delete_request' AS proc UNION ALL
			SELECT 'sp_request_get_history' AS proc UNION ALL 
			SELECT 'sp_get_approval' AS proc UNION ALL 
			SELECT 'sp_check_payroll_period_status' AS proc UNION ALL
			SELECT 'sp_for_approval_get_all_detail' AS proc UNION ALL
			SELECT 'sp_timeentry_load_request' AS proc UNION ALL
			SELECT 'sp_for_approval_get_all' AS proc UNION ALL
			SELECT 'sp_overtime_get_request' AS proc UNION ALL
			SELECT 'sp_get_all_leave' AS proc UNION ALL
			SELECT 'sp_offset_get_details' AS proc UNION ALL
			SELECT 'sp_time_adj_get_all_request' AS proc UNION ALL
			SELECT 'sp_portal_mfa_activation' AS proc UNION ALL
			SELECT 'sp_portal_mfa' AS proc UNION ALL
			SELECT 'sp_ob_application_get_all_request' AS proc UNION ALL
			SELECT 'sp_portal_insert_user_password_logs' AS proc UNION ALL
			SELECT 'sp_portal_update_user_password' AS proc UNION ALL
			SELECT 'sp_approval_appNo_details' AS proc UNION ALL
			SELECT 'sp_rpt_get_employee_nthmonth' AS proc UNION ALL 
			SELECT 'sp_get_employee_nthmonth' AS proc UNION ALL
			SELECT 'sp_get_signatories' AS proc UNION ALL
			SELECT 'sp_pf_common_sub_app_license' AS proc UNION ALL
			SELECT 'sp_get_lms_license' AS proc UNION ALL
			SELECT 'sp_get_rbp_license' AS proc UNION ALL
			
			SELECT 'sp_get_payslip_param' AS proc UNION ALL
			SELECT 'sp_portal_get_consumed_leave' AS proc UNION ALL
			SELECT 'sp_portal_get_user_password_logs' AS proc UNION ALL
			SELECT 'sp_portal_process_dtr_logs' AS proc UNION ALL
			SELECT 'sp_portal_otp' AS proc UNION ALL
			SELECT 'sp_portal_announcement' AS proc UNION ALL
			SELECT 'sp_portal_get_user_status' AS proc UNION ALL
			SELECT 'sp_portal_get_all_pending_applications' AS proc UNION ALL
			SELECT 'sp_portal_initialize_logsview_per_id' AS proc UNION ALL
			SELECT 'sp_portal_dtr_vew_per_cutoff_process' AS proc UNION ALL
			SELECT 'sp_portal_initialize_logsview' AS proc UNION ALL
			SELECT 'sp_approver_information' AS proc UNION ALL
			SELECT 'sp_offset_get_ref_list' AS proc UNION ALL
			SELECT 'sp_leave_delete' AS proc UNION ALL
			SELECT 'sp_emp_ytd_get_details' AS proc UNION ALL
			SELECT 'sp_emp_ytd_get_summary' AS proc UNION ALL 
			SELECT 'sp_time_adj_get_disabled_array' AS proc UNION ALL
			SELECT 'sp_get_user_iformation' AS proc UNION ALL
			SELECT 'sp_get_users' AS proc UNION ALL
			SELECT 'sp_portal_get_failed_login' AS proc UNION ALL
			SELECT 'sp_lms_url' AS proc UNION ALL
			SELECT 'sp_check_exists_app_valid_for_edit' AS proc UNION ALL
			SELECT 'sp_check_exists_app_valid_for_edit' AS proc  
		)t1
	);
	
	
	SELECT IFNULL(CONCAT(@error_msg,GROUP_CONCAT(CONCAT('Stored Procedure name "',t1.proc,'" is missing!') SEPARATOR '</br><hr>'),'</br>'),'') INTO @error_msg  
	FROM kiosk_stored_proc t1 LEFT JOIN pf_stored_proc t2 ON t1.proc=t2.proc
	WHERE t2.proc IS NULL;
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;
	
-- COMPANY SETTING SETUP
	DROP TEMPORARY TABLE IF EXISTS tempPfCompanySettingsSetup;
	CREATE TEMPORARY TABLE tempPfCompanySettingsSetup AS (
		SELECT  COLUMN_NAME  AS clmn
		FROM information_schema.COLUMNS
		WHERE TABLE_SCHEMA = DATABASE()
		AND TABLE_NAME = 'companySetting'
	);
	
	DROP TEMPORARY TABLE IF EXISTS tempKioskCompanySettingsSetup;
	CREATE TEMPORARY TABLE tempKioskCompanySettingsSetup AS (
		SELECT *
		FROM(
			SELECT 'emailTE' AS clmn UNION ALL
			SELECT 'emailOT' AS clmn UNION ALL
			SELECT 'emailOS' AS clmn UNION ALL
			SELECT 'emailLV' AS clmn UNION ALL
			SELECT 'emailTA' AS clmn UNION ALL
			SELECT 'emailOB' AS clmn UNION ALL
			SELECT 'emailHRD' AS clmn UNION ALL
			SELECT 'emailSched' AS clmn UNION ALL
			SELECT 'enableOnlineDtr' AS clmn 
			)t1
		);
		
	
	
	SELECT IFNULL(CONCAT(@error_msg,rslt),'') INTO @error_msg  
	FROM(
		SELECT IFNULL(CONCAT(@error_msg,GROUP_CONCAT(CONCAT('Column name "',t1.clmn,'" in companySetting table is missing!') SEPARATOR '</br><hr>'),'</br>'),'') AS rslt
		FROM tempKioskCompanySettingsSetup t1
		LEFT JOIN tempPfCompanySettingsSetup t2 ON t1.clmn=t2.clmn
		WHERE t2.clmn IS NULL
	)t1 WHERE rslt NOT IN ('')
	;
	-- tempPfCompanySettingsSetup
	
	IF (IFNULL(@error_msg,'') NOT IN ('')) THEN 
		SELECT @error_msg AS error_msg;
		LEAVE proc_start; 
	END IF;
	
	SELECT @error_msg AS error_msg;
	

END $$ 
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_approved_request_cancel;
DELIMITER $$  
CREATE PROCEDURE sp_approved_request_cancel  
( 
IN pint_mode INT,	
IN switch INT, 
IN rAppNo VARCHAR(30),  
IN rRemarks VARCHAR(100), 
IN rUserId VARCHAR(100), 
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
			"id":"lbltxtCancelRemarks",
			"msg":"Approval for application No.',rAppNo,' failed. ',@errorMessage,'"	
			}'); 
END;

SET num = 0;
SET msg = '';

IF (TRIM(rRemarks)='') THEN
	SET num = 1;
	SET msg = CONCAT('{
			"id":"lbltxtCancelRemarks",
			"msg":"Cancellation remarks cannot be empty!"	
			}'); 
	END IF;
	
	-- SELECT * FROM documentMaster;
	
	SET @document = (SELECT docVal FROM documentMaster WHERE dID=switch);
	
	START TRANSACTION; 
	
	IF (switch=1 AND pint_mode=1) THEN   --  LEAVE
		
		SET @laAppNo=rAppNo; 
		SET @laTotalDays=(SELECT laTotalDays FROM leaveapplicationform WHERE laAppNo=@laAppNo);
		SET @laType=(SELECT laType FROM leaveapplicationform WHERE laAppNo=@laAppNo); 
		SET @id = (SELECT laID FROM leaveapplicationform WHERE laAppNo=@laAppNo);
		SET @code=(SELECT `code` FROM identity WHERE identityId=@id); 
		SET @leaveBalance=(SELECT leaveBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=@laType);
		SET @currentBalance=(SELECT currentBalance FROM employeeleavebalances WHERE `code`=@code AND leaveCode=@laType);
		
		
		UPDATE  leaveapplicationform SET laStatus='C' WHERE laAppNo=@laAppNo;
		
		UPDATE  approval SET decision='C',remarks=CONCAT('Currently approved but cancelled by staff on ',DATE(NOW()),' due to ',rRemarks)
		WHERE document=@document AND id=@id AND appNo=@laAppNo; 
		
		UPDATE employeeleavebalances  
		SET currentBalance = (currentBalance + @laTotalDays),
		leaveBalance = (leaveBalance + @laTotalDays)
		WHERE `code` = @code AND leaveCode = @laType;
		
		
		
		INSERT INTO cancelledApprovedRequest (appNo,document,remarks,userId)
		VALUES (rAppNo,@document,rRemarks,rUserId);
		
		-- SELECT * FROM employeeleavebalances;  --TRUNCATE TABLE cancelledApprovedRequest;
		
	END IF;

COMMIT;

END $$ 
DELIMITER ;

-- CALL `pf-common`.`sp_host_companySettings`(0,@num,@msg); 
DELIMITER $$  
CREATE PROCEDURE IF NOT EXISTS `pf-common`.`sp_host_companySettings`
(  
IN pint_mode INT,
IN hostName VARCHAR(100),	 
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start:BEGIN 

SET num = 0;
SET msg = 'Success'; 


SET @defaultComapnyName = 'Unkown Company';
SET @defaultCompanyLogo = 'data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCALyA+gDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9U6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKZSZHrQBJRUe4eopaBXH0UUUDCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKZQA+imU7NAC0Uyk3D1oFckopmc9KKBj6KSm0APoqPcPWn7h6igV0LRTKKBj6KTNNzQA+iimUALuFN3DmlOAtcF8dPGF14E+E3ijXLLH221snNv/ANdSNq/qRV04OpOMI9XYxqT9nCU5dFc5DxH8TvE3jrxXfeGfhxFawx6dJ9n1TxNqIL29pL/zyhj/AOWsv6DNcL4ntfBug3TR+Pvjtrd7qWcTQWOopbIjf9cIFOyuP/aG8TT/AAE+C/hPwB4cu5ra91S3d77UI/8AXOmB5r7v78jvXxrX6BlmTfW4e0jLkh0svefnc/Psyzf6rPklHmn1u/dXlY+4NMn+BmoalBZ6T8SPEyXl3KlvEItWvQZHZtoQbl9a9J+HuiX/AIF+Ol74c/4SjxD4g0qbQBqCx67f/afLl+07cr8o7V+e3wymj/4Wb4Uj83/mL2v/AKOSv0itcr+1JOP+pST/ANKzXBnGDWEkoKbleLevyO3KcW8UudxUbNLQ9hoplLvX1H518Wfc3Q6io9w9aWgY+imUUAPopmR60u9f7w/OgV0OplGaKBnj2vftEWmk+K9Z0O08I+J9dn0qRILifS9PM0W5k39c+lQN+0hLkY+G3jjH/YJ/+yrL8MapcaH4j+Peq2gzPaXKTxeZ03pYI1fMn/Dd3xMxjGj4/wCvT/7Kvp8PlssW2qFNPlSveXdHymIzJYX+PUau3a0ezPqjUv2nYtIsbm9u/h344tbO3jeWa4l0rYiIoyzfer1nwzrkHijw7p2rWyyR299bJcR+Z94I6hh/Ovl34efGTxB8aP2efiveeIltPtFjp17bxG1i2fI1mzf1r6I+DvzfCnweP+oTa/8Aola83GYeOHTi42knZ63PQwOKniJ35rxautLHZ0Uyk3Ad68o9okoqPev94fnT9wPegLoWimUUDH0UmR602gB9FMzjrS71/vD86BXQ6ikznpzS0DCiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAaOprjfi9q934d+F3ijU7CX7Pe2mnT3EMn9xlQkH9K7IfeNcB8d/+SL+N/8AsEXX/otq3ofxY+qOav8AwZejPLNF8I+KJPCOg65q/wAcNS0g6lbxz7LiG2RNzIG2ru+tO/4R+55x+0RP/wB92n+Ncf8AHZQPgj8LTjk2sX/pMteB195gMqqY6h7f2iWr+zHoflea5+stxX1V072S15pdUfXt98JfiPZ3VpcQfGW7TSNjfa5rmzhL7exj42j61y+paL8K7Z/K1n4r+J9ZvR96b+25n/8ARS7a8y+LPxj1H4iXcdpFJLa+HrYokVp/z02/xy15vXZg8jrVYc9epyvySX4nHjeKqVOcoYWnzLvJt/cj6o8P+FYr75/hx8ZtWF1g7LLWJ01CFv8Atk6qw/Ous8O/GfVfDfiC18LfErS4tC1O7k8qw1i1JfTdSb+6jnmJ/wDYevjGGaSGbzI5fKkj+5JFX0H8LfiVYfFXQ5fh58Qo/wC0or6LZb3cv3pG/hXd/f7q/tXn5lkzoQ50+ePXT3l5+Z6OTcTQxVaNGpHkm9tfdfl5H0Z448c6P8O/D9zrWvXa2VhB1fqzt/Cqr/Exry3+1vin8S7b7dbXFr8LvDRG9J7+FLnUnTH3mRv3cX6mue8H/D7xBp/ii71P4mX39p+H/AkZTRJJP+Xr93u+1y/3pVj+T868W+J3xf1z4lapK891La6V5n+jWEX3ET/b/vvXl5flbxFRwpNO28t18ke3nOe/UIRnWi1faC0fm2+x67qfh74cQgx+Ivi74m1qbHzf8Tt9n/ARCtVLfSvg95oOnfEnxNpdx/DNFqtyh/8AIimvnSivr/7Cilb20vwPz7/WzEc91Rjb53++59c6b4Z8e2VjLc+AfijD4vsx8osfEWyf/wAmovm3Vi/Dv4e/FPXfD91P4s+I2teGtSsriRLm38qB4Sq8rIkn9wrXzXpWq32hXUV3pl1NY3CfcuLWXY9fZP7P/wAVH+KPhm70/VjFJq1l+7uPSaNuj4r5/Msvr4Ck5w5ZR6vlVz6vJs7w2bVo0Z80alnZcz5Wcz/wjlyOB+0VMP8Agdn/AI1b0/wHrmvySQaZ8er6+u9m7y7ZbaTHv8vavmX4geFX8F+NdZ0R+lrcuU/64t8y/wDjlbPwR8Sf8In8TtAu5B5dvcSfZJc/3X4H612yyef1d4ijU5tLr3Ynn0eJf9rjhK1Hl97lfvy0PrX9n/xlfeNPhvZnV3L65p0k2malI/3jcQvtLY/2gA341gfE7UPEPi/4taJ4I8OeI7rw1FBps+qajd20SSOV3rHGo3f7WaT4eEeDPj74/wDDWAllrkcHiOzGc/Of3Vx/4+gP41z3g/xABe/GX4lyFQgun0mxkH/PK0Qp+srNXycKf76VSMd0resv6Z+hVMRbDKM5bX5vSI+Xw7exyiOT9oW4idPvx77MVnax8PIPGVidI1P49TanZz7N9qZLQeZtfd2NfMP+u/eSf6yT79YnxC0R4fAdrrkn7q3k1L7Gn/TR9m5q+4/sP2dm69v+3Yn5nQ4l+s1PZqjp19+Wx6T+3dq1rqXxG0BLS5ivreHSeZI5d/8Ay2b+7XzvpMKXmrafb3H/AB7yXKRv/uM9VIZo5v8AV0V9Dg8P9Vw8aHPscOLxf1ivKty7n60aLH4C0WztLOwGgwRQxrHFHF5Ixt9K8p+JWq+LdB/aOsbjwloB167uvDBgfzZPKtoP9JyskkmP9nGK/Pjw9dwf8JDpX72H/j5j/wDQ6++/2uv2i7j4V6fZ6D4elji8S6hHva6YbxawZ64/vN2//VXwGJymphMVTpwftHNPc++w+awxeFqTqL2ag1sX/E2i6rYwrc/E740f8I95g407w9Kmnp/wFm3SvXA3Wrfs/ecftHxP8Q3Mn8Un9q3p/wDQVr4y1DULvWNQlvNQu5r+9uP3j3F1LveT/gTVV/13+rr6CnkaX8Ss16JRR8/Uzt1P4dFP1bkz728Pw+A9YmCeCfjvrmm3w/1cF9qvnQ/9+p1G6u4k8YfE74Vx+d4osLbx94eQ/Pq2hx+Tewp/fktvuv8A8Ar80fkmr134FftIeI/hHrmnwS6hNfeFnk8q5025l3rEn9+L+5trkxmQTjDmpy5/JrX/AMCR14TPoupapHk809P/AAFn6U+E/FmleNvD9rreiXcV9pt1H5kNxH0IrzXxV8bdR1jXbrwz8NtITxNrlqfLvdSuJNmm6a3pLIOXf/YTmvO/GnhHxF4d+II0L4fTfY/DXxCj+0XNxERs0148efPD7yROPxArifjz8dLX4MaXH8MPhpjTJLGPy77Uosb4mb+BT3lPVnNfL4bLVWqRjQ95y1SfRf3j6vFZlKlTl7b3eXRtdX/dPSfFeippGJPij8bbqxnccaboUyacn/fK7pHrjP7X/Z987P8AwsrxF5n/AD3/ALVvP/ia+LLu7nvLuW4uJZrq5k/ePJL87yVF50dfc08hSh79Z/8Abtoo+JqZ4/8Al3RXzvJn6F+E9Ji1hjJ8Mfjlc38yD5dM1ieHUU/74YLIlWFk+OXij4gw6Hd6la+CrK10x5/7T0yyhvba/mWZF+XzV3RHY33DX54wzSWc0UkcvlSR/cki+R6+xP2Sf2ptS1bWrbwV4xu/tslx8mnanKcTF+f3Uv8AeP8AdNeRmGT18LTdenaaXeKuv8z1MDm9HEzjRqXg2+knb/gHqVr4Zg8A+CfiY+r+OLHxNrWt20888hWG1bctsybfLRvavzkroPiRNH/wsjxX+9/5iV1/6Oeufr6PKcv+qwlUnO/PbpY+fzTHPEzjThG3Lfrc+wP2OrfTta+D/wAR9Av9VtNM/tUvab5JU+TzLZo9+013fibQfiF8MfhBqusaH8XodTsNA00mG0h0SzdD5afKu/n2r4Emmjh/1lfcP7GfhTTviB+zn4p0K+kzZajqVxBMYvvhGjirwM4wawrli5SupSV4uKZ7uU4t4lRwcI2ai7STaPQbH4weL/ilbw6f8OrGGWKONEv/ABZqw22aS7PnWCNeZn5HT5BXLeK9P8EaFPMnxO+Mur6tqH/Lext9Q+yRJ/272/3a8m/aP/aQNnN/wr74dSnQfDek/wCiTXdidjzOv/LKJv7v/odfL9Z4HI51oe1f7uL2t8XzYsdnUKM/Zr95Jb3+H5I+xP8AhJv2X/P2edrm/wD57/b9T/8AjtdZ4Utfh9rs/l/Dj4xa14ev/wDljaXOomaHd/173I+evgrzo/8AWf8ALOpa9epkcXoq0vn7y+48qGdyW9GPy91/efpVH8VPFvwpvYrX4mWFrd6DJII4vF2kxnyUbr/pMPWIf7ecU/4l3XiHxT8U/C/h3w74tu/D1he6VdX0lxYwpL5hV0Cn5v8Afr5p/Zv/AGnLjQbqPwZ45lGseE7/AP0RJb/5/sm75dj7vvxV7X4I+Huq/DL9o7R9J8ya68HDSr19EkkG77IrOjSWpb0Xjb7V8hiMveBrSVRJSUW12l8u59jh8f8AXaMXTk2m0n3j8+xautHk0++ltLz9oz7Nd28myWGWWyjdGH8DKW4+lXND8Jal4oupLfRvj/eavOkW9oLH7FM+3+98tfDPxuOfjR49P/Uavf8A0c1dL+zr8VLT4L6r4p1+SPzLuTRXgsbb/nrcNNFtFe3LJ67wixFOV5NLTlieJHN6KxXsJxtG715mfV2reEbrwjpcT/Fn426lbRrv8i1sLpLISJ/tbV8yaq3gXwX8KfiNNqcHhDx14ovru1j3z+Vq1yhjX/totfC/iTxJqvjPWrrVtav5b3UJpN7TydBX07/wT8P/ABVHjH/sHx/+hGpxWUzwODliHUfMui0QsLmkMbjFQVNcr6vWR9Kfst6hear8CfDtzf3Ut9ct9pR7i5k3ySbbmVVJbvwBXrvpXjv7JX/JA/D3/XW9/wDSyevYvSvhcZ/vFT1Z9/gv93p+iFooorkO4KKSloAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooARa8/+PH/JF/G//YIuv/RbV6Atef8Ax4/5Iv44/wCwRdf+i2rfD/xoeqOXFfwZ+jPA/jt/yRL4W/8AXrF/6TCvn6voH47f8kS+Fv8A16xf+kwr5+m/1P7v/WV+u5Jpgb+cvzP594oV80a8o/ke4fDv4eeFvC3w9l+InxElxpY+a3tWHEg+6o2r98t/ClL4f/aB+BvjjVY9Bu/BraLBPJ9ngvpbSONDu/2423JWV+3FI+j/AA/+HHhy3Pl2RSSR4/8ArnCqr/6HXx9XDhMG80pyxdepJXb5bO1kj6edSnlPJgqNOLslzXV7tn1P8Zvhk/wx8UfZLeWWTS7qPz7R5Dl9v8aN/u1wdpdz6bdxXlvL5VzbypIkn+2te7fFS+k8Xfs1/DjxJd/8f5it97+7QlX/APQa8Dr1MsrzxWFtW3V4v5Hxue4WGBxzjQ0TtJfM+zvizca18RfgVYzeHrCS/uNVjtpJII/+eZwzV81f8KL+IH/Qr3/5p/8AFV9YfAfUI7f4JaBe3ckcUENu+92OFVVdv8K878c/td29rdSWnhew+2mPrfXh2R/8BHU18fluJxuHqVMLgaaaUnqz9CzXC5ZiaFHMMxrOLlGOiL/hDwDqPwl+GNpqGl+Bv+Em8a3hBmgknhgMJb+/K5+RF/2a67w3ba54006+tviF4E0XQrBY/wB35eoJd5/8hrtr5x1X9pb4g6iuP7VisR/07WqL/wChbq4rXviJ4m8TQ+Vq2vahexSf8spJcR/98rXYslx2IqSqV5xTbvfW69Dzv9Zsrw9ONDC0m0lazsk/Uy9Whgh1bUI7OXzbKO5eOGT/AJ6Jv+Wva/2QJHb4kaih/wBW2luR/wB/Y68J/wBT+7k/dSV7j+x9/wAlO1L/ALBUn/o2Ovos4VstqLyPlOHn/wAK9J+ZrftgeFUh1fR/E0P+ruo/sc0kf95fmQ188edJD+8j/dSR/ckr6Z0PUf8AhcXwf8e+HpSJdU8N6tdLDx/AsjSRfmu9Pwr5mrjySpKVB4ee8Hb5dDs4ow/sccsVT+Gor/PqfSvxn8dT6F4V+HvxhsIhcz2EU1peQj+NLiHbt/4DOkdZXj+0Pw0/Zo8G+FTu/tHURHNef3pH/wBdLu/4G1bf7P1nZfFL4Uaz4J1f97a2l4rkesTOJB/48hri/wBrDxJ/avxMj09ObfSrdU/4G3zN+mK8PCYf/b44Pl+CTfy+z+Z9ZmOL/wCEiWM5v4kVH5v4vyPGK+pNU8baP+zb8LfAOm6no8Or3+rXSL9nGxNjv80kvzf3S6V4f8GfCv8AwmnxK0XT3iElvHJ59zn/AJ5R/MK7j9oXPjrX/GevECXTvCdzpGiWWOn2iS9gkuX/AOA/ukr1c5qxxGJp4Wfw7v56I8ThjDzw+GrY2G/wx+Wsjj/2/LC10/x94ZS0tobeP+zX+SKIJ/y2r5u8O/8AIxaV/wBf0H/oaV9Mf8FCP+Si+Gv+wQ//AKOr5n8O/wDIxaV/1/Qf+hpXpZQ75bBvsdOaf8jSfqfp7qni7R9N+MGgeBj4btZX1LTpr4X3lJ+78s427dtfIn7RnwZ+Jfjr4z+JdWs/CF/e2EkkcFpNCU2PEibV/ir0P9rDxH4n8KfHrwXP4Nkx4ivNJewtgYkfzN833fmr0nWPjL/wz14Jtv8AhYviSTxN4tvI98djYQon1CD+5n+N6+Hwkq+DdOvh0pSmrW1vvufZ4pUMYqlDEycYwd76W22Pmf4Lfsn+LNW+JWlx+MfCt3p3huDfcXDXJTZJt4WL5W/ir6nvtW8a6XrkujeGPg/pJ8PWp+zxXl9qUNojqP4kiWN/kr5p8Vft8eOtWl/4kljp+hwfwEx/aXP515tq37UXxS1ht0njPUIkf+C1CQH/AMdWvcxGX5ljqntMSorTa7/Q8mhj8uwMPZ4Zyeu9l+p7j+3L4Q8O6f4d8M6wmn6fo3iy6lEdxBZdZFKZf7u3dtbHz18gVb1bVtS8SXUuoahd3mqXH8dxdSvO/wD301VK+py/CTwOHjRnPmsfMY7FQxmIlWhG1z9OPDfjRfBv7KujeKrjEk1j4YguB5neXyF2j/vrFfmZd3c+pXd3eXkv2q5uJXkmkl/5aO3zNX3H8XNRksv2EfDUUfS40zS4H/3NiN/7LXwvXh8OYf8AjVO8mvuPb4hxGlGh2in957v+yr8D9N+KGtaprfifA8K6Gm64jPyRzv8Ae2P/ALCp96vT1/am+D/9q/2Anw4iPhXzPs/2v7JB5ez+/wCV/crO+F92fD/7Cvj69t/9fc3M0byf7Mnkxf8AoDV8lf8ATOlTw/8AalevOtJ2g+WKTt8zOpXWW0aEKMVea5pNq/yPcv2sPgrY/CjxtYz6BED4f1hHnt4x8/2d15ZP9zBG2vGNP1C70HULTVLPzorm0kS4h/31fdX09pP7el9puh2Gn3Hgu1vpLS3jg+0S3f39qbd33at/8N+XH/Qgad/4F/8A2NbUa+Z0qEcPOjzW0vzLUK2Hy2pWdeFblvrbleh9NeMNC8P618I9a1uPSNPL3eizXYnNqhfc0DNuzivyxr9EPh78eLj46/Bn4h3dxo8ekfYbKeBI45fM8zdbM1fnfXJw5GdB16dbdNHTxDKFdUZ0NmmfX37Hv9laR8HPiHr9/pFrq39kl7vy7iFH/wBXbmTZ83+ea9M+IHxlj0f9lOXxdpOjxeGr7xBCILKzj2fu3mO0P8qr/CN9eT/sv/8AJsPxo/68rr/0japf2tpjpvwD+EenwjEEluknl/7S2y4/9DNeXXoxxObOnU/nX3JXPSoVpYbK+eH8j+9ux8kV9LfszfBnwzN4M1X4pfEHyZPDWm7/ALLaSjMb+X993X+P5vkVK+aa+u/jYr+HP2Kfh7plucx30tqJv9v93JN/6GBX1ecVJqFLD05W55Wv5dT5fKacHOpXqRvyRvbz6Eo/bm8Kw3P2JPhpGdB/1fWHft/65bdv61z/AO0R8H/C2sfDqx+LHw7h+zaNdf8AH/YwjZGoZ9u/b/AVfO6vl+vr79meN/FH7KPxT0O4PmW8JuhBH/c3Wqyf+hV5uLwcMr5MVhW17yUtd0z0MJi5Ztz4bEpP3W46bNHyDX6S/sheOx8Rvg7pT6gftOqaBK9hJPL9/Kp8r/jE4r82of8AU19mf8E679y3jm0/5Z/6FOn5Sq38q34loe1wTq/yv/gGXDdf2WMVP+ZW/U+a/jd/yWnxx/2Grz/0c1clpOn3esahaafp8U11e3cqW8NvF9+R2rrvjf8A8lq8c/8AYavf/RzV2v7HOkx61+0BoQkj3x2sM8+fR1T5a9CNd4bL1WXSF/wPKlQ+s450e87fiei6f+yj4B+HOk2tz8VPGpstQmj3rZWUyRD8PlZ5K9F+C+ofAj4X3ep3fhbxuv2i+g8h49Uu9ifL/vRrg12fwf8ADth4o+JXxK8T6haxXt9BrZ0q0luAH8iKBFG2P+7knPHevWtU8I6HrEJS/wBH0++j9Li1R/8A0IV+Z4rMqlX93WnJ3tezsvuP0nC5ZCl+9oxirXtdXf3nmv7IeJP2fPDEi9C17j/wMmr2Zu1ZmjaTYaDpsVjptpDY2kedlvbRBETPP3VrS7rXiVp+0qyn3bZ9HQh7OlGHZJD6KKKwOkY3BzSZHanN8wrI8Ra9Y+GdFutT1GYW1naxmSaQ/wAC1S1JnKNOPPLoa+6jdXlf/DTXw3/6GWP/AL9S/wDxNH/DTXw3/wChlj/79S//ABNdf1HFf8+pfczzP7UwP/P+P3o9U3Ubq8r/AOGmvhv/ANDLH/36l/8AiaP+Gmvhv/0Msf8A36l/+Jo+o4v/AJ8y+5h/amB/5/x+9Hqm6jdXlf8Aw018N/8AoZY/+/Uv/wATR/w018N/+hlj/wC/Uv8A8TR9Rxf/AD5l9zD+1MD/AM/4/ej1TdRuryr/AIae+G3/AEMsX/fmX/4mj/hp74bf9DLF/wB+Zf8A4mj6ji/+fMvuYf2pgf8An/H70eq7qN1eVf8ADT3w2/6GWL/vzL/8TR/w098Nv+hli/78y/8AxNH1HF/8+Zfcw/tTA/8AP+P3o9V3Ubq8q/4ae+Gn/QzR/wDfmX/4mj/hp74af9DNH/35l/8AiaPqOL/58y+5h/amB/5/x+9Hqu6jdXlX/DT3w0/6GWP/AMBpv/iai/4ak+Gf/QzR/wDgLN/8TR9RxX/PmX3MP7UwP/P+P3o9a3Ubq8l/4ak+Gf8A0M0f/gLN/wDE0f8ADUnwz/6GaP8A8BZv/iaPqOK/59S+5h/amB/5/wAfvR61x60ceteS/wDDUnwz/wChmj/8BZv/AImj/hqT4Z/9DNH/AOAs3/xNP6jiv+fUvuH/AGpgf+f0fvR61x60ceteS/8ADUnwz/6GaP8A8BZv/iaP+GpPhn/0M0f/AICzf/E0fUcV/wA+pfcH9qYH/n9H70etcetHHrXkv/DUnwz/AOhmj/8AAWb/AOJpP+Gp/hj/ANDPH/4Czf8AxFH1HFf8+pfcH9qYH/n9H70et8etHHrXkn/DU/wx/wChnj/8BZv/AIij/hqf4Y/9DPH/AOAs3/xFH1HFf8+pfcH9qYH/AJ/R+9HrfHrRx615J/w1P8Mf+hnj/wDAWb/4ij/hqf4Y/wDQzx/+As3/AMRR9RxX/PqX3B/amB/5/R+9HrfHrRx615J/w1P8Mf8AoZ4//AWb/wCIpn/DVHww/wChmj/8BZv/AImj6hiv+fUvuD+1MD/z+j96PXuPWjj1ryH/AIao+GH/AEM0f/gLN/8AE0n/AA1d8L/+hqi/8BZv/iaPqGK/59S+4P7UwP8Az+j96PX+PWjj1ryD/hq74X/9DVF/4Czf/E0f8NYfC7/oao//AAFm/wDiaPqOK/59S+4P7UwP/P6P3o9f49aOPWvIP+GsPhd/0NUf/gLN/wDE0f8ADWHwu/6GqP8A8BZv/iaPqOK/59S+4P7UwP8Az+j96PX+PWjj1ryD/hrD4Xf9DVH/AOAs3/xNH/DWHwt/6GqP/wABZv8A4mj6jiv+fUvuD+1MD/z+j96PX+aOa8e/4aw+Fn/Q1R/+As3/AMTR/wANYfCz/oao/wDwGm/+Jo+o4v8A59S+4P7Twf8Az+j/AOBI9h/Cj8K8e/4ax+Fn/Q1R/wDgLN/8TR/w1j8LP+hqj/8AAWb/AOIo+o4r/n1L7mP+0cJ/z+j/AOBI9hz70Z968e/4az+Fv/Q0xf8AgLN/8TR/w1n8Lf8AoaYv/AWb/wCJo+o4v/n1L7i/7Qwn/P6P3o9hz70Z968b/wCGtfhV/wBDVD/4Czf/ABNH/DXXwp/6GuL/AMBpv/iKPqOL/wCfUvuD+0MJ/wA/o/ej2TPvRn3rxv8A4a6+FP8A0NcX/gNN/wDEUf8ADXXwp/6GuL/wGm/+Io+o4v8A59S+4P7Qwn/P2P3o9kz70Z968b/4a6+FP/Q1xf8AgNN/8RR/w118Kf8Aoa4v/Aab/wCIo+o4v/n1L7g/tDCf8/Y/ej2PafX9KXafX9K8c/4a6+FP/Q1x/wDgLN/8RR/w118Kf+hrj/8AAWb/AOIo+o4v/n1L7h/2hg/+fsfvR7HtPr+lG0+v6V45/wANdfCn/oa4/wDwFm/+Ipv/AA198KP+hrj/APAWb/4mj6ji/wDn1L7g/tDB/wDP2P3o9l2n1/SjafX9K8a/4a++FH/Q1x/+As3/AMTR/wANgfCb/oa4/wDwGm/+Io+o4v8A59S+4P7Qwf8Az9j96PZ6K8X/AOGv/hP/ANDXF/4DTf8AxFM/4bA+E3/Q1xf+As3/AMRS+oYv/n1L7hf2hhP+fq+89rorxT/hsD4Tf9DXF/4Czf8AxFH/AA2B8Jv+hri/8BZv/iKf1DF/8+pfcH9oYP8A5+r7z2uivE/+GxfhL/0Nkf8A4Czf/E0f8Ni/CX/obI//AAFm/wDiaPqGL/59S+4P7Qwf/P1fee2UV4n/AMNi/CX/AKGyP/wFm/8AiaX/AIbF+Ev/AEN8P/gNN/8AEUvqGL/59S+4P7Qwf/P1fee10V4p/wANi/CX/ob4f/Aab/4ij/hsX4S/9DfD/wCA03/xFH1DF/8APqX3B/aGD/5+r7z2uivE/wDhsb4R/wDQ3w/+A03/AMRR/wANjfCP/ob4f/Aab/4ij6hi/wDn1L7g/tDCf8/V957ZRXiX/DZXwi/6G+H/AMBpv/iKKPqGL/59S+4P7Qwn/P1fee20UUVxHoBRRRQAi15/8eP+SL+OP+wRdf8Aotq9AWvP/jx/yRfxx/2CLr/0W1b4f+ND1Ry4r+BP0Z4H8dv+SJfC3/r1i/8ASYV8/Tf6mvoH47f8kS+Fv/XrF/6TCvn6v13JNcDbzl+Z/PvFDtmjflH8j2f9sLS5/Hfwa8D+MdMi+1WdhHm5Mf8AAkiJ834Mgr440/T7vXtQtNP0+L7Ve3cqW8NvF/y0dq+sPhV8cb/4fWcuj3VmmseH5yxe2bGY8/eC+o9q7a1+Onw08MSDUvDPw9itdZxhZBaQwFN3+2ua46DxeWwlhYUedXfK0+/c+hlisvzFQxVatySsuZNduxH8f7WPwL8KfAXgWOb9/aW8fm/9s49v/odfPtbXi/xfqXjnX7nVtXl824mGBHF9yNP7i1N8P/BN38QPGGn6Jbxf6+X99J/zzhX7zV62Dw/9n4P9/LvKTPk8xr/2xmKnRjvaMV+CPV/ifrl14W+AngLwxF+6/tK38+6/3ceZt/76cV4RX0j+2BoX2E+EriCP/RIY5rUj04Qr/Kvm7/rn/rI65MlUZ4R16e8m2/vNeI4Tp5g6FTaEYpeiR9AW/wALfh58KfDmnat8TtYMF5eR70sUlfnjOweX8z9a7P4FeNvhV4+8RXth4K8M7JbG1899QubQL/FtVQ7Zb3rmvE2q/Cb9oDSdCuPG99daTqOlROix+e8BBbbvG7Hzj5BWXqPxS8CfCjwrceH/AIW6aRNc/JLqEm/rjG8u/wAzvXzFSnicbGUKnP7Vv0gj72hWyzLoxrUfZ+zS9Zs8a8Y3UepeLNauI/8AVyX08if99163+yB/yUzUv+wVJ/6Njrw+vcv2RJPL+Jd/H/f01z/4/FX1mbU/ZZbOHkj4PI6iqZvSqd5HH/s7ePD4V/as8V6TPL/ofiC+urT/ALaq7NH+mazPi14V/wCEL+I2taZ/qrfzfPtsf88pPmWvIPG+rXeg/GPW9Us5fKvbDXJ7iGT/AG45t1fWP7R8dv408H+EfiDpxzb39siSn2ZPMT8v3lccf9lxtKp9mrHlfqtj6LMKf17AVYfaoyuv8L3Oa/Zh8VJ4c+J0UE7hIdRtngbP99fnX9FNeceMfED+KfFmq6vJ0vrl7j/gH8P/AI5WVDNJDN5kf7qSl/eTfu4/3sn8EdezDBwpYqeL6tJfcfDTx1Stg6eBW0ZN/efQH7OscHw/8B+NPiLfxDy7W2eOHJ/1nlpub/vpti/hUvirwrdeF/2Rbb+0D/xOtV1bT9Wv39bifUIZHP61veMfDAs/Dfwz+EVvt8zWLlLrVUz/AMukH76cf8CbCfjXXftYKF+CN2B0/tPS/wD0tgr84rYv22NhN/bmn/27HRH7bl+B+q4B0f5IO/8Ailqz5w/4KEf8lG8Nf9gh/wD0dXzP4d/5GLSv+v6D/wBDSvpj/goR/wAlG8Nf9gh//R1fM/h3/kYtK/6/oP8A0NK+0yj/AJFsPRnyGaf8jSfqfphqXhSHWP2mNP1yaLzBo/hx/JPpLJNtP/jtfnR8VvHV18SviBrXiK6l8wXVy/kf9M4V/wBUn/fFfpjNexSfGC/0hvv3XhxJF+izOv8A7PX5Yatp8+j6hd6fcReVc2kr280f+2r7a8Phm0qs3PdJJeh9BxHpShCn1bb9T0P9nn4HXHxv8YS6Z9pOm6VYRie8ux88mzPyqv8AvV7fdS/su/C2aWCW2l8YXsH33w90m5f++Y68z/ZQ+NWl/B3xhqh10zDR9Vt44ZbiP5xA6/dYrXqttp/7Lfw/uI9bi1CTxBMn7yCw86a7w3/XL/4uuzMZ1/rUoT5+Sy5eTr3uzly+FBYaM4cnPd8zn07WRY/bA/sOz+BPg8aRo0Xh621K8iu47COJIPL/AHJb5gv4V8Y16l+0J8dLr42+Jra4+zNpujWKbLC0Y/vPm+87f7deW16+UYephsIoVPi3PDzWvTxGKc6fw7H3b8UtLbUP2D/D7p1tNI0u4/758pf/AGavhKv1A+EugQ+M/wBmHw3ol+M21/4fjs5P9xodv8q/NPxh4VvfBfiXVNB1KPy9QsZHgY/+z/8AAq8jIMQuavh/tKTZ7fEGH0o1/suKR9TfAW1Hj/8AY/8AiH4VtAJdVtZJp/Ij/jOxJYv++vLr5F8mSab7Pb/vbiT92kf+21ehfBH40ap8E/Fx1awi+3WVxFsvLCSXYZl7Ef7dfQn/AA0h8CodU/4SaP4e3f8Awk3m/aM/ZIc+b/e3+Ztz710f7Vl9er7Om5xqPmVu/mcy+q46jT56ihKmrO/byOo+KEvwe+Atj4YsNe+HOnapqF9Z/N5WnQF/3YRWZt31rgv+GhfgH/0SOD/wW21eDfGT4s6j8ZvHN1r19D9liEX2e2tI/n8iJeqn3q78Avhbd/Fn4maVo8cX/Eut5EvNQk/5526//FfcqIZXClhfb42UuZK7940nmUqmK9hg4x5W7L3T9B9Q8JeHvDnwX8UP4e0Kz8P299o09w9vawJD963bG7b6V+WdfqFrnxBsvF/h34raJYNFJB4f097ORo/+ejWzsw/4DxX5e1ycM8zdbn7o6+JeW1Hk2sz6z/Zdx/wzP8aM/wDPldf+kbVY/aQiHi/9lj4W+Irb95HZxw27++6HZ/6FGK4T9mv49eGfhf4Z8UeHfF2mXl7pesHLi1iRwVZPLkR/mX71fT3g+x8BfHr4Baz4X8G2Euj+H/3lpDFcQ7PInzvV1+ZujEGuLHKeBx/1icHy8yd+lrWZvgeTG4H6rCS5uVq3W97o/OGvsHXLGb4vfsP6I+mD7VqXht45JoIvv/ud0cn/AJCffXyb4g8P33hfWr/SNTtRbahYyPBMkn99a9C+Bnx91j4G6tcyQRf2no96d13psk2wsf76N/A9fU5hh6mKpwqYfWUHzLzPmMBXhhakqdfRSXK/I8u/d19g/DPT5/hP+xf4v1vVM2114gEhto5fv/vEWGL/AOLpR+0D+z9Ldf23J8N5jrP+s2f2dBt3/wDfzZXjXx6/aK1X426hbW/2Y6T4esjm301PnJf+/K1ck3is05aDounBNOTfl0R6FNYXLeat7ZTm01FLz6s8ir7e/wCCd+hyQ+HfGGsSf6u7uYLRP+2aM3/tWvizT9Pu9Y1C10/T4prq9u5Ut4beL78jtX6Y/B/SdJ+C2h+EvhuZPN166spr+48v+9kGV/pvfav0rLiXEWwyw6+KX5LU14boXxLrz+GP5vQ/Pv43f8lq8cf9hq9/9HNXon7D/wDyXqw/68bn/wBAFed/G7/ktXjj/sNXn/o5q9E/Yf8A+S9WH/Xjc/8AoArvxP8AyKH/AIP0PPw3/I1X+P8AU+vP2b/9Z8Tf+xz1H/0JK9q9K8V/Zv8A9Z8Tf+xz1H/0JK9q9K/IsV/Gf9dD9cwf8CItFFFcp3BRRRQAVSu7W31Szkt7iKK4t5BseOQb0ertFAHOf8ID4c/6AOn/APgKn+FH/CA+HP8AoBaf/wCAqf4V0H4UfhWvtqn8zOT6tQ/kX3HP/wDCA+HP+gFp/wD4Cp/hR/wr3wz/ANAHTv8AwFT/AAroPwo/Cj29T+Zh9WofyL7jn/8AhXvhn/oA6d/4Cp/hR/wr3wz/ANAHTv8AwFT/AAroPwo/Cj29T+Zh9WofyL7jn/8AhXvhn/oA6d/4Cp/hR/wr3wz/ANAHTv8AwFT/AAroPwo/Cj29T+Zh9WofyL7jn/8AhXvhn/oA6d/4Cp/hR/wr3wz/ANAHTv8AwFT/AAroPwo/Cj29T+Zh9WofyL7jn/8AhXvhn/oA6d/4Cp/hTf8AhXvhn/oAaZ/4Bx/4V0X4UfhR7ap/Mw+rUP5F9xzn/Cu/DH/QB0r/AMBE/wAKP+Fd+GP+gDpX/gIn+FdHt9qNvtR7ef8AMy/q1D+Rfcc5/wAK78Mf9AHSv/ARP8KP+Fd+GP8AoA6V/wCAif4V0e32o2+1Ht5/zMPq1D+Rfcc3/wAK68L/APQvaX/4CR/4Uf8ACuvC/wD0L2l/+Akf+FdJt9qNvtR7af8AMx/V6H8i+45v/hXXhf8A6F7S/wDwEj/wo/4V14X/AOhe0v8A8BI/8K6Tb7Ubfaj20/5mH1eh/IvuOb/4V14X/wChe0v/AMBI/wDCj/hW/hf/AKF3S/8AwDj/AMK6Tb7Ubfaj21T+Zh9XofyL7jm/+Fb+F/8AoXdL/wDAOP8Awo/4Vv4X/wChd0v/AMA4/wDCuk2+1G32o9vU/mYfV6H8i+45v/hW/hf/AKF3S/8AwDj/AMKP+Fa+FP8AoXdK/wDASP8AwrpNvtRt9qPb1P5mL6vQ/kX3HN/8K38K/wDQt6T/AOAcf/xNH/CtfCn/AELulf8AgJH/AIV0m32o2+1Htp/zMPq9D+Rfcc3/AMK38K/9C3pP/gHH/wDE0f8ACt/Cv/Qt6T/4Bx//ABNdJt9qNvtS9tP+Zh9XofyL7jm/+Fb+Ff8AoW9J/wDAOP8A+Jo/4Vv4V/6FvSf/AADj/wDia6Tb7Ubfaj20/wCZh9XofyL7jm/+Fb+Ff+hb0n/wDj/+Jo/4Vv4V/wChb0n/AMA4/wD4muk2+1G32o9tP+Zh9XofyL7jm/8AhW/hX/oW9J/8A4//AImj/hW/hX/oW9J/8A4//ia6Tb7Ubfaj20/5mH1eh/IvuOb/AOFb+Ff+hb0n/wAA4/8A4mj/AIVv4V/6FvSf/AOP/wCJrpNvtRt9qPbT/mYfV6H8i+45v/hW/hX/AKFvSf8AwDj/APiaP+Fb+Ff+hb0n/wAA4/8A4muk2+1G32o9tP8AmYfV6H8i+45r/hWfhT/oWtJ/8BI//iaP+FZ+FP8AoWtJ/wDASP8A+JrpdvtRt9qPbT/mY/q9D+Rfcc1/wrPwp/0LWk/+Akf/AMTR/wAK18J/9C1pP/gBH/8AE10u32o2+1Htp/zMPq9H+Rfccx/wrTwl/wBC1pP/AIAR/wDxNH/CtPCX/QtaT/4AR/8AxNdPRR7ep/MxfV6P8iOY/wCFaeEv+ha0n/wAj/8AiaP+FaeEv+ha0n/wAj/+Jrp6KPb1P5mH1ej/ACI5j/hWnhL/AKFrSf8AwAj/APiab/wrPwh/0LOlf+AEf/xNdTRR7ep/Mw+r0f5Ecr/wrPwh/wBCxpP/AIL4/wD4mj/hWfhD/oWNJ/8ABfH/APE11VFHt6n8zH9Xo/yI5X/hWfhD/oWNJ/8ABfH/APE0f8Kz8If9CxpP/gvj/wDia6qij29T+Zh9Xo/yI5X/AIVn4Q/6FjSf/BfH/wDE0f8ACs/CH/QsaT/4L4//AImuqoo9vU/mYfV6P8iOV/4Vn4Q/6FjSf/BfH/8AE0f8Kz8If9CxpP8A4L4//ia6qij29T+Zh9Xo/wAiOV/4Vf4P/wChX0n/AMAI/wD4mj/hV/g//oV9J/8AACP/AOJrqqKPb1P5mH1ej/Ijlf8AhV/g/wD6FfSf/ACP/wCJpf8AhV/hD/oVtH/8F8P/AMTXU0Ue3qfzMPq9H+VHLf8ACr/CH/QraP8A+C+H/wCJo/4Vd4Q/6FbR/wDwXw//ABNdTRR7ap/MxfV6P8qOX/4Vb4Q/6FbR/wDwAh/+JpP+FV+Dv+hW0f8A8F8P/wATXVfhR+FHtp/zMf1el/Kjlf8AhVfg7/oVtH/8F8P/AMTRXVfhRR7af8zF9XpfyodRRRWZ0BRRRQAi15/8eP8Aki/jj/sEXX/otq9AWvP/AI8f8kX8cf8AYIuv/RbV0Yb+ND1Ry4r+DP0Z4H8df+SJ/C7/AK9Yv/SYV8/Tf6mWvoH46/8AJE/hd/16xf8ApMK+fpv9TLX6zkn+5/OX5n8/8Uf8jJ+kfyPor4jfs23eraXY694UigeS4s4XuNNzsG7Z96P0NeK3Xw58V2kvlz+GtXik/wCvV6+mPiRd+I5pvhLpHhvxLN4butTMiPPHCk6fLaGTDRt9/pW5Dpfxys4/LGr+DNUH/Pe4tbmB/wDvlSwr5vD55isLBc0ovtfRn2uK4ZwWOk5wjKO17WavY+afC3wL8a+LJIkh0Wawtv45779yn5H5q9ltTp3wHtV8J+DI/wDhK/ijqseduPkh/wCms+D+6hWusb4a/FHxQRD4i+I0WjWLfeg8L2Ahm/CeQt/6BXc/D34W+HPhjYS2+hWPlS3B8y5vJpDNc3Tf35ZW+Zz9a8/H51PF+5Ukmv5Y7fNnr5Tw3SwMueEXf+aW6/wo8Z0VZtSsbr4P/FS63a5/rtI145Cakv3g8TN/y1jztK+gFeQeNPgL4x8G3Usb6XLqll/Bd2EXnJ/3x95K+zvHXw70D4jaM2m6/p8d9bZ3ox+SSF/78bD5lb3Fedx/DD4meDdsXhbx9FrFgg+Sz8V2pmdfrcJ8x/EUsBm8sLf2ckr7xe1+6tsVm3D9PHcvtIttaKS3t2d9z5NtfBPiG8l+zweH9Rlk/wCecVo9ewfDL9lzUdVmjvvFh/smwH/LoJcyz/75/gr1b7N8d7xTHLJ4D08f89rb7XM3/fLBRWZrH7Ner+ObPzPGHxC1rUdUjkjms3sYktba0lVtwZYV+/8A8DzXpV8/q1ocnPGC8veZ4eE4SoUZ884yqW6P3UeXfEP9nXxW3jTU5NA0aGXR5JPMthHKkabW6rirfwv+FvxK+HfjC11aDw2JY/8Aj3mjlu4/nib7x+9XrX/CjvGpbH/C6PFGf+vOz/8AjVI3wP8AGqqT/wALp8T/APgLZ/8Axqub+2qkqH1edSLja2qkd64XoU8T9apxnF3urOOh8wft4+H9N0H4kaTcWFhDZS31jJPdSRR7fPff95zXc/sv6l/wtX9nXxR4FuJfN1DSvmt/9xv3kX/j6Gjw38GdJ+OXw5tPGXxF8bawby0ubqw+2PLBGiLHcvGv/LP/ADmt/wAJw/DX9mjw3rz+FNd/4SHxBqMQVczRyOdoO0fu12olejLEKWDhgoXlVhJWaWl0+5jVpwo4mpiq8oxpTi7pvWzXY+df3n/LT91J/HXonwF8Hnxd8UNLt3iEkFpJ9slz/dj6f+P153NNJNN5kn72ST949fQ3wfmT4Q/BHxT8Qp4s3c8Wyxi/v7fliRf96VzX0ebYidHCvl+KXur1Z+b5Fg4YrMY83wR95+iPR/hqT44+OHjjxfIu+z0fZ4Z05vdP3lyf++yPyq3+1p/yRm8/7Cel/wDpfb10nwP8Ev4A+F+i6TcnOoeX9ov3/v3MuZJT/wB9uatfFj4cwfFTwTd+HZ76bS455YJ/tlttZ42imSRfve6V+Ue2hDFxm/hi0vkj+gvYSng5QXxSTfzZ85/tifA3xv8AFHxpoGoeGtFGo29vp5t5n85Ew3mbh95q8P0X9kf4rWWt6fcS+Fh5UdzBI/8ApcP3Ff8A3q+yP+FGeNv+i0eJ/wDwEs//AI1S/wDCjfG3f40eJ/8AwEs//jVfQ0M3nhqCw8KkeVeUj52tk0MRWdedOXM/OJwPxx1DX/Df7SHhrXPDlr/aVxpWgTXF5p8eN91aGYLIif7fRq4n41fs9WPx2iX4kfC+7tL+e+HmXum+bs818cn/AGJefmR6+gPA/wAC73wx46TxTrHjbVvFl/HZPYR/2hFCgVGfd/yzRe9J4m+ANrceIJfEnhHWLvwP4imObifTQHtrs/8ATaBvleuOjmEcLUpujL3oq17aPyZ11stniadRVo+7J3tfVeaPzm1T4W+M9DuvIv8Awrq9tJ/0009//Qq2vBP7O/xF8dXUUdh4VvLWN/8Al8voXtoY/wDgT/8Aslfeq6f8dtNHlRal4I1n/pvdQ3Ns/wD3ym4VHJ4I+MPipdms+ONJ8LWcg+ePwzYPJP8A8Bln+7/3zXuz4jquFrQT73b/AAPDhw9T5/tvysl+J41rf7FKaD8GNVtNJkh8QePZJIZ3lY7EO18+VFn7gwxrxP8A4ZB+LX/QrD/wLh/+Kr7BtP2Ybzw5qF1c+GfiR4m0JL7ZJeJmG6eeZf8Alqzyo3NaX/CjfG69PjR4nA/69LP/AONV5+HzqrS5v3ylfX3lL9Drr5FQq8v7lxsraNfqY37P/wDwsDwF8ItT0fxfokWmy6BbN/Zs/no4njCOwDBf7pxXnPiDwr4T/bQ8N22t6TcReGfiBaWw+0Wlx1ZPRx/Gn9169YuvgH4uvrWaCb4x+J5reeMxvH9ks/un/tlWpL+zX4YvPCPh/SJ5ryPVNDtkt7PXrGX7Nex7R1Dp0rzfrdKnUliIStNu94p6d9Get9UrVacaE43glaza17ao+AvFv7O3xG8E3UiX3hbUZo0GftdhD9ph/wC+krjf+EN8QzTeXHomo+Z/zz+yP/8AE1+kEfgX4weF/k0jx7pPiizQfu4/EWnmOf8A4FLB97/vintL8eMFDY+AEH/Pb7Tefy219DT4krRWqi/nb8z56pw7Tf8AMvlf8j4l+H/7KfxI+IF3DnRZtB07+O81j9zs/wC2X3nr6Z0PSdP+Dumv8NfhfjXPiBqIzqOry8rYKRj7RP8A3dufkhH/AOvu5vhb8RvGh8vxd8Qhp1g337Dwpai23f7PnuWevRPAvw38P/DfSf7O8PadHYwSfPK/33mfH3pGPzMfqa8jH5zPF/xJJ/3Y7fN9T1sBk0cN8EWv7z3+SPCNJ8M6f+y/40hgvZZZfBnim0jsr/Urr5kTU13fvZ/+u4fH1FeGfE39inxn4f1S6ufCEEXiTQ5JfMtlSVEnjRv4G3ffr9Adc0Kw8SaZc6fqlpDe2U6bJoLiPejr6EV5Ov7PF74V/wCRF8fa54TssfJpcwS+s4/9xJfmX/vqscHm1ShP2ilab3urp/cb4zKYVoezcbwW1nZr7z4O/wCGc/ieOvgbVv8Av1X1D8GbPxb8Cf2X/HF9f6XLpGtWss+oW8V8U6COPGfbg16u3w++M3/RWdK/8JVP/j9Z3iz4HfEDx5oV/omt/FQS6VfWxt7i3t9AhTere+6vSxmbvHQjTryhy3Tdubp8jzsHlP1GcqlCM+azSvy9fmeb+MvAvhL9rmxN/YyHwh8SrGJEubG+++voJU/jT+7ItfNfjD9m34keC5ZI7zwreXVunP2vTIftKf8AjlfoT4q+BfhjxnY6Yl/FPDqumxrBbazYSm3vYNq9UkXkVzcXw/8Ai34VYR6H8QLDxJZJ92DxNYfvvxniP/slZYPOpYT3KMly/wAsv0Zpi8lWK9+vF8380f1R+cH/AAhuu+d5f9iaj5v/ADz+yP8A/E11/hX9nn4keNJI0sPCuoxRuM/aL6H7ND/309fennfHg/J/Z3gEDZ/rvtN51+mymSeBfjD4o/d6t480nw3aSDDxeHdP8yb/AIDLP/8AEV6NTiSs9lFfO/5Hn0+HaX95/K35nk/w/wDhX4U/ZVhh1rxDcHxP8Qb393p2k2Y3vub+CCM/+hmuh+HfhPX9H/aH0fXvFd15nibXNIvZ7i0j5gsoVeERwR+u3PX616/4B+CPhv4d3U2oWsU+p67OP3+tapKbi8l+rtVT4jfB+68ceJtM1/TPF2o+FNRsbaS0WSwihk3o7BufMVvSvnJ5jGtOTnLWSacn+SXY+hhl0qUI8kfhaaivzb7nxv8AFD9l34n+JPiZ4t1ew8OC60++1S5uLeT7VCN6NKzLwW4rtf2Wf2e/H3w5+Llvrev+H/sOnx2s0bz/AGqGT52T/ZaveP8AhRvjYf8ANaPE/wD4CWf/AMao/wCFG+Nuv/C6PE//AICWf/xqvSqZtOph/qzqR5bW2kefDJoU6/1r2cua994i/s3n958TB6+M9R/9CWvaq8/+Efwt/wCFWaTqdrJrF3rt1qWoS6lcXl5GiO8smN3CfSvQMda+TxEozquUT63CwlTpKMxaKKKwOoKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigBrda4H47/wDJFvHH/YIuv/RbV3zVx3xZ0S98TfDHxRpOnp5l/f6dPbwoTsyzIVHP41pR/ix9UY1/4UvRnzp8dCP+FJ/C4Dr9liz/AOAwr5/m/wBTLX1/4b134m6N4U0TSLj4PRXn9nW8duJJfElt/Cm3d92rn/CTfEE5/wCLGWH/AIUFp/8AG6+6webTwNH2CjF6vXnj1Py3MuH1mWI+se0cbpK3JLoiHxMf+K0+BPGP3s//AKQmvde9eBtD8QvG/wATPAuoa14Ci8NabodzPcS3H9sw3X+shaP7qgete9/zr4/GbU9vk79WfoWBVlNa7rdW6IdT6KK4T1gplPooAZRT6KAEpJP9W30p1Rt900Cex8faSf8AjDfUB/1Frr/04NXg37uvpz4cjx38OfBc3hTV/hRL4isRe3U/nxahaukiyTPIv7tvrWmniScttt/2e7xXH3TJHZxr+dfoWDzR4T2i5FK8m7qUT8lzTIf7UdOftOXlik04vofPXw/+HWq/EXxBDYWFrKLbzf8ASbzyvkgX+9X0Zq2lWfjr4m+HPh7pMf8AxTHgrydT1TbjY9wo/wBGtz693atJG+LvjC0Gnado2k/DDS2Hz3E0qX15Gv8A0yjTEY/4HXoPw4+HGlfDDw+dO04zTPLK1xd311Jvnupm+9LI3cmvJzPNniPfnZW+FJ336tnv5LkVPAQ5IXd/ik1bbokdlT6KK+TPvAooooASm0+igBlFPooAZT6KKACmU+igBlFPooAZRT6KACiiigAooooAKZT6KAGUU+igBlOpaKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKZQA+iiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKZT6KAGU+iigBlFPooAKKKKACiiigAooooAKKKKAGUU+igBlFPooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKZRQA+mUVxnjv4oaV4KzbyTRyajs8z7Pn7if3m9qAOy80VhXXjrw/ps32e41a1W4H/LMSh2r5H+Ln7SWpatZw21l4gi0aynk8v7RHFmST/rmteNQ/GjRvCunRf2f/pUn8dxdf8ALR65PbnV7A/ROH4i6DN/y94/25I+Ko+IPix4e0fT/tMd/Dff3I4q/NWb9o/VtY0+W3jl83/nt5X39i/NsWulu/iRptnq0Vxqlp9vkjsU/wCJfYSu/wA/3v3ta+0M/Zn3z8P/AIuWPjC1lkuPJsJPMxDH5v8ArK9A3CvzW/4XRJZ2v2jT7Sz0uy8r54/K3z/N/tfd/wDHa91+Dvxz1bXoYtQ8maOyk8u3+0X8vzyO3+z/AH2pinTPran1i+GtbTWNPEgP7yM+XJ/vVr1qZD6KKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAKKKKACiiigAooooAZVHUtRtNMsZby8ljtraH53kk6CrrfdNfF/7X/7Qcem6j/wjGly+bLB9+OL/ntWNSp7OFzanT9obfxc/auvptQuvD/hOGa1Mf39Qk+//wDYV84eMvFl/DpP2i4lvJZLiX995v37h61fDOn/AGPw9/aGoS/YLm4/eTSff8v+LZXn/jjUP+Eq1CKPzZrXTo/3aR/xxp/8XXn+09oej7OFM8/m8Q3d5qEuoap/pX/PGP8Ag3//ABC151rniG717UPtFxN/rPuV1XjfUPOu5be3i8qP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';


SET @DB = (
	CASE
		WHEN hostName='mdb4' THEN 'mdb_demo_v4' -- MDB
		WHEN hostName='msipf' THEN 'materials_solutions_inc' -- MSI
		WHEN hostName='htlandpf' THEN 'ht_land_inc' -- HTLAND 
		WHEN hostName='matling' THEN 'micc_prod' -- HTLAND 
		ELSE ''
	END
	);
	
	
IF EXISTS (SELECT SCHEMA_NAME  FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = @DB) THEN
	
	-- SELECT companyName,companyLogoBlob FROM companySetting
	
	SET @sql = CONCAT('SELECT companyName,companyLogoBlob,0 AS isDefault
				FROM ', @DB, '.companySetting');
	
	
	PREPARE stmt FROM @sql;
	EXECUTE stmt;
	DEALLOCATE PREPARE stmt;

END IF;

SELECT @defaultComapnyName AS companyName,@defaultCompanyLogo AS companyLogoBlob,1 AS isDefault;

	
-- CALL `pf-common`.`sp_host_companySettings`(0,'mdb4',@num,@msg);
END $$ 
DELIMITER ;




DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_acknowledge_clearance`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_acknowledge_clearance`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	UPDATE clearanceform SET cfAcknowledgeTag = 1 WHERE cfID = username;
	
END IF;


END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_clearance_get_form_list`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_clearance_get_form_list`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
	SELECT
		d.departmentName AS departmentName,
		c.cfApproverName,
		c.cfStatus,
		c.cfApprovedDateTime,
		c.cfRemarks,
		c.cfClearanceItems
	FROM `clearanceform` c
	LEFT JOIN `department` d ON c.cfDeptCode = d.departmentCode
	WHERE c.cfID = username;
	
END IF;

IF pint_mode = 2 THEN
	SELECT DISTINCT cfAcknowledgeTag 
	FROM `clearanceform` 
	WHERE cfID = username;
END IF;

IF pint_mode = 3 THEN
	
	SELECT COUNT(*) AS `count`
	FROM clearanceform c
	LEFT JOIN department d ON c.cfDeptCode = d.departmentCode WHERE c.cfID = username;
	
END IF;
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_hr`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_hr`(  
IN pint_mode INT,	

OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
		CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', 
		clearanceform.cfID, 
		MAX(clearanceform.cfApprover) AS 'cfApprover', 
		MAX(clearanceform.cfApproverName) AS 'cfApproverName', 
		MAX(clearanceform.cfApprovedDateTime) AS 'cfApprovedDateTime', 
		MAX(clearanceform.cfDateCreated) AS 'cfDateCreated', 
		MAX(clearanceform.cfDateModified) AS 'cfDateModified', 
		MAX(clearanceform.cfRemarks) AS 'cfRemarks', 
		MAX(clearanceform.cfStatus) AS 'cfStatus', 
		MAX(clearanceform.cfAppNo) AS 'cfAppNo'
		FROM 
		clearanceform 
		LEFT JOIN 
		identity 
		ON 
		clearanceform.cfId = identity.identityId
		WHERE clearanceform.cfApprovedDateTime IS NOT NULL
		GROUP BY 
		clearanceform.cfID;

	
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approvalHistory`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approvalHistory`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
	DISTINCT CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', clearanceform.cfID, 
	clearanceform.`cfApprover`, clearanceform.`cfApproverName`, clearanceform.`cfApprovedDateTime`, clearanceform.`cfDateCreated`, clearanceform.`cfDateModified`, clearanceform.`cfRemarks`, clearanceform.`cfStatus`, clearanceform.`cfAppNo`
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.cfId = identity.identityId
	WHERE `clearanceform`.`cfApprover` = username
	AND clearanceform.`cfApprovedDateTime` IS NOT NULL;

	
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_insert_clearance_status`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_insert_clearance_status`(  
IN pint_mode INT,	
IN _appno VARCHAR(10),
IN _identityId VARCHAR(50),
IN _cfid VARCHAR(50),
IN _cfStatus VARCHAR(5),
IN _cfRemarks VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	UPDATE clearanceform
	SET
		cfRemarks = _cfRemarks,
		cfStatus = _cfStatus,
		cfApprovedDateTime = CURRENT_TIMESTAMP
	WHERE
		cfID = _cfid
	AND
		cfAppNo = _appno
	AND cfApprover = _identityId;
			
END IF;

END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approval_details`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approval_details`(  
IN pint_mode INT,	
IN _appno VARCHAR(10),
IN _cfid VARCHAR(10), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT `clearanceform`.*, CONCAT(identity.`firstName`, ' ', identity.`middleName`, ' ', identity.`lastName`) AS 'Name', department.`departmentName`, `cfApprover`, `cfAppNo` = '".$cfAppNo."' AS 'cfAppNo'
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.`cfID` = `identity`.`identityId`
	LEFT JOIN `department`
	ON `department`.`departmentCode` = `clearanceform`.`cfDeptCode`
	WHERE  `clearanceform`.`cfID` = _cfid
	AND `clearanceform`.`cfAppNo` = _appno;
	
END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_get_clearance_for_approval`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_get_clearance_for_approval`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT 
	DISTINCT CONCAT(identity.firstName, ' ', identity.middleName, ' ', identity.lastName) AS 'Name', clearanceform.cfID, 
	clearanceform.`cfApprover`, clearanceform.`cfApproverName`, clearanceform.`cfApprovedDateTime`, clearanceform.`cfDateCreated`, clearanceform.`cfDateModified`, clearanceform.`cfRemarks`, clearanceform.`cfStatus`, clearanceform.`cfAppNo`
	FROM `clearanceform` 
	LEFT JOIN `identity` 
	ON `clearanceform`.cfId = identity.identityId
	WHERE `clearanceform`.`cfApprover` = username
	AND `clearanceform`.`cfApprovedDateTime` IS NULL;
	
END IF;

END$$
DELIMITER ;



DROP PROCEDURE IF EXISTS sp_insert_clearance_form;
DELIMITER $$
CREATE PROCEDURE sp_insert_clearance_form (
IN _employeeId VARCHAR(10),
IN _username   VARCHAR(20)
)
BEGIN
-- =========================
-- DECLARE VARIABLES (FIRST)
-- =========================
DECLARE v_batchId VARCHAR(50);
DECLARE v_departmentCode VARCHAR(50);
DECLARE v_approverHRIS VARCHAR(50);
DECLARE v_finalApprover VARCHAR(50);

-- =========================
-- ERROR HANDLER
-- =========================
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	GET DIAGNOSTICS CONDITION 1 
		@p1 = RETURNED_SQLSTATE, 
		@p2 = MESSAGE_TEXT, 
		@errno = MYSQL_ERRNO;

	SELECT IFNULL(@errno, 0) AS CODE,
		CONCAT(@p1, ' - ', @p2) AS message;

	ROLLBACK;
END;

-- =========================
-- COLLECT DATA
-- =========================

-- Get batchId
SELECT batchId
INTO v_batchId
FROM identity
WHERE identityId = _employeeId
LIMIT 1;

-- Get latest departmentCode
SELECT em.departmentCode
INTO v_departmentCode
FROM employeemovement em
LEFT JOIN identity idy ON idy.code = em.code
WHERE idy.identityId = _employeeId
ORDER BY em.dateEnd DESC
LIMIT 1;

-- Get HRIS approver
SELECT approverHRIS
INTO v_approverHRIS
FROM payrollgroup
WHERE payrollGroupCode = v_batchId
LIMIT 1;

-- Get final approver identity
SELECT identityId
INTO v_finalApprover
FROM users
WHERE userId = v_approverHRIS
LIMIT 1;

-- =========================
-- START TRANSACTION
-- =========================
START TRANSACTION;

-- Housekeeping
DELETE FROM clearanceform
WHERE cfID = _employeeId
AND cfStatus IS NULL;

-- =========================
-- IMMEDIATE SUPERVISOR
-- =========================
INSERT INTO clearanceform (
	cfID,
	cfDeptCode,
	cfApprover,
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)
SELECT
	_employeeId,
	ca.departmentCode,
	IFNULL(ca.approverId, 'NOT-FOUND'),
	IFNULL(ca.approverName, 'NOT-FOUND'),
	'Turnover List',
	_username,
	'IM'
FROM department d
LEFT JOIN clearance_approvers ca 
	ON ca.departmentCode = d.departmentCode
WHERE d.departmentCode = v_departmentCode
AND d.departmentCode NOT IN (
		SELECT cfDeptCode
		FROM clearanceform
		WHERE cfID = _employeeId
		AND cfStatus IS NOT NULL
	);

-- =========================
-- DEPARTMENT CLEARANCE
-- =========================
INSERT INTO clearanceform (
	cfID,
	cfDeptCode,
	cfApprover,
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)
SELECT
	_employeeId,
	d.departmentCode,
	IFNULL(ca.approverId, 'NOT-FOUND'),
	IFNULL(ca.approverName, 'NOT-FOUND'),
	IFNULL(ci.ItemName, 'NO-DATA-AVAILABLE'),
	_username,
	'DH'
FROM department d
LEFT JOIN clearance_approvers ca 
	ON ca.departmentCode = d.departmentCode
LEFT JOIN clearance_itemlist ci
	ON ci.departmentCode = d.departmentCode
WHERE d.departmentCode NOT IN (
		SELECT cfDeptCode
		FROM clearanceform
		WHERE cfID = _employeeId
		AND cfStatus IS NOT NULL
	)
AND d.departmentCode <> v_departmentCode;

-- =========================
-- FINAL APPROVER
-- =========================
INSERT INTO clearanceform (
	cfID,
	cfDeptCode,
	cfApprover,
	cfApproverName,
	cfClearanceItems,
	cfUserCreated,
	cfApproverTag
)
SELECT
	_employeeId,
	em.departmentCode,
	usr.identityId,
	CONCAT(idy.firstName, ' ', idy.lastName),
	'Endorsement for final pay computation',
	_username,
	'FA'
FROM users usr
LEFT JOIN identity idy 
	ON idy.identityId = usr.identityId
LEFT JOIN employeemovement em 
	ON em.code = idy.code
LEFT JOIN vw_rpt_max_employeemovement vw 
	ON vw.code = em.code 
AND vw.lineId = em.lineId
WHERE usr.userId = v_approverHRIS;

-- =========================
-- SUCCESS RESPONSE
-- =========================
SELECT 0 AS CODE,  'Employee clearance form created successfully.' AS message;

COMMIT;
END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_myprofile_save_contact`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_contact`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _name VARCHAR(30),
IN _relationship VARCHAR(30),
IN _mobileNo VARCHAR(30),
IN _alt_mobileNo VARCHAR(30),
IN _email VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN  

DECLARE v_requestNo INT DEFAULT 0;

-- existing values
DECLARE v_name VARCHAR(30);
DECLARE v_relationship VARCHAR(30);
DECLARE v_mobileNo VARCHAR(30);
DECLARE v_alt_mobileNo VARCHAR(30);
DECLARE v_email VARCHAR(30);

SET num = 0;
SET msg = 'Success';

IF _code IS NULL OR _code = '' THEN
	SELECT `code`
	INTO _code
	FROM identity
	WHERE identityId = _identityId
	LIMIT 1;
END IF;

-- AUTO GENERATE LINE ID
IF _lineId IS NULL OR _lineId = '' THEN
	SELECT IFNULL(MAX(lineId), 0) + 1
	INTO _lineId
	FROM employeecontacts
	WHERE `code` = _code;
END IF;

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM employeecontacts_changelogs 
WHERE `code` = _code ;

-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN

	-- AUTO GENERATE CODE


	-- =========================
	-- GET EXISTING DATA
	-- =========================
	SELECT 
		`name`,
		relationship,
		mobileNo,
		alt_mobileNo,
		email
	INTO
		v_name,
		v_relationship,
		v_mobileNo,
		v_alt_mobileNo,
		v_email
	FROM employeecontacts
	WHERE CODE = _code
	AND lineId = _lineId
	LIMIT 1;

	-- =========================
	-- CHECK IF NO CHANGES
	-- =========================
	IF v_name IS NOT NULL THEN
		IF 
			IFNULL(v_name,'') = IFNULL(_name,'') AND
			IFNULL(v_relationship,'') = IFNULL(_relationship,'') AND
			IFNULL(v_mobileNo,'') = IFNULL(_mobileNo,'') AND
			IFNULL(v_alt_mobileNo,'') = IFNULL(_alt_mobileNo,'') AND
			IFNULL(v_email,'') = IFNULL(_email,'')
		THEN
			SET num = 0;
			SET msg = 'No changes detected';
			LEAVE proc_end;
		END IF;
	END IF;

	-- =========================
	-- INSERT CHANGELOG
	-- =========================
	INSERT INTO employeecontacts_changelogs (
		`code`,
		lineId,
		`name`,
		relationship,
		mobileNo,
		alt_mobileNo,
		email,
		updateRequestedBy,
		updateRequestDate,
		updateStatus,
		requestNo,
		source,
		crud
	) VALUES (
		_code,
		_lineId,
		_name,
		_relationship,
		_mobileNo,
		_alt_mobileNo,
		_email,
		_identityId,
		CURRENT_TIMESTAMP,
		'P',
		v_requestNo,
		'Manual',
		'U'
	);

END IF;

-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN

	INSERT INTO employeecontacts_changelogs (
		`code`,
		lineId,
		`name`,
		relationship,
		mobileNo,
		alt_mobileNo,
		email,
		updateRequestedBy,
		updateRequestDate,
		updateStatus,
		requestNo,
		source,
		crud
	) VALUES (
		_code,
		_lineId,
		'deleted',
		'deleted',
		'deleted',
		'deleted',
		'deleted',
		_identityId,
		CURRENT_TIMESTAMP,
		'P',
		v_requestNo,
		'Manual',
		'D'
	);

END IF;

END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_myprofile_get_emergencycontact`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_emergencycontact`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT c.* FROM employeecontacts c
	INNER JOIN identity i ON i.identityId = identity_id
	WHERE c.code = i.`code`;


END IF;
	
END$$
DELIMITER ;


DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_myprofile_check_pending`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_check_pending`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
DECLARE v_count INT DEFAULT 0;

SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN

	SELECT COUNT(*) 
	INTO v_count
	FROM identity_changelogs 
	WHERE updateRequestedBy = identity_id 
	AND updateStatus = 'P';

	IF v_count > 0 THEN
		SET num = 1;
		SET msg = 'You have a pending change request';
	END IF;

END IF;
	
END$$
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_myprofile_edit_information`$$
CREATE PROCEDURE `sp_myprofile_edit_information`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _firstName VARCHAR (50),
IN _middleName VARCHAR (50),
IN _lastName VARCHAR (50),
IN _suffix VARCHAR (5),
IN _birthdate VARCHAR (50),
IN _age VARCHAR (50),
IN _address VARCHAR (50),
IN _address2 VARCHAR (50),
IN _address3 VARCHAR (50),
IN _citizenship VARCHAR (50),
IN _religion VARCHAR (50),
IN _gender VARCHAR (50),
IN _civilStatus VARCHAR (50),
IN _contactNo VARCHAR (50),
IN _emailAddress VARCHAR (50),
IN _tinNo VARCHAR (50),
IN _sssNo VARCHAR (50),
IN _pagibigNo VARCHAR (50),
IN _hmoNo VARCHAR (50),
IN _prcNo VARCHAR (50),
IN _dateIssued VARCHAR (50),
IN _dateExpired VARCHAR (50),
IN _updateRequestedBy VARCHAR (50),
IN _updateRequestDate VARCHAR (50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
DECLARE v_requestNo INT DEFAULT 0;

SET num = 0;
SET msg = 'Success';

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM identity_changelogs WHERE updateRequestedBy = _identityId;

IF pint_mode = 1 THEN
	INSERT INTO `identity_changelogs` (
		`code`,
		`identityId`,
		`firstName`,
		`middleName`,
		`lastName`,
		`suffix`,
		`birthdate`,
		`age`,
		`address`,
		`address2`,
		`address3`,
		`citizenship`,
		`religion`,
		`gender`,
		`civilStatus`,
		`contactNo`,
		`emailAddress`,
		`tinNo`,
		`sssNo`,
		`pagibigNo`,
		`hmoNo`,
		`prcNo`,
		`dateIssued`,
		`dateExpired`,
		`updateRequestedBy`,
		`updateRequestDate`,
		`updateApprovedBy`,
		`updateApprovedDate`,
		`updateStatus`,
		`requestNo`,
		`isChanged`,
		`source`,
		`crud`
	) VALUES (
		(SELECT `code` FROM identity WHERE identityId = _identityId),
		_identityId,
		_firstName,
		_middleName,
		_lastName,
		_suffix,
		_birthdate,
		_age,
		_address,
		_address2,
		_address3,
		_citizenship,
		_religion,
		_gender,
		_civilStatus,
		_contactNo,
		_emailAddress,
		_tinNo,
		_sssNo,
		_pagibigNo,
		_hmoNo,
		_prcNo,
		_dateIssued,
		_dateExpired,
		_updateRequestedBy,
		_updateRequestDate,
		NULL,
		NULL,
		'P',
		v_requestNo,
		'N',
		'Manual',
		'C'
	);
END IF;

END$$
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_get_payroll`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_payroll`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN

	SELECT 
		t1.identityId,
		t0.code AS CODE,
		t0.lineId,
		t0.rate,
		t0.rateType,
		t0.dateEffective,
		t0.dateEnd,
		-- Data from reference tables
	dept.departmentName AS DepartmentName,
		divi.divisionName AS DivisionName,
		pos.positionName AS PositionName,
		lab.laborName AS LaborName
	FROM employeemovement t0
	INNER JOIN identity t1 ON t0.code = t1.code
	-- Joins to reference tables
	LEFT JOIN department dept ON t0.departmentCode = dept.departmentCode
	LEFT JOIN division divi     ON t0.divisionCode   = divi.divisionCode
	LEFT JOIN POSITION pos     ON t0.positionCode   = pos.positionCode
	LEFT JOIN labor lab        ON t0.laborCode      = lab.laborCode
	-- Logic to grab ONLY the highest lineId for this specific code/user
	WHERE t1.identityId = identity_id
	AND t0.lineId = (
		SELECT MAX(sub.lineId)
		FROM employeemovement sub 
		WHERE sub.code = t0.code
	)
	ORDER BY t0.code; 
	
END IF;

IF pint_mode = 2 THEN
	SELECT 
		t1.identityId,
		t0.code AS CODE,
		t0.lineId,
		t0.rate,
		t0.rateType,
		t0.dateEffective,
		t0.dateEnd,
		-- Data from reference tables
	dept.departmentName AS DepartmentName,
		divi.divisionName AS DivisionName,
		pos.positionName AS PositionName,
		lab.laborName AS LaborName
	FROM employeemovement t0
	INNER JOIN identity t1 ON t0.code = t1.code
	-- Joins to reference tables
	LEFT JOIN department dept ON t0.departmentCode = dept.departmentCode
	LEFT JOIN division divi     ON t0.divisionCode   = divi.divisionCode
	LEFT JOIN POSITION pos     ON t0.positionCode   = pos.positionCode
	LEFT JOIN labor lab        ON t0.laborCode      = lab.laborCode
	-- Logic to grab ONLY the highest lineId for this specific code/user
	WHERE t1.identityId = identity_id
	AND t0.lineId = (
		SELECT MAX(sub.lineId) - 1
		FROM employeemovement sub 
		WHERE sub.code = t0.code
	)
	ORDER BY t0.code;    
		
END IF;


/* ACCOUNTABILITY ITEMS  */


IF pint_mode = 3 THEN

	SELECT 
		acc.*, 
		items.item_name
	FROM `employeeaccountability` acc
	INNER JOIN identity t1 ON acc.code = t1.code
	LEFT JOIN `accountabilityitems` items ON acc.itemId = items.id
	WHERE t1.identityId = identity_id;
	
END IF;

/* LOAN VIEW*/

IF pint_mode = 4 THEN

	SELECT 
		ded.*, 
		items.deductionName
	FROM `employeedeductions` ded
	INNER JOIN identity t1 ON ded.code = t1.code
	LEFT JOIN `recurringdeduction` items ON ded.deductionType = items.deductionCode
	WHERE t1.identityId = identity_id
	AND items.tagging = 'Loan';
	
END IF;

/* LEAVE BALANCES*/

IF pint_mode = 5 THEN

	SELECT 
		emp.*, 
		items.leaveName
	FROM `employeeleavebalances` emp
	INNER JOIN identity t1 ON emp.code = t1.code
	LEFT JOIN `leave` items ON emp.leaveCode = items.leaveCode
	WHERE t1.identityId = identity_id;
END IF;
	
END$$
DELIMITER ;


DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_myprofile_get_information`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_information`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN
	SELECT 
		identityId
		,firstName
		,middleName
		,lastName
		,suffix
		,birthPlace
		,birthdate
		,age
		,address
		,address2
		,address3
		,citizenship
		,religion
		,gender
		,civilStatus
		,contactNo
		,emailAddress
		,batchId 
		,paymentType
		,tinNo
		,BankAccountNo
		,sssNo
		,pagibigNo
		,hmoNo
		,prcNo
		,dateIssued
		,dateExpired
		,signatureFile
		,pictureFile
	FROM identity WHERE identityId = identity_id;
END IF;

END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_initialize_logsview_per_id`$$ 
CREATE  PROCEDURE `sp_initialize_logsview_per_id`(
IN _payrollPeriod VARCHAR(20),
IN _identityId VARCHAR(50)
)
BEGIN
DECLARE _dateFrom DATE;
DECLARE _dateTo DATE;
DECLARE EXIT HANDLER FOR SQLEXCEPTION
BEGIN
	GET DIAGNOSTICS CONDITION 1
	@p1 = RETURNED_SQLSTATE, @p2 = MESSAGE_TEXT, @errno = MYSQL_ERRNO;
	ROLLBACK;	
	INSERT INTO processlogs(payrollPeriod, payrollGroup, `status`, `remarks`,`processBy`)
	VALUES('PERIOD-COVERED', 'ALL GROUPS','DTR Collection Failed.',CONCAT(@p1,'-',@p2),'SYSTEM');
	SELECT IFNULL(@errno,999) AS `code`  ,CONCAT(@p1,'-',@p2) AS message, @p1 AS `sqlstate`;
END;
START TRANSACTION;
SET @startTime := NOW(6);
SELECT payrollPeriodFrom INTO _dateFrom 
FROM v_payrollperiod
WHERE payrollPeriod = _payrollPeriod;

SELECT LAST_DAY(_dateFrom) INTO _dateTo;		
SET @batchId := (SELECT DISTINCT batchId FROM identity WHERE identityId = _identityId);	
DELETE FROM dtrlogs WHERE dtrTime IS NULL;	
	
DROP TEMPORARY TABLE IF EXISTS kiosklogsCollector_per_id;
CREATE TEMPORARY TABLE IF NOT EXISTS kiosklogsCollector_per_id (
	EmpId VARCHAR(20),
	kDate DATE,
	kType VARCHAR(5),
	kIn VARCHAR(5),
	kOut VARCHAR(5),
	Source VARCHAR(50)
) ENGINE=MEMORY;

INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID EmpId,taDate kDate,taType kType,taTime kIn, '' kOut,'TIME ADJUSTMENT' Source  
FROM `timeadjustmentform` 
WHERE taType = 'in' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo AND taID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT taID,taDate,taType,'' kIn,taTime,'TIME ADJUSTMENT' Source  
FROM `timeadjustmentform` 
WHERE taType = 'out' AND taStatus = 'A' AND taDate BETWEEN _dateFrom AND _dateTo AND taID = _identityId;


INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'in',obTimeFrom ,'' kOut,'OFFICIAL BUSINESS' Source  
FROM `officialbusinessform` 
WHERE obType = 'in' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT obID,obDateTo,'out','' kIn ,obTimeTo,'OFFICIAL BUSINESS' Source  
FROM `officialbusinessform` WHERE obType = 'out' AND obStatus = 'A' AND obDateTo BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
		
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,`obLstDate`,'in' kType,`obLstTimeFrom`,'' kOut,'OFFICIAL BUSINESS' Source 
FROM `officialbusinessform` ob LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` 
WHERE ob.obType='days' AND ob.obStatus = 'A' AND obLstDate BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `obID`,IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) `obLstDate`,'out' kType,'' kIn,`obLstTimeTo`,'OFFICIAL BUSINESS' Source 
FROM `officialbusinessform` ob 
LEFT JOIN `officialbusinesslist` ob1 ON ob.obAppNo = ob1.`obLstAppNo` 
WHERE ob.obType='days' AND ob.obStatus = 'A' AND IF(`obLstTimeFrom` > `obLstTimeTo`,DATE_FORMAT((`obLstDate` + INTERVAL 1 DAY),'%Y-%m-%d'),`obLstDate`) BETWEEN _dateFrom AND _dateTo AND obID = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,`teTime`,'','TIME ENTRY' Source FROM `timeentryform` 
WHERE `teType` = 'IN' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo AND `teID` = _identityId;
	
INSERT INTO kiosklogsCollector_per_id (EmpId,kDate,kType,kIn,kOut,Source)
SELECT `teID`,`teDate`,`teType`,'',`teTime`,'TIME ENTRY' Source 
FROM `timeentryform` 
WHERE `teType` = 'OUT' AND `teStatus` = 'A' AND teDate BETWEEN _dateFrom AND _dateTo AND `teID` = _identityId;
	
-- HOUSE KEEPING
DELETE DtrlogsviewCollector.* FROM DtrlogsviewCollector
INNER JOIN employeebiometrics ON DtrlogsviewCollector.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;

/* -- COMMENTED BY RBC:-) NOV-22-2023
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	identity.`identityId`,
	dtr.`machineID`,
	'DTR' AS Source
FROM dtrlogs dtr
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;*/

/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MINIMUM TIME-IN - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	-- identity.`identityId`,
	dtr.biometricsId,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MIN(machineID) 'machineID', MIN(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'I'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'I' AND identity.`identityId` = _identityId;

/* ===========================================================================	
INITILIZE DTR LOGS - GET ONLY MINIMUM TIME-OUT - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */		
INSERT INTO DtrlogsviewCollector (dtrTime, dtrType, biometricsId, machineID, Source)
SELECT 
	DISTINCT DATE_FORMAT(dtr.`dtrTime`, '%Y-%m-%d %H:%i:%00') AS `dtrTime`,
	dtr.`dtrType`,
	-- identity.`identityId`,		
	dtr.biometricsId,
	dtr.`machineID`,
	'DTR' AS Source
FROM (
	SELECT biometricsId, dtrType, MAX(machineID) 'machineID', MAX(dtrTime) 'dtrTime'
	FROM dtrlogs
	WHERE CAST(dtrTime AS DATE) BETWEEN CAST(_dateFrom AS DATE) AND CAST(_dateTo AS DATE)
	AND dtrType = 'O'
	GROUP BY biometricsId, dtrType, CAST(dtrTime AS DATE)	
) dtr 
INNER JOIN employeebiometrics ON dtr.`biometricsId` = employeebiometrics.`bioId` AND employeebiometrics.`machineId` = dtr.`machineID`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(`dtrTime` AS DATE) BETWEEN _dateFrom AND _dateTo AND dtr.`dtrType` = 'O' AND identity.`identityId` = _identityId;	

/* ===========================================================================	
END OF INITILIZE DTR LOGS - GET ONLY MAXIMUM TIME-OUT - REVISED BY: RBC:-) NOV-22-2023
============================================================================== */	
	
INSERT INTO DtrlogsviewCollector(dtrTime,dtrType,biometricsId,machineID,Source)
SELECT 
	TIMESTAMP(kiosk.`kDate`, STR_TO_DATE(IF(kiosk.`kIn` = '',kiosk.`kOut`,kiosk.`kIn`), '%H:%i:%00')) AS dtrTime
	,UPPER(LEFT(kiosk.`kType`,1)) AS `dtrType`
	,kiosk.`EmpId`
	,'KIOSK'
	,kiosk.source
FROM kiosklogsCollector_per_id kiosk;
	
SET @executionTime := (SELECT REPLACE(TIME_FORMAT(TIMEDIFF(@startTime, NOW(6)),'%T'),'-',''));
INSERT INTO processlogs(payrollPeriod,payrollGroup,`status`,noOfRecords,`remarks`,processBy,processDuration)
SELECT _payrollPeriod, @batchId, 'AUTO DTR COLLECTION',COUNT(DISTINCT biometricsId), CONCAT('DTR Collection Successful. - ',COUNT(DISTINCT biometricsId), ' Records Affected'), 'SYSTEM', @executionTime 
FROM DtrlogsviewCollector 
INNER JOIN employeebiometrics ON DtrlogsviewCollector.`biometricsId` = employeebiometrics.`bioId`
INNER JOIN identity ON employeebiometrics.`code` = identity.`code`
WHERE CAST(dtrTime AS DATE) BETWEEN _dateFrom AND _dateTo
AND identity.`identityId` = _identityId;
	
COMMIT;		


END$$

DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_approved_leave_date`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_approved_leave_date`( 
IN pint_mode INT,	
IN rAppNo INT,  
IN rId INT,  
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
			"id":"lblTbl",
			"msg":"Approval for application No.',rAppNo,' failed. ',@errorMessage,'"	
			}'); 
END;


SET num = 0;
SET msg = 'OK';

-- SET num = 1; SET msg = CONCAT('{ "id":"lblTbl", "msg":"TEST Return" }'); LEAVE proc_start;
SET @rAppNo = rAppNo;
SET @rId = rId;

-- SET @rAppNo = 2; SET @rId = 2; 
IF NOT EXISTS (SELECT 1 FROM leaveapplicationlist WHERE laLstAppNo=@rAppNo AND laLstID<>@rId) THEN 
	SET num = 1; 
	SET msg = CONCAT('{ "id":"lblTbl", "msg":"Sorry, you cant delete all leaves of application!" }'); 
	LEAVE proc_start;
END IF;
	
	START TRANSACTION; 
	
	
		
		-- TRUNCATE TABLE deletedleaveapplicationlist
		-- SELECT * FROM leaveapplicationform WHERE laAppNo=@rAppNo
		-- SELECT * FROM deletedleaveapplicationlist
		
		INSERT INTO deletedleaveapplicationlist
		SELECT *,NOW() FROM leaveapplicationlist WHERE laLstAppNo=@rAppNo AND laLstID=@rId;
		
		
		
		SELECT laLstType,laSched,laLstDate
		INTO @laLstType,@laSched,@laLstDate
		FROM leaveapplicationlist WHERE laLstAppNo=@rAppNo AND laLstID=@rId;
		
		SELECT  (CASE WHEN laDateTo<@laLstDate THEN @laLstDate ELSE laDateTo END),laID
		INTO @newLaDateTo,@laID
		FROM leaveapplicationform WHERE laAppNo=@rAppNo;
		
		SET @newLaDateTo = (SELECT MAX(laLstDate) FROM leaveapplicationlist WHERE laLstAppNo=@rAppNo AND laLstID<>@rId);
		
		UPDATE  leaveapplicationform 
		SET laDateTo=@newLaDateTo,
			laTotalDays=ROUND(laTotalDays-@laSched,2)
		WHERE laAppNo=@rAppNo;
		
		
		SELECT `code` INTO @code FROM identity WHERE identityId=@laID;
		
		
		UPDATE employeeleavebalances
		SET leaveBalance=ROUND(leaveBalance+@laSched,2)
		,currentBalance=ROUND(currentBalance+@laSched,2)   
			WHERE `code`=@code AND leaveCode=@laLstType;
		
		DELETE  FROM leaveapplicationlist WHERE laLstAppNo=@rAppNo AND laLstID=@rId;
		
		-- SELECT *,@newLaDateTo FROM employeeleavebalances where `code`=@code AND leaveCode=@laLstType;
	
COMMIT;

END$$ 
DELIMITER ;

DROP PROCEDURE IF EXISTS `pf-common`.`sp_get_company_settings_name_by_db`; 
DELIMITER $$ 
CREATE PROCEDURE `pf-common`.`sp_get_company_settings_name_by_db`
(  
IN pint_mode INT,    
IN r_hostName VARCHAR(50),
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



SELECT GROUP_CONCAT(CONCAT('SELECT companyName AS db_description,"',`name`,'" AS db_name FROM `',`name`,'`.`companysetting`') SEPARATOR ' UNION ALL ')
INTO @sql
FROM v_kiosk_database_host
WHERE hostName=r_hostName;  -- 'manilajockeypf';

IF (@sql IS NULL) THEN  LEAVE proc_start; END IF;

PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;


END $$
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



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_dropdown_fill`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dropdown_fill`(
IN pint_mode INT,
IN opt_param VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF pint_mode = 0 THEN /*OVERTIME*/
	
	SELECT '' AS val,'' AS lbl UNION ALL 
	SELECT 'OT' AS val,'Overtime' AS lbl UNION ALL 
	SELECT 'UT' AS val,'Under Time' AS lbl;
	
END IF;


IF pint_mode = 1 THEN /*LEAVE SCHEDULE*/
	
	SELECT 'Whole Day (1.0)' AS txt,'1.00' AS val UNION ALL
	SELECT 'Half Day (0.5)' AS txt,'0.50' AS val;
	
END IF;


IF pint_mode = 2 THEN /*INT OUT*/
	
SELECT '' AS val UNION ALL
	SELECT 'IN' AS val UNION ALL
	SELECT 'OUT' AS val;
	
END IF;

IF pint_mode = 3 THEN /*DAYS INT OUT*/
	
SELECT '' AS val UNION ALL
SELECT 'Days' AS val UNION ALL
	SELECT 'In' AS val UNION ALL
	SELECT 'Out' AS val;
	
END IF;

IF pint_mode = 4 THEN /*STATUS*/
	
SELECT *
FROM statusMaster;
	
END IF;


IF pint_mode = 5 THEN /*DEPARTMENT*/

SELECT *
FROM(
	SELECT '' AS departmentName,'' AS departmentCode UNION ALL
	SELECT departmentName,departmentCode
	FROM department
	)t1
ORDER BY departmentName,departmentCode;

END IF;


IF pint_mode = 6 THEN /*DTR IN OUT*/
	
SELECT '' AS val,'Select DTR Type' AS txt UNION ALL
	SELECT 'I' AS val,'IN' AS txt UNION ALL
	SELECT 'O' AS val,'OUT' AS txt;
	
END IF;


END$$
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_get_information`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_information`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN
SELECT 
	identityId
	,firstName
	,middleName
	,lastName
	,suffix
	,birthPlace
	,birthdate
	,age
	,address
	,address2
	,address3
	,citizenship
	,religion
	,gender
	,civilStatus
	,contactNo
	,emailAddress
	,batchId 
	,paymentType
	,tinNo
	,BankAccountNo
	,sssNo
	,pagibigNo
	,hmoNo
	,prcNo
	,dateIssued
	,dateExpired
	,signatureFile
	,pictureFile
 FROM identity WHERE identityId = identity_id;
END IF;

END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_edit_information`$$ 
CREATE DEFINER=`root`@`%` PROCEDURE `sp_myprofile_edit_information`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _firstName VARCHAR(50),
IN _middleName VARCHAR(50),
IN _lastName VARCHAR(50),
IN _suffix VARCHAR(5),
IN _birthdate VARCHAR(50),
IN _age VARCHAR(50),
IN _address VARCHAR(50),
IN _address2 VARCHAR(50),
IN _address3 VARCHAR(50),
IN _citizenship VARCHAR(50),
IN _religion VARCHAR(50),
IN _gender VARCHAR(50),
IN _civilStatus VARCHAR(50),
IN _contactNo VARCHAR(50),
IN _emailAddress VARCHAR(50),
IN _tinNo VARCHAR(50),
IN _sssNo VARCHAR(50),
IN _pagibigNo VARCHAR(50),
IN _hmoNo VARCHAR(50),
IN _prcNo VARCHAR(50),
IN _dateIssued VARCHAR(50),
IN _dateExpired VARCHAR(50),
IN _updateRequestedBy VARCHAR(50),
IN _updateRequestDate VARCHAR(50),
IN _payrollGroup VARCHAR(50),
IN _birthPlace VARCHAR(50),
IN _paymentType VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
DECLARE v_requestNo INT DEFAULT 0;
DECLARE v_hasChanged BOOLEAN DEFAULT FALSE;

-- Variables to hold current identity data
DECLARE v_code VARCHAR(50);
DECLARE v_dateHired VARCHAR(50);
DECLARE v_firstName VARCHAR(50);
DECLARE v_middleName VARCHAR(50);
DECLARE v_lastName VARCHAR(50);
DECLARE v_suffix VARCHAR(5);
DECLARE v_birthdate VARCHAR(50);
DECLARE v_age VARCHAR(50);
DECLARE v_gender VARCHAR(50);
DECLARE v_civilStatus VARCHAR(50);
DECLARE v_contactNo VARCHAR(50);
DECLARE v_emailAddress VARCHAR(50);
DECLARE v_address VARCHAR(50);
DECLARE v_address2 VARCHAR(50);
DECLARE v_address3 VARCHAR(50);
DECLARE v_street VARCHAR(50);
DECLARE v_barangay VARCHAR(50);
DECLARE v_city VARCHAR(50);
DECLARE v_province VARCHAR(50);
DECLARE v_zipCode VARCHAR(50);
DECLARE v_country VARCHAR(50);
DECLARE v_tinNo VARCHAR(50);
DECLARE v_taxCode VARCHAR(50);
DECLARE v_taxExemptionCode VARCHAR(50);
DECLARE v_philhealthNo VARCHAR(50);
DECLARE v_sssNo VARCHAR(50);
DECLARE v_pagibigNo VARCHAR(50);
DECLARE v_hmoNo VARCHAR(50);
DECLARE v_prcNo VARCHAR(50);
DECLARE v_dateIssued VARCHAR(50);
DECLARE v_dateExpired VARCHAR(50);
DECLARE v_paymentType VARCHAR(50);
DECLARE v_bankAccountCode VARCHAR(50);
DECLARE v_BankAccountNo VARCHAR(50);
DECLARE v_approver VARCHAR(50);
DECLARE v_batchId VARCHAR(50);
DECLARE v_minimumWage VARCHAR(50);
DECLARE v_dateCreated VARCHAR(50);
DECLARE v_createdBy VARCHAR(50);
DECLARE v_dateUpdated VARCHAR(50);
DECLARE v_updatedBy VARCHAR(50);
DECLARE v_seriesType VARCHAR(50);
DECLARE v_paymentFrequency VARCHAR(50);
DECLARE v_paymentComputation VARCHAR(50);
DECLARE v_doleSetup VARCHAR(50);
DECLARE v_basisOfAbsent VARCHAR(50);
DECLARE v_workSchedule VARCHAR(50);
DECLARE v_scheduleCode VARCHAR(50);
DECLARE v_windowHours VARCHAR(50);
DECLARE v_FotStart VARCHAR(50);
DECLARE v_tempScheduleCode VARCHAR(50);
DECLARE v_lateConversionCode VARCHAR(50);
DECLARE v_undertimeConversionCode VARCHAR(50);
DECLARE v_location VARCHAR(50);
DECLARE v_taxShieldRate VARCHAR(50);
DECLARE v_globalTaxShield VARCHAR(50);
DECLARE v_birthPlace VARCHAR(50);
DECLARE v_citizenship VARCHAR(50);
DECLARE v_religion VARCHAR(50);
DECLARE v_finalPay VARCHAR(50);
DECLARE v_streetNo VARCHAR(50);
DECLARE v_bldg VARCHAR(50);
DECLARE v_subdivision VARCHAR(50);
DECLARE v_district VARCHAR(50);
DECLARE v_municipality VARCHAR(50);
DECLARE v_municipalCode VARCHAR(50);
DECLARE v_foreignAdd VARCHAR(50);
DECLARE v_taxpayerType VARCHAR(50);
DECLARE v_claims VARCHAR(50);
DECLARE v_spouseEmpStatus VARCHAR(50);
DECLARE v_spouseTIN VARCHAR(50);
DECLARE v_spouseLastName VARCHAR(50);
DECLARE v_spouseFirstName VARCHAR(50);
DECLARE v_spouseMiddleName VARCHAR(50);
DECLARE v_spouseEmployerName VARCHAR(50);
DECLARE v_spouseEmployerTIN VARCHAR(50);
DECLARE v_foreignName VARCHAR(50);
DECLARE v_signatureFile VARCHAR(255);
DECLARE v_pictureFile VARCHAR(255);
DECLARE v_street2 VARCHAR(50);
DECLARE v_barangay2 VARCHAR(50);
DECLARE v_city2 VARCHAR(50);
DECLARE v_province2 VARCHAR(50);
DECLARE v_zipCode2 VARCHAR(50);
DECLARE v_country2 VARCHAR(50);
DECLARE v_street3 VARCHAR(50);
DECLARE v_barangay3 VARCHAR(50);
DECLARE v_city3 VARCHAR(50);
DECLARE v_province3 VARCHAR(50);
DECLARE v_zipCode3 VARCHAR(50);
DECLARE v_country3 VARCHAR(50);
DECLARE v_oldEmpId VARCHAR(50);
DECLARE v_linkIdentityId VARCHAR(50);
DECLARE v_payrollPeriodID VARCHAR(50);
DECLARE v_payrollConfigurationCode VARCHAR(50);
DECLARE v_workingDaysInaYear VARCHAR(50);
DECLARE v_workingHoursInaDay VARCHAR(50);
DECLARE v_workOnHoliday VARCHAR(50);
DECLARE v_requiredFiledOT VARCHAR(50);

SET num = 0;
SET msg = 'Success';

-- Get the complete current record from identity table
SELECT 
CODE,
dateHired,
firstName,
middleName,
lastName,
suffix,
birthdate,
age,
gender,
civilStatus,
contactNo,
emailAddress,
address,
street,
barangay,
city,
province,
zipCode,
country,
tinNo,
taxCode,
taxExemptionCode,
philhealthNo,
sssNo,
pagibigNo,
hmoNo,
prcNo,
dateIssued,
dateExpired,
paymentType,
bankAccountCode,
BankAccountNo,
approver,
batchId,
minimumWage,
dateCreated,
createdBy,
dateUpdated,
updatedBy,
seriesType,
paymentFrequency,
paymentComputation,
doleSetup,
basisOfAbsent,
workSchedule,
scheduleCode,
windowHours,
FotStart,
tempScheduleCode,
lateConversionCode,
undertimeConversionCode,
location,
taxShieldRate,
globalTaxShield,
birthPlace,
citizenship,
religion,
finalPay,
streetNo,
bldg,
subdivision,
district,
municipality,
municipalCode,
foreignAdd,
taxpayerType,
claims,
spouseEmpStatus,
spouseTIN,
spouseLastName,
spouseFirstName,
spouseMiddleName,
spouseEmployerName,
spouseEmployerTIN,
foreignName,
signatureFile,
pictureFile,
address2,
street2,
barangay2,
city2,
province2,
zipCode2,
country2,
address3,
street3,
barangay3,
city3,
province3,
zipCode3,
country3,
oldEmpId,
linkIdentityId,
payrollPeriodID,
payrollConfigurationCode,
workingDaysInaYear,
workingHoursInaDay,
workOnHoliday,
requiredFiledOT
INTO 
v_code,
v_dateHired,
v_firstName,
v_middleName,
v_lastName,
v_suffix,
v_birthdate,
v_age,
v_gender,
v_civilStatus,
v_contactNo,
v_emailAddress,
v_address,
v_street,
v_barangay,
v_city,
v_province,
v_zipCode,
v_country,
v_tinNo,
v_taxCode,
v_taxExemptionCode,
v_philhealthNo,
v_sssNo,
v_pagibigNo,
v_hmoNo,
v_prcNo,
v_dateIssued,
v_dateExpired,
v_paymentType,
v_bankAccountCode,
v_BankAccountNo,
v_approver,
v_batchId,
v_minimumWage,
v_dateCreated,
v_createdBy,
v_dateUpdated,
v_updatedBy,
v_seriesType,
v_paymentFrequency,
v_paymentComputation,
v_doleSetup,
v_basisOfAbsent,
v_workSchedule,
v_scheduleCode,
v_windowHours,
v_FotStart,
v_tempScheduleCode,
v_lateConversionCode,
v_undertimeConversionCode,
v_location,
v_taxShieldRate,
v_globalTaxShield,
v_birthPlace,
v_citizenship,
v_religion,
v_finalPay,
v_streetNo,
v_bldg,
v_subdivision,
v_district,
v_municipality,
v_municipalCode,
v_foreignAdd,
v_taxpayerType,
v_claims,
v_spouseEmpStatus,
v_spouseTIN,
v_spouseLastName,
v_spouseFirstName,
v_spouseMiddleName,
v_spouseEmployerName,
v_spouseEmployerTIN,
v_foreignName,
v_signatureFile,
v_pictureFile,
v_address2,
v_street2,
v_barangay2,
v_city2,
v_province2,
v_zipCode2,
v_country2,
v_address3,
v_street3,
v_barangay3,
v_city3,
v_province3,
v_zipCode3,
v_country3,
v_oldEmpId,
v_linkIdentityId,
v_payrollPeriodID,
v_payrollConfigurationCode,
v_workingDaysInaYear,
v_workingHoursInaDay,
v_workOnHoliday,
v_requiredFiledOT
FROM identity 
WHERE identityId = _identityId;

-- Get the next request number
SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM identity_changelogs 
WHERE updateRequestedBy COLLATE utf8mb4_unicode_ci = _identityId;

IF pint_mode = 1 THEN
-- Check if any field has changed by comparing new values with current identity data
SET v_hasChanged = (
COALESCE(_firstName, '') <> COALESCE(v_firstName, '')
OR COALESCE(_middleName, '') <> COALESCE(v_middleName, '')
OR COALESCE(_lastName, '') <> COALESCE(v_lastName, '')
OR COALESCE(_suffix, '') <> COALESCE(v_suffix, '')
OR COALESCE(_birthdate, '') <> COALESCE(v_birthdate, '')
OR COALESCE(_age, '') <> COALESCE(v_age, '')
OR COALESCE(_address, '') <> COALESCE(v_address, '')
OR COALESCE(_address2, '') <> COALESCE(v_address2, '')
OR COALESCE(_address3, '') <> COALESCE(v_address3, '')
OR COALESCE(_citizenship, '') <> COALESCE(v_citizenship, '')
OR COALESCE(_religion, '') <> COALESCE(v_religion, '')
OR COALESCE(_gender, '') <> COALESCE(v_gender, '')
OR COALESCE(_civilStatus, '') <> COALESCE(v_civilStatus, '')
OR COALESCE(_contactNo, '') <> COALESCE(v_contactNo, '')
OR COALESCE(_emailAddress, '') <> COALESCE(v_emailAddress, '')
OR COALESCE(_tinNo, '') <> COALESCE(v_tinNo, '')
OR COALESCE(_sssNo, '') <> COALESCE(v_sssNo, '')
OR COALESCE(_pagibigNo, '') <> COALESCE(v_pagibigNo, '')
OR COALESCE(_hmoNo, '') <> COALESCE(v_hmoNo, '')
OR COALESCE(_prcNo, '') <> COALESCE(v_prcNo, '')
OR COALESCE(_dateIssued, '') <> COALESCE(v_dateIssued, '')
OR COALESCE(_dateExpired, '') <> COALESCE(v_dateExpired, '')
OR COALESCE(_payrollGroup, '') <> COALESCE(v_batchId, '')
OR COALESCE(_birthPlace, '') <> COALESCE(v_birthPlace, '')
OR COALESCE(_paymentType, '') <> COALESCE(v_paymentType, '')
);

-- Only process if there are actual changes
IF v_hasChanged THEN
-- Insert into identity_changelogs with smart value selection
-- If IN parameter is NULL/empty, use identity value; otherwise use IN parameter
INSERT INTO identity_changelogs (
`code`,
`dateHired`,
`identityId`,
`firstName`,
`middleName`,
`lastName`,
`suffix`,
`birthdate`,
`age`,
`gender`,
`civilStatus`,
`contactNo`,
`emailAddress`,
`address`,
`street`,
`barangay`,
`city`,
`province`,
`zipCode`,
`country`,
`tinNo`,
`taxCode`,
`taxExemptionCode`,
`philhealthNo`,
`sssNo`,
`pagibigNo`,
`hmoNo`,
`prcNo`,
`dateIssued`,
`dateExpired`,
`paymentType`,
`bankAccountCode`,
`BankAccountNo`,
`approver`,
`batchId`,
`minimumWage`,
`dateCreated`,
`createdBy`,
`dateUpdated`,
`updatedBy`,
`seriesType`,
`paymentFrequency`,
`paymentComputation`,
`doleSetup`,
`basisOfAbsent`,
`workSchedule`,
`scheduleCode`,
`windowHours`,
`FotStart`,
`tempScheduleCode`,
`lateConversionCode`,
`undertimeConversionCode`,
`location`,
`taxShieldRate`,
`globalTaxShield`,
`birthPlace`,
`citizenship`,
`religion`,
`finalPay`,
`streetNo`,
`bldg`,
`subdivision`,
`district`,
`municipality`,
`municipalCode`,
`foreignAdd`,
`taxpayerType`,
`claims`,
`spouseEmpStatus`,
`spouseTIN`,
`spouseLastName`,
`spouseFirstName`,
`spouseMiddleName`,
`spouseEmployerName`,
`spouseEmployerTIN`,
`foreignName`,
`signatureFile`,
`pictureFile`,
`address2`,
`street2`,
`barangay2`,
`city2`,
`province2`,
`zipCode2`,
`country2`,
`address3`,
`street3`,
`barangay3`,
`city3`,
`province3`,
`zipCode3`,
`country3`,
`oldEmpId`,
`linkIdentityId`,
`payrollPeriodID`,
`payrollConfigurationCode`,
`workingDaysInaYear`,
`workingHoursInaDay`,
`workOnHoliday`,
`requiredFiledOT`,
`updateRequestedBy`,
`updateRequestDate`,
`updateApprovedBy`,
`updateApprovedDate`,
`updateStatus`,
`requestNo`,
`isChanged`,
`source`,
`crud`
)
VALUES (
v_code,
v_dateHired,
_identityId,
COALESCE(NULLIF(_firstName, ''), v_firstName),
COALESCE(NULLIF(_middleName, ''), v_middleName),
COALESCE(NULLIF(_lastName, ''), v_lastName),
COALESCE(NULLIF(_suffix, ''), v_suffix),
COALESCE(NULLIF(_birthdate, ''), v_birthdate),
COALESCE(NULLIF(_age, ''), v_age),
COALESCE(NULLIF(_gender, ''), v_gender),
COALESCE(NULLIF(_civilStatus, ''), v_civilStatus),
COALESCE(NULLIF(_contactNo, ''), v_contactNo),
COALESCE(NULLIF(_emailAddress, ''), v_emailAddress),
COALESCE(NULLIF(_address, ''), v_address),
v_street,
v_barangay,
v_city,
v_province,
v_zipCode,
v_country,
COALESCE(NULLIF(_tinNo, ''), v_tinNo),
v_taxCode,
v_taxExemptionCode,
v_philhealthNo,
COALESCE(NULLIF(_sssNo, ''), v_sssNo),
COALESCE(NULLIF(_pagibigNo, ''), v_pagibigNo),
COALESCE(NULLIF(_hmoNo, ''), v_hmoNo),
COALESCE(NULLIF(_prcNo, ''), v_prcNo),
COALESCE(NULLIF(_dateIssued, ''), v_dateIssued),
COALESCE(NULLIF(_dateExpired, ''), v_dateExpired),
COALESCE(NULLIF(_paymentType, ''), v_paymentType),
v_bankAccountCode,
v_BankAccountNo,
v_approver,
COALESCE(NULLIF(_payrollGroup, ''), v_batchId),
v_minimumWage,
v_dateCreated,
v_createdBy,
v_dateUpdated,
v_updatedBy,
v_seriesType,
v_paymentFrequency,
v_paymentComputation,
v_doleSetup,
v_basisOfAbsent,
v_workSchedule,
v_scheduleCode,
v_windowHours,
v_FotStart,
v_tempScheduleCode,
v_lateConversionCode,
v_undertimeConversionCode,
v_location,
v_taxShieldRate,
v_globalTaxShield,
 COALESCE(NULLIF(_birthPlace, ''), v_birthPlace),
COALESCE(NULLIF(_citizenship, ''), v_citizenship),
COALESCE(NULLIF(_religion, ''), v_religion),
v_finalPay,
v_streetNo,
v_bldg,
v_subdivision,
v_district,
v_municipality,
v_municipalCode,
v_foreignAdd,
v_taxpayerType,
v_claims,
v_spouseEmpStatus,
v_spouseTIN,
v_spouseLastName,
v_spouseFirstName,
v_spouseMiddleName,
v_spouseEmployerName,
v_spouseEmployerTIN,
v_foreignName,
v_signatureFile,
v_pictureFile,
COALESCE(NULLIF(_address2, ''), v_address2),
v_street2,
v_barangay2,
v_city2,
v_province2,
v_zipCode2,
v_country2,
COALESCE(NULLIF(_address3, ''), v_address3),
v_street3,
v_barangay3,
v_city3,
v_province3,
v_zipCode3,
v_country3,
v_oldEmpId,
v_linkIdentityId,
v_payrollPeriodID,
v_payrollConfigurationCode,
v_workingDaysInaYear,
v_workingHoursInaDay,
v_workOnHoliday,
v_requiredFiledOT,
_updateRequestedBy,
_updateRequestDate,
NULL,
NULL,
'P',
v_requestNo,
'Y',
'Manual',
'C'
);

-- Insert complete identity record into identity_history
INSERT INTO identity_history (
`code`,
`dateHired`,
`identityId`,
`firstName`,
`middleName`,
`lastName`,
`suffix`,
`birthdate`,
`age`,
`gender`,
`civilStatus`,
`contactNo`,
`emailAddress`,
`address`,
`street`,
`barangay`,
`city`,
`province`,
`zipCode`,
`country`,
`tinNo`,
`taxCode`,
`taxExemptionCode`,
`philhealthNo`,
`sssNo`,
`pagibigNo`,
`hmoNo`,
`prcNo`,
`dateIssued`,
`dateExpired`,
`paymentType`,
`bankAccountCode`,
`BankAccountNo`,
`approver`,
`batchId`,
`minimumWage`,
`dateCreated`,
`createdBy`,
`dateUpdated`,
`updatedBy`,
`seriesType`,
`paymentFrequency`,
`paymentComputation`,
`doleSetup`,
`basisOfAbsent`,
`workSchedule`,
`scheduleCode`,
`windowHours`,
`FotStart`,
`tempScheduleCode`,
`lateConversionCode`,
`undertimeConversionCode`,
`location`,
`taxShieldRate`,
`globalTaxShield`,
`birthPlace`,
`citizenship`,
`religion`,
`finalPay`,
`streetNo`,
`bldg`,
`subdivision`,
`district`,
`municipality`,
`municipalCode`,
`foreignAdd`,
`taxpayerType`,
`claims`,
`spouseEmpStatus`,
`spouseTIN`,
`spouseLastName`,
`spouseFirstName`,
`spouseMiddleName`,
`spouseEmployerName`,
`spouseEmployerTIN`,
`foreignName`,
`signatureFile`,
`pictureFile`,
`address2`,
`street2`,
`barangay2`,
`city2`,
`province2`,
`zipCode2`,
`country2`,
`address3`,
`street3`,
`barangay3`,
`city3`,
`province3`,
`zipCode3`,
`country3`,
`oldEmpId`,
`linkIdentityId`,
`payrollPeriodID`,
`payrollConfigurationCode`,
`workingDaysInaYear`,
`workingHoursInaDay`,
`workOnHoliday`,
`requiredFiledOT`,
`updateRequestedBy`,
`updateRequestDate`,
`updateApprovedBy`,
`updateApprovedDate`,
`updateStatus`,
`requestNo`,
`isChanged`,
`source`
)
VALUES (
v_code,
v_dateHired,
_identityId,
v_firstName,
v_middleName,
v_lastName,
v_suffix,
v_birthdate,
v_age,
v_gender,
v_civilStatus,
v_contactNo,
v_emailAddress,
v_address,
v_street,
v_barangay,
v_city,
v_province,
v_zipCode,
v_country,
v_tinNo,
v_taxCode,
v_taxExemptionCode,
v_philhealthNo,
v_sssNo,
v_pagibigNo,
v_hmoNo,
v_prcNo,
v_dateIssued,
v_dateExpired,
v_paymentType,
v_bankAccountCode,
v_BankAccountNo,
v_approver,
v_batchId,
v_minimumWage,
v_dateCreated,
v_createdBy,
v_dateUpdated,
v_updatedBy,
v_seriesType,
v_paymentFrequency,
v_paymentComputation,
v_doleSetup,
v_basisOfAbsent,
v_workSchedule,
v_scheduleCode,
v_windowHours,
v_FotStart,
v_tempScheduleCode,
v_lateConversionCode,
v_undertimeConversionCode,
v_location,
v_taxShieldRate,
v_globalTaxShield,
v_birthPlace,
v_citizenship,
v_religion,
v_finalPay,
v_streetNo,
v_bldg,
v_subdivision,
v_district,
v_municipality,
v_municipalCode,
v_foreignAdd,
v_taxpayerType,
v_claims,
v_spouseEmpStatus,
v_spouseTIN,
v_spouseLastName,
v_spouseFirstName,
v_spouseMiddleName,
v_spouseEmployerName,
v_spouseEmployerTIN,
v_foreignName,
v_signatureFile,
v_pictureFile,
v_address2,
v_street2,
v_barangay2,
v_city2,
v_province2,
v_zipCode2,
v_country2,
v_address3,
v_street3,
v_barangay3,
v_city3,
v_province3,
v_zipCode3,
v_country3,
v_oldEmpId,
v_linkIdentityId,
v_payrollPeriodID,
v_payrollConfigurationCode,
v_workingDaysInaYear,
v_workingHoursInaDay,
v_workOnHoliday,
v_requiredFiledOT,
_updateRequestedBy,
_updateRequestDate,
NULL,
NULL,
'P',
v_requestNo,
'Y',
'Manual'

);

SET num = 0;
SET msg = 'Changes recorded successfully';
ELSE
SET num = 0;
SET msg = 'No changes detected';
END IF;
END IF;
END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_check_pending`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_check_pending`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
DECLARE v_count INT DEFAULT 0;
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN

SELECT COUNT(*) 
INTO v_count
FROM identity_changelogs 
WHERE updateRequestedBy = identity_id 
AND updateStatus = 'P';
IF v_count > 0 THEN
SET num = 1;
SET msg = 'You have a pending change request';
END IF;
END IF;

END$$ 
DELIMITER ;

DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_get_emergencycontact`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_emergencycontact`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN

SELECT c.* FROM employeecontacts c
INNER JOIN identity i ON i.identityId = identity_id
WHERE c.code = i.`code`;
END IF;

END$$ 
DELIMITER ;




DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_save_education`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_education`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _school VARCHAR(50),
IN _degree VARCHAR(50),
IN _major VARCHAR(50),
IN _yearFrom VARCHAR(30),
IN _yearTo VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN  
DECLARE v_requestNo INT DEFAULT 0;
-- existing values
DECLARE v_school VARCHAR(30);
DECLARE v_degree VARCHAR(30);
DECLARE v_major VARCHAR(30);
DECLARE v_yearFrom VARCHAR(30);
DECLARE v_yearTo VARCHAR(30);
SET num = 0;
SET msg = 'Success';

IF _code IS NULL OR _code = '' THEN
SELECT `code`
INTO _code
FROM identity
WHERE identityId = _identityId
LIMIT 1;
END IF;
-- AUTO GENERATE LINE ID
IF _lineId IS NULL OR _lineId = '' THEN
SELECT IFNULL(MAX(lineId), 0) + 1
INTO _lineId
FROM employeeeducation
WHERE `code` = _code;
END IF;

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM employeeeducation_changelogs 
WHERE `code` = _code ;
-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN

-- AUTO GENERATE CODE
-- =========================
-- GET EXISTING DATA
-- =========================
SELECT 
`school`,
degree,
major,
`from`,
`to`
INTO
v_school,
v_degree,
v_major,
v_yearFrom,
v_yearTo
FROM employeeeducation
WHERE CODE = _code
AND lineId = _lineId
LIMIT 1;
-- =========================
-- CHECK IF NO CHANGES
-- =========================
IF v_school IS NOT NULL THEN
IF 
IFNULL(v_school,'') = IFNULL(_school,'') AND
IFNULL(v_degree,'') = IFNULL(_degree,'') AND
IFNULL(v_major,'') = IFNULL(_major,'') AND
IFNULL(v_yearFrom,'') = IFNULL(_yearFrom,'') AND
IFNULL(v_yearTo,'') = IFNULL(_yearTo,'')
THEN
SET num = 0;
SET msg = 'No changes detected';
LEAVE proc_end;
END IF;
END IF;
-- =========================
-- INSERT CHANGELOG
-- =========================
INSERT INTO employeeeducation_changelogs (
`code`,
lineId,
`school`,
degree,
major,
`from`,
`to`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
_school,
_degree,
_major,
_yearFrom,
_yearTo,
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'U'
);
END IF;
-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN

INSERT INTO employeeeducation_changelogs (
`code`,
lineId,
`school`,
degree,
major,
`from`,
`to`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
'deleted',
'deleted',
'deleted',
'deleted',
'deleted',
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'D'
);
END IF;
END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_save_contact`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_contact`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _name VARCHAR(30),
IN _relationship VARCHAR(30),
IN _mobileNo VARCHAR(30),
IN _alt_mobileNo VARCHAR(30),
IN _email VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN  
DECLARE v_requestNo INT DEFAULT 0;
-- existing values
DECLARE v_name VARCHAR(30);
DECLARE v_relationship VARCHAR(30);
DECLARE v_mobileNo VARCHAR(30);
DECLARE v_alt_mobileNo VARCHAR(30);
DECLARE v_email VARCHAR(30);
SET num = 0;
SET msg = 'Success';

IF _code IS NULL OR _code = '' THEN
SELECT `code`
INTO _code
FROM identity
WHERE identityId = _identityId
LIMIT 1;
END IF;
-- AUTO GENERATE LINE ID
IF _lineId IS NULL OR _lineId = '' THEN
SELECT IFNULL(MAX(lineId), 0) + 1
INTO _lineId
FROM employeecontacts
WHERE `code` = _code;
END IF;

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM employeecontacts_changelogs 
WHERE `code` = _code ;
-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN

-- AUTO GENERATE CODE
-- =========================
-- GET EXISTING DATA
-- =========================
SELECT 
`name`,
relationship,
mobileNo,
alt_mobileNo,
email
INTO
v_name,
v_relationship,
v_mobileNo,
v_alt_mobileNo,
v_email
FROM employeecontacts
WHERE CODE = _code
AND lineId = _lineId
LIMIT 1;
-- =========================
-- CHECK IF NO CHANGES
-- =========================
IF v_name IS NOT NULL THEN
IF 
IFNULL(v_name,'') = IFNULL(_name,'') AND
IFNULL(v_relationship,'') = IFNULL(_relationship,'') AND
IFNULL(v_mobileNo,'') = IFNULL(_mobileNo,'') AND
IFNULL(v_alt_mobileNo,'') = IFNULL(_alt_mobileNo,'') AND
IFNULL(v_email,'') = IFNULL(_email,'')
THEN
SET num = 0;
SET msg = 'No changes detected';
LEAVE proc_end;
END IF;
END IF;
-- =========================
-- INSERT CHANGELOG
-- =========================
INSERT INTO employeecontacts_changelogs (
`code`,
lineId,
`name`,
relationship,
mobileNo,
alt_mobileNo,
email,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
_name,
_relationship,
_mobileNo,
_alt_mobileNo,
_email,
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'U'
);
END IF;
-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN

INSERT INTO employeecontacts_changelogs (
`code`,
lineId,
`name`,
relationship,
mobileNo,
alt_mobileNo,
email,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
'deleted',
'deleted',
'deleted',
'deleted',
'deleted',
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'D'
);
END IF;
END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_save_employment`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_employment`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _tin VARCHAR(50),
IN _employerName VARCHAR(50),
IN _dateFrom VARCHAR(50),
IN _dateTo VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN  
DECLARE v_requestNo INT DEFAULT 0;
-- existing values
DECLARE v_tin VARCHAR(30);
DECLARE v_employerName VARCHAR(30);
DECLARE v_dateFrom VARCHAR(30);
DECLARE v_dateTo VARCHAR(30);
SET num = 0;
SET msg = 'Success';

IF _code IS NULL OR _code = '' THEN
SELECT `code`
INTO _code
FROM identity
WHERE identityId = _identityId
LIMIT 1;
END IF;
-- AUTO GENERATE LINE ID
IF _lineId IS NULL OR _lineId = '' THEN
SELECT IFNULL(MAX(lineId), 0) + 1
INTO _lineId
FROM `employeeemployementhistory`
WHERE `code` = _code;
END IF;

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM `employeeemployementhistory_changelogs` 
WHERE `code` = _code ;
-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN

-- AUTO GENERATE CODE
-- =========================
-- GET EXISTING DATA
-- =========================
SELECT 
`tinNo`,
company,
`from`,
`to`
INTO
v_tin,
v_employerName,
v_dateFrom,
v_dateTo
FROM employeeemployementhistory
WHERE CODE = _code
AND lineId = _lineId
LIMIT 1;
-- =========================
-- CHECK IF NO CHANGES
-- =========================
IF v_employerName IS NOT NULL THEN
IF 
IFNULL(v_tin,'') = IFNULL(_tin,'') AND
IFNULL(v_employerName,'') = IFNULL(_employerName,'') AND
IFNULL(v_dateFrom,'') = IFNULL(_dateFrom,'') AND
IFNULL(v_dateTo,'') = IFNULL(_dateTo,'')
THEN
SET num = 0;
SET msg = 'No changes detected';
LEAVE proc_end;
END IF;
END IF;
-- =========================
-- INSERT CHANGELOG
-- =========================
INSERT INTO employeeemployementhistory_changelogs (
`code`,
lineId,
`tinNo`,
company,
`from`,
`to`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
_tin,
_employerName,
_dateFrom,
_dateTo,
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'U'
);
END IF;
-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN

INSERT INTO employeeemployementhistory_changelogs (
`code`,
lineId,
`tinNo`,
company,
`from`,
`to`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
'deleted',
'deleted',
'deleted',
'deleted',
'deleted',
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'D'
);
END IF;
END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_save_training`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_training`(  
IN pint_mode INT,     
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _description VARCHAR(50),
IN _from VARCHAR(50) ,
IN _to VARCHAR(30),
IN _places VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN  
DECLARE v_requestNo INT DEFAULT 0;
-- existing values
DECLARE v_description VARCHAR(50);
DECLARE v_from VARCHAR(50);
DECLARE v_to VARCHAR(30);
DECLARE v_places VARCHAR(50);
SET num = 0;
SET msg = 'Success';
IF _code IS NULL OR _code = '' THEN
SELECT `code`
INTO _code
FROM identity
WHERE identityId = _identityId
LIMIT 1;
END IF;
-- AUTO GENERATE LINE ID
IF _lineId IS NULL OR _lineId = '' THEN
SELECT IFNULL(MAX(lineId), 0) + 1
INTO _lineId
FROM `employeeseminarattended`
WHERE `code` = _code;
END IF;

SELECT IFNULL(MAX(requestNo),0) + 1 
INTO v_requestNo
FROM `employeeseminarattended_changelogs` 
WHERE `code` = _code ;
-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN

-- AUTO GENERATE CODE
-- =========================
-- GET EXISTING DATA
-- =========================
SELECT 
`description`,
`from`,
`to`,
`places`
INTO
v_description,
v_from,
v_to,
v_places
FROM `employeeseminarattended`
WHERE `code` = _code
AND lineId = _lineId
LIMIT 1;
-- =========================
-- CHECK IF NO CHANGES
-- =========================
IF v_description IS NOT NULL THEN
IF 
    IFNULL(v_description,'') =
    IFNULL(_description,'') AND
    IFNULL(v_from,'') =
    IFNULL(_from,'') AND
    IFNULL(v_to,'') =
    IFNULL(_to,'') AND
    IFNULL(v_places,'') =
    IFNULL(_places,'')
THEN
SET num = 0;
SET msg = 'No changes detected';
LEAVE proc_end;
END IF;
END IF;
-- =========================
-- INSERT CHANGELOG
-- =========================
INSERT INTO `employeeseminarattended_changelogs` (
`code`,
lineId,
`description`,
`from`,
`to`,
`places`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
_description,
_from,
_to,
_places,
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'U'
);
END IF;
-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN

INSERT INTO employeeseminarattended_changelogs (
`code`,
lineId,
`description`,
`from`,
`to`,
`places`,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
source,
crud
) VALUES (
_code,
_lineId,
'deleted',
'deleted',
'deleted',
'deleted',
'deleted',
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'D'
);
END IF;
END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_get_payroll`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_get_payroll`(  
IN pint_mode INT,     
IN identity_id VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
IF pint_mode = 1 THEN

SELECT 
	t1.identityId,
	t0.code AS CODE,
	t0.lineId,
	t0.rate,
	t0.rateType,
	t0.allowance,
	t0.dateEffective,
	t0.dateEnd,
	-- Data from reference tables
   dept.departmentName AS DepartmentName,
	divi.divisionName AS DivisionName,
	pos.positionName AS PositionName,
	lab.laborName AS LaborName
FROM employeemovement t0
INNER JOIN identity t1 ON t0.code = t1.code
-- Joins to reference tables
LEFT JOIN department dept ON t0.departmentCode = dept.departmentCode
LEFT JOIN division divi     ON t0.divisionCode   = divi.divisionCode
LEFT JOIN POSITION pos     ON t0.positionCode   = pos.positionCode
LEFT JOIN labor lab        ON t0.laborCode      = lab.laborCode
-- Logic to grab ONLY the highest lineId for this specific code/user
WHERE t1.identityId = identity_id
  AND t0.lineId = (
	  SELECT MAX(sub.lineId)
	  FROM employeemovement sub 
	  WHERE sub.code = t0.code
  )
ORDER BY t0.code; 

END IF;

IF pint_mode = 2 THEN
SELECT 
	t1.identityId,
	t0.code AS CODE,
	t0.lineId,
	t0.rate,
	t0.rateType,
	t0.dateEffective,
	t0.dateEnd,
	-- Data from reference tables
   dept.departmentName AS DepartmentName,
	divi.divisionName AS DivisionName,
	pos.positionName AS PositionName,
	lab.laborName AS LaborName
FROM employeemovement t0
INNER JOIN identity t1 ON t0.code = t1.code
-- Joins to reference tables
LEFT JOIN department dept ON t0.departmentCode = dept.departmentCode
LEFT JOIN division divi     ON t0.divisionCode   = divi.divisionCode
LEFT JOIN POSITION pos     ON t0.positionCode   = pos.positionCode
LEFT JOIN labor lab        ON t0.laborCode      = lab.laborCode
-- Logic to grab ONLY the highest lineId for this specific code/user
WHERE t1.identityId = identity_id
  AND t0.lineId = (
	  SELECT MAX(sub.lineId) - 1
	  FROM employeemovement sub 
	  WHERE sub.code = t0.code
  )
ORDER BY t0.code;    
	
END IF;


/* ACCOUNTABILITY ITEMS  */


IF pint_mode = 3 THEN

SELECT 
	acc.*, 
	items.item_name
FROM `employeeaccountability` acc
INNER JOIN identity t1 ON acc.code = t1.code
LEFT JOIN `accountabilityitems` items ON acc.itemId = items.id
WHERE t1.identityId = identity_id;

END IF;

/* LOAN VIEW*/

IF pint_mode = 4 THEN

SELECT 
	ded.*, 
	items.deductionName
FROM `employeedeductions` ded
INNER JOIN identity t1 ON ded.code = t1.code
LEFT JOIN `recurringdeduction` items ON ded.deductionType = items.deductionCode
WHERE t1.identityId = identity_id
AND items.tagging = 'Loan';

END IF;

/* LEAVE BALANCES*/

IF pint_mode = 5 THEN

SELECT 
	emp.*, 
	items.leaveName
FROM `employeeleavebalances` emp
INNER JOIN identity t1 ON emp.code = t1.code
LEFT JOIN `leave` items ON emp.leaveCode = items.leaveCode
WHERE t1.identityId = identity_id;
END IF;

IF pint_mode = 5 THEN

SELECT 
	emp.*, 
	items.leaveName
FROM `employeeleavebalances` emp
INNER JOIN identity t1 ON emp.code = t1.code
LEFT JOIN `leave` items ON emp.leaveCode = items.leaveCode
WHERE t1.identityId = identity_id;
END IF;

END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_myprofile_save_hmo_dependent`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_myprofile_save_hmo_dependent`(
IN pint_mode INT,
IN _identityId VARCHAR(30),
IN _code VARCHAR(30),
IN _lineId VARCHAR(30),
IN _firstName VARCHAR(100),
IN _middleName VARCHAR(100),
IN _lastName VARCHAR(100),
IN _birthDate DATE,
IN _relationship VARCHAR(50),
IN _civilStatus VARCHAR(30),
IN _gender VARCHAR(20),
IN _hmoDependent VARCHAR(10),
IN _hmoId VARCHAR(30),
IN _startDate DATE,
IN _renewalDate DATE,
OUT num INT,
OUT msg VARCHAR(300)
)
proc_end: BEGIN
DECLARE v_requestNo INT DEFAULT 0;
DECLARE v_name VARCHAR(25);
DECLARE v_count INT DEFAULT 0;
DECLARE v_firstName VARCHAR(25);
DECLARE v_middleName VARCHAR(25);
DECLARE v_lastName VARCHAR(25);
DECLARE v_birthDate VARCHAR(25);
DECLARE v_relationship VARCHAR(25);
DECLARE v_civilStatus VARCHAR(25);
DECLARE v_gender VARCHAR(255);
DECLARE v_hmoDependent VARCHAR(5);
DECLARE v_hmoId VARCHAR(25);
DECLARE v_startDate VARCHAR(25);
DECLARE v_renewalDate VARCHAR(25);
SET num = 0;
SET msg = 'Success';
-- =========================
-- GET CODE
-- =========================
IF _code IS NULL OR _code = '' THEN
SELECT CODE
INTO _code
FROM identity
WHERE identityId = _identityId
LIMIT 1;
END IF;
-- =========================
-- AUTO GENERATE LINE ID
-- =========================
IF _lineId IS NULL OR _lineId = '' THEN
SELECT IFNULL(MAX(lineId), 0) + 1
INTO _lineId
FROM employeedependent
WHERE CODE = _code;
END IF;
-- =========================
-- REQUEST NUMBER
-- =========================
SELECT IFNULL(MAX(requestNo), 0) + 1
INTO v_requestNo
FROM employeedependent_changelogs
WHERE CODE = _code;
-- =========================
-- SAVE / UPDATE
-- =========================
IF pint_mode = 1 THEN
SET v_name = CONCAT(
IFNULL(_lastName,''), ', ',
IFNULL(_firstName,''), ' ',
IFNULL(_middleName,'')
);
-- =========================
-- CHECK EXISTING DEPENDENT
-- =========================
SELECT COUNT(*)
INTO v_count
FROM employeedependent
WHERE CODE = _code
AND lineId = _lineId;
-- =========================
-- INSERT
-- =========================
IF v_count = 0 THEN

SELECT 
    `firstName`,
    `middleName`,
    `lastName`,
    `birthDate`,
    `relationship`,
    `civilStatus`,
    `gender`,
    `hmoDependent`
    
INTO
    v_firstName,
    v_middleName,
    v_lastName,
    v_birthDate,
    v_relationship,
    v_civilStatus,
    v_gender,
    v_hmoDependent
FROM `employeedependent`
WHERE `code` = _code
  AND lineId = _lineId
LIMIT 1;
-- =========================
-- CHECK IF NO CHANGES
-- =========================
IF v_firstName IS NOT NULL THEN
    IF 
	IFNULL(v_firstName,'') = IFNULL(_firstName,'') AND
	IFNULL(v_middleName,'') = IFNULL(_middleName,'') AND
	IFNULL(v_lastName,'') = IFNULL(_lastName,'') AND
	IFNULL(v_birthDate,'') = IFNULL(_birthDate,'') AND
	IFNULL(v_relationship,'') = IFNULL(_relationship,'') AND
	IFNULL(v_civilStatus,'') = IFNULL(_civilStatus,'') AND
	IFNULL(v_gender,'') = IFNULL(_gender,'') AND
	IFNULL(v_hmoDependent,'') = IFNULL(_hmoDependent,'')
    THEN
	SET num = 0;
	SET msg = 'No changes detected';
	LEAVE proc_end;
    END IF;
END IF;
END IF;
-- =========================
-- CHANGELOG
-- =========================
INSERT INTO employeedependent_changelogs (
`code`,
lineId,
`name`,
birthdate,
relationship,
lastName,
firstName,
middleName,
hmoDependent,
civilStatus,
gender,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
crud,
source
)
VALUES (
_code,
_lineId,
v_name,
_birthDate,
_relationship,
_lastName,
_firstName,
_middleName,
_hmoDependent,
_civilStatus,
_gender,
_identityId,
NOW(),
'P',
v_requestNo,
IF(v_count = 0, 'C', 'U'),
'Manual'
);

/*

INSERT INTO employee_hmo_details (
CODE,
lineId,
hmoId,
hmoType,
startDate,
renewalDate,
dt_created
)
VALUES (
_code,
_lineId,
_hmoId,
'DEPENDENT',
_startDate,
_renewalDate,
NOW()
);

*/
END IF;
-- =========================
-- DELETE
-- =========================
IF pint_mode = 2 THEN
INSERT INTO employeedependent_changelogs (
`code`,
lineId,
`name`,
birthdate,
relationship,
lastName,
firstName,
middleName,
hmoDependent,
civilStatus,
gender,
updateRequestedBy,
updateRequestDate,
updateStatus,
requestNo,
crud,
source
)
VALUES (
_code,
_lineId,
_identityId,
'deleted',
'deleted',
'deleted',
'deleted',
'deleted',
_identityId,
CURRENT_TIMESTAMP,
'P',
v_requestNo,
'Manual',
'D'
);

END IF;
END$$ 
DELIMITER ;



-- CALL sp_portal_get_hris_approval_template(1,'M09103',@num,@msg); SELECT @msg
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_approval_template`$$ 
CREATE PROCEDURE `sp_portal_get_hris_approval_template`(  
IN pint_mode INT,	
IN _identityId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
-- select specific
IF pint_mode = 1 THEN



SELECT 	
    approvaltemplateoriginator.code,
    approvaltemplatestages.lineId,
    approvaltemplateoriginator.id, 
    approvaltemplates.HRISApprovalDetails, 
    approvaltemplates.HRISApproval,
    CASE 
	WHEN approvaltemplatestages.lineId > 1 THEN 'P' 
	ELSE 'F' 
    END AS lineId
FROM approvaltemplateoriginator 
LEFT JOIN approvaltemplatestages 
    ON approvaltemplateoriginator.code = approvaltemplatestages.code
JOIN approvaltemplates 
    ON approvaltemplates.code = approvaltemplatestages.code 
   AND approvaltemplates.HRISApproval = '1' 
WHERE approvaltemplateoriginator.id = _identityId
	AND approvaltemplateoriginator.code IN (SELECT `code` FROM approvalstagedetails WHERE id=_identityId)
	
;
	
END IF;

-- SELECT * FROM approvalstages WHERE `code` = 2
END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval`(  
IN pint_mode INT,	
IN _identityId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';
-- select specific
IF pint_mode = 1 THEN


/*
SELECT 	
    approvaltemplateoriginator.code,
    approvaltemplatestages.lineId,
    approvaltemplateoriginator.id, 
    approvaltemplates.HRISApprovalDetails, 
    approvaltemplates.HRISApproval,
    CASE 
	WHEN approvaltemplatestages.lineId > 1 THEN 'P' 
	ELSE 'F' 
    END AS lineId
FROM approvaltemplateoriginator 
LEFT JOIN approvaltemplatestages 
    ON approvaltemplateoriginator.code = approvaltemplatestages.code
JOIN approvaltemplates 
    ON approvaltemplates.code = approvaltemplatestages.code 
   AND approvaltemplates.HRISApproval = '1'
WHERE approvaltemplateoriginator.id = _identityId; */



SELECT 
    identity_changelogs.*,
    MAX(approvaltemplateoriginator.code) AS originatorCode,
    MAX(approvaltemplateoriginator.id) AS originatorId
FROM identity_changelogs
INNER JOIN approvaltemplateoriginator ON
    identity_changelogs.identityId = approvaltemplateoriginator.id
INNER JOIN approvalstagedetails ON
    approvalstagedetails.id = _identityId
WHERE 
    identity_changelogs.updateStatus = 'P'
GROUP BY identity_changelogs.requestNo
ORDER BY identity_changelogs.updateRequestDate DESC;
	
END IF;

-- select list





END$$ 
DELIMITER ;


DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval_approve`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval_approve`(  
IN pint_mode INT,
IN _requestNo VARCHAR(30),	
IN _identityId VARCHAR(30),
IN _employeeId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

-- Personal Information
IF pint_mode = 1 THEN

-- Update identity_changelogs table
UPDATE identity_changelogs 
SET `updateApprovedBy` = _identityId, 
`updateApprovedDate` = NOW(), 
`updateStatus` = 'A' 
WHERE CAST(`requestNo` AS CHAR CHARACTER SET latin1) = CAST(_requestNo AS CHAR CHARACTER SET latin1)
AND CAST(`identityId` AS CHAR CHARACTER SET latin1) = CAST(_employeeId AS CHAR CHARACTER SET latin1);

-- Update identity_history table
UPDATE identity_history 
SET `updateApprovedBy` = _identityId, 
`updateApprovedDate` = NOW(), 
`updateStatus` = 'A' 
WHERE CAST(`requestNo` AS CHAR CHARACTER SET latin1) = CAST(_requestNo AS CHAR CHARACTER SET latin1)
AND CAST(`identityId` AS CHAR CHARACTER SET latin1) = CAST(_employeeId AS CHAR CHARACTER SET latin1);

-- Main UPDATE with JOIN - Using CAST to handle collation
UPDATE `identity` idyo
INNER JOIN `identity_changelogs` idyc 
ON CAST(idyo.`code` AS CHAR CHARACTER SET utf8mb4) = CAST(idyc.`code` AS CHAR CHARACTER SET utf8mb4)
AND CAST(idyo.`identityId` AS CHAR CHARACTER SET latin1) = CAST(idyc.`identityId` AS CHAR CHARACTER SET latin1)
SET 
idyo.`firstName` = idyc.`firstName`,
idyo.`middleName` = idyc.`middleName`,
idyo.`lastName` = idyc.`lastName`,
idyo.`suffix` = idyc.`suffix`,
idyo.`birthdate` = idyc.`birthdate`,
idyo.`age` = idyc.`age`,
idyo.`gender` = idyc.`gender`,
idyo.`civilStatus` = idyc.`civilStatus`,
idyo.`contactNo` = idyc.`contactNo`,
idyo.`emailAddress` = idyc.`emailAddress`,
idyo.`address` = idyc.`address`,
idyo.`street` = idyc.`street`,
idyo.`barangay` = idyc.`barangay`,
idyo.`city` = idyc.`city`,
idyo.`province` = idyc.`province`,
idyo.`zipCode` = idyc.`zipCode`,
idyo.`country` = idyc.`country`,
idyo.`tinNo` = idyc.`tinNo`,
idyo.`taxCode` = idyc.`taxCode`,
idyo.`taxExemptionCode` = idyc.`taxExemptionCode`,
idyo.`philhealthNo` = idyc.`philhealthNo`,
idyo.`sssNo` = idyc.`sssNo`,
idyo.`pagibigNo` = idyc.`pagibigNo`,
idyo.`hmoNo` = idyc.`hmoNo`,
idyo.`prcNo` = idyc.`prcNo`,
idyo.`dateIssued` = idyc.`dateIssued`,
idyo.`dateExpired` = idyc.`dateExpired`,
idyo.`paymentType` = idyc.`paymentType`,
idyo.`bankAccountCode` = idyc.`bankAccountCode`,
idyo.`BankAccountNo` = idyc.`BankAccountNo`,
idyo.`minimumWage` = idyc.`minimumWage`,
idyo.`batchId` = idyc.`batchId`,
idyo.`approver` = idyc.`approver`,
idyo.`paymentFrequency` = idyc.`paymentFrequency`,
idyo.`taxShieldRate` = idyc.`taxShieldRate`,
idyo.`globalTaxShield` = idyc.`globalTaxShield`,
idyo.`dateHired` = idyc.`dateHired`,
idyo.`birthPlace` = idyc.`birthPlace`,
idyo.`citizenship` = idyc.`citizenship`,
idyo.`religion` = idyc.`religion`,
idyo.`finalPay` = idyc.`finalPay`,
idyo.`signatureFile` = idyc.`signatureFile`,
idyo.`pictureFile` = idyc.`pictureFile`,
idyo.`address2` = idyc.`address2`,
idyo.`street2` = idyc.`street2`,
idyo.`barangay2` = idyc.`barangay2`,
idyo.`city2` = idyc.`city2`,
idyo.`province2` = idyc.`province2`,
idyo.`zipCode2` = idyc.`zipCode2`,
idyo.`country2` = idyc.`country2`,
idyo.`address3` = idyc.`address3`,
idyo.`street3` = idyc.`street3`,
idyo.`barangay3` = idyc.`barangay3`,
idyo.`city3` = idyc.`city3`,
idyo.`province3` = idyc.`province3`,
idyo.`zipCode3` = idyc.`zipCode3`,
idyo.`country3` = idyc.`country3`,
idyo.`oldEmpId` = idyc.`oldEmpId`,
idyo.`linkIdentityId` = idyc.`linkIdentityId`,
idyo.`payrollPeriodID` = idyc.`payrollPeriodID`,
idyo.`payrollConfigurationCode` = idyc.`payrollConfigurationCode`,
idyo.`workingDaysInaYear` = idyc.`workingDaysInaYear`,
idyo.`workingHoursInaDay` = idyc.`workingHoursInaDay`,
idyo.`paymentComputation` = idyc.`paymentComputation`,
idyo.`doleSetup` = idyc.`doleSetup`,
idyo.`basisOfAbsent` = idyc.`basisOfAbsent`,
idyo.`workSchedule` = idyc.`workSchedule`,
idyo.`scheduleCode` = idyc.`scheduleCode`,
idyo.`windowHours` = idyc.`windowHours`,
idyo.`tempScheduleCode` = idyc.`tempScheduleCode`,
idyo.`lateConversionCode` = idyc.`lateConversionCode`,
idyo.`undertimeConversionCode` = idyc.`undertimeConversionCode`,
idyo.`location` = idyc.`location`,
idyo.`workOnHoliday` = idyc.`workOnHoliday`,
idyo.`requiredFiledOT` = idyc.`requiredFiledOT`
WHERE CAST(idyc.`updateStatus` AS CHAR CHARACTER SET latin1) = 'A'
AND CAST(idyc.`requestNo` AS CHAR CHARACTER SET latin1) = CAST(_requestNo AS CHAR CHARACTER SET latin1)
AND CAST(idyc.`identityId` AS CHAR CHARACTER SET latin1) = CAST(_employeeId AS CHAR CHARACTER SET latin1);

END IF;

-- DEPENDENT
IF pint_mode = 2 THEN


DELETE FROM employeedependent
	WHERE (`code`, lineId) IN (
	    SELECT c.`code`, c.lineId
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);
    -- Insert approved records back into main table
    INSERT INTO employeedependent (
	`code`,
	lineId,
	`name`,
	birthdate,
	relationship,
	lastName,
	firstName,
	middleName,
	hmoDependent,
	civilStatus,
	gender
    )
    SELECT
	`code`,
	lineId,
	`name`,
	birthdate,
	relationship,
	lastName,
	firstName,
	middleName,
	hmoDependent,
	civilStatus,
	gender
    FROM employeedependent_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);

    UPDATE employeedependent_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeedependent_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
END IF;

-- CONTACTS
IF pint_mode = 3 THEN


DELETE FROM employeecontacts
	WHERE (`code`, lineId) IN (
	    SELECT c.`code`, c.lineId
	    FROM employeecontacts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);
    -- Insert approved records back into main table
    INSERT INTO `employeecontacts` (`code`,`lineId`,`name`,`relationship`,`mobileNo`,`alt_mobileNo`,`email`)
    SELECT
	  `code`,
	  `lineId`,
	  `name`,
	  `relationship`,
	  `mobileNo`,
	  `alt_mobileNo`,
	  `email`
    FROM employeecontacts_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeecontacts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	       AND  c.updateStatus = 'P' AND c.crud != 'D'
	);

    UPDATE employeecontacts_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeecontacts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeecontacts_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeecontacts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);

END IF;

-- EDUCATION
IF pint_mode = 4 THEN

DELETE FROM employeeeducation
	WHERE (`code`, lineId) IN (
	    SELECT c.`code`, c.lineId
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);
	
INSERT INTO  `employeeeducation` (`code`,`lineId`,`from`,`to`,`school`,`degree`,`major`) 
    SELECT
	  `code`,
	  `lineId`,
	  CASE
		WHEN `from` REGEXP '^[0-9]{4}$' THEN `from`
		ELSE YEAR(`from`)
	    END AS `from`,
	    CASE
		WHEN `to` REGEXP '^[0-9]{4}$' THEN `to`
		ELSE YEAR(`to`)
	    END AS `to`,
	  `school`,
	  `degree`,
	  `major`
    FROM employeeeducation_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
		AND  c.updateStatus = 'P' AND c.crud != 'D'
	);

	
    UPDATE employeeeducation_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeeducation_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);

	
 

END IF;

-- EMPLOYMENT HISTORY
IF pint_mode = 5 THEN

	DELETE FROM employeeemployementhistory
	WHERE (`code`, lineId) IN (
	    SELECT c.`code`, c.lineId
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);

	    INSERT INTO  `employeeemployementhistory` (
	  `code`,
	  `lineId`,
	  `from`,
	  `to`,
	  `company`,
	  `position`,
	  `rate`,
	  `tinNo`,
	  `address`,
	  `zipCode`,
	  `taxableCompensation`,
	  `amountOfTaxes`,
	  `nonTaxableCompensation`,
	  `prevGrossCompIncome`,
	  `prevNonTax13thMonthOtherBenefits`,
	  `prevNonTaxDeminimis`,
	  `prevNonTaxGovtContUnionDues`,
	  `prevNonTaxSalaries`,
	  `prevNonTaxExemptIncome`,
	  `prevTaxBasicSalary`,
	  `prevTax13thMonthOtherBenefits`,
	  `prevTaxSalaries`,
	  `prevTaxDue`,
	  `prevNonTaxBasicSMW`,
	  `prevNonTaxHolidayPay`,
	  `prevNonTaxOvertimePay`,
	  `prevNonTaxNightDiff`,
	  `prevNonTaxHazardPay`,
	  `reasonOfSeparation`,
	  `empStatus`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `from`,
	  `to`,
	  `company`,
	  `position`,
	  `rate`,
	  `tinNo`,
	  `address`,
	  `zipCode`,
	  `taxableCompensation`,
	  `amountOfTaxes`,
	  `nonTaxableCompensation`,
	  `prevGrossCompIncome`,
	  `prevNonTax13thMonthOtherBenefits`,
	  `prevNonTaxDeminimis`,
	  `prevNonTaxGovtContUnionDues`,
	  `prevNonTaxSalaries`,
	  `prevNonTaxExemptIncome`,
	  `prevTaxBasicSalary`,
	  `prevTax13thMonthOtherBenefits`,
	  `prevTaxSalaries`,
	  `prevTaxDue`,
	  `prevNonTaxBasicSMW`,
	  `prevNonTaxHolidayPay`,
	  `prevNonTaxOvertimePay`,
	  `prevNonTaxNightDiff`,
	  `prevNonTaxHazardPay`,
	  `reasonOfSeparation`,
	  `empStatus`
    FROM employeeemployementhistory_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	       AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeeemployementhistory_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeemployementhistory_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
	
	

END IF;

-- LEAVE CREDIT
IF pint_mode = 6 THEN

DELETE FROM `employeeleavebalances`
	WHERE (`code`, lineId) IN (
	    SELECT c.`code`, c.lineId
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);


INSERT INTO  `employeeleavebalances` (`code`,`lineId`,`leaveCode`,`leaveBalance`,`currentBalance`,`leaveCredit`,`leavePrevious`,`leaveAdvance`,`leaveAlloted`,`validUntil`) 
    SELECT
	  `code`,
	  `lineId`,
	  `leaveCode`,
	  `leaveBalance`,
	  `currentBalance`,
	  `leaveCredit`,
	  `leavePrevious`,
	  `leaveAdvance`,
	  `leaveAlloted`,
	  `validUntil`
    FROM employeeleavebalances_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);

	
    UPDATE employeeleavebalances_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeleavebalances_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
 

END IF;

-- EARNINGS
IF pint_mode = 7 THEN


DELETE FROM `employeeallowances`
	WHERE `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	);

INSERT INTO `employeeallowances` 
	(
	  `code`,
	  `lineId`,
	  `allowanceType`,
	  `terms`,
	  `amount`,
	  `dateEffective`,
	  `dateEnd`,
	  `inputTax`,
	  `taxable`,
	  `treshold`,
	  `diminimiss`,
	  `sss`,
	  `hdmf`,
	  `month13`,
	  `taxShield`,
	  `hold`,
	  `vatable`,
	  `remarks`,
	  `payrollperiod`,
	  `phic`,
	  `bonus`,
	  `finalPay`,
	  `special_process`,
	  `nonmonetized`,
	  `ea_status`,
	  `fringe_benefit`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `allowanceType`,
	  `terms`,
	  `amount`,
	  `dateEffective`,
	  `dateEnd`,
	  `inputTax`,
	  `taxable`,
	  `treshold`,
	  `diminimiss`,
	  `sss`,
	  `hdmf`,
	  `month13`,
	  `taxShield`,
	  `hold`,
	  `vatable`,
	  `remarks`,
	  `payrollperiod`,
	  `phic`,
	  `bonus`,
	  `finalPay`,
	  `special_process`,
	  `nonmonetized`,
	  `ea_status`,
	  `fringe_benefit`
    FROM employeeallowances_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);

		
    UPDATE `employeeallowances_changelogs` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeeallowances_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);

END IF;

-- DEDUCTION
IF pint_mode = 8 THEN

DELETE FROM `employeedeductions`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM employeedeductions_changelogs c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);

 INSERT INTO  `employeedeductions`
	 (
	  `code`,
	  `lineId`,
	  `deductionType`,
	  `terms`,
	  `amount`,
	  `balance`,
	  `dateEffective`,
	  `dateEnd`,
	  `principalAmount`,
	  `interest`,
	  `advancePayment`,
	  `referenceNumber`,
	  `hold`,
	  `recurring`,
	  `loanDate`,
	  `loanAmount`,
	  `remarks`,
	  `finalPay`,
	  `hierarchy`,
	  `mp2AccountNo`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `deductionType`,
	  `terms`,
	  `amount`,
	  `balance`,
	  `dateEffective`,
	  `dateEnd`,
	  `principalAmount`,
	  `interest`,
	  `advancePayment`,
	  `referenceNumber`,
	  `hold`,
	  `recurring`,
	  `loanDate`,
	  `loanAmount`,
	  `remarks`,
	  `finalPay`,
	  `hierarchy`,
	  `mp2AccountNo`
    FROM employeedeductions_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedeductions_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeedeductions_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeedeductions_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeedeductions_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedeductions_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;

-- BANK ACCOUNTS
IF pint_mode = 9 THEN

DELETE FROM `employeebankaccounts`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM employeebankaccounts_changelogs c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  `employeebankaccounts`
	 (
	  `code`,
	  `lineId`,
	  `bankAccountCode`,
	  `accountNumber`,
	  `accountType`,
	  `percentage`,
	  `status`,
	  `fixedAmount`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `bankAccountCode`,
	  `accountNumber`,
	  `accountType`,
	  `percentage`,
	  `status`,
	  `fixedAmount`
    FROM employeebankaccounts_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebankaccounts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeebankaccounts_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeebankaccounts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeebankaccounts_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebankaccounts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;

-- ACCOUNTABILITY
IF pint_mode = 10 THEN

DELETE FROM `employeeaccountability`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM `employeeaccountability_changelogs` c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  `employeeaccountability`
	 (
	    `code`,
	  `lineId`,
	  `itemId`,
	  `itemDescription`,
	  `dateFrom`,
	  `dateTo`,
	  `status`,
	  `remarks`,
	  `penaltyAmount`,
	  `docFile`
	) 
    SELECT
	    `code`,
	  `lineId`,
	  `itemId`,
	  `itemDescription`,
	  `dateFrom`,
	  `dateTo`,
	  `status`,
	  `remarks`,
	  `penaltyAmount`,
	  `docFile`
    FROM employeeaccountability_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeaccountability_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeeaccountability_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeaccountability_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeeaccountability_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeaccountability_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;

-- MEDICAL RECORDS
IF pint_mode = 11 THEN

DELETE FROM `employeemedicalrecords`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM `employeemedicalrecords_changelogs` c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  `employeemedicalrecords`
	 (
	   `code`,
	  `lineId`,
	  `examDate`,
	  `examType`,
	  `hospitalLabName`,
	  `diagnosis`,
	  `medicines`,
	  `bloodType`,
	  `weight`,
	  `height`,
	  `results`,
	  `category`,
	  `remarks`,
	  `docFile`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `examDate`,
	  `examType`,
	  `hospitalLabName`,
	  `diagnosis`,
	  `medicines`,
	  `bloodType`,
	  `weight`,
	  `height`,
	  `results`,
	  `category`,
	  `remarks`,
	  `docFile`
    FROM employeemedicalrecords_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemedicalrecords_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeemedicalrecords_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeemedicalrecords_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeemedicalrecords_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemedicalrecords_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;



-- SEMINAR ATTENDED
IF pint_mode = 12 THEN

DELETE FROM `employeeseminarattended`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM `employeeseminarattended_changelogs` c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  employeeseminarattended
	 (
	`code`,
	`lineId`,
	`from`,
	`to`,
	`description`,
	`places`,
	`docFile`
	) 
    SELECT
	`code`,
	`lineId`,
	`from`,
	`to`,
	`description`,
	`places`,
	`docFile`
    FROM employeeseminarattended_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeseminarattended_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeeseminarattended_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeseminarattended_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeeseminarattended_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeseminarattended_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;

-- BIOMETRICS INFO
IF pint_mode = 13 THEN
DELETE FROM `employeebiometrics`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM `employeebiometrics_changelogs` c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  employeebiometrics
	 (
	  `code`,
	  `lineId`,
	  `machineId`,
	  `bioId`
	) 
    SELECT
	  `code`,
	  `lineId`,
	  `machineId`,
	  `bioId`
    FROM employeebiometrics_changelogs
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebiometrics_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeebiometrics_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeebiometrics_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeebiometrics_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebiometrics_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;


-- EMPLOYEE MOVEMENT
IF pint_mode = 14 THEN
DELETE FROM `employeemovement`
WHERE (`code`, lineId) IN (
    SELECT c.`code`, c.lineId
    FROM `employeemovement_changelogs` c
    INNER JOIN `identity` i
	ON i.`code` = c.`code`
    WHERE c.requestNo = _requestNo
      AND i.identityId = _employeeId
);
 INSERT INTO  `employeemovement`
	 (
	`code`,
	`lineId`,
	`status`,
	`costCode`,
	`positionCode`,
	`jobCategoryCode`,
	`laborCode`,
	`scheduleType`,
	`rate`,
	`allowance`,
	`cola`,
	`currency`,
	`dateEffective`,
	`dateEnd`,
	`departmentCode`,
	`divisionCode`,
	`rateType`,
	`salaryIncreasePercent`,
	`remarks`,
	`vatRegistered`,
	`regionCode`
	) 

    SELECT
	`code`,
	`lineId`,
	`status`,
	`costCode`,
	`positionCode`,
	`jobCategoryCode`,
	`laborCode`,
	`scheduleType`,
	`rate`,
	`allowance`,
	`cola`,
	`currency`,
	`dateEffective`,
	`dateEnd`,
	`departmentCode`,
	`divisionCode`,
	`rateType`,
	`salaryIncreasePercent`,
	`remarks`,
	`vatRegistered`,
	`regionCode`
    FROM `employeemovement_changelogs`
    WHERE requestNo = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemovement_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId
	      AND  c.updateStatus = 'P' AND c.crud != 'D'
	);
    UPDATE employeemovement_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeemovement_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeemovement_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'A' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemovement_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
	
   

END IF;

END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval_disapprove`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval_disapprove`(  
IN pint_mode INT,	
IN _requestNo VARCHAR(30),
IN _identityId VARCHAR(30),
IN _employeeId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

-- Personal Information
IF pint_mode = 1 THEN

/*UPDATE identity_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo  AND `identityId` = _employeeId;
UPDATE identity_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo  AND `identityId` = _employeeId; */
UPDATE identity_changelogs 
	SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' 
	WHERE CONVERT(`requestNo` USING utf8mb4) COLLATE utf8mb4_unicode_ci = CONVERT(_requestNo USING utf8mb4) COLLATE utf8mb4_unicode_ci
	  AND CONVERT(`identityId` USING utf8mb4) COLLATE utf8mb4_unicode_ci = CONVERT(_employeeId USING utf8mb4) COLLATE utf8mb4_unicode_ci;
	UPDATE identity_history 
	SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' 
	WHERE CONVERT(`requestNo` USING utf8mb4) COLLATE utf8mb4_unicode_ci = CONVERT(_requestNo USING utf8mb4) COLLATE utf8mb4_unicode_ci
	  AND CONVERT(`identityId` USING utf8mb4) COLLATE utf8mb4_unicode_ci = CONVERT(_employeeId USING utf8mb4) COLLATE utf8mb4_unicode_ci;
END IF;

-- DEPENDENT
IF pint_mode = 2 THEN

UPDATE employeedependent_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
UPDATE employeedependent_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	    AND i.identityId = _employeeId);
END IF;

-- CONTACTS
IF pint_mode = 3 THEN

UPDATE employeecontacts_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
UPDATE employeecontacts_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedependent_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	    AND i.identityId = _employeeId);
END IF;

-- EDUCATION
IF pint_mode = 4 THEN

 UPDATE employeeeducation_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeeducation_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeeducation_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	    AND i.identityId = _employeeId);

END IF;

-- EMPLOYMENT HISTORY
IF pint_mode = 5 THEN

 UPDATE employeeemployementhistory_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeemployementhistory_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeemployementhistory_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	    AND i.identityId = _employeeId);
END IF;

-- LEAVE CREDIT
IF pint_mode = 6 THEN

 UPDATE employeeleavebalances_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeleavebalances_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeleavebalances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- EARNINGS
IF pint_mode = 7 THEN

 UPDATE employeeallowances_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeallowances_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeallowances_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- DEDUCTIONS
IF pint_mode = 8 THEN

 UPDATE employeedeductions_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeedeductions_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeedeductions_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeedeductions_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- BANK ACCOUNTS
IF pint_mode = 9 THEN

 UPDATE employeebankaccounts_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeebankaccounts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeebankaccounts_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebankaccounts_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- ACCOUNTABILITY
IF pint_mode = 10 THEN

 UPDATE employeeaccountability_changelogs SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeaccountability_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE employeeaccountability_history SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeaccountability_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- MEDICAL RECORDS
IF pint_mode = 11 THEN

 UPDATE `employeemedicalrecords_changelogs` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeemedicalrecords_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeemedicalrecords_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemedicalrecords_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- SEMINAR ATTENDED
IF pint_mode = 12 THEN

 UPDATE `employeeseminarattended_changelogs` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeeseminarattended_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeeseminarattended_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeeseminarattended_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- BIOMETRICS INFO
IF pint_mode = 13 THEN

 UPDATE `employeebiometrics_changelogs` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeebiometrics_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeebiometrics_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeebiometrics_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;

-- EMPLOYEEMOVEMENT
IF pint_mode = 14 THEN

 UPDATE `employeemovement_changelogs` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND  `code` IN (
	    SELECT c.`code`
	    FROM employeemovement_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
    UPDATE `employeemovement_history` SET `updateApprovedBy` = _identityId, `updateApprovedDate` = NOW(), `updateStatus` = 'D' WHERE `requestNo` = _requestNo AND `code` IN (
	    SELECT c.`code`
	    FROM employeemovement_changelogs c
	    INNER JOIN `identity` i
		ON i.`code` = c.`code`
	    WHERE c.requestNo = _requestNo
	      AND i.identityId = _employeeId);
END IF;
END$$ 
DELIMITER ;




DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval_history`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval_history`(  
IN pint_mode INT,	
IN _identityId VARCHAR(30),
IN _requestNo VARCHAR(30),
IN _employeeId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';


-- Personal Information
IF pint_mode = 1 THEN

SELECT idyh.`code` AS 'Employee Code'
,idyh.`identityId` AS 'Employee Id'
,IF(IFNULL(idyh.`dateHired`,'no data') <> IFNULL(idyc.`dateHired`,'no data'), IFNULL(idyh.`dateHired`,'no data'), 'match') AS 'Date Hired'
,IF(IFNULL(idyh.`firstName`,'no data') <> IFNULL(idyc.`firstName`,'no data'), IFNULL(idyh.`firstName`,'no data'), 'match') AS 'First Name'
,IF(IFNULL(idyh.`middleName`,'no data') <> IFNULL(idyc.`middleName`,'no data'), IFNULL(idyh.`middleName`,'no data'), 'match') AS 'Middle Name'
,IF(IFNULL(idyh.`lastName`,'no data') <> IFNULL(idyc.`lastName`,'no data'), IFNULL(idyh.`lastName`,'no data'), 'match') AS 'Last Name'
,IF(IFNULL(idyh.`suffix`,'no data') <> IFNULL(idyc.`suffix`,'no data'), IFNULL(idyh.`suffix`,'no data'), 'match') AS 'Suffix'
,IF(IFNULL(idyh.`birthdate`,'no data') <> IFNULL(idyc.`birthdate`,'no data'), IFNULL(idyh.`birthdate`,'no data'), 'match') AS 'Birthdate'
,IF(IFNULL(idyh.`age`,'no data') <> IFNULL(idyc.`age`,'no data'), IFNULL(idyh.`age`,'no data'), 'match') AS 'Age'
,IF(IFNULL(idyh.`gender`,'no data') <> IFNULL(idyc.`gender`,'no data'), IFNULL(idyh.`gender`,'no data'), 'match') AS 'Gender'
,IF(IFNULL(idyh.`civilStatus`,'no data') <> IFNULL(idyc.`civilStatus`,'no data'), IFNULL(idyh.`civilStatus`,'no data'), 'match') AS 'Civil Status'
,IF(IFNULL(idyh.`contactNo`,'no data') <> IFNULL(idyc.`contactNo`,'no data'), IFNULL(idyh.`contactNo`,'no data'), 'match') AS 'contactNo'
,IF(IFNULL(idyh.`emailAddress`,'no data') <> IFNULL(idyc.`emailAddress`,'no data'), IFNULL(idyh.`emailAddress`,'no data'), 'match') AS 'Email Address'
,IF(IFNULL(idyh.`address`,'no data') <> IFNULL(idyc.`address`,'no data'), IFNULL(idyh.`address`,'no data'), 'match') AS 'Address'
,IF(IFNULL(idyh.`street`,'no data') <> IFNULL(idyc.`street`,'no data'), IFNULL(idyh.`street`,'no data'), 'match') AS 'Street'
,IF(IFNULL(idyh.`barangay`,'no data') <> IFNULL(idyc.`barangay`,'no data'), IFNULL(idyh.`barangay`,'no data'), 'match') AS 'Barangay'
,IF(IFNULL(idyh.`city`,'no data') <> IFNULL(idyc.`city`,'no data'), IFNULL(idyh.`city`,'no data'), 'match') AS 'City'
,IF(IFNULL(idyh.`province`,'no data') <> IFNULL(idyc.`province`,'no data'), IFNULL(idyh.`province`,'no data'), 'match') AS 'Province'
,IF(IFNULL(idyh.`zipCode`,'no data') <> IFNULL(idyc.`zipCode`,'no data'), IFNULL(idyh.`zipCode`,'no data'), 'match') AS 'Zip Code'
,IF(IFNULL(idyh.`country`,'no data') <> IFNULL(idyc.`country`,'no data'), IFNULL(idyh.`country`,'no data'), 'match') AS 'Country'
,IF(IFNULL(idyh.`tinNo`,'no data') <> IFNULL(idyc.`tinNo`,'no data'), IFNULL(idyh.`tinNo`,'no data'), 'match') AS 'TinNo'
,IF(IFNULL(idyh.`taxCode`,'no data') <> IFNULL(idyc.`taxCode`,'no data'), IFNULL(idyh.`taxCode`,'no data'), 'match') AS 'Tax Code'
,IF(IFNULL(idyh.`taxExemptionCode`,'no data') <> IFNULL(idyc.`taxExemptionCode`,'no data'), IFNULL(idyh.`taxExemptionCode`,'no data'), 'match') AS 'Tax Exemption Code'
,IF(IFNULL(idyh.`philhealthNo`,'no data') <> IFNULL(idyc.`philhealthNo`,'no data'), IFNULL(idyh.`philhealthNo`,'no data'), 'match') AS 'Philhealth No'
,IF(IFNULL(idyh.`sssNo`,'no data') <> IFNULL(idyc.`sssNo`,'no data'), IFNULL(idyh.`sssNo`,'no data'), 'match') AS 'SSS No'
,IF(IFNULL(idyh.`pagibigNo`,'no data') <> IFNULL(idyc.`pagibigNo`,'no data'), IFNULL(idyh.`pagibigNo`,'no data'), 'match') AS 'Pagibig No'
,IF(IFNULL(idyh.`hmoNo`,'no data') <> IFNULL(idyc.`hmoNo`,'no data'), IFNULL(idyh.`hmoNo`,'no data'), 'match') AS 'HMO No'
,IF(IFNULL(idyh.`prcNo`,'no data') <> IFNULL(idyc.`prcNo`,'no data'), IFNULL(idyh.`prcNo`,'no data'), 'match') AS 'PRC No'
,IF(IFNULL(idyh.`dateIssued`,'no data') <> IFNULL(idyc.`dateIssued`,'no data'), IFNULL(idyh.`dateIssued`,'no data'), 'match') AS 'Date Issued'
,IF(IFNULL(idyh.`dateExpired`,'no data') <> IFNULL(idyc.`dateExpired`,'no data'), IFNULL(idyh.`dateExpired`,'no data'), 'match') AS 'Date Expired'
,IF(IFNULL(idyh.`paymentType`,'no data') <> IFNULL(idyc.`paymentType`,'no data'), IFNULL(idyh.`paymentType`,'no data'), 'match') AS 'Payment Type'
,IF(IFNULL(idyh.`bankAccountCode`,'no data') <> IFNULL(idyc.`bankAccountCode`,'no data'), IFNULL(idyh.`bankAccountCode`,'no data'), 'match') AS 'Bank Account Code'
,IF(IFNULL(idyh.`BankAccountNo`,'no data') <> IFNULL(idyc.`BankAccountNo`,'no data'), IFNULL(idyh.`BankAccountNo`,'no data'), 'match') AS 'Bank Account No'
,IF(IFNULL(idyh.`approver`,'no data') <> IFNULL(idyc.`approver`,'no data'), IFNULL(idyh.`approver`,'no data'), 'match') AS 'Approver'
,IF(IFNULL(idyh.`batchId`,'no data') <> IFNULL(idyc.`batchId`,'no data'), IFNULL(idyh.`batchId`,'no data'), 'match') AS 'BatchId'
,IF(IFNULL(idyh.`minimumWage`,'no data') <> IFNULL(idyc.`minimumWage`,'no data'), IFNULL(idyh.`minimumWage`,'no data'), 'match') AS 'Minimum Wage'
,IF(IFNULL(idyh.`dateCreated`,'no data') <> IFNULL(idyc.`dateCreated`,'no data'), IFNULL(idyh.`dateCreated`,'no data'), 'match') AS 'dateCreated'
,IF(IFNULL(idyh.`createdBy`,'no data') <> IFNULL(idyc.`createdBy`,'no data'), IFNULL(idyh.`createdBy`,'no data'), 'match') AS 'createdBy'
,IF(IFNULL(idyh.`dateUpdated`,'no data') <> IFNULL(idyc.`dateUpdated`,'no data'), IFNULL(idyh.`dateUpdated`,'no data'), 'match') AS 'dateUpdated'
,IF(IFNULL(idyh.`updatedBy`,'no data') <> IFNULL(idyc.`updatedBy`,'no data'), IFNULL(idyh.`updatedBy`,'no data'), 'match') AS 'updatedBy'						
,IF(IFNULL(idyh.`seriesType`,'no data') <> IFNULL(idyc.`seriesType`,'no data'), IFNULL(idyh.`seriesType`,'no data'), 'match') AS 'Series Type'
,IF(IFNULL(idyh.`paymentFrequency`,'no data') <> IFNULL(idyc.`paymentFrequency`,'no data'), IFNULL(idyh.`paymentFrequency`,'no data'), 'match') AS 'Payment Frequency'
,IF(IFNULL(idyh.`taxShieldRate`,'no data') <> IFNULL(idyc.`taxShieldRate`,'no data'), IFNULL(idyh.`taxShieldRate`,'no data'), 'match') AS 'Tax Shield Rate'
,IF(IFNULL(idyh.`globalTaxShield`,'no data') <> IFNULL(idyc.`globalTaxShield`,'no data'), IFNULL(idyh.`globalTaxShield`,'no data'), 'match') AS 'Global Tax Shield'
,IF(IFNULL(idyh.`birthPlace`,'no data') <> IFNULL(idyc.`birthPlace`,'no data'), IFNULL(idyh.`birthPlace`,'no data'), 'match') AS 'Birth Place'
,IF(IFNULL(idyh.`citizenship`,'no data') <> IFNULL(idyc.`citizenship`,'no data'), IFNULL(idyh.`citizenship`,'no data'), 'match') AS 'Citizenship'
,IF(IFNULL(idyh.`religion`,'no data') <> IFNULL(idyc.`religion`,'no data'), IFNULL(idyh.`religion`,'no data'), 'match') AS 'Religion'
,IF(IFNULL(idyh.`finalPay`,'no data') <> IFNULL(idyc.`finalPay`,'no data'), IFNULL(idyh.`finalPay`,'no data'), 'match') AS 'Final Pay'
,IF(IFNULL(idyh.`streetNo`,'no data') <> IFNULL(idyc.`streetNo`,'no data'), IFNULL(idyh.`streetNo`,'no data'), 'match') AS 'Street No'
,IF(IFNULL(idyh.`bldg`,'no data') <> IFNULL(idyc.`bldg`,'no data'), IFNULL(idyh.`bldg`,'no data'), 'match') AS 'Bldg'
,IF(IFNULL(idyh.`subdivision`,'no data') <> IFNULL(idyc.`subdivision`,'no data'), IFNULL(idyh.`subdivision`,'no data'), 'match') AS 'Subdivision'
,IF(IFNULL(idyh.`district`,'no data') <> IFNULL(idyc.`district`,'no data'), IFNULL(idyh.`district`,'no data'), 'match') AS 'District'
,IF(IFNULL(idyh.`municipality`,'no data') <> IFNULL(idyc.`municipality`,'no data'), IFNULL(idyh.`municipality`,'no data'), 'match') AS 'Municipality'
,IF(IFNULL(idyh.`municipalCode`,'no data') <> IFNULL(idyc.`municipalCode`,'no data'), IFNULL(idyh.`municipalCode`,'no data'), 'match') AS 'Municipal Code'
,IF(IFNULL(idyh.`foreignAdd`,'no data') <> IFNULL(idyc.`foreignAdd`,'no data'), IFNULL(idyh.`foreignAdd`,'no data'), 'match') AS 'Foreign Add'
,IF(IFNULL(idyh.`taxpayerType`,'no data') <> IFNULL(idyc.`taxpayerType`,'no data'), IFNULL(idyh.`taxpayerType`,'no data'), 'match') AS 'Taxpayer Type'
,IF(IFNULL(idyh.`claims`,'no data') <> IFNULL(idyc.`claims`,'no data'), IFNULL(idyh.`claims`,'no data'), 'match') AS 'Claims'
,IF(IFNULL(idyh.`spouseEmpStatus`,'no data') <> IFNULL(idyc.`spouseEmpStatus`,'no data'), IFNULL(idyh.`spouseEmpStatus`,'no data'), 'match') AS 'Spouse Emp. Status'
,IF(IFNULL(idyh.`spouseTIN`,'no data') <> IFNULL(idyc.`spouseTIN`,'no data'), IFNULL(idyh.`spouseTIN`,'no data'), 'match') AS 'Spouse TIN'
,IF(IFNULL(idyh.`spouseLastName`,'no data') <> IFNULL(idyc.`spouseLastName`,'no data'), IFNULL(idyh.`spouseLastName`,'no data'), 'match') AS 'Spouse Last Name'
,IF(IFNULL(idyh.`spouseFirstName`,'no data') <> IFNULL(idyc.`spouseFirstName`,'no data'), IFNULL(idyh.`spouseFirstName`,'no data'), 'match') AS 'Spouse First Name'
,IF(IFNULL(idyh.`spouseMiddleName`,'no data') <> IFNULL(idyc.`spouseMiddleName`,'no data'), IFNULL(idyh.`spouseMiddleName`,'no data'), 'match') AS 'Spouse Middle Name'
,IF(IFNULL(idyh.`spouseEmployerName`,'no data') <> IFNULL(idyc.`spouseEmployerName`,'no data'), IFNULL(idyh.`spouseEmployerName`,'no data'), 'match') AS 'Spouse Employer Name'
,IF(IFNULL(idyh.`spouseEmployerTIN`,'no data') <> IFNULL(idyc.`spouseEmployerTIN`,'no data'), IFNULL(idyh.`spouseEmployerTIN`,'no data'), 'match') AS 'Spouse Employer TIN'
,IF(IFNULL(idyh.`foreignName`,'no data') <> IFNULL(idyc.`foreignName`,'no data'), IFNULL(idyh.`foreignName`,'no data'), 'match') AS 'Foreign Name'
,IF(IFNULL(idyh.`signatureFile`,'no data') <> IFNULL(idyc.`signatureFile`,'no data'), IFNULL(idyh.`signatureFile`,'no data'), 'match') AS 'E Signature'
,IF(IFNULL(idyh.`pictureFile`,'no data') <> IFNULL(idyc.`pictureFile`,'no data'), IFNULL(idyh.`pictureFile`,'no data'), 'match') AS 'E Picture'	
,IF(IFNULL(idyh.`street2`, 'no data') <> IFNULL(idyc.`street2`,'no data'), IFNULL(idyh.`street2`,'no data'), 'match') AS 'Street 2'
,IF(IFNULL(idyh.`barangay2`, 'no data') <> IFNULL(idyc.`barangay2`,'no data'), IFNULL(idyh.`barangay2`,'no data'), 'match') AS 'Barangay 2'
,IF(IFNULL(idyh.`city2`, 'no data') <> IFNULL(idyc.`city2`,'no data'), IFNULL(idyh.`city2`,'no data'), 'match') AS 'City 2'
,IF(IFNULL(idyh.`province2`, 'no data') <> IFNULL(idyc.`province2`,'no data'), IFNULL(idyh.`province2`,'no data'), 'match') AS 'Province 2'
,IF(IFNULL(idyh.`zipCode2`, 'no data') <> IFNULL(idyc.`zipCode2`,'no data'), IFNULL(idyh.`zipCode2`,'no data'), 'match') AS 'Zip_Code 2'
,IF(IFNULL(idyh.`country2`, 'no data') <> IFNULL(idyc.`country2`,'no data'), IFNULL(idyh.`country2`,'no data'), 'match') AS 'Country 2'				
,IF(IFNULL(idyh.`street3`, 'no data') <> IFNULL(idyc.`street3`,'no data'), IFNULL(idyh.`street3`,'no data'), 'match') AS 'Street 3'
,IF(IFNULL(idyh.`barangay3`, 'no data') <> IFNULL(idyc.`barangay3`,'no data'), IFNULL(idyh.`barangay3`,'no data'), 'match') AS 'Barangay 3'
,IF(IFNULL(idyh.`city3`, 'no data') <> IFNULL(idyc.`city3`,'no data'), IFNULL(idyh.`city3`,'no data'), 'match') AS 'City 3'
,IF(IFNULL(idyh.`province3`, 'no data') <> IFNULL(idyc.`province3`,'no data'), IFNULL(idyh.`province3`,'no data'), 'match') AS 'Province 3'
,IF(IFNULL(idyh.`zipCode3`, 'no data') <> IFNULL(idyc.`zipCode3`,'no data'), IFNULL(idyh.`zipCode3`,'no data'), 'match') AS 'Zip_Code 3'
,IF(IFNULL(idyh.`country3`, 'no data') <> IFNULL(idyc.`country3`,'no data'), IFNULL(idyh.`country3`,'no data'), 'match') AS 'Country 3'
,IF(IFNULL(idyh.`oldEmpId`, 'no data') <> IFNULL(idyc.`oldEmpId`,'no data'), IFNULL(idyh.`oldEmpId`,'no data'), 'match') AS 'Old EmployeeId'
,IF(IFNULL(idyh.`payrollPeriodID`,'no data') <> IFNULL(idyc.`payrollPeriodID`,'no data'), IFNULL(idyh.`payrollPeriodID`,'no data'), 'match') AS 'payrollPeriodID'
,IF(IFNULL(idyh.`payrollConfigurationCode`,'no data') <> IFNULL(idyc.`payrollConfigurationCode`,'no data'), IFNULL(idyh.`payrollConfigurationCode`,'no data'), 'match') AS 'payrollConfigurationCode'
,IF(IFNULL(idyh.`workingDaysInaYear`,'no data') <> IFNULL(idyc.`workingDaysInaYear`,'no data'), IFNULL(idyh.`workingDaysInaYear`,'no data'), 'match') AS 'Working Day Per Year'
,IF(IFNULL(idyh.`workingHoursInaDay`,'no data') <> IFNULL(idyc.`workingHoursInaDay`,'no data'), IFNULL(idyh.`workingHoursInaDay`,'no data'), 'match') AS 'Working Hour Per Day'
,IF(IFNULL(idyh.`paymentFrequency`,'no data') <> IFNULL(idyc.`paymentFrequency`,'no data'), IFNULL(idyh.`paymentFrequency`,'no data'), 'match') AS 'paymentFrequency'
,IF(IFNULL(idyh.`paymentComputation`,'no data') <> IFNULL(idyc.`paymentComputation`,'no data'), IFNULL(idyh.`paymentComputation`,'no data'), 'match') AS 'paymentComputation'
,IF(IFNULL(idyh.`doleSetup`,'no data') <> IFNULL(idyc.`doleSetup`,'no data'), IFNULL(idyh.`doleSetup`,'no data'), 'match') AS 'doleSetup'
,IF(IFNULL(idyh.`basisOfAbsent`,'no data') <> IFNULL(idyc.`basisOfAbsent`,'no data'), IFNULL(idyh.`basisOfAbsent`,'no data'), 'match') AS 'basisOfAbsent'
,IF(IFNULL(idyh.`workSchedule`,'no data') <> IFNULL(idyc.`workSchedule`,'no data'), IFNULL(idyh.`workSchedule`,'no data'), 'match') AS 'workSchedule'
,IF(IFNULL(idyh.`scheduleCode`,'no data') <> IFNULL(idyc.`scheduleCode`,'no data'), IFNULL(idyh.`scheduleCode`,'no data'), 'match') AS 'scheduleCode'
,IF(IFNULL(idyh.`windowHours`,'no data') <> IFNULL(idyc.`windowHours`,'no data'), IFNULL(idyh.`windowHours`,'no data'), 'match') AS 'windowHours'
,IF(IFNULL(idyh.`tempScheduleCode`,'no data') <> IFNULL(idyc.`tempScheduleCode`,'no data'), IFNULL(idyh.`tempScheduleCode`,'no data'), 'match') AS 'tempScheduleCode'
,IF(IFNULL(idyh.`lateConversionCode`,'no data') <> IFNULL(idyc.`lateConversionCode`,'no data'), IFNULL(idyh.`lateConversionCode`,'no data'), 'match') AS 'lateConversionCode'
,IF(IFNULL(idyh.`undertimeConversionCode`,'no data') <> IFNULL(idyc.`undertimeConversionCode`,'no data'), IFNULL(idyh.`undertimeConversionCode`,'no data'), 'match') AS 'undertimeConversionCode'
,IF(IFNULL(idyh.`location`,'no data') <> IFNULL(idyc.`location`,'no data'), IFNULL(idyh.`location`,'no data'), 'match') AS 'location'
,IF(IFNULL(idyh.`workOnHoliday`,'no data') <> IFNULL(idyc.`workOnHoliday`,'no data'), IFNULL(idyh.`workOnHoliday`,'no data'), 'match') AS 'workOnHoliday'
,IF(IFNULL(idyh.`requiredFiledOT`,'no data') <> IFNULL(idyc.`requiredFiledOT`,'no data'), IFNULL(idyh.`requiredFiledOT`,'no data'), 'match') AS 'requiredFiledOT'
,IF(IFNULL(idyh.`address2`,'no data') <> IFNULL(idyc.`address2`,'no data'), IFNULL(idyh.`address2`,'no data'), 'match') AS 'address2'
,IF(IFNULL(idyh.`address3`,'no data') <> IFNULL(idyc.`address3`,'no data'), IFNULL(idyh.`address3`,'no data'), 'match') AS 'address3'
FROM `identity_history` idyh
LEFT JOIN identity_changelogs idyc ON idyh.`code` = idyc.`code` AND idyc.`identityId` = idyh.`identityId` AND idyc.`requestNo` = idyh.`requestNo`
LEFT JOIN payrollgroup pg ON pg.`payrollGroupCode` = idyh.`batchId`
LEFT JOIN users usr ON usr.`userid` = pg.`approverHRIS`
WHERE idyc.updateStatus = 'P'
AND idyc.isChanged = 'Y'
AND idyc.`identityId` IN (
-- Get all employee IDs that this approver is responsible for
SELECT 
approvaltemplateoriginator.id
FROM approvaltemplateoriginator
LEFT JOIN approvaltemplates ON
approvaltemplateoriginator.code = approvaltemplates.code
LEFT JOIN approvaltemplatestages ON
approvaltemplateoriginator.code = approvaltemplatestages.code
LEFT JOIN approvalstages ON
approvaltemplatestages.stageCode = approvalstages.stageCode
LEFT JOIN approvalstagedetails ON
approvalstagedetails.code = approvalstages.code
LEFT JOIN identity ON
approvaltemplateoriginator.id = identity.identityId
LEFT JOIN payrollgroup ON
identity.batchId = payrollgroup.payrollGroupCode
LEFT JOIN payrollconfiguration ON
payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
LEFT JOIN payrollperiod ON
payrollconfiguration.paymentFrequency = 
(CASE 
    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
END)
LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code
WHERE approvalstagedetails.id = _identityId AND idyh.`requestNo` = _requestNo AND idyh.`identityId` = _employeeId
AND approvaltemplates.HRISApproval = '1'
GROUP BY approvaltemplateoriginator.id
);




END IF;

-- DEPENDENT
IF pint_mode = 2 THEN


SELECT edh.`lineId` AS 'Line_Id'
,IF(IFNULL(edh.`name`, 'no data') <> IFNULL(edc.`name`,'no data'), IFNULL(edh.`name`,'no data'), 'match') AS 'name'
,IF(IFNULL(edh.`lastName`, 'no data') <> IFNULL(edc.`lastName`,'no data'), IFNULL(edh.`lastName`,'no data'), 'match') AS 'lastName'
,IF(IFNULL(edh.`firstName`, 'no data') <> IFNULL(edc.`firstName`,'no data'), IFNULL(edh.`firstName`,'no data'), 'match') AS 'firstName'
,IF(IFNULL(edh.`middleName`, 'no data') <> IFNULL(edc.`middleName`,'no data'), IFNULL(edh.`middleName`,'no data'), 'match') AS 'middleName'
,IF(IFNULL(edh.`birthdate`, 'no data') <> IFNULL(edc.`birthdate`,'no data'), IFNULL(edh.`birthdate`,'no data'), 'match') AS 'birthdate'
,IF(IFNULL(edh.`relationship`, 'no data') <> IFNULL(edc.`relationship`,'no data'), IFNULL(edh.`relationship`,'no data'), 'match') AS 'relationship'
,IF(IFNULL(edh.`hmoDependent`, 'no data') <> IFNULL(edc.`hmoDependent`,'no data'), IFNULL(edh.`hmoDependent`,'no data'), 'match') AS 'hmoDependent'
,IF(IFNULL(edh.`civilStatus`, 'no data') <> IFNULL(edc.`civilStatus`,'no data'), IFNULL(edh.`civilStatus`,'no data'), 'match') AS 'civilStatus'
,IF(IFNULL(edh.`gender`, 'no data') <> IFNULL(edc.`gender`,'no data'), IFNULL(edh.`gender`,'no data'), 'match') AS 'gender'
FROM `employeedependent_history` edh
LEFT JOIN `employeedependent_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- CONTACTS
IF pint_mode = 3 THEN


SELECT edh.`lineId` AS 'Line_Id'

,IF(IFNULL(edh.`name`, 'no data') <> IFNULL(edc.`name`,'no data'), IFNULL(edh.`name`,'no data'), 'match') AS 'name'
,IF(IFNULL(edh.`relationship`, 'no data') <> IFNULL(edc.`relationship`,'no data'), IFNULL(edh.`relationship`,'no data'), 'match') AS 'relationship'
,IF(IFNULL(edh.`mobileNo`, 'no data') <> IFNULL(edc.`mobileNo`,'no data'), IFNULL(edh.`mobileNo`,'no data'), 'match') AS 'mobileNo'
,IF(IFNULL(edh.`alt_mobileNo`, 'no data') <> IFNULL(edc.`alt_mobileNo`,'no data'), IFNULL(edh.`alt_mobileNo`,'no data'), 'match') AS 'alt_mobileNo'
,IF(IFNULL(edh.`email`, 'no data') <> IFNULL(edc.`email`,'no data'), IFNULL(edh.`email`,'no data'), 'match') AS 'email'
FROM `employeecontacts_history` edh
LEFT JOIN `employeecontacts_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- EDUCATION
IF pint_mode = 4 THEN
SELECT edh.`lineId` AS 'Line_Id'
,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
,IF(IFNULL(edh.`from`, 'no data') <> IFNULL(edc.`from`,'no data'), IFNULL(edh.`from`,'no data'), 'match') AS 'from'
,IF(IFNULL(edh.`to`, 'no data') <> IFNULL(edc.`to`,'no data'), IFNULL(edh.`to`,'no data'), 'match') AS 'to'
,IF(IFNULL(edh.`school`, 'no data') <> IFNULL(edc.`school`,'no data'), IFNULL(edh.`school`,'no data'), 'match') AS 'school'
,IF(IFNULL(edh.`degree`, 'no data') <> IFNULL(edc.`degree`,'no data'), IFNULL(edh.`degree`,'no data'), 'match') AS 'degree'
,IF(IFNULL(edh.`major`, 'no data') <> IFNULL(edc.`major`,'no data'), IFNULL(edh.`major`,'no data'), 'match') AS 'major'
FROM `employeeeducation_history` edh
LEFT JOIN `employeeeducation_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- EMPLOYMENT HISTORY
IF pint_mode = 5 THEN
SELECT edh.`lineId` AS 'Line_Id'
,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
,IF(IFNULL(edh.`from`, 'no data') <> IFNULL(edc.`from`,'no data'), IFNULL(edh.`from`,'no data'), 'match') AS 'from'
,IF(IFNULL(edh.`to`, 'no data') <> IFNULL(edc.`to`,'no data'), IFNULL(edh.`to`,'no data'), 'match') AS 'to'
,IF(IFNULL(edh.`company`, 'no data') <> IFNULL(edc.`company`,'no data'), IFNULL(edh.`company`,'no data'), 'match') AS 'company'
,IF(IFNULL(edh.`position`, 'no data') <> IFNULL(edc.`position`,'no data'), IFNULL(edh.`position`,'no data'), 'match') AS 'position'
,IF(IFNULL(edh.`rate`, 'no data') <> IFNULL(edc.`rate`,'no data'), IFNULL(edh.`rate`,'no data'), 'match') AS 'rate'
,IF(IFNULL(edh.`tinNo`, 'no data') <> IFNULL(edc.`tinNo`,'no data'), IFNULL(edh.`tinNo`,'no data'), 'match') AS 'tinNo'
,IF(IFNULL(edh.`address`, 'no data') <> IFNULL(edc.`address`,'no data'), IFNULL(edh.`address`,'no data'), 'match') AS 'address'
,IF(IFNULL(edh.`zipCode`, 'no data') <> IFNULL(edc.`zipCode`,'no data'), IFNULL(edh.`zipCode`,'no data'), 'match') AS 'zipCode'
,IF(IFNULL(edh.`taxableCompensation`, 'no data') <> IFNULL(edc.`taxableCompensation`,'no data'), IFNULL(edh.`taxableCompensation`,'no data'), 'match') AS 'taxableCompensation'
,IF(IFNULL(edh.`amountOfTaxes`, 'no data') <> IFNULL(edc.`amountOfTaxes`,'no data'), IFNULL(edh.`amountOfTaxes`,'no data'), 'match') AS 'amountOfTaxes'
,IF(IFNULL(edh.`nonTaxableCompensation`, 'no data') <> IFNULL(edc.`nonTaxableCompensation`,'no data'), IFNULL(edh.`nonTaxableCompensation`,'no data'), 'match') AS 'nonTaxableCompensation'
,IF(IFNULL(edh.`prevGrossCompIncome`, 'no data') <> IFNULL(edc.`prevGrossCompIncome`,'no data'), IFNULL(edh.`prevGrossCompIncome`,'no data'), 'match') AS 'prevGrossCompIncome'
,IF(IFNULL(edh.`prevNonTax13thMonthOtherBenefits`, 'no data') <> IFNULL(edc.`prevNonTax13thMonthOtherBenefits`,'no data'), IFNULL(edh.`prevNonTax13thMonthOtherBenefits`,'no data'), 'match') AS 'prevNonTax13thMonthOtherBenefits'
,IF(IFNULL(edh.`prevNonTaxDeminimis`, 'no data') <> IFNULL(edc.`prevNonTaxDeminimis`,'no data'), IFNULL(edh.`prevNonTaxDeminimis`,'no data'), 'match') AS 'prevNonTaxDeminimis'
,IF(IFNULL(edh.`prevNonTaxGovtContUnionDues`, 'no data') <> IFNULL(edc.`prevNonTaxGovtContUnionDues`,'no data'), IFNULL(edh.`prevNonTaxGovtContUnionDues`,'no data'), 'match') AS 'prevNonTaxGovtContUnionDues'
,IF(IFNULL(edh.`prevNonTaxSalaries`, 'no data') <> IFNULL(edc.`prevNonTaxSalaries`,'no data'), IFNULL(edh.`prevNonTaxSalaries`,'no data'), 'match') AS 'prevNonTaxSalaries'
,IF(IFNULL(edh.`prevNonTaxExemptIncome`, 'no data') <> IFNULL(edc.`prevNonTaxExemptIncome`,'no data'), IFNULL(edh.`prevNonTaxExemptIncome`,'no data'), 'match') AS 'prevNonTaxExemptIncome'
,IF(IFNULL(edh.`prevTaxBasicSalary`, 'no data') <> IFNULL(edc.`prevTaxBasicSalary`,'no data'), IFNULL(edh.`prevTaxBasicSalary`,'no data'), 'match') AS 'prevTaxBasicSalary'
,IF(IFNULL(edh.`prevTax13thMonthOtherBenefits`, 'no data') <> IFNULL(edc.`prevTax13thMonthOtherBenefits`,'no data'), IFNULL(edh.`prevTax13thMonthOtherBenefits`,'no data'), 'match') AS 'prevTax13thMonthOtherBenefits'
,IF(IFNULL(edh.`prevTaxSalaries`, 'no data') <> IFNULL(edc.`prevTaxSalaries`,'no data'), IFNULL(edh.`prevTaxSalaries`,'no data'), 'match') AS 'prevTaxSalaries'
,IF(IFNULL(edh.`prevTaxDue`, 'no data') <> IFNULL(edc.`prevTaxDue`,'no data'), IFNULL(edh.`prevTaxDue`,'no data'), 'match') AS 'prevTaxDue'
,IF(IFNULL(edh.`prevNonTaxBasicSMW`, 'no data') <> IFNULL(edc.`prevNonTaxBasicSMW`,'no data'), IFNULL(edh.`prevNonTaxBasicSMW`,'no data'), 'match') AS 'prevNonTaxBasicSMW'
,IF(IFNULL(edh.`prevNonTaxHolidayPay`, 'no data') <> IFNULL(edc.`prevNonTaxHolidayPay`,'no data'), IFNULL(edh.`prevNonTaxHolidayPay`,'no data'), 'match') AS 'prevNonTaxHolidayPay'
,IF(IFNULL(edh.`prevNonTaxOvertimePay`, 'no data') <> IFNULL(edc.`prevNonTaxOvertimePay`,'no data'), IFNULL(edh.`prevNonTaxOvertimePay`,'no data'), 'match') AS 'prevNonTaxOvertimePay'
,IF(IFNULL(edh.`prevNonTaxNightDiff`, 'no data') <> IFNULL(edc.`prevNonTaxNightDiff`,'no data'), IFNULL(edh.`prevNonTaxNightDiff`,'no data'), 'match') AS 'prevNonTaxNightDiff'
,IF(IFNULL(edh.`prevNonTaxHazardPay`, 'no data') <> IFNULL(edc.`prevNonTaxHazardPay`,'no data'), IFNULL(edh.`prevNonTaxHazardPay`,'no data'), 'match') AS 'prevNonTaxHazardPay'
,IF(IFNULL(edh.`reasonOfSeparation`, 'no data') <> IFNULL(edc.`reasonOfSeparation`,'no data'), IFNULL(edh.`reasonOfSeparation`,'no data'), 'match') AS 'reasonOfSeparation'
,IF(IFNULL(edh.`empStatus`, 'no data') <> IFNULL(edc.`empStatus`,'no data'), IFNULL(edh.`empStatus`,'no data'), 'match') AS 'empStatus'
FROM `employeeemployementhistory_history` edh
LEFT JOIN `employeeemployementhistory_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- LEAVE CREDIT
IF pint_mode = 6 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`leaveCode`, 'no data') <> IFNULL(edc.`leaveCode`,'no data'), IFNULL(edh.`leaveCode`,'no data'), 'match') AS 'leaveCode'
		,IF(IFNULL(edh.`leaveBalance`, 'no data') <> IFNULL(edc.`leaveBalance`,'no data'), IFNULL(edh.`leaveBalance`,'no data'), 'match') AS 'leaveBalance'
		,IF(IFNULL(edh.`currentBalance`, 'no data') <> IFNULL(edc.`currentBalance`,'no data'), IFNULL(edh.`currentBalance`,'no data'), 'match') AS 'currentBalance'
		,IF(IFNULL(edh.`leaveCredit`, 'no data') <> IFNULL(edc.`leaveCredit`,'no data'), IFNULL(edh.`leaveCredit`,'no data'), 'match') AS 'leaveCredit'
		,IF(IFNULL(edh.`leavePrevious`, 'no data') <> IFNULL(edc.`leavePrevious`,'no data'), IFNULL(edh.`leavePrevious`,'no data'), 'match') AS 'leavePrevious'
		,IF(IFNULL(edh.`leaveAdvance`, 'no data') <> IFNULL(edc.`leaveAdvance`,'no data'), IFNULL(edh.`leaveAdvance`,'no data'), 'match') AS 'leaveAdvance'
		,IF(IFNULL(edh.`leaveAlloted`, 'no data') <> IFNULL(edc.`leaveAlloted`,'no data'), IFNULL(edh.`leaveAlloted`,'no data'), 'match') AS 'leaveAlloted'
		,IF(IFNULL(edh.`validUntil`, 'no data') <> IFNULL(edc.`validUntil`,'no data'), IFNULL(edh.`validUntil`,'no data'), 'match') AS 'validUntil'
FROM `employeeleavebalances_history` edh
LEFT JOIN `employeeleavebalances_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- EARNINGS
IF pint_mode = 7 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`allowanceType`, 'no data') <> IFNULL(edc.`allowanceType`,'no data'), IFNULL(edh.`allowanceType`,'no data'), 'match') AS 'allowanceType'
		,IF(IFNULL(edh.`terms`, 'no data') <> IFNULL(edc.`terms`,'no data'), IFNULL(edh.`terms`,'no data'), 'match') AS 'terms'
		,IF(IFNULL(edh.`amount`, 'no data') <> IFNULL(edc.`amount`,'no data'), IFNULL(edh.`amount`,'no data'), 'match') AS 'amount'
		,IF(IFNULL(edh.`dateEffective`, 'no data') <> IFNULL(edc.`dateEffective`,'no data'), IFNULL(edh.`dateEffective`,'no data'), 'match') AS 'dateEffective'
		,IF(IFNULL(edh.`dateEnd`, 'no data') <> IFNULL(edc.`dateEnd`,'no data'), IFNULL(edh.`dateEnd`,'no data'), 'match') AS 'dateEnd'
		,IF(IFNULL(edh.`inputTax`, 'no data') <> IFNULL(edc.`inputTax`,'no data'), IFNULL(edh.`inputTax`,'no data'), 'match') AS 'inputTax'
		,IF(IFNULL(edh.`taxable`, 'no data') <> IFNULL(edc.`taxable`,'no data'), IFNULL(edh.`taxable`,'no data'), 'match') AS 'taxable'
		,IF(IFNULL(edh.`treshold`, 'no data') <> IFNULL(edc.`treshold`,'no data'), IFNULL(edh.`treshold`,'no data'), 'match') AS 'treshold'
		,IF(IFNULL(edh.`diminimiss`, 'no data') <> IFNULL(edc.`diminimiss`,'no data'), IFNULL(edh.`diminimiss`,'no data'), 'match') AS 'diminimiss'
		,IF(IFNULL(edh.`sss`, 'no data') <> IFNULL(edc.`sss`,'no data'), IFNULL(edh.`sss`,'no data'), 'match') AS 'sss'
		,IF(IFNULL(edh.`hdmf`, 'no data') <> IFNULL(edc.`hdmf`,'no data'), IFNULL(edh.`hdmf`,'no data'), 'match') AS 'hdmf'
		,IF(IFNULL(edh.`month13`, 'no data') <> IFNULL(edc.`month13`,'no data'), IFNULL(edh.`month13`,'no data'), 'match') AS 'month13'
		,IF(IFNULL(edh.`taxShield`, 'no data') <> IFNULL(edc.`taxShield`,'no data'), IFNULL(edh.`taxShield`,'no data'), 'match') AS 'taxShield'
		,IF(IFNULL(edh.`hold`, 'no data') <> IFNULL(edc.`hold`,'no data'), IFNULL(edh.`hold`,'no data'), 'match') AS 'hold'
		,IF(IFNULL(edh.`vatable`, 'no data') <> IFNULL(edc.`vatable`,'no data'), IFNULL(edh.`vatable`,'no data'), 'match') AS 'vatable'
		,IF(IFNULL(edh.`remarks`, 'no data') <> IFNULL(edc.`remarks`,'no data'), IFNULL(edh.`remarks`,'no data'), 'match') AS 'remarks'
		,IF(IFNULL(edh.`payrollperiod`, 'no data') <> IFNULL(edc.`payrollperiod`,'no data'), IFNULL(edh.`payrollperiod`,'no data'), 'match') AS 'payrollperiod'
		,IF(IFNULL(edh.`phic`, 'no data') <> IFNULL(edc.`phic`,'no data'), IFNULL(edh.`phic`,'no data'), 'match') AS 'phic'
		,IF(IFNULL(edh.`bonus`, 'no data') <> IFNULL(edc.`bonus`,'no data'), IFNULL(edh.`bonus`,'no data'), 'match') AS 'bonus'
		,IF(IFNULL(edh.`finalPay`, 'no data') <> IFNULL(edc.`finalPay`,'no data'), IFNULL(edh.`finalPay`,'no data'), 'match') AS 'finalPay'
		,IF(IFNULL(edh.`special_process`, 'no data') <> IFNULL(edc.`special_process`,'no data'), IFNULL(edh.`special_process`,'no data'), 'match') AS 'special_process'
		,IF(IFNULL(edh.`nonmonetized`, 'no data') <> IFNULL(edc.`nonmonetized`,'no data'), IFNULL(edh.`nonmonetized`,'no data'), 'match') AS 'nonmonetized'
		,IF(IFNULL(edh.`ea_status`, 'no data') <> IFNULL(edc.`ea_status`,'no data'), IFNULL(edh.`ea_status`,'no data'), 'match') AS 'ea_status'
		,IF(IFNULL(edh.`fringe_benefit`, 'no data') <> IFNULL(edc.`fringe_benefit`,'no data'), IFNULL(edh.`fringe_benefit`,'no data'), 'match') AS 'fringe_benefit'
FROM `employeeallowances_history` edh
LEFT JOIN `employeeallowances_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;


-- DEDUCTION
IF pint_mode = 8 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`deductionType`, 'no data') <> IFNULL(edc.`deductionType`,'no data'), IFNULL(edh.`deductionType`,'no data'), 'match') AS 'deductionType'
		,IF(IFNULL(edh.`terms`, 'no data') <> IFNULL(edc.`terms`,'no data'), IFNULL(edh.`terms`,'no data'), 'match') AS 'terms'
		,IF(IFNULL(edh.`amount`, 'no data') <> IFNULL(edc.`amount`,'no data'), IFNULL(edh.`amount`,'no data'), 'match') AS 'amount'
		,IF(IFNULL(edh.`balance`, 'no data') <> IFNULL(edc.`balance`,'no data'), IFNULL(edh.`balance`,'no data'), 'match') AS 'balance'
		,IF(IFNULL(edh.`dateEffective`, 'no data') <> IFNULL(edc.`dateEffective`,'no data'), IFNULL(edh.`dateEffective`,'no data'), 'match') AS 'dateEffective'
		,IF(IFNULL(edh.`dateEnd`, 'no data') <> IFNULL(edc.`dateEnd`,'no data'), IFNULL(edh.`dateEnd`,'no data'), 'match') AS 'dateEnd'
		,IF(IFNULL(edh.`principalAmount`, 'no data') <> IFNULL(edc.`principalAmount`,'no data'), IFNULL(edh.`principalAmount`,'no data'), 'match') AS 'principalAmount'
		,IF(IFNULL(edh.`interest`, 'no data') <> IFNULL(edc.`interest`,'no data'), IFNULL(edh.`interest`,'no data'), 'match') AS 'interest'
		,IF(IFNULL(edh.`advancePayment`, 'no data') <> IFNULL(edc.`advancePayment`,'no data'), IFNULL(edh.`advancePayment`,'no data'), 'match') AS 'advancePayment'
		,IF(IFNULL(edh.`referenceNumber`, 'no data') <> IFNULL(edc.`referenceNumber`,'no data'), IFNULL(edh.`referenceNumber`,'no data'), 'match') AS 'referenceNumber'
		,IF(IFNULL(edh.`hold`, 'no data') <> IFNULL(edc.`hold`,'no data'), IFNULL(edh.`hold`,'no data'), 'match') AS 'hold'
		,IF(IFNULL(edh.`recurring`, 'no data') <> IFNULL(edc.`recurring`,'no data'), IFNULL(edh.`recurring`,'no data'), 'match') AS 'recurring'
		,IF(IFNULL(edh.`loanDate`, 'no data') <> IFNULL(edc.`loanDate`,'no data'), IFNULL(edh.`loanDate`,'no data'), 'match') AS 'loanDate'
		,IF(IFNULL(edh.`loanAmount`, 'no data') <> IFNULL(edc.`loanAmount`,'no data'), IFNULL(edh.`loanAmount`,'no data'), 'match') AS 'loanAmount'
		,IF(IFNULL(edh.`remarks`, 'no data') <> IFNULL(edc.`remarks`,'no data'), IFNULL(edh.`remarks`,'no data'), 'match') AS 'remarks'
		,IF(IFNULL(edh.`finalPay`, 'no data') <> IFNULL(edc.`finalPay`,'no data'), IFNULL(edh.`finalPay`,'no data'), 'match') AS 'finalPay'
		,IF(IFNULL(edh.`hierarchy`, 'no data') <> IFNULL(edc.`hierarchy`,'no data'), IFNULL(edh.`hierarchy`,'no data'), 'match') AS 'hierarchy'
		,IF(IFNULL(edh.`mp2AccountNo`, 'no data') <> IFNULL(edc.`mp2AccountNo`,'no data'), IFNULL(edh.`mp2AccountNo`,'no data'), 'match') AS 'mp2AccountNo'
FROM `employeedeductions_history` edh
LEFT JOIN `employeedeductions_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- BANK ACCOUNTS
IF pint_mode = 9 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`bankAccountCode`, 'no data') <> IFNULL(edc.`bankAccountCode`,'no data'), IFNULL(edh.`bankAccountCode`,'no data'), 'match') AS 'bankAccountCode'
		,IF(IFNULL(edh.`accountNumber`, 'no data') <> IFNULL(edc.`accountNumber`,'no data'), IFNULL(edh.`accountNumber`,'no data'), 'match') AS 'accountNumber'
		,IF(IFNULL(edh.`accountType`, 'no data') <> IFNULL(edc.`accountType`,'no data'), IFNULL(edh.`accountType`,'no data'), 'match') AS 'accountType'
		,IF(IFNULL(edh.`percentage`, 'no data') <> IFNULL(edc.`percentage`,'no data'), IFNULL(edh.`percentage`,'no data'), 'match') AS 'percentage'
		,IF(IFNULL(edh.`status`, 'no data') <> IFNULL(edc.`status`,'no data'), IFNULL(edh.`status`,'no data'), 'match') AS 'status'
		,IF(IFNULL(edh.`fixedAmount`, 'no data') <> IFNULL(edc.`fixedAmount`,'no data'), IFNULL(edh.`fixedAmount`,'no data'), 'match') AS 'fixedAmount'
FROM `employeebankaccounts_history` edh
LEFT JOIN `employeebankaccounts_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- ACCOUNTABILITY
IF pint_mode = 10 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`itemId`, 'no data') <> IFNULL(edc.`itemId`,'no data'), IFNULL(edh.`itemId`,'no data'), 'match') AS 'itemId'
		,IF(IFNULL(edh.`itemDescription`, 'no data') <> IFNULL(edc.`itemDescription`,'no data'), IFNULL(edh.`itemDescription`,'no data'), 'match') AS 'itemDescription'
		,IF(IFNULL(edh.`dateFrom`, 'no data') <> IFNULL(edc.`dateFrom`,'no data'), IFNULL(edh.`dateFrom`,'no data'), 'match') AS 'dateFrom'
		,IF(IFNULL(edh.`dateTo`, 'no data') <> IFNULL(edc.`dateTo`,'no data'), IFNULL(edh.`dateTo`,'no data'), 'match') AS 'dateTo'
		,IF(IFNULL(edh.`status`, 'no data') <> IFNULL(edc.`status`,'no data'), IFNULL(edh.`status`,'no data'), 'match') AS 'status'
		,IF(IFNULL(edh.`remarks`, 'no data') <> IFNULL(edc.`remarks`,'no data'), IFNULL(edh.`remarks`,'no data'), 'match') AS 'remarks'
		,IF(IFNULL(edh.`penaltyAmount`, 'no data') <> IFNULL(edc.`penaltyAmount`,'no data'), IFNULL(edh.`penaltyAmount`,'no data'), 'match') AS 'penaltyAmount'
		,IF(IFNULL(edh.`docFile`, 'no data') <> IFNULL(edc.`docFile`,'no data'), IFNULL(edh.`docFile`,'no data'), 'match') AS 'docFile'
FROM `employeeaccountability_history` edh
LEFT JOIN `employeeaccountability_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- MEDICAL RECORDS
IF pint_mode = 11 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`examDate`, 'no data') <> IFNULL(edc.`examDate`,'no data'), IFNULL(edh.`examDate`,'no data'), 'match') AS 'examDate'
		,IF(IFNULL(edh.`examType`, 'no data') <> IFNULL(edc.`examType`,'no data'), IFNULL(edh.`examType`,'no data'), 'match') AS 'examType'
		,IF(IFNULL(edh.`hospitalLabName`, 'no data') <> IFNULL(edc.`hospitalLabName`,'no data'), IFNULL(edh.`hospitalLabName`,'no data'), 'match') AS 'hospitalLabName'
		,IF(IFNULL(edh.`diagnosis`, 'no data') <> IFNULL(edc.`diagnosis`,'no data'), IFNULL(edh.`diagnosis`,'no data'), 'match') AS 'diagnosis'
		,IF(IFNULL(edh.`medicines`, 'no data') <> IFNULL(edc.`medicines`,'no data'), IFNULL(edh.`medicines`,'no data'), 'match') AS 'medicines'
		,IF(IFNULL(edh.`bloodType`, 'no data') <> IFNULL(edc.`bloodType`,'no data'), IFNULL(edh.`bloodType`,'no data'), 'match') AS 'bloodType'
		,IF(IFNULL(edh.`weight`, 'no data') <> IFNULL(edc.`weight`,'no data'), IFNULL(edh.`weight`,'no data'), 'match') AS 'weight'
		,IF(IFNULL(edh.`height`, 'no data') <> IFNULL(edc.`height`,'no data'), IFNULL(edh.`height`,'no data'), 'match') AS 'height'
		,IF(IFNULL(edh.`results`, 'no data') <> IFNULL(edc.`results`,'no data'), IFNULL(edh.`results`,'no data'), 'match') AS 'results'
		,IF(IFNULL(edh.`category`, 'no data') <> IFNULL(edc.`category`,'no data'), IFNULL(edh.`category`,'no data'), 'match') AS 'category'
		,IF(IFNULL(edh.`remarks`, 'no data') <> IFNULL(edc.`remarks`,'no data'), IFNULL(edh.`remarks`,'no data'), 'match') AS 'remarks'
		,IF(IFNULL(edh.`docFile`, 'no data') <> IFNULL(edc.`docFile`,'no data'), IFNULL(edh.`docFile`,'no data'), 'match') AS 'docFile'
FROM `employeemedicalrecords_history` edh
LEFT JOIN `employeemedicalrecords_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- SEMINAR ATTENDED
IF pint_mode = 12 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`from`, 'no data') <> IFNULL(edc.`from`,'no data'), IFNULL(edh.`from`,'no data'), 'match') AS 'from'
		,IF(IFNULL(edh.`to`, 'no data') <> IFNULL(edc.`to`,'no data'), IFNULL(edh.`to`,'no data'), 'match') AS 'to'
		,IF(IFNULL(edh.`description`, 'no data') <> IFNULL(edc.`description`,'no data'), IFNULL(edh.`description`,'no data'), 'match') AS 'description'
		,IF(IFNULL(edh.`places`, 'no data') <> IFNULL(edc.`places`,'no data'), IFNULL(edh.`places`,'no data'), 'match') AS 'places'
		,IF(IFNULL(edh.`docFile`, 'no data') <> IFNULL(edc.`docFile`,'no data'), IFNULL(edh.`docFile`,'no data'), 'match') AS 'docFile'
FROM `employeeseminarattended_history` edh
LEFT JOIN `employeeseminarattended_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- BIOMETRICS INFO
IF pint_mode = 13 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		,IF(IFNULL(edh.`machineId`, 'no data') <> IFNULL(edc.`machineId`,'no data'), IFNULL(edh.`machineId`,'no data'), 'match') AS 'machineId'
		,IF(IFNULL(edh.`bioId`, 'no data') <> IFNULL(edc.`bioId`,'no data'), IFNULL(edh.`bioId`,'no data'), 'match') AS 'bioId'
FROM `employeebiometrics_history`edh
LEFT JOIN `employeebiometrics_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;

-- EMPLOYEE MOVEMENT
IF pint_mode = 14 THEN
SELECT edh.`lineId` AS 'Line_Id'
		,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
		
		,IF(IFNULL(edh.`status`,'No Data') <> IFNULL(edc.`status`,'No Data'), IFNULL(edh.`status`,'No Data'), 'match') AS `status`
		,IF(IFNULL(edh.`costCode`,'No Data') <> IFNULL(edc.`costCode`,'No Data'), IFNULL(edh.`costCode`,'No Data'), 'match') AS `costCode`
		,IF(IFNULL(edh.`positionCode`,'No Data') <> IFNULL(edc.`positionCode`,'No Data'), IFNULL(edh.`positionCode`,'No Data'), 'match') AS `positionCode`
		,IF(IFNULL(edh.`jobCategoryCode`,'No Data') <> IFNULL(edc.`jobCategoryCode`,'No Data'), IFNULL(edh.`jobCategoryCode`,'No Data'), 'match') AS `jobCategoryCode`
		,IF(IFNULL(edh.`laborCode`,'No Data') <> IFNULL(edc.`laborCode`,'No Data'), IFNULL(edh.`laborCode`,'No Data'), 'match') AS `laborCode`
		,IF(IFNULL(edh.`scheduleType`,'No Data') <> IFNULL(edc.`scheduleType`,'No Data'), IFNULL(edh.`scheduleType`,'No Data'), 'match') AS `scheduleType`
		,IF(IFNULL(edh.`rate`,'No Data') <> IFNULL(edc.`rate`,'No Data'), IFNULL(edh.`rate`,'No Data'), 'match') AS `rate`
		,IF(IFNULL(edh.`allowance`,'No Data') <> IFNULL(edc.`allowance`,'No Data'), IFNULL(edh.`allowance`,'No Data'), 'match') AS `allowance`
		,IF(IFNULL(edh.`cola`,'No Data') <> IFNULL(edc.`cola`,'No Data'), IFNULL(edh.`cola`,'No Data'), 'match') AS `cola`
		,IF(IFNULL(edh.`currency`,'No Data') <> IFNULL(edc.`currency`,'No Data'), IFNULL(edh.`currency`,'No Data'), 'match') AS `currency`
		,IF(IFNULL(edh.`dateEffective`,'No Data') <> IFNULL(edc.`dateEffective`,'No Data'), IFNULL(edh.`dateEffective`,'No Data'), 'match') AS `dateEffective`
		,IF(IFNULL(edh.`dateEnd`,'No Data') <> IFNULL(edc.`dateEnd`,'No Data'), IFNULL(edh.`dateEnd`,'No Data'), 'match') AS `dateEnd`
		,IF(IFNULL(edh.`departmentCode`,'No Data') <> IFNULL(edc.`departmentCode`,'No Data'), IFNULL(edh.`departmentCode`,'No Data'), 'match') AS `departmentCode`
		,IF(IFNULL(edh.`divisionCode`,'No Data') <> IFNULL(edc.`divisionCode`,'No Data'), IFNULL(edh.`divisionCode`,'No Data'), 'match') AS `divisionCode`
		,IF(IFNULL(edh.`rateType`,'No Data') <> IFNULL(edc.`rateType`,'No Data'), IFNULL(edh.`rateType`,'No Data'), 'match') AS `rateType`
		,IF(IFNULL(edh.`salaryIncreasePercent`,'No Data') <> IFNULL(edc.`salaryIncreasePercent`,'No Data'), IFNULL(edh.`salaryIncreasePercent`,'No Data'), 'match') AS `salaryIncreasePercent`
		,IF(IFNULL(edh.`remarks`,'No Data') <> IFNULL(edc.`remarks`,'No Data'), IFNULL(edh.`remarks`,'No Data'), 'match') AS `remarks`
		,IF(IFNULL(edh.`vatRegistered`,'No Data') <> IFNULL(edc.`vatRegistered`,'No Data'), IFNULL(edh.`vatRegistered`,'No Data'), 'match') AS `vatRegistered`
		,IF(IFNULL(edh.`regionCode`,'No Data') <> IFNULL(edc.`regionCode`,'No Data'), IFNULL(edh.`regionCode`,'No Data'), 'match') AS `regionCode`
FROM `employeemovement_history`edh
LEFT JOIN `employeemovement_changelogs` edc 
	ON edc.code = edh.`code` 
	AND edc.`lineId` = edh.`lineId` 
	AND edc.`requestNo` = edh.`requestNo`
LEFT JOIN identity idy 
	ON idy.code = edh.`code`
WHERE edh.`updateStatus` = 'P'
AND edh.`code` IN 
(
	SELECT identity.code
	FROM approvaltemplateoriginator
	LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
			CASE 
				WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
				WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
				WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
			END
		)
	LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edh.`requestNo` = _requestNo
		AND edh.`code` = (
			SELECT CODE
			FROM identity
			WHERE identityId = _employeeId
			LIMIT 1
		)
	GROUP BY identity.code
);

END IF;
END$$ 
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval_list`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval_list`(  
IN pint_mode INT,	
IN _identityId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';


-- PERSONAL INFORMATION
IF pint_mode = 1 THEN

SELECT 
idyc.`code` AS 'Employee_Code',
idyc.`identityId` AS 'Employee_Id',
CONCAT(idyc.`lastName`,' ',idyc.`firstName`, IF(idyc.`middleName` IS NULL,'', CONCAT(' ',LEFT(idyc.`middleName`,1),'.') ) ) AS 'Employee_Name',
IF(IFNULL(idyc.`dateHired`, 'no data') <> IFNULL(idyh.`dateHired`,'no data'), IFNULL(idyc.`dateHired`,'no data'), 'match') AS 'Date_Hired',
IF(IFNULL(idyc.`firstName`, 'no data') <> IFNULL(idyh.`firstName`,'no data'), IFNULL(idyc.`firstName`,'no data'), 'match') AS 'First_Name',
IF(IFNULL(idyc.`middleName`, 'no data') <> IFNULL(idyh.`middleName`,'no data'), IFNULL(idyc.`middleName`,'no data'), 'match') AS 'Middle_Name',
IF(IFNULL(idyc.`lastName`, 'no data') <> IFNULL(idyh.`lastName`,'no data'), IFNULL(idyc.`lastName`,'no data'), 'match') AS 'Last_Name'
,idyc.`crud` AS 'crud'
,idyc.`requestNo` AS 'Request_No',
idyc.`updateRequestedBy` AS 'Requested_By',
idyc.`updateRequestDate` AS 'Request_Date'
FROM `identity_changelogs` idyc
JOIN identity_history idyh ON idyh.`code` = idyc.`code` AND idyh.`identityId` = idyc.`identityId` AND idyc.`requestNo` = idyh.`requestNo`
WHERE idyc.`updateStatus` = 'P'
AND idyc.`isChanged` = 'Y'
AND idyc.`identityId` IN (
-- Get all employee IDs that this approver is responsible for
SELECT 
approvaltemplateoriginator.id
FROM approvaltemplateoriginator
LEFT JOIN approvaltemplates ON
approvaltemplateoriginator.code = approvaltemplates.code
LEFT JOIN approvaltemplatestages ON
approvaltemplateoriginator.code = approvaltemplatestages.code
LEFT JOIN approvalstages ON
approvaltemplatestages.stageCode = approvalstages.stageCode
LEFT JOIN approvalstagedetails ON
approvalstagedetails.code = approvalstages.code
LEFT JOIN identity ON
approvaltemplateoriginator.id = identity.identityId
LEFT JOIN payrollgroup ON
identity.batchId = payrollgroup.payrollGroupCode
LEFT JOIN payrollconfiguration ON
payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
LEFT JOIN payrollperiod ON
payrollconfiguration.paymentFrequency = 
(CASE 
    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
END)
LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code
WHERE approvalstagedetails.id = _identityId
AND approvaltemplates.HRISApproval = '1'
GROUP BY approvaltemplateoriginator.id
);




END IF;

-- DEPENDENT
IF pint_mode = 2 THEN


SELECT DISTINCT 
edc.requestNo AS 'Request_No',
idy.`identityId` AS 'Employee_Id',
CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
edc.`crud` AS 'crud',
edc.updateRequestedBy AS 'Requested_By',
edc.updateRequestDate AS 'Request_Date'
FROM `employeedependent_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
-- Get all employee IDs that this approver is responsible for
SELECT 
approvaltemplateoriginator.id
FROM approvaltemplateoriginator
LEFT JOIN approvaltemplates ON
approvaltemplateoriginator.code = approvaltemplates.code
LEFT JOIN approvaltemplatestages ON
approvaltemplateoriginator.code = approvaltemplatestages.code
LEFT JOIN approvalstages ON
approvaltemplatestages.stageCode = approvalstages.stageCode
LEFT JOIN approvalstagedetails ON
approvalstagedetails.code = approvalstages.code
LEFT JOIN identity ON
approvaltemplateoriginator.id = identity.identityId
LEFT JOIN payrollgroup ON
identity.batchId = payrollgroup.payrollGroupCode
LEFT JOIN payrollconfiguration ON
payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
LEFT JOIN payrollperiod ON
payrollconfiguration.paymentFrequency = 
(CASE 
    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
END)
LEFT JOIN payrollperioddetails ON
payrollperiod.code = payrollperioddetails.code
WHERE approvalstagedetails.id = _identityId
AND approvaltemplates.HRISApproval = '1'
GROUP BY approvaltemplateoriginator.id
)
GROUP BY edc.requestNo, edc.`code`;



END IF;

-- CONTACTS
IF pint_mode = 3 THEN

SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeecontacts_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
     GROUP BY edc.requestNo, edc.`code`;

END IF;

-- EDUCATION
IF pint_mode = 4 THEN

SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeeducation_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
     GROUP BY edc.requestNo, edc.`code`;

END IF;

-- EMPLOYMENT HISTORY
IF pint_mode = 5 THEN

SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeemployementhistory_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
     GROUP BY edc.requestNo, edc.`code`;		    

END IF;

-- LEAVE CREDIT
IF pint_mode = 6 THEN

SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeleavebalances_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
     GROUP BY edc.requestNo, edc.`code`;

END IF;

-- EARNINGS
IF pint_mode = 7 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeallowances_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- DEDUCTION
IF pint_mode = 8 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeedeductions_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- BANK ACCOUNTS
IF pint_mode = 9 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeebankaccounts_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- ACCOUNTABILITY
IF pint_mode = 10 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeaccountability_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- MEDICAL RECORDS
IF pint_mode = 11 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeemedicalrecords_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- SEMINAR ATTENDED
IF pint_mode = 12 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeeseminarattended_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- BIOMETRICS INFO
IF pint_mode = 13 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeebiometrics_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;

-- EMPLOYEE MOVEMENT
IF pint_mode = 14 THEN


SELECT DISTINCT 
    edc.requestNo AS 'Request_No',
    idy.`identityId` AS 'Employee_Id',
    CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name',
    edc.`crud` AS 'crud',
    edc.updateRequestedBy AS 'Requested_By',
    edc.updateRequestDate AS 'Request_Date'
FROM `employeemovement_changelogs` edc 
LEFT JOIN identity idy ON idy.`code` = edc.`code`
WHERE edc.`updateStatus` = 'P'
AND idy.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'
    GROUP BY approvaltemplateoriginator.id
    )
    GROUP BY edc.requestNo, edc.`code`;

END IF;
END$$ 
DELIMITER ;



DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_portal_get_hris_for_approval_view`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_portal_get_hris_for_approval_view`(  
IN pint_mode INT,	
IN _identityId VARCHAR(30),
IN _requestNo VARCHAR(30),
IN _employeeId VARCHAR(30),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

-- SET _identityId = CONVERT(_identityId USING utf8mb4) COLLATE utf8mb4_unicode_ci;
-- SET _requestNo  = CONVERT(_requestNo USING utf8mb4)  COLLATE utf8mb4_unicode_ci;
-- SET _employeeId = CONVERT(_employeeId USING utf8mb4) COLLATE utf8mb4_unicode_ci;
-- Personal Information
IF pint_mode = 1 THEN

SELECT 
    idyc.`code` AS 'Employee_Code',
    idyc.`identityId` AS 'Employee_Id',
    CONCAT(idyc.`lastName`,' ',idyc.`firstName`, IF(idyc.`middleName` IS NULL,'', CONCAT(' ',LEFT(idyc.`middleName`,1),'.') ) ) AS 'Employee_Name',
    IF(IFNULL(idyc.`dateHired`, 'no data') <> IFNULL(idyh.`dateHired`,'no data'), IFNULL(idyc.`dateHired`,'no data'), 'match') AS 'Date_Hired',
    IF(IFNULL(idyc.`firstName`, 'no data') <> IFNULL(idyh.`firstName`,'no data'), IFNULL(idyc.`firstName`,'no data'), 'match') AS 'First_Name',
    IF(IFNULL(idyc.`middleName`, 'no data') <> IFNULL(idyh.`middleName`,'no data'), IFNULL(idyc.`middleName`,'no data'), 'match') AS 'Middle_Name',
    IF(IFNULL(idyc.`lastName`, 'no data') <> IFNULL(idyh.`lastName`,'no data'), IFNULL(idyc.`lastName`,'no data'), 'match') AS 'Last_Name'
    ,IF(IFNULL(idyc.`suffix`, 'no data') <> IFNULL(idyh.`suffix`,'no data'), IFNULL(idyc.`suffix`,'no data'), 'match') AS 'Suffix'
	,IF(IFNULL(idyc.`birthdate`,'no data') <> IFNULL(idyh.`birthdate`,'no data'), IFNULL(idyc.`birthdate`,'no data'), 'match') AS 'Birthdate'
	,IF(IFNULL(idyc.`age`, 'no data') <> IFNULL(idyh.`age`,'no data'), IFNULL(idyc.`age`,'no data'), 'match') AS 'Age'
	,IF(IFNULL(idyc.`gender`, 'no data') <> IFNULL(idyh.`gender`,'no data'), IFNULL(idyc.`gender`,'no data'), 'match') AS 'Gender'
	,IF(IFNULL(idyc.`civilStatus`, 'no data') <> IFNULL(idyh.`civilStatus`,'no data'), IFNULL(idyc.`civilStatus`,'no data'), 'match') AS 'Civil_Status'
	,IF(IFNULL(idyc.`contactNo`, 'no data') <> IFNULL(idyh.`contactNo`,'no data'), IFNULL(idyc.`contactNo`,'no data'), 'match') AS 'contactNo'
	,IF(IFNULL(idyc.`emailAddress`, 'no data') <> IFNULL(idyh.`emailAddress`,'no data'), IFNULL(idyc.`emailAddress`,'no data'), 'match') AS 'Email_Address'
	,IF(IFNULL(idyc.`address`, 'no data') <> IFNULL(idyh.`address`,'no data'), IFNULL(idyc.`address`,'no data'), 'match') AS 'Address'
	,IF(IFNULL(idyc.`street`, 'no data') <> IFNULL(idyh.`street`,'no data'), IFNULL(idyc.`street`,'no data'), 'match') AS 'Street'
	,IF(IFNULL(idyc.`barangay`, 'no data') <> IFNULL(idyh.`barangay`,'no data'), IFNULL(idyc.`barangay`,'no data'), 'match') AS 'Barangay'
	,IF(IFNULL(idyc.`city`, 'no data') <> IFNULL(idyh.`city`,'no data'), IFNULL(idyc.`city`,'no data'), 'match') AS 'City'
	,IF(IFNULL(idyc.`province`, 'no data') <> IFNULL(idyh.`province`,'no data'), IFNULL(idyc.`province`,'no data'), 'match') AS 'Province'
	,IF(IFNULL(idyc.`zipCode`, 'no data') <> IFNULL(idyh.`zipCode`,'no data'), IFNULL(idyc.`zipCode`,'no data'), 'match') AS 'Zip_Code'
	,IF(IFNULL(idyc.`country`, 'no data') <> IFNULL(idyh.`country`,'no data'), IFNULL(idyc.`country`,'no data'), 'match') AS 'Country'
	,IF(IFNULL(idyc.`tinNo`, 'no data') <> IFNULL(idyh.`tinNo`,'no data'), IFNULL(idyc.`tinNo`,'no data'), 'match') AS 'TinNo'
	,IF(IFNULL(idyc.`taxCode`, 'no data') <> IFNULL(idyh.`taxCode`,'no data'), IFNULL(idyc.`taxCode`,'no data'), 'match') AS 'Tax_Code'
	,IF(IFNULL(idyc.`taxExemptionCode`, 'no data') <> IFNULL(idyh.`taxExemptionCode`,'no data'), IFNULL(idyc.`taxExemptionCode`,'no data'), 'match') AS 'Tax_Exemption_Code'
	,IF(IFNULL(idyc.`philhealthNo`, 'no data') <> IFNULL(idyh.`philhealthNo`,'no data'), IFNULL(idyc.`philhealthNo`,'no data'), 'match') AS 'Philhealth_No'
	,IF(IFNULL(idyc.`sssNo`, 'no data') <> IFNULL(idyh.`sssNo`,'no data'), IFNULL(idyc.`sssNo`,'no data'), 'match') AS 'SSS No'
	,IF(IFNULL(idyc.`pagibigNo`, 'no data') <> IFNULL(idyh.`pagibigNo`,'no data'), IFNULL(idyc.`pagibigNo`,'no data'), 'match') AS 'Pagibig_No'
	,IF(IFNULL(idyc.`hmoNo`, 'no data') <> IFNULL(idyh.`hmoNo`,'no data'), IFNULL(idyc.`hmoNo`,'no data'), 'match') AS 'HMO_No'
	,IF(IFNULL(idyc.`prcNo`, 'no data') <> IFNULL(idyh.`prcNo`,'no data'), IFNULL(idyc.`prcNo`,'no data'), 'match') AS 'PRC_No'
	,IF(IFNULL(idyc.`dateIssued`, 'no data') <> IFNULL(idyh.`dateIssued`,'no data'), IFNULL(idyc.`dateIssued`,'no data'), 'match') AS 'Date_Issued'
	,IF(IFNULL(idyc.`dateExpired`, 'no data') <> IFNULL(idyh.`dateExpired`,'no data'), IFNULL(idyc.`dateExpired`,'no data'), 'match') AS 'Date_Expired'
	,IF(IFNULL(idyc.`paymentType`, 'no data') <> IFNULL(idyh.`paymentType`,'no data'), IFNULL(idyc.`paymentType`,'no data'), 'match') AS 'Payment_Type'
	,IF(IFNULL(idyc.`bankAccountCode`, 'no data') <> IFNULL(idyh.`bankAccountCode`,'no data'), IFNULL(idyc.`bankAccountCode`,'no data'), 'match') AS 'Bank_Account_Code'
	,IF(IFNULL(idyc.`BankAccountNo`, 'no data') <> IFNULL(idyh.`BankAccountNo`,'no data'), IFNULL(idyc.`BankAccountNo`,'no data'), 'match') AS 'Bank_Account_No'
	,IF(IFNULL(idyc.`approver`, 'no data') <> IFNULL(idyh.`approver`,'no data'), IFNULL(idyc.`approver`,'no data'), 'match') AS 'Approver'
	,IF(IFNULL(idyc.`batchId`, 'no data') <> IFNULL(idyh.`batchId`,'no data'), IFNULL(idyc.`batchId`,'no data'), 'match') AS 'BatchId'
	,IF(IFNULL(idyc.`minimumWage`, 'no data') <> IFNULL(idyh.`minimumWage`,'no data'), IFNULL(idyc.`minimumWage`,'no data'), 'match') AS 'Minimum_Wage'
	,IF(IFNULL(idyc.`dateCreated`, 'no data') <> IFNULL(idyh.`dateCreated`,'no data'), IFNULL(idyc.`dateCreated`,'no data'), 'match') AS 'dateCreated'
	,IF(IFNULL(idyc.`createdBy`, 'no data') <> IFNULL(idyh.`createdBy`,'no data'), IFNULL(idyc.`createdBy`,'no data'), 'match') AS 'createdBy'
	,IF(IFNULL(idyc.`dateUpdated`, 'no data') <> IFNULL(idyh.`dateUpdated`,'no data'), IFNULL(idyc.`dateUpdated`,'no data'), 'match') AS 'dateUpdated'
	,IF(IFNULL(idyc.`updatedBy`, 'no data') <> IFNULL(idyh.`updatedBy`,'no data'), IFNULL(idyc.`updatedBy`,'no data'), 'match') AS 'updatedBy'
	,IF(IFNULL(idyc.`seriesType`, 'no data') <> IFNULL(idyh.`seriesType`,'no data'), IFNULL(idyc.`seriesType`,'no data'), 'match') AS 'Series_Type'
	,IF(IFNULL(idyc.`paymentFrequency`, 'no data') <> IFNULL(idyh.`paymentFrequency`,'no data'), IFNULL(idyc.`paymentFrequency`,'no data'), 'match') AS 'Payment_Frequency'
	,IF(IFNULL(idyc.`taxShieldRate`, 'no data') <> IFNULL(idyh.`taxShieldRate`,'no data'), IFNULL(idyc.`taxShieldRate`,'no data'), 'match') AS 'Tax_Shield_Rate'
	,IF(IFNULL(idyc.`globalTaxShield`, 'no data') <> IFNULL(idyh.`globalTaxShield`,'no data'), IFNULL(idyc.`globalTaxShield`,'no data'), 'match') AS 'Global_Tax_Shield'
	,IF(IFNULL(idyc.`birthPlace`, 'no data') <> IFNULL(idyh.`birthPlace`,'no data'), IFNULL(idyc.`birthPlace`,'no data'), 'match') AS 'Birth_Place'
	,IF(IFNULL(idyc.`citizenship`, 'no data') <> IFNULL(idyh.`citizenship`,'no data'), IFNULL(idyc.`citizenship`,'no data'), 'match') AS 'Citizenship'
	,IF(IFNULL(idyc.`religion`, 'no data') <> IFNULL(idyh.`religion`,'no data'), IFNULL(idyc.`religion`,'no data'), 'match') AS 'Religion'
	,IF(IFNULL(idyc.`finalPay`, 'no data') <> IFNULL(idyh.`finalPay`,'no data'), IFNULL(idyc.`finalPay`,'no data'), 'match') AS 'Final_Pay'
	,IF(IFNULL(idyc.`streetNo`, 'no data') <> IFNULL(idyh.`streetNo`,'no data'), IFNULL(idyc.`streetNo`,'no data'), 'match') AS 'Street_No'
	,IF(IFNULL(idyc.`bldg`, 'no data') <> IFNULL(idyh.`bldg`,'no data'), IFNULL(idyc.`bldg`,'no data'), 'match') AS 'Bldg'
	,IF(IFNULL(idyc.`subdivision`, 'no data') <> IFNULL(idyh.`subdivision`,'no data'), IFNULL(idyc.`subdivision`,'no data'), 'match') AS 'Subdivision'
	,IF(IFNULL(idyc.`district`, 'no data') <> IFNULL(idyh.`district`,'no data'), IFNULL(idyc.`district`,'no data'), 'match') AS 'District'
	,IF(IFNULL(idyc.`municipality`, 'no data') <> IFNULL(idyh.`municipality`,'no data'), IFNULL(idyc.`municipality`,'no data'), 'match') AS 'Municipality'
	,IF(IFNULL(idyc.`municipalCode`, 'no data') <> IFNULL(idyh.`municipalCode`,'no data'), IFNULL(idyc.`municipalCode`,'no data'), 'match') AS 'Municipal_Code'
	,IF(IFNULL(idyc.`foreignAdd`, 'no data') <> IFNULL(idyh.`foreignAdd`,'no data'), IFNULL(idyc.`foreignAdd`,'no data'), 'match') AS 'Foreign_Add'
	,IF(IFNULL(idyc.`taxpayerType`, 'no data') <> IFNULL(idyh.`taxpayerType`,'no data'), IFNULL(idyc.`taxpayerType`,'no data'), 'match') AS 'Taxpayer_Type'
	,IF(IFNULL(idyc.`claims`, 'no data') <> IFNULL(idyh.`claims`,'no data'), IFNULL(idyc.`claims`,'no data'), 'match') AS 'Claims'
	,IF(IFNULL(idyc.`spouseEmpStatus`, 'no data') <> IFNULL(idyh.`spouseEmpStatus`,'no data'), IFNULL(idyc.`spouseEmpStatus`,'no data'), 'match') AS 'Spouse_Emp._Status'
	,IF(IFNULL(idyc.`spouseTIN`, 'no data') <> IFNULL(idyh.`spouseTIN`,'no data'), IFNULL(idyc.`spouseTIN`,'no data'), 'match') AS 'Spouse_TIN'
	,IF(IFNULL(idyc.`spouseLastName`, 'no data') <> IFNULL(idyh.`spouseLastName`,'no data'), IFNULL(idyc.`spouseLastName`,'no data'), 'match') AS 'Spouse_Last_Name'
	,IF(IFNULL(idyc.`spouseFirstName`, 'no data') <> IFNULL(idyh.`spouseFirstName`,'no data'), IFNULL(idyc.`spouseFirstName`,'no data'), 'match') AS 'Spouse_First_Name'
	,IF(IFNULL(idyc.`spouseMiddleName`, 'no data') <> IFNULL(idyh.`spouseMiddleName`,'no data'), IFNULL(idyc.`spouseMiddleName`,'no data'), 'match') AS 'Spouse Middle_Name'
	,IF(IFNULL(idyc.`spouseEmployerName`, 'no data') <> IFNULL(idyh.`spouseEmployerName`,'no data'), IFNULL(idyc.`spouseEmployerName`,'no data'), 'match') AS 'Spouse Employer_Name'
	,IF(IFNULL(idyc.`spouseEmployerTIN`, 'no data') <> IFNULL(idyh.`spouseEmployerTIN`,'no data'), IFNULL(idyc.`spouseEmployerTIN`,'no data'), 'match') AS 'Spouse_Employer_TIN'
	,IF(IFNULL(idyc.`foreignName`, 'no data') <> IFNULL(idyh.`foreignName`,'no data'), IFNULL(idyc.`foreignName`,'no data'), 'match') AS 'Foreign_Name'
	,IF(IFNULL(idyc.`signatureFile`, 'no data') <> IFNULL(idyh.`signatureFile`,'no data'), IFNULL(idyc.`signatureFile`,'no data'), 'match') AS 'E_Signature'
	,IF(IFNULL(idyc.`pictureFile`, 'no data') <> IFNULL(idyh.`pictureFile`,'no data'), IFNULL(idyc.`pictureFile`,'no data'), 'match') AS 'E_Picture'
	,IF(IFNULL(idyc.`street2`, 'no data') <> IFNULL(idyh.`street2`,'no data'), IFNULL(idyc.`street2`,'no data'), 'match') AS 'Street_2'
	,IF(IFNULL(idyc.`barangay2`, 'no data') <> IFNULL(idyh.`barangay2`,'no data'), IFNULL(idyc.`barangay2`,'no data'), 'match') AS 'Barangay_2'
	,IF(IFNULL(idyc.`city2`, 'no data') <> IFNULL(idyh.`city2`,'no data'), IFNULL(idyc.`city2`,'no data'), 'match') AS 'City_2'
	,IF(IFNULL(idyc.`province2`, 'no data') <> IFNULL(idyh.`province2`,'no data'), IFNULL(idyc.`province2`,'no data'), 'match') AS 'Province_2'
	,IF(IFNULL(idyc.`zipCode2`, 'no data') <> IFNULL(idyh.`zipCode2`,'no data'), IFNULL(idyc.`zipCode2`,'no data'), 'match') AS 'Zip_Code_2'
	,IF(IFNULL(idyc.`country2`, 'no data') <> IFNULL(idyh.`country2`,'no data'), IFNULL(idyc.`country2`,'no data'), 'match') AS 'Country_2'			
	,IF(IFNULL(idyc.`street3`, 'no data') <> IFNULL(idyh.`street3`,'no data'), IFNULL(idyc.`street3`,'no data'), 'match') AS 'Street_3'
	,IF(IFNULL(idyc.`barangay3`, 'no data') <> IFNULL(idyh.`barangay3`,'no data'), IFNULL(idyc.`barangay3`,'no data'), 'match') AS 'Barangay_3'
	,IF(IFNULL(idyc.`city3`, 'no data') <> IFNULL(idyh.`city3`,'no data'), IFNULL(idyc.`city3`,'no data'), 'match') AS 'City_3'
	,IF(IFNULL(idyc.`province3`, 'no data') <> IFNULL(idyh.`province3`,'no data'), IFNULL(idyc.`province3`,'no data'), 'match') AS 'Province_3'
	,IF(IFNULL(idyc.`zipCode3`, 'no data') <> IFNULL(idyh.`zipCode3`,'no data'), IFNULL(idyc.`zipCode3`,'no data'), 'match') AS 'Zip_Code_3'
	,IF(IFNULL(idyc.`country3`, 'no data') <> IFNULL(idyh.`country3`,'no data'), IFNULL(idyc.`country3`,'no data'), 'match') AS 'Country_3'
	,IF(IFNULL(idyc.`oldEmpId`, 'no data') <> IFNULL(idyh.`oldEmpId`,'no data'), IFNULL(idyc.`oldEmpId`,'no data'), 'match') AS 'Old_Employee_Id'				
	,IF(IFNULL(idyc.`payrollPeriodID`, 'no data') <> IFNULL(idyh.`payrollPeriodID`,'no data'), IFNULL(idyc.`payrollPeriodID`,'no data'), 'match') AS 'payrollPeriodID'
	,IF(IFNULL(idyc.`payrollConfigurationCode`, 'no data') <> IFNULL(idyh.`payrollConfigurationCode`,'no data'), IFNULL(idyc.`payrollConfigurationCode`,'no data'), 'match') AS 'payrollConfigurationCode'
	,IF(IFNULL(idyc.`workingDaysInaYear`, 'no data') <> IFNULL(idyh.`workingDaysInaYear`,'no data'), IFNULL(idyc.`workingDaysInaYear`,'no data'), 'match') AS 'Working_Day_Per_Year'
	,IF(IFNULL(idyc.`workingHoursInaDay`, 'no data') <> IFNULL(idyh.`workingHoursInaDay`,'no data'), IFNULL(idyc.`workingHoursInaDay`,'no data'), 'match') AS 'Working_Hour_Per_Day'
	,IF(IFNULL(idyc.`paymentFrequency`, 'no data') <> IFNULL(idyh.`paymentFrequency`,'no data'), IFNULL(idyc.`paymentFrequency`,'no data'), 'match') AS 'paymentFrequency'
	,IF(IFNULL(idyc.`paymentComputation`, 'no data') <> IFNULL(idyh.`paymentComputation`,'no data'), IFNULL(idyc.`paymentComputation`,'no data'), 'match') AS 'paymentComputation'
	,IF(IFNULL(idyc.`doleSetup`, 'no data') <> IFNULL(idyh.`doleSetup`,'no data'), IFNULL(idyc.`doleSetup`,'no data'), 'match') AS 'doleSetup'
	,IF(IFNULL(idyc.`basisOfAbsent`, 'no data') <> IFNULL(idyh.`basisOfAbsent`,'no data'), IFNULL(idyc.`basisOfAbsent`,'no data'), 'match') AS 'basisOfAbsent'
	,IF(IFNULL(idyc.`workSchedule`, 'no data') <> IFNULL(idyh.`workSchedule`,'no data'), IFNULL(idyc.`workSchedule`,'no data'), 'match') AS 'workSchedule'
	,IF(IFNULL(idyc.`scheduleCode`, 'no data') <> IFNULL(idyh.`scheduleCode`,'no data'), IFNULL(idyc.`scheduleCode`,'no data'), 'match') AS 'scheduleCode'
	,IF(IFNULL(idyc.`windowHours`, 'no data') <> IFNULL(idyh.`windowHours`,'no data'), IFNULL(idyc.`windowHours`,'no data'), 'match') AS 'windowHours'
	,IF(IFNULL(idyc.`tempScheduleCode`, 'no data') <> IFNULL(idyh.`tempScheduleCode`,'no data'), IFNULL(idyc.`tempScheduleCode`,'no data'), 'match') AS 'tempScheduleCode'
	,IF(IFNULL(idyc.`lateConversionCode`, 'no data') <> IFNULL(idyh.`lateConversionCode`,'no data'), IFNULL(idyc.`lateConversionCode`,'no data'), 'match') AS 'lateConversionCode'
	,IF(IFNULL(idyc.`undertimeConversionCode`, 'no data') <> IFNULL(idyh.`undertimeConversionCode`,'no data'), IFNULL(idyc.`undertimeConversionCode`,'no data'), 'match') AS 'undertimeConversionCode'
	,IF(IFNULL(idyc.`location`, 'no data') <> IFNULL(idyh.`location`,'no data'), IFNULL(idyc.`location`,'no data'), 'match') AS 'location'
	,IF(IFNULL(idyc.`workOnHoliday`, 'no data') <> IFNULL(idyh.`workOnHoliday`,'no data'), IFNULL(idyc.`workOnHoliday`,'no data'), 'match') AS 'workOnHoliday'
	,IF(IFNULL(idyc.`requiredFiledOT`, 'no data') <> IFNULL(idyh.`requiredFiledOT`,'no data'), IFNULL(idyc.`requiredFiledOT`,'no data'), 'match') AS 'requiredFiledOT'
	,IF(IFNULL(idyc.`address2`, 'no data') <> IFNULL(idyh.`address2`,'no data'), IFNULL(idyc.`address2`,'no data'), 'match') AS 'address2'
	,IF(IFNULL(idyc.`address3`, 'no data') <> IFNULL(idyh.`address3`,'no data'), IFNULL(idyc.`address3`,'no data'), 'match') AS 'address3'
	
    ,idyc.`requestNo` AS 'Request_No',
    idyc.`updateRequestedBy` AS 'Requested_By',
    idyc.`updateRequestDate` AS 'Request_Date'
FROM `identity_changelogs` idyc
JOIN identity_history idyh ON idyh.`code` = idyc.`code` AND idyh.`identityId` = idyc.`identityId` AND idyc.`requestNo` = idyh.`requestNo`
WHERE idyc.`updateStatus` = 'P'
AND idyc.`isChanged` = 'Y'
AND idyc.`identityId` IN (
    -- Get all employee IDs that this approver is responsible for
    SELECT 
	approvaltemplateoriginator.id
    FROM approvaltemplateoriginator
    LEFT JOIN approvaltemplates ON
	approvaltemplateoriginator.code = approvaltemplates.code
    LEFT JOIN approvaltemplatestages ON
	approvaltemplateoriginator.code = approvaltemplatestages.code
    LEFT JOIN approvalstages ON
	approvaltemplatestages.stageCode = approvalstages.stageCode
    LEFT JOIN approvalstagedetails ON
	approvalstagedetails.code = approvalstages.code
    LEFT JOIN identity ON
	approvaltemplateoriginator.id = identity.identityId
    LEFT JOIN payrollgroup ON
	identity.batchId = payrollgroup.payrollGroupCode
    LEFT JOIN payrollconfiguration ON
	payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
    LEFT JOIN payrollperiod ON
	payrollconfiguration.paymentFrequency = 
	(CASE 
	    WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
	    WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
	    WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
	END)
    LEFT JOIN payrollperioddetails ON
	payrollperiod.code = payrollperioddetails.code
    WHERE approvalstagedetails.id = _identityId
    AND approvaltemplates.HRISApproval = '1'  AND  idyc.`requestNo` = _requestNo AND idyc.`identityId` COLLATE utf8mb4_unicode_ci = _employeeId
    GROUP BY approvaltemplateoriginator.id
);




END IF;

-- DEPENDENT
IF pint_mode = 2 THEN

		SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`name`, 'no data') <> IFNULL(edh.`name`,'no data'), IFNULL(edc.`name`,'no data'), 'match') AS 'name'
			,IF(IFNULL(edc.`lastName`, 'no data') <> IFNULL(edh.`lastName`,'no data'), IFNULL(edc.`lastName`,'no data'), 'match') AS 'lastName'
			,IF(IFNULL(edc.`firstName`, 'no data') <> IFNULL(edh.`firstName`,'no data'), IFNULL(edc.`firstName`,'no data'), 'match') AS 'firstName'
			,IF(IFNULL(edc.`middleName`, 'no data') <> IFNULL(edh.`middleName`,'no data'), IFNULL(edc.`middleName`,'no data'), 'match') AS 'middleName'
			,IF(IFNULL(edc.`birthdate`, 'no data') <> IFNULL(edh.`birthdate`,'no data'), IFNULL(edc.`birthdate`,'no data'), 'match') AS 'birthdate'
			,IF(IFNULL(edc.`relationship`, 'no data') <> IFNULL(edh.`relationship`,'no data'), IFNULL(edc.`relationship`,'no data'), 'match') AS 'relationship'
			,IF(IFNULL(edc.`hmoDependent`, 'no data') <> IFNULL(edh.`hmoDependent`,'no data'), IFNULL(edc.`hmoDependent`,'no data'), 'match') AS 'hmoDependent'
			,IF(IFNULL(edc.`civilStatus`, 'no data') <> IFNULL(edh.`civilStatus`,'no data'), IFNULL(edc.`civilStatus`,'no data'), 'match') AS 'civilStatus'
			,IF(IFNULL(edc.`gender`, 'no data') <> IFNULL(edh.`gender`,'no data'), IFNULL(edc.`gender`,'no data'), 'match') AS 'gender'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeedependent_changelogs` edc
	LEFT JOIN `employeedependent_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT CODE
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- CONTACTS
IF pint_mode = 3 THEN
			SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`name`, 'no data') <> IFNULL(edh.`name`,'no data'), IFNULL(edc.`name`,'no data'), 'match') AS 'name'
			,IF(IFNULL(edc.`relationship`, 'no data') <> IFNULL(edh.`relationship`,'no data'), IFNULL(edc.`relationship`,'no data'), 'match') AS 'relationship'
			,IF(IFNULL(edc.`mobileNo`, 'no data') <> IFNULL(edh.`mobileNo`,'no data'), IFNULL(edc.`mobileNo`,'no data'), 'match') AS 'mobileNo'
			,IF(IFNULL(edc.`alt_mobileNo`, 'no data') <> IFNULL(edh.`alt_mobileNo`,'no data'), IFNULL(edc.`alt_mobileNo`,'no data'), 'match') AS 'alt_mobileNo'
			,IF(IFNULL(edc.`email`, 'no data') <> IFNULL(edh.`email`,'no data'), IFNULL(edc.`email`,'no data'), 'match') AS 'email'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeecontacts_changelogs` edc
	LEFT JOIN `employeecontacts_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT CODE
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- EDUCATIONS
IF pint_mode = 4 THEN
	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`from`, 'no data') <> IFNULL(edh.`from`,'no data'), IFNULL(edc.`from`,'no data'), 'match') AS 'from'
			,IF(IFNULL(edc.`to`, 'no data') <> IFNULL(edh.`to`,'no data'), IFNULL(edc.`to`,'no data'), 'match') AS 'to'
			,IF(IFNULL(edc.`school`, 'no data') <> IFNULL(edh.`school`,'no data'), IFNULL(edc.`school`,'no data'), 'match') AS 'school'
			,IF(IFNULL(edc.`degree`, 'no data') <> IFNULL(edh.`degree`,'no data'), IFNULL(edc.`degree`,'no data'), 'match') AS 'degree'
			,IF(IFNULL(edc.`major`, 'no data') <> IFNULL(edh.`major`,'no data'), IFNULL(edc.`major`,'no data'), 'match') AS 'major'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeeeducation_changelogs` edc
	LEFT JOIN `employeeeducation_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT CODE
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- EMPLOYMENT HISTORY
IF pint_mode = 5 THEN
	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`from`, 'no data') <> IFNULL(edh.`from`,'no data'), IFNULL(edc.`from`,'no data'), 'match') AS 'from'
			,IF(IFNULL(edc.`to`, 'no data') <> IFNULL(edh.`to`,'no data'), IFNULL(edc.`to`,'no data'), 'match') AS 'to'
			,IF(IFNULL(edc.`company`, 'no data') <> IFNULL(edh.`company`,'no data'), IFNULL(edc.`company`,'no data'), 'match') AS 'company'
			,IF(IFNULL(edc.`position`, 'no data') <> IFNULL(edh.`position`,'no data'), IFNULL(edc.`position`,'no data'), 'match') AS 'position'
			,IF(IFNULL(edc.`rate`, 'no data') <> IFNULL(edh.`rate`,'no data'), IFNULL(edc.`rate`,'no data'), 'match') AS 'rate'
			,IF(IFNULL(edc.`tinNo`, 'no data') <> IFNULL(edh.`tinNo`,'no data'), IFNULL(edc.`tinNo`,'no data'), 'match') AS 'tinNo'
			,IF(IFNULL(edc.`address`, 'no data') <> IFNULL(edh.`address`,'no data'), IFNULL(edc.`address`,'no data'), 'match') AS 'address'
			,IF(IFNULL(edc.`zipCode`, 'no data') <> IFNULL(edh.`zipCode`,'no data'), IFNULL(edc.`zipCode`,'no data'), 'match') AS 'zipCode'
			,IF(IFNULL(edc.`taxableCompensation`, 'no data') <> IFNULL(edh.`taxableCompensation`,'no data'), IFNULL(edc.`taxableCompensation`,'no data'), 'match') AS 'taxableCompensation'
			,IF(IFNULL(edc.`amountOfTaxes`, 'no data') <> IFNULL(edh.`amountOfTaxes`,'no data'), IFNULL(edc.`amountOfTaxes`,'no data'), 'match') AS 'amountOfTaxes'
			,IF(IFNULL(edc.`nonTaxableCompensation`, 'no data') <> IFNULL(edh.`nonTaxableCompensation`,'no data'), IFNULL(edc.`nonTaxableCompensation`,'no data'), 'match') AS 'nonTaxableCompensation'
			,IF(IFNULL(edc.`prevGrossCompIncome`, 'no data') <> IFNULL(edh.`prevGrossCompIncome`,'no data'), IFNULL(edc.`prevGrossCompIncome`,'no data'), 'match') AS 'prevGrossCompIncome'
			,IF(IFNULL(edc.`prevNonTax13thMonthOtherBenefits`, 'no data') <> IFNULL(edh.`prevNonTax13thMonthOtherBenefits`,'no data'), IFNULL(edc.`prevNonTax13thMonthOtherBenefits`,'no data'), 'match') AS 'prevNonTax13thMonthOtherBenefits'
			,IF(IFNULL(edc.`prevNonTaxDeminimis`, 'no data') <> IFNULL(edh.`prevNonTaxDeminimis`,'no data'), IFNULL(edc.`prevNonTaxDeminimis`,'no data'), 'match') AS 'prevNonTaxDeminimis'
			,IF(IFNULL(edc.`prevNonTaxGovtContUnionDues`, 'no data') <> IFNULL(edh.`prevNonTaxGovtContUnionDues`,'no data'), IFNULL(edc.`prevNonTaxGovtContUnionDues`,'no data'), 'match') AS 'prevNonTaxGovtContUnionDues'
			,IF(IFNULL(edc.`prevNonTaxSalaries`, 'no data') <> IFNULL(edh.`prevNonTaxSalaries`,'no data'), IFNULL(edc.`prevNonTaxSalaries`,'no data'), 'match') AS 'prevNonTaxSalaries'
			,IF(IFNULL(edc.`prevNonTaxExemptIncome`, 'no data') <> IFNULL(edh.`prevNonTaxExemptIncome`,'no data'), IFNULL(edc.`prevNonTaxExemptIncome`,'no data'), 'match') AS 'prevNonTaxExemptIncome'
			,IF(IFNULL(edc.`prevTaxBasicSalary`, 'no data') <> IFNULL(edh.`prevTaxBasicSalary`,'no data'), IFNULL(edc.`prevTaxBasicSalary`,'no data'), 'match') AS 'prevTaxBasicSalary'
			,IF(IFNULL(edc.`prevTax13thMonthOtherBenefits`, 'no data') <> IFNULL(edh.`prevTax13thMonthOtherBenefits`,'no data'), IFNULL(edc.`prevTax13thMonthOtherBenefits`,'no data'), 'match') AS 'prevTax13thMonthOtherBenefits'
			,IF(IFNULL(edc.`prevTaxSalaries`, 'no data') <> IFNULL(edh.`prevTaxSalaries`,'no data'), IFNULL(edc.`prevTaxSalaries`,'no data'), 'match') AS 'prevTaxSalaries'
			,IF(IFNULL(edc.`prevTaxDue`, 'no data') <> IFNULL(edh.`prevTaxDue`,'no data'), IFNULL(edc.`prevTaxDue`,'no data'), 'match') AS 'prevTaxDue'
			,IF(IFNULL(edc.`prevNonTaxBasicSMW`, 'no data') <> IFNULL(edh.`prevNonTaxBasicSMW`,'no data'), IFNULL(edc.`prevNonTaxBasicSMW`,'no data'), 'match') AS 'prevNonTaxBasicSMW'
			,IF(IFNULL(edc.`prevNonTaxHolidayPay`, 'no data') <> IFNULL(edh.`prevNonTaxHolidayPay`,'no data'), IFNULL(edc.`prevNonTaxHolidayPay`,'no data'), 'match') AS 'prevNonTaxHolidayPay'
			,IF(IFNULL(edc.`prevNonTaxOvertimePay`, 'no data') <> IFNULL(edh.`prevNonTaxOvertimePay`,'no data'), IFNULL(edc.`prevNonTaxOvertimePay`,'no data'), 'match') AS 'prevNonTaxOvertimePay'
			,IF(IFNULL(edc.`prevNonTaxNightDiff`, 'no data') <> IFNULL(edh.`prevNonTaxNightDiff`,'no data'), IFNULL(edc.`prevNonTaxNightDiff`,'no data'), 'match') AS 'prevNonTaxNightDiff'
			,IF(IFNULL(edc.`prevNonTaxHazardPay`, 'no data') <> IFNULL(edh.`prevNonTaxHazardPay`,'no data'), IFNULL(edc.`prevNonTaxHazardPay`,'no data'), 'match') AS 'prevNonTaxHazardPay'
			,IF(IFNULL(edc.`reasonOfSeparation`, 'no data') <> IFNULL(edh.`reasonOfSeparation`,'no data'), IFNULL(edc.`reasonOfSeparation`,'no data'), 'match') AS 'reasonOfSeparation'
			,IF(IFNULL(edc.`empStatus`, 'no data') <> IFNULL(edh.`empStatus`,'no data'), IFNULL(edc.`empStatus`,'no data'), 'match') AS 'empStatus'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeeemployementhistory_changelogs` edc
	LEFT JOIN `employeeemployementhistory_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT CODE
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- LEAVE CREDIT
IF pint_mode = 6 THEN
	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`leaveCode`, 'no data') <> IFNULL(edh.`leaveCode`,'no data'), IFNULL(edc.`leaveCode`,'no data'), 'match') AS 'leaveCode'
			,IF(IFNULL(edc.`leaveBalance`, 'no data') <> IFNULL(edh.`leaveBalance`,'no data'), IFNULL(edc.`leaveBalance`,'no data'), 'match') AS 'leaveBalance'
			,IF(IFNULL(edc.`currentBalance`, 'no data') <> IFNULL(edh.`currentBalance`,'no data'), IFNULL(edc.`currentBalance`,'no data'), 'match') AS 'currentBalance'
			,IF(IFNULL(edc.`leaveCredit`, 'no data') <> IFNULL(edh.`leaveCredit`,'no data'), IFNULL(edc.`leaveCredit`,'no data'), 'match') AS 'leaveCredit'
			,IF(IFNULL(edc.`leavePrevious`, 'no data') <> IFNULL(edh.`leavePrevious`,'no data'), IFNULL(edc.`leavePrevious`,'no data'), 'match') AS 'leavePrevious'
			,IF(IFNULL(edc.`leaveAdvance`, 'no data') <> IFNULL(edh.`leaveAdvance`,'no data'), IFNULL(edc.`leaveAdvance`,'no data'), 'match') AS 'leaveAdvance'
			,IF(IFNULL(edc.`leaveAlloted`, 'no data') <> IFNULL(edh.`leaveAlloted`,'no data'), IFNULL(edc.`leaveAlloted`,'no data'), 'match') AS 'leaveAlloted'
			,IF(IFNULL(edc.`validUntil`, 'no data') <> IFNULL(edh.`validUntil`,'no data'), IFNULL(edc.`validUntil`,'no data'), 'match') AS 'validUntil'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeeleavebalances_changelogs` edc
	LEFT JOIN `employeeleavebalances_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT CODE
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- EARNINGS
IF pint_mode = 7 THEN	

	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`allowanceType`, 'no data') <> IFNULL(edh.`allowanceType`,'no data'), IFNULL(edc.`allowanceType`,'no data'), 'match') AS 'allowanceType'
			,IF(IFNULL(edc.`terms`, 'no data') <> IFNULL(edh.`terms`,'no data'), IFNULL(edc.`terms`,'no data'), 'match') AS 'terms'
			,IF(IFNULL(edc.`amount`, 'no data') <> IFNULL(edh.`amount`,'no data'), IFNULL(edc.`amount`,'no data'), 'match') AS 'amount'
			,IF(IFNULL(edc.`dateEffective`, 'no data') <> IFNULL(edh.`dateEffective`,'no data'), IFNULL(edc.`dateEffective`,'no data'), 'match') AS 'dateEffective'
			,IF(IFNULL(edc.`dateEnd`, 'no data') <> IFNULL(edh.`dateEnd`,'no data'), IFNULL(edc.`dateEnd`,'no data'), 'match') AS 'dateEnd'
			,IF(IFNULL(edc.`inputTax`, 'no data') <> IFNULL(edh.`inputTax`,'no data'), IFNULL(edc.`inputTax`,'no data'), 'match') AS 'inputTax'
			,IF(IFNULL(edc.`taxable`, 'no data') <> IFNULL(edh.`taxable`,'no data'), IFNULL(edc.`taxable`,'no data'), 'match') AS 'taxable'
			,IF(IFNULL(edc.`treshold`, 'no data') <> IFNULL(edh.`treshold`,'no data'), IFNULL(edc.`treshold`,'no data'), 'match') AS 'treshold'
			,IF(IFNULL(edc.`diminimiss`, 'no data') <> IFNULL(edh.`diminimiss`,'no data'), IFNULL(edc.`diminimiss`,'no data'), 'match') AS 'diminimiss'
			,IF(IFNULL(edc.`sss`, 'no data') <> IFNULL(edh.`sss`,'no data'), IFNULL(edc.`sss`,'no data'), 'match') AS 'sss'
			,IF(IFNULL(edc.`hdmf`, 'no data') <> IFNULL(edh.`hdmf`,'no data'), IFNULL(edc.`hdmf`,'no data'), 'match') AS 'hdmf'
			,IF(IFNULL(edc.`month13`, 'no data') <> IFNULL(edh.`month13`,'no data'), IFNULL(edc.`month13`,'no data'), 'match') AS 'month13'
			,IF(IFNULL(edc.`taxShield`, 'no data') <> IFNULL(edh.`taxShield`,'no data'), IFNULL(edc.`taxShield`,'no data'), 'match') AS 'taxShield'
			,IF(IFNULL(edc.`hold`, 'no data') <> IFNULL(edh.`hold`,'no data'), IFNULL(edc.`hold`,'no data'), 'match') AS 'hold'
			,IF(IFNULL(edc.`vatable`, 'no data') <> IFNULL(edh.`vatable`,'no data'), IFNULL(edc.`vatable`,'no data'), 'match') AS 'vatable'
			,IF(IFNULL(edc.`remarks`, 'no data') <> IFNULL(edh.`remarks`,'no data'), IFNULL(edc.`remarks`,'no data'), 'match') AS 'remarks'
			,IF(IFNULL(edc.`payrollperiod`, 'no data') <> IFNULL(edh.`payrollperiod`,'no data'), IFNULL(edc.`payrollperiod`,'no data'), 'match') AS 'payrollperiod'
			,IF(IFNULL(edc.`phic`, 'no data') <> IFNULL(edh.`phic`,'no data'), IFNULL(edc.`phic`,'no data'), 'match') AS 'phic'
			,IF(IFNULL(edc.`bonus`, 'no data') <> IFNULL(edh.`bonus`,'no data'), IFNULL(edc.`bonus`,'no data'), 'match') AS 'bonus'
			,IF(IFNULL(edc.`finalPay`, 'no data') <> IFNULL(edh.`finalPay`,'no data'), IFNULL(edc.`finalPay`,'no data'), 'match') AS 'finalPay'
			,IF(IFNULL(edc.`special_process`, 'no data') <> IFNULL(edh.`special_process`,'no data'), IFNULL(edc.`special_process`,'no data'), 'match') AS 'special_process'
			,IF(IFNULL(edc.`nonmonetized`, 'no data') <> IFNULL(edh.`nonmonetized`,'no data'), IFNULL(edc.`nonmonetized`,'no data'), 'match') AS 'nonmonetized'
			,IF(IFNULL(edc.`ea_status`, 'no data') <> IFNULL(edh.`ea_status`,'no data'), IFNULL(edc.`ea_status`,'no data'), 'match') AS 'ea_status'
			,IF(IFNULL(edc.`fringe_benefit`, 'no data') <> IFNULL(edh.`fringe_benefit`,'no data'), IFNULL(edc.`fringe_benefit`,'no data'), 'match') AS 'fringe_benefit'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeeallowances_changelogs` edc
	LEFT JOIN `employeeallowances_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- DEDUCTION
IF pint_mode = 8 THEN	

	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`deductionType`, 'no data') <> IFNULL(edh.`deductionType`,'no data'), IFNULL(edc.`deductionType`,'no data'), 'match') AS 'deductionType'
			,IF(IFNULL(edc.`terms`, 'no data') <> IFNULL(edh.`terms`,'no data'), IFNULL(edc.`terms`,'no data'), 'match') AS 'terms'
			,IF(IFNULL(edc.`amount`, 'no data') <> IFNULL(edh.`amount`,'no data'), IFNULL(edc.`amount`,'no data'), 'match') AS 'amount'
			,IF(IFNULL(edc.`balance`, 'no data') <> IFNULL(edh.`balance`,'no data'), IFNULL(edc.`balance`,'no data'), 'match') AS 'balance'
			,IF(IFNULL(edc.`dateEffective`, 'no data') <> IFNULL(edh.`dateEffective`,'no data'), IFNULL(edc.`dateEffective`,'no data'), 'match') AS 'dateEffective'
			,IF(IFNULL(edc.`dateEnd`, 'no data') <> IFNULL(edh.`dateEnd`,'no data'), IFNULL(edc.`dateEnd`,'no data'), 'match') AS 'dateEnd'
			,IF(IFNULL(edc.`principalAmount`, 'no data') <> IFNULL(edh.`principalAmount`,'no data'), IFNULL(edc.`principalAmount`,'no data'), 'match') AS 'principalAmount'
			,IF(IFNULL(edc.`interest`, 'no data') <> IFNULL(edh.`interest`,'no data'), IFNULL(edc.`interest`,'no data'), 'match') AS 'interest'
			,IF(IFNULL(edc.`advancePayment`, 'no data') <> IFNULL(edh.`advancePayment`,'no data'), IFNULL(edc.`advancePayment`,'no data'), 'match') AS 'advancePayment'
			,IF(IFNULL(edc.`referenceNumber`, 'no data') <> IFNULL(edh.`referenceNumber`,'no data'), IFNULL(edc.`referenceNumber`,'no data'), 'match') AS 'referenceNumber'
			,IF(IFNULL(edc.`hold`, 'no data') <> IFNULL(edh.`hold`,'no data'), IFNULL(edc.`hold`,'no data'), 'match') AS 'hold'
			,IF(IFNULL(edc.`recurring`, 'no data') <> IFNULL(edh.`recurring`,'no data'), IFNULL(edc.`recurring`,'no data'), 'match') AS 'recurring'
			,IF(IFNULL(edc.`loanDate`, 'no data') <> IFNULL(edh.`loanDate`,'no data'), IFNULL(edc.`loanDate`,'no data'), 'match') AS 'loanDate'
			,IF(IFNULL(edc.`loanAmount`, 'no data') <> IFNULL(edh.`loanAmount`,'no data'), IFNULL(edc.`loanAmount`,'no data'), 'match') AS 'loanAmount'
			,IF(IFNULL(edc.`remarks`, 'no data') <> IFNULL(edh.`remarks`,'no data'), IFNULL(edc.`remarks`,'no data'), 'match') AS 'remarks'
			,IF(IFNULL(edc.`finalPay`, 'no data') <> IFNULL(edh.`finalPay`,'no data'), IFNULL(edc.`finalPay`,'no data'), 'match') AS 'finalPay'
			,IF(IFNULL(edc.`hierarchy`, 'no data') <> IFNULL(edh.`hierarchy`,'no data'), IFNULL(edc.`hierarchy`,'no data'), 'match') AS 'hierarchy'
			,IF(IFNULL(edc.`mp2AccountNo`, 'no data') <> IFNULL(edh.`mp2AccountNo`,'no data'), IFNULL(edc.`mp2AccountNo`,'no data'), 'match') AS 'mp2AccountNo'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeedeductions_changelogs` edc
	LEFT JOIN `employeedeductions_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- BANK ACCOUNTS
IF pint_mode = 9 THEN

	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`bankAccountCode`, 'no data') <> IFNULL(edh.`bankAccountCode`,'no data'), IFNULL(edc.`bankAccountCode`,'no data'), 'match') AS 'bankAccountCode'
			,IF(IFNULL(edc.`accountNumber`, 'no data') <> IFNULL(edh.`accountNumber`,'no data'), IFNULL(edc.`accountNumber`,'no data'), 'match') AS 'accountNumber'
			,IF(IFNULL(edc.`accountType`, 'no data') <> IFNULL(edh.`accountType`,'no data'), IFNULL(edc.`accountType`,'no data'), 'match') AS 'accountType'
			,IF(IFNULL(edc.`percentage`, 'no data') <> IFNULL(edh.`percentage`,'no data'), IFNULL(edc.`percentage`,'no data'), 'match') AS 'percentage'
			,IF(IFNULL(edc.`status`, 'no data') <> IFNULL(edh.`status`,'no data'), IFNULL(edc.`status`,'no data'), 'match') AS 'status'
			,IF(IFNULL(edc.`fixedAmount`, 'no data') <> IFNULL(edh.`fixedAmount`,'no data'), IFNULL(edc.`fixedAmount`,'no data'), 'match') AS 'fixedAmount'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM`employeebankaccounts_changelogs` edc
	LEFT JOIN `employeebankaccounts_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;


-- ACCOUNTABILITY
IF pint_mode = 10 THEN
	SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`itemId`, 'no data') <> IFNULL(edh.`itemId`,'no data'), IFNULL(edc.`itemId`,'no data'), 'match') AS 'itemId'
			,IF(IFNULL(edc.`itemDescription`, 'no data') <> IFNULL(edh.`itemDescription`,'no data'), IFNULL(edc.`itemDescription`,'no data'), 'match') AS 'itemDescription'
			,IF(IFNULL(edc.`dateFrom`, 'no data') <> IFNULL(edh.`dateFrom`,'no data'), IFNULL(edc.`dateFrom`,'no data'), 'match') AS 'dateFrom'
			,IF(IFNULL(edc.`dateTo`, 'no data') <> IFNULL(edh.`dateTo`,'no data'), IFNULL(edc.`dateTo`,'no data'), 'match') AS 'dateTo'
			,IF(IFNULL(edc.`status`, 'no data') <> IFNULL(edh.`status`,'no data'), IFNULL(edc.`status`,'no data'), 'match') AS 'status'
			,IF(IFNULL(edc.`remarks`, 'no data') <> IFNULL(edh.`remarks`,'no data'), IFNULL(edc.`remarks`,'no data'), 'match') AS 'remarks'
			,IF(IFNULL(edc.`penaltyAmount`, 'no data') <> IFNULL(edh.`penaltyAmount`,'no data'), IFNULL(edc.`penaltyAmount`,'no data'), 'match') AS 'penaltyAmount'
			,IF(IFNULL(edc.`docFile`, 'no data') <> IFNULL(edh.`docFile`,'no data'), IFNULL(edc.`docFile`,'no data'), 'match') AS 'docFile'
		    ,edc.`requestNo` AS 'Request_No',
		    edc.`updateRequestedBy` AS 'Requested_By',
		    edc.`updateRequestDate` AS 'Request_Date',
		    idy.identityId
	FROM `employeeaccountability_changelogs` edc
	LEFT JOIN `employeeaccountability_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- MEDICAL RECORDS
IF pint_mode = 11 THEN
		SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`examDate`, 'no data') <> IFNULL(edh.`examDate`,'no data'), IFNULL(edc.`examDate`,'no data'), 'match') AS 'examDate'
			,IF(IFNULL(edc.`examType`, 'no data') <> IFNULL(edh.`examType`,'no data'), IFNULL(edc.`examType`,'no data'), 'match') AS 'examType'
			,IF(IFNULL(edc.`hospitalLabName`, 'no data') <> IFNULL(edh.`hospitalLabName`,'no data'), IFNULL(edc.`hospitalLabName`,'no data'), 'match') AS 'hospitalLabName'
			,IF(IFNULL(edc.`diagnosis`, 'no data') <> IFNULL(edh.`diagnosis`,'no data'), IFNULL(edc.`diagnosis`,'no data'), 'match') AS 'diagnosis'
			,IF(IFNULL(edc.`medicines`, 'no data') <> IFNULL(edh.`medicines`,'no data'), IFNULL(edc.`medicines`,'no data'), 'match') AS 'medicines'
			,IF(IFNULL(edc.`bloodType`, 'no data') <> IFNULL(edh.`bloodType`,'no data'), IFNULL(edc.`bloodType`,'no data'), 'match') AS 'bloodType'
			,IF(IFNULL(edc.`weight`, 'no data') <> IFNULL(edh.`weight`,'no data'), IFNULL(edc.`weight`,'no data'), 'match') AS 'weight'
			,IF(IFNULL(edc.`height`, 'no data') <> IFNULL(edh.`height`,'no data'), IFNULL(edc.`height`,'no data'), 'match') AS 'height'
			,IF(IFNULL(edc.`results`, 'no data') <> IFNULL(edh.`results`,'no data'), IFNULL(edc.`results`,'no data'), 'match') AS 'results'
			,IF(IFNULL(edc.`category`, 'no data') <> IFNULL(edh.`category`,'no data'), IFNULL(edc.`category`,'no data'), 'match') AS 'category'
			,IF(IFNULL(edc.`remarks`, 'no data') <> IFNULL(edh.`remarks`,'no data'), IFNULL(edc.`remarks`,'no data'), 'match') AS 'remarks'
			,IF(IFNULL(edc.`docFile`, 'no data') <> IFNULL(edh.`docFile`,'no data'), IFNULL(edc.`docFile`,'no data'), 'match') AS 'docFile'
		    ,edc.`requestNo` AS 'Request_No'
		    ,edc.`updateRequestedBy` AS 'Requested_By'
		    ,edc.`updateRequestDate` AS 'Request_Date'
		    ,idy.identityId
	FROM `employeemedicalrecords_changelogs` edc
	LEFT JOIN `employeemedicalrecords_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- TRAININGS ATTENDED
IF pint_mode = 12 THEN
		SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`from`, 'no data') <> IFNULL(edh.`from`,'no data'), IFNULL(edc.`from`,'no data'), 'match') AS 'from'
			,IF(IFNULL(edc.`to`, 'no data') <> IFNULL(edh.`to`,'no data'), IFNULL(edc.`to`,'no data'), 'match') AS 'to'
			,IF(IFNULL(edc.`description`, 'no data') <> IFNULL(edh.`description`,'no data'), IFNULL(edc.`description`,'no data'), 'match') AS 'description'
			,IF(IFNULL(edc.`places`, 'no data') <> IFNULL(edh.`places`,'no data'), IFNULL(edc.`places`,'no data'), 'match') AS 'places'
			,IF(IFNULL(edc.`docFile`, 'no data') <> IFNULL(edh.`docFile`,'no data'), IFNULL(edc.`docFile`,'no data'), 'match') AS 'docFile'
		    ,edc.`requestNo` AS 'Request_No'
		    ,edc.`updateRequestedBy` AS 'Requested_By'
		    ,edc.`updateRequestDate` AS 'Request_Date'
		    ,idy.identityId
	FROM `employeeseminarattended_changelogs` edc
	LEFT JOIN `employeeseminarattended_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- BIOMETRICS INFO
IF pint_mode = 13 THEN

		SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`machineId`, 'no data') <> IFNULL(edh.`machineId`, 'no data'),IFNULL(edc.`machineId`, 'no data'),'match') AS `machineId`
			,IF(IFNULL(edc.`bioId`, 'no data') <> IFNULL(edh.`bioId`,'no data'), IFNULL(edc.`bioId`,'no data'), 'match') AS 'bioId'
		    ,edc.`requestNo` AS 'Request_No'
		    ,edc.`updateRequestedBy` AS 'Requested_By'
		    ,edc.`updateRequestDate` AS 'Request_Date'
		    ,idy.identityId
	FROM `employeebiometrics_changelogs` edc
	LEFT JOIN `employeebiometrics_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

END IF;

-- EMPLOYEE MOVEMENT
IF pint_mode = 14 THEN

		SELECT edc.`lineId` AS 'Line_Id'
			,CONCAT(idy.`lastName`,', ',idy.`firstName`,' ',IFNULL(CONCAT(LEFT(idy.`middleName`,1),'.'),'')) AS 'Employee_Name'
			,IF(IFNULL(edc.`status`,'No Data') <> IFNULL(edh.`status`,'No Data'), IFNULL(edc.`status`,'No Data'), 'match') AS `status`
			,IF(IFNULL(edc.`costCode`,'No Data') <> IFNULL(edh.`costCode`,'No Data'), IFNULL(edc.`costCode`,'No Data'), 'match') AS `costCode`
			,IF(IFNULL(edc.`positionCode`,'No Data') <> IFNULL(edh.`positionCode`,'No Data'), IFNULL(edc.`positionCode`,'No Data'), 'match') AS `positionCode`
			,IF(IFNULL(edc.`jobCategoryCode`,'No Data') <> IFNULL(edh.`jobCategoryCode`,'No Data'), IFNULL(edc.`jobCategoryCode`,'No Data'), 'match') AS `jobCategoryCode`
			,IF(IFNULL(edc.`laborCode`,'No Data') <> IFNULL(edh.`laborCode`,'No Data'), IFNULL(edc.`laborCode`,'No Data'), 'match') AS `laborCode`
			,IF(IFNULL(edc.`scheduleType`,'No Data') <> IFNULL(edh.`scheduleType`,'No Data'), IFNULL(edc.`scheduleType`,'No Data'), 'match') AS `scheduleType`
			,IF(IFNULL(edc.`rate`,'No Data') <> IFNULL(edh.`rate`,'No Data'), IFNULL(edc.`rate`,'No Data'), 'match') AS `rate`
			,IF(IFNULL(edc.`allowance`,'No Data') <> IFNULL(edh.`allowance`,'No Data'), IFNULL(edc.`allowance`,'No Data'), 'match') AS `allowance`
			,IF(IFNULL(edc.`cola`,'No Data') <> IFNULL(edh.`cola`,'No Data'), IFNULL(edc.`cola`,'No Data'), 'match') AS `cola`
			,IF(IFNULL(edc.`currency`,'No Data') <> IFNULL(edh.`currency`,'No Data'), IFNULL(edc.`currency`,'No Data'), 'match') AS `currency`
			,IF(IFNULL(edc.`dateEffective`,'No Data') <> IFNULL(edh.`dateEffective`,'No Data'), IFNULL(edc.`dateEffective`,'No Data'), 'match') AS `dateEffective`
			,IF(IFNULL(edc.`dateEnd`,'No Data') <> IFNULL(edh.`dateEnd`,'No Data'), IFNULL(edc.`dateEnd`,'No Data'), 'match') AS `dateEnd`
			,IF(IFNULL(edc.`departmentCode`,'No Data') <> IFNULL(edh.`departmentCode`,'No Data'), IFNULL(edc.`departmentCode`,'No Data'), 'match') AS `departmentCode`
			,IF(IFNULL(edc.`divisionCode`,'No Data') <> IFNULL(edh.`divisionCode`,'No Data'), IFNULL(edc.`divisionCode`,'No Data'), 'match') AS `divisionCode`
			,IF(IFNULL(edc.`rateType`,'No Data') <> IFNULL(edh.`rateType`,'No Data'), IFNULL(edc.`rateType`,'No Data'), 'match') AS `rateType`
			,IF(IFNULL(edc.`salaryIncreasePercent`,'No Data') <> IFNULL(edh.`salaryIncreasePercent`,'No Data'), IFNULL(edc.`salaryIncreasePercent`,'No Data'), 'match') AS `salaryIncreasePercent`
			,IF(IFNULL(edc.`remarks`,'No Data') <> IFNULL(edh.`remarks`,'No Data'), IFNULL(edc.`remarks`,'No Data'), 'match') AS `remarks`
			,IF(IFNULL(edc.`vatRegistered`,'No Data') <> IFNULL(edh.`vatRegistered`,'No Data'), IFNULL(edc.`vatRegistered`,'No Data'), 'match') AS `vatRegistered`
			,IF(IFNULL(edc.`regionCode`,'No Data') <> IFNULL(edh.`regionCode`,'No Data'), IFNULL(edc.`regionCode`,'No Data'), 'match') AS `regionCode`
		    ,edc.`requestNo` AS 'Request_No'
		    ,edc.`updateRequestedBy` AS 'Requested_By'
		    ,edc.`updateRequestDate` AS 'Request_Date'
		    ,idy.identityId
	FROM `employeemovement_changelogs` edc
	LEFT JOIN `employeemovement_history` edh 
	    ON edc.code = edh.`code` 
	    AND edc.`lineId` = edh.`lineId` 
	    AND edc.`requestNo` = edh.`requestNo`
	LEFT JOIN identity idy 
	    ON idy.code = edc.`code`
	WHERE edc.`updateStatus` = 'P'
	AND edc.`code` IN 
	(
	    SELECT identity.code
	    FROM approvaltemplateoriginator
	    LEFT JOIN approvaltemplates ON
		approvaltemplateoriginator.code = approvaltemplates.code
	    LEFT JOIN approvaltemplatestages ON
		approvaltemplateoriginator.code = approvaltemplatestages.code
	    LEFT JOIN approvalstages ON
		approvaltemplatestages.stageCode = approvalstages.stageCode
	    LEFT JOIN approvalstagedetails ON
		approvalstagedetails.code = approvalstages.code
	    LEFT JOIN identity ON
		approvaltemplateoriginator.id = identity.identityId
	    LEFT JOIN payrollgroup ON
		identity.batchId = payrollgroup.payrollGroupCode
	    LEFT JOIN payrollconfiguration ON
		payrollgroup.payrollConfigurationCode = payrollconfiguration.payrollConfigurationCode
	    LEFT JOIN payrollperiod ON
		payrollconfiguration.paymentFrequency = 
		(
		    CASE 
			WHEN payrollperiod.PayrollPeriodType = 'Semi-Monthly' THEN 'SM' 
			WHEN payrollperiod.PayrollPeriodType = 'Monthly' THEN 'MO'
			WHEN payrollperiod.PayrollPeriodType = 'Weekly' THEN 'WK' 
		    END
		)
	    LEFT JOIN payrollperioddetails ON
		payrollperiod.code = payrollperioddetails.code
	    WHERE approvalstagedetails.id = _identityId
		AND approvaltemplates.HRISApproval = '1'
		-- AND edc.`requestNo` = _requestNo
		AND edc.`code` = (
		    SELECT `code`
		    FROM identity
		    WHERE identityId = _employeeId
		    LIMIT 1
		)
	      
	    GROUP BY identity.code
	);

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

-- DROP TABLE IF EXISTS tblJson; CREATE TABLE tblJson AS  SELECT r_data;


IF (pint_mode=1) THEN
-- CALL sp_portal_overtime_ext_allo_mapping(1,'{"username":"2518","date":"2026-07-11"}',@num,@msg); SELECT @msg
SET @r_data=JSON_UNQUOTE(r_data);
-- SET @r_data=(SELECT JSON_UNQUOTE(r_data) FROM tblJson); 
SELECT JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.username')),JSON_UNQUOTE(JSON_EXTRACT(@r_data, '$.date'))
INTO @username,@date;

-- SELECT 'JULY2028_SCHED' AS regSched,'07:00' AS dtrIn,'15:00' AS dtrOut;

SELECT shift AS regSched,timeIN AS dtrIn,timeOUT AS dtrOut
     -- ,employeeId,DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m-%d') as `date`
INTO @regSched,@start_time,@end_time
FROM `v_kiosk_dtr_per_cut_off`
WHERE employeeId=@username AND DATE_FORMAT(STR_TO_DATE(`date`, '%m/%d/%Y'), '%Y-%m-%d')=@date;



SELECT
    CASE
	WHEN TIMEDIFF(
	    STR_TO_DATE(@end_time, '%h:%i:%s %p'),
	    STR_TO_DATE(@start_time, '%h:%i:%s %p')
	) > '08:00:00'
	THEN SUBTIME(
	    TIMEDIFF(
		STR_TO_DATE(@end_time, '%h:%i:%s %p'),
		STR_TO_DATE(@start_time, '%h:%i:%s %p')
	    ),
	    '01:00:00'
	)
	ELSE TIMEDIFF(
	    STR_TO_DATE(@end_time, '%h:%i:%s %p'),
	    STR_TO_DATE(@start_time, '%h:%i:%s %p')
	)
    END -- INTO SUBTIME(@total_time, '08:00:00');
    INTO @total_time;
    
    SET @allHrs = @total_time;
    SET @total_time = SUBTIME(@total_time, '08:00:00');
    SET @otTotal = (250 + GREATEST(0, FLOOR(TIME_TO_SEC(@total_time) / 3600) - 3) * 50);

-- SELECT @regSched,@dtrIn,@timeOUT;

 SELECT @regSched AS regSched,@start_time AS dtrIn,@end_time AS dtrOut,@total_time AS totalTime,@otTotal AS otTotal,@allHrs AS allHrs;

-- M2504
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



-- CALL sp_requestattachments (0,0,'awdaw','{"srcDB":"mjci_land_corp"}',@num,@msg);SELECT @msg;
DELIMITER $$  
DROP PROCEDURE IF EXISTS `sp_requestattachments`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_requestattachments`( 
IN pint_mode INT,	 
IN r_appNo INT, 
IN r_document VARCHAR(30),     
IN r_files LONGTEXT, 
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

-- DROP TABLE IF EXISTS tmpJson; CREATE TABLE tmpJson AS SELECT r_files;

-- SET @db =  (SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_files),'$.srcDB')) FROM tmpJson);
SET @db =  IFNULL((SELECT JSON_UNQUOTE(JSON_EXTRACT(JSON_UNQUOTE(r_files),'$.srcDB'))),DATABASE());

SET @sql = CONCAT('SELECT * FROM `',@db,'`.`requestattachments`  WHERE appNo=',r_appNo,' AND document="',r_document,'"'  ); 
PREPARE stmt FROM @sql; EXECUTE stmt;  DEALLOCATE PREPARE stmt;


-- SELECT * FROM requestattachments  WHERE appNo=r_appNo AND document=r_document;

END$$
DELIMITER ;



-- SELECT fn_overtimeExtensionAllowanceDetails(1)
DELIMITER $$  
DROP FUNCTION IF EXISTS `fn_overtimeExtensionAllowanceDetails`$$ 
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_overtimeExtensionAllowanceDetails`(r_appNo INT
) RETURNS LONGTEXT CHARSET latin1
DETERMINISTIC
BEGIN
DECLARE result LONGTEXT DEFAULT '';
-- SELECT * FROM overtimeextensionallowance
SET result = (
SELECT JSON_OBJECT(
	  'otAppNo',otAppNo,
	  'regSched',regSched,
	  'actTimeIn',actTimeIn,
	  'actTimeOut',actTimeOut,
	  'totalTime',totalTime,
	  'otTotal',otTotal,
	  'totalAllowance',totalAllowance,
	  'attachmentContent',attachmentContent,
	  'attachmentFileName',attachmentFileName, 
	  'attachmentFilType',attachmentFilType, 
	  'isImage',(CASE WHEN attachmentFilType LIKE '%pdf%' THEN 0 ELSE 1 END)
	) AS otExtAllowDetails
 FROM overtimeextensionallowance
 WHERE otAppNo=r_appNo
 );

RETURN result; 

END$$ 
DELIMITER ;



DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_application_movement`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_application_movement`(
IN pint_mode INT,
IN switch INT,
IN rAppNo INT,
IN rDatabase VARCHAR(30), 
IN r_Opt TEXT,
OUT num INT,
OUT msg VARCHAR(300)
)
proc_start: BEGIN
-- CALL sp_application_movement(0,5,7,'manilajockey_v4_test','',@num,@msg); SELECT @msg
SET num=1;
SET msg='';

SET @switch = switch;
-- SELECT * FROM documentMaster
SET @appNo = rAppNo; 
SET @database = rDatabase; 
SET @document = (SELECT docVal FROM documentMaster WHERE dID = @switch);

/*
SET @switch = 5;
-- SELECT * FROM documentMaster
SET @appNo = 7; 
SET @database = 'manilajockey_v4_test'; 
SET @document = (SELECT docVal FROM documentMaster WHERE dID = @switch);
*/
SET @pNeedDB = 'manilajockey_v4_test,mjci_jockey_club,mjci_san_lazaro,mjci_land_corp,mjci_vertex_inc';
DROP TEMPORARY TABLE IF EXISTS tempAllstages;
SET @sql =CONCAT('CREATE TEMPORARY TABLE tempAllstages AS ',(SELECT GROUP_CONCAT(
CONCAT(
'
SELECT t1.`stageCode`,t1.stageName,t2.`id` AS authId,t2.`authorizer`,t2.`lineId`
      ,emailAddress
FROM `', REPLACE(NAME, '`', '``'), '`.`approvalstages` t1
LEFT JOIN  `', REPLACE(NAME, '`', '``'), '`.`approvalstagedetails`  t2 ON t1.`code`=t2.`code`
LEFT JOIN  `', REPLACE(NAME, '`', '``'), '`.`identity`  t3 ON t2.`id`=t3.`identityId`
 '
    )  SEPARATOR ' UNION ALL '
)
FROM `pf-common`.`databases`
 WHERE FIND_IN_SET(NAME, @pNeedDB) > 0
));
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;


-- SELECT *   FROM tempAllstages


SET @sql =  
CONCAT(
	'
	SELECT t1.*,',(SELECT fn_accross_db_mapping(102,'',@document,'t5')),'
	      ,CONCAT(IFNULL(firstname,"")," ",IFNULL(lastname,"")) AS fullName,t4.emailAddress AS emailAddress
	      ,(CASE WHEN t1.decision ="F" THEN 1 ELSE 0 END) AS isNextApprover
	      ,t3.stageCode,t3.stageName,t3.authorizer AS approverName ,t3.emailAddress AS approverEmail
	FROM `',@database,'`.`approval` t1
	LEFT JOIN `',@database,'`.`approvaltemplatestages` t2 ON t1.templateCode=t2.code
	LEFT JOIN tempAllstages t3 on t2.stageCode=t3.stageCode
	LEFT JOIN  `',@database, '`.`identity`  t4 ON t1.`id`=t4.`identityId`
	',(SELECT fn_accross_db_mapping(0,@database,@document,'t5')),'
	WHERE t1.appNo=',@appNo,' AND t1.document="',@document,'" 
	GROUP BY t1.appNo,t1.templateLineId
	 '
);  

--  SELECT @sql;
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- UPDATE identity SET emailAddress = 'onnix2559@gmail2.com'


END$$ 
DELIMITER ;



DELIMITER $$
DROP PROCEDURE IF EXISTS `sp_acknowledge_clearance`$$
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_acknowledge_clearance`(  
IN pint_mode INT,	
IN username VARCHAR(30), 
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN  
SET num = 0;
SET msg = 'Success';

IF pint_mode = 1 THEN
UPDATE clearanceform SET cfAcknowledgeTag = 1 WHERE cfID = username;

END IF;


END$$
DELIMITER ;


-- PROCEDURES

ALTER TABLE overtimeform ADD COLUMN IF NOT EXISTS otFrDate DATE DEFAULT NULL;
ALTER TABLE overtimeform ADD COLUMN IF NOT EXISTS `otToDate` DATE DEFAULT NULL;


CREATE TABLE IF NOT EXISTS cancelledApprovedRequest(
id BIGINT AUTO_INCREMENT,
`appNo` INT NOT NULL,
`document` VARCHAR(50) NOT NULL,
`remarks` VARCHAR(100) NOT NULL,
userId  VARCHAR(50) NOT NULL,
systemDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY  (id,`appNo`)
)ENGINE=MYISAM;




-- DROP TABLE IF EXISTS `clearanceform`; 
CREATE TABLE IF NOT EXISTS `clearanceform` (
`cfAppNo` INT(11) NOT NULL AUTO_INCREMENT,
`cfID` VARCHAR(20) DEFAULT NULL,
`cfDeptCode` VARCHAR(10) NOT NULL,
`cfRemarks` VARCHAR(100) DEFAULT NULL,
`cfStatus` VARCHAR(1) DEFAULT NULL,
`cfApprover` VARCHAR(20) DEFAULT NULL,
`cfApproverName` VARCHAR(75) DEFAULT NULL,
`cfClearanceItems` VARCHAR(200) DEFAULT NULL,
`cfApprovedDateTime` DATETIME DEFAULT NULL,
`cfDateCreated` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
`cfUserCreated` VARCHAR(20) DEFAULT NULL,
`cfDateModified` DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(),
`cfLastUserModified` VARCHAR(20) DEFAULT NULL,
`cfNotifSent` TINYINT(4) DEFAULT 0,
`cfApproverTag` VARCHAR(20) DEFAULT NULL,
`cfAcknowledgeTag` TINYINT(1) DEFAULT NULL,
PRIMARY KEY (`cfAppNo`)
) ENGINE=INNODB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;




-- DROP TABLE IF EXISTS `clearance_approvers`;
CREATE TABLE IF NOT EXISTS`clearance_approvers` (
`departmentCode` VARCHAR(25) DEFAULT NULL,
`approverId` VARCHAR(10) DEFAULT NULL,
`approverName` VARCHAR(100) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;




-- DROP TABLE IF EXISTS `clearance_informationheader`;
CREATE TABLE IF NOT EXISTS`clearance_informationheader` (
`itemName` VARCHAR(50) NOT NULL,
`itemNumber` INT(5) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;


-- DROP TABLE IF EXISTS `clearance_itemlist`;
CREATE TABLE IF NOT EXISTS`clearance_itemlist` (
`departmentCode` VARCHAR(20) DEFAULT NULL,
`itemName` VARCHAR(100) DEFAULT NULL
) ENGINE=INNODB DEFAULT CHARSET=latin1;



-- DROP TABLE IF EXISTS `clearance_signatories`;
CREATE TABLE  IF NOT EXISTS`clearance_signatories` (
`id` INT(10) NOT NULL,
`departmentCode` VARCHAR(50) DEFAULT NULL,
`signatoryId` VARCHAR(50) DEFAULT NULL,
`signatoryName` VARCHAR(100) DEFAULT NULL,
PRIMARY KEY (`id`)
) ENGINE=INNODB DEFAULT CHARSET=latin1;




-- DROP TABLE IF EXISTS `table_attachments`; 
CREATE TABLE  IF NOT EXISTS`table_attachments` (
`identityId` VARCHAR(50) NOT NULL,
`code` VARCHAR(50) NOT NULL,
`lineId` VARCHAR(50) NOT NULL,
`tableName` VARCHAR(100) DEFAULT NULL,
`attachement` VARCHAR(100) DEFAULT NULL,
`reason` VARCHAR(100) DEFAULT NULL,
`requestNo` VARCHAR(10) DEFAULT NULL
);



-- TABLES


DROP TABLE IF EXISTS v_portal_exists_date_appilcation; 
DROP VIEW IF EXISTS v_portal_exists_date_appilcation;
DELIMITER $$ 
CREATE VIEW `v_portal_exists_date_appilcation` AS 

	SELECT
	`leaveapplicationform`.`laAppNo`    AS `appNo`,
	`leaveapplicationform`.`laType`     AS `reason`,
	`leaveapplicationform`.`laDateFrom` AS `dateFrom`,
	`leaveapplicationform`.`laDateTo`   AS `dateTo`,
	`leaveapplicationform`.`laID`       AS `empID`,
	'LEAVE'                             AS `appType`
	FROM `leaveapplicationform`
	WHERE `leaveapplicationform`.`laStatus` <> 'D' 
	
	UNION ALL 
	
	SELECT
	`officialbusinessform`.`obAppNo`     AS `obAppNo`,
	`officialbusinessform`.`obReason`    AS `obReason`,
	`officialbusinessform`.`obDateFrom`  AS `obDateFrom`,
	`officialbusinessform`.`obDateTo`  AS `obDateTo`,
	`officialbusinessform`.`obID`        AS `obID`,
	'OB'                                 AS `appType`
	FROM `officialbusinessform`
	WHERE `officialbusinessform`.`obStatus` <> 'D' 
	
	UNION ALL 
	
	SELECT
	`overtimeform`.`otAppNo`              AS `otAppNo`,
	`overtimeform`.`otReason`             AS `otReason`,
	`overtimeform`.`otFrDate`             AS `otFrDate`,
	`overtimeform`.`otToDate`             AS `otToDate`,
	`overtimeform`.`otID`                 AS `otID`,
	'OVERTIME'                            AS `appType`
	FROM `overtimeform`
	WHERE `overtimeform`.`otStatus` <> 'D'
	
	$$  
DELIMITER ;


-- VIEWS

DROP FUNCTION IF EXISTS fn_check_used_dates;  
DELIMITER $$  
CREATE FUNCTION fn_check_used_dates (
		pint_mode INT,
		txtJSON LONGTEXT
		)
RETURNS VARCHAR(200)
DETERMINISTIC
BEGIN
DECLARE result VARCHAR(200) DEFAULT '';
SET @remarks = '';
-- SELECT * FROM documentMaster


IF (pint_mode=0) THEN -- overtime
-- SELECT fn_check_used_dates(1,'{"otFrom" : "2024-12-16","otTo" : "2024-12-16","otID" : "0601200035"}') as result;
SET @otFrom = (SELECT  JSON_UNQUOTE(JSON_EXTRACT(txtJSON, '$.otFrom')) );
SET @otTo = (SELECT  JSON_UNQUOTE(JSON_EXTRACT(txtJSON, '$.otTo')));
SET @otID = (SELECT  JSON_UNQUOTE(JSON_EXTRACT(txtJSON, '$.otID')));
SET @otDates = CONCAT(@otFrom,' to ',@otTo);

-- CHECKING FOR LEAVE
SET @remarks = (SELECT CONCAT('Sorry, ',@otDates,' is already filed in LEAVE as ',laType,' with application ID:',laAppNo) 
		FROM leaveapplicationform 
		WHERE laID = @otID 
			AND (@otFrom BETWEEN laDateFrom AND ladateTo OR @otTo BETWEEN laDateFrom AND ladateTo)  
			AND laStatus NOT IN ('D','C') LIMIT 1); 
			
-- CHECKING FOR OB
IF (IFNULL(@remarks,'')='') THEN
SET @remarks = (SELECT CONCAT('Sorry, ',@otDates,' is already filed in OB due to ',obReason,' with application ID:',obAppNo) 
		FROM officialbusinessform 
		WHERE obID = @otID 
			AND obDateFrom  BETWEEN @otFrom AND @otTo
			AND obStatus NOT IN ('D','C') 
			LIMIT 1);   
	
END IF;

SET result=IFNULL(@remarks,'');
END IF;


IF (pint_mode=1) THEN -- Time Entry 
-- SELECT fn_check_used_dates(1,'{"taDate" : "2024-12-16","teID" : "0601200035"}') as result; 

SET @teDate = (SELECT  JSON_UNQUOTE(JSON_EXTRACT(txtJSON, '$.teDate')) );
SET @teID = (SELECT  JSON_UNQUOTE(JSON_EXTRACT(txtJSON, '$.teID')) );

SET @remarks = (SELECT CONCAT('Sorry, ',@teDate,' is already filed in ',appType,' with application ID:',appNo) FROM v_portal_exists_date_appilcation WHERE empID = @teID AND (@laDate BETWEEN dateFrom AND dateTo)  LIMIT 1); 
SET result=IFNULL(@remarks,'');


END IF;


RETURN result;

END$$ 
DELIMITER ;




-- SELECT fn_offset_ot_id('From: 2024-08-30 07:42:00 To: 2024-08-30 20:15:00','0601200008');
DROP FUNCTION IF EXISTS fn_offset_ot_id; 
DELIMITER $$  
CREATE FUNCTION fn_offset_ot_id (osReference VARCHAR(150),osID VARCHAR(30))
RETURNS VARCHAR(30)
DETERMINISTIC
BEGIN
DECLARE result VARCHAR(30) DEFAULT '';

-- SET @osReference = 'From: 2024-08-30 07:42:00 To: 2024-08-30 20:15:00';
-- SET @osID = '0601200008';
SET @result = '';
SET @osReference = osReference;
SET @osID = osID;

SET @from = DATE(
STR_TO_DATE(
	SUBSTRING_INDEX(SUBSTRING_INDEX(@osReference, 'To:', 1), 'From: ', -1),
	'%Y-%m-%d %H:%i:%s'
)
);


SELECT CONCAT('Yes : ',otAppNo)
FROM overtimeform
WHERE otID = @osID
	AND otDate = @from
	AND otStatus NOT IN ('C','D')
INTO @result
	;
	
	SET result = @result;

RETURN result;

END$$ 
DELIMITER ;

-- CALL sp_dropdown_fill(3,0,@num,@msg); SELECT @msg
DELIMITER $$ 
DROP PROCEDURE IF EXISTS `sp_dropdown_fill`$$ 
CREATE DEFINER=`root`@`localhost` PROCEDURE `sp_dropdown_fill`(
IN pint_mode INT,
IN opt_param VARCHAR(50),
OUT num INT,
OUT msg VARCHAR(300)
)
BEGIN 
SET num = 0;
SET msg = 'Success';

IF pint_mode = 0 THEN /*OVERTIME*/
	
	SELECT '' AS val,'' AS lbl UNION ALL 
	SELECT 'OT' AS val,'Overtime' AS lbl UNION ALL 
	SELECT 'UT' AS val,'Under Time' AS lbl;
	
END IF;


IF pint_mode = 1 THEN /*LEAVE SCHEDULE*/
	
	SELECT 'Whole Day (1.0)' AS txt,'1.00' AS val UNION ALL
	SELECT 'Half Day (0.5)' AS txt,'0.50' AS val;
	
END IF;


IF pint_mode = 2 THEN /*INT OUT*/
	
SELECT '' AS val UNION ALL
	SELECT 'IN' AS val UNION ALL
	SELECT 'OUT' AS val;
	
END IF;

IF pint_mode = 3 THEN /*DAYS INT OUT*/
	
SELECT '' AS val,'' AS txt UNION ALL
SELECT 'Days' AS val,'Days' AS txt UNION ALL
	SELECT 'In' AS val,'From Time' AS txt UNION ALL
	SELECT 'Out' AS val,'To Time' AS txt;
	
END IF;

IF pint_mode = 4 THEN /*STATUS*/
	
SELECT *
FROM statusMaster;
	
END IF;


IF pint_mode = 5 THEN /*DEPARTMENT*/

SELECT *
FROM(
	SELECT '' AS departmentName,'' AS departmentCode UNION ALL
	SELECT departmentName,departmentCode
	FROM department
	)t1
ORDER BY departmentName,departmentCode;

END IF;


IF pint_mode = 6 THEN /*DTR IN OUT*/
	
SELECT '' AS val,'Select DTR Type' AS txt UNION ALL
	SELECT 'I' AS val,'IN' AS txt UNION ALL
	SELECT 'O' AS val,'OUT' AS txt;
	
END IF;
	
END$$ 
DELIMITER ;

-- SELECT fn_validate_leave_filing('2026-08-12',DATE(NOW()),'timeentry'); 
DELIMITER $$
DROP FUNCTION IF EXISTS fn_validate_leave_filing$$
CREATE FUNCTION fn_validate_leave_filing(
pLeaveDate DATE,
pFileDate DATE,
application VARCHAR(50)
)
RETURNS VARCHAR(10)
DETERMINISTIC
BEGIN
DECLARE daysAfter INT DEFAULT 2;
DECLARE daysBefore INT DEFAULT 2;
DECLARE workDays INT DEFAULT 0;
DECLARE d DATE;

SET daysAfter = (
	SELECT days_after
	FROM filing_window_matrix
	WHERE app_type = application
);

SET daysBefore = (
	SELECT days_before
	FROM filing_window_matrix
	WHERE app_type = application
);

-- ============================================
-- 0 = NO VALIDATION
-- ============================================
IF daysAfter = 0 AND daysBefore = 0 THEN
	RETURN 'VALID';
END IF;

-- ============================================
-- FILED AFTER LEAVE
-- ============================================
IF pFileDate > pLeaveDate THEN

	-- No after-leave validation
	IF daysAfter = 0 THEN
		RETURN 'VALID';
	END IF;

	SET d = DATE_ADD(pLeaveDate, INTERVAL 1 DAY);

	WHILE d <= pFileDate DO
		IF DAYOFWEEK(d) NOT IN (1, 7) THEN
			SET workDays = workDays + 1;
		END IF;

		SET d = DATE_ADD(d, INTERVAL 1 DAY);
	END WHILE;

	IF workDays <= daysAfter THEN
		RETURN 'VALID';
	ELSE
		RETURN 'INVALID';
	END IF;

-- ============================================
-- FILED BEFORE LEAVE
-- ============================================
ELSEIF pFileDate < pLeaveDate THEN

	-- No before-leave validation
	IF daysBefore = 0 THEN
		RETURN 'VALID';
	END IF;

	SET d = DATE_ADD(pFileDate, INTERVAL 1 DAY);

	WHILE d <= pLeaveDate DO
		IF DAYOFWEEK(d) NOT IN (1, 7) THEN
			SET workDays = workDays + 1;
		END IF;

		SET d = DATE_ADD(d, INTERVAL 1 DAY);
	END WHILE;

	IF workDays >= daysBefore THEN
		RETURN 'VALID';
	ELSE
		RETURN 'INVALID';
	END IF;

-- ============================================
-- SAME DATE
-- ============================================
ELSE
	RETURN 'INVALID';
END IF;

END$$ 
DELIMITER ;



-- SELECT fn_accross_db_mapping(6,'manilajockey_v4_test','leave',''); 
DELIMITER $$ 
DROP FUNCTION IF EXISTS `fn_accross_db_mapping`$$
CREATE DEFINER=`root`@`localhost` FUNCTION `fn_accross_db_mapping`(pMode INT,
pDB VARCHAR(100),
pApplication VARCHAR(50),
pOptions VARCHAR(50)
) RETURNS TEXT CHARSET latin1
DETERMINISTIC
BEGIN
DECLARE result TEXT DEFAULT ''; 
-- SELECT fn_accross_db_mapping(102,'manilajockey_v4_test','timeentry','t5')
-- 0 APPLICATION FORMS
IF (pMode=0) THEN	
SET result =(CASE 
		  WHEN pApplication='overtime' THEN CONCAT('LEFT JOIN `',pDB,'`.`overtimeform` ',pOptions,' on t1.appNo=',pOptions,'.otAppNo')
		  WHEN pApplication='leave' THEN CONCAT('LEFT JOIN `',pDB,'`.`leaveapplicationform` ',pOptions,' on t1.appNo=',pOptions,'.laAppNo')
		  WHEN pApplication='timeadjustment' THEN CONCAT('LEFT JOIN `',pDB,'`.`timeadjustmentform` ',pOptions,' on t1.appNo=',pOptions,'.taAppNo')
		  WHEN pApplication='officialbusiness' THEN CONCAT('LEFT JOIN `',pDB,'`.`officialbusinessform` ',pOptions,' on t1.appNo=',pOptions,'.obAppNo')
		  WHEN pApplication='offset' THEN CONCAT('LEFT JOIN `',pDB,'`.`offsetform` ',pOptions,' on t1.appNo=',pOptions,'.osAppNo')
		  WHEN pApplication='timeentry' THEN CONCAT('LEFT JOIN `',pDB,'`.`timeentryform` ',pOptions,' on t1.appNo=',pOptions,'.teAppNo')
		  WHEN pApplication='schedulechange' THEN CONCAT('LEFT JOIN `',pDB,'`.`schedulechange` t2 on t1.appNo=',pOptions,'.scAppNo')
		  WHEN pApplication='hrdcert' THEN CONCAT('LEFT JOIN `',pDB,'`.`hrdcertificate` ',pOptions,' on t1.appNo=',pOptions,'.appNo') 
	 END);
END IF;



IF (pMode=1000) THEN
SET result = CONCAT('
	LEFT JOIN (
		SELECT MAX(templateLineId)AS templateLineId,appNo,document
		FROM `',pDB,'`.`approval` 
		WHERE (CASE WHEN templateLineId=1 AND approver IS NULL THEN id ELSE approver END) IS NOT NULL
		GROUP BY appNo,document 
	     ) t3 ON t1.appNo = t3.appNo AND t3.document=t1.document AND t1.templateLineId = t3.templateLineId
	   ');
END IF;	 

-- 1 approvaltemplatestages
IF (pMode=1) THEN 
SET result =CONCAT('LEFT JOIN `',pDB,'`.`approvaltemplatestages` auth ON t1.`templateCode`=auth.`code` AND t1.`templateLineId`=auth.`lineId`' );
END IF;

-- 2 approvalstages
IF (pMode=2) THEN 
SET result =CONCAT('LEFT JOIN `',pDB,'`.`approvalstages` stgs ON auth.`stageCode`=stgs.`stageCode`' );
END IF;
 
-- 3 approvalstagedetails
IF (pMode=3) THEN 
SET result =CONCAT('LEFT JOIN `',pDB,'`.`approvalstagedetails` stdtls ON stgs.`code`=stdtls.`code` -- AND stdtls.`lineId`= t1.`templateLineId`' );
END IF;


-- 4 statusMaster
IF (pMode=4) THEN 
SET result =CONCAT('LEFT JOIN `',pDB,'`.`statusMaster` t4 ON ' );
END IF;


-- 5 approvalstagedetails
IF (pMode=5) THEN 
SET result =CONCAT('LEFT JOIN `',pDB,'`.`appLinkStatus` t5 ON ' );
END IF;


-- 6 appStatus
IF (pMode=6) THEN 
SET @document = pApplication;
SET result=(CASE 
  WHEN @document='overtime' THEN 't2.otStatus'
  WHEN @document='leave' THEN 't2.laStatus'
  WHEN @document='timeadjustment' THEN 't2.taStatus'
  WHEN @document='officialbusiness' THEN 't2.obStatus'
  WHEN @document='offset' THEN 't2.osStatus'
  WHEN @document='timeentry' THEN 't2.teStatus' 
  WHEN @document='schedulechange' THEN 't2.scStatus' 
  WHEN @document='hrdcert' THEN 't2.status' 
END);
END IF;




-- 7 Date Filter
IF (pMode=7) THEN 
SET @document = pApplication;
SET result=(CASE 
	  WHEN @document='overtime' THEN 't2.otAppDate'
	  WHEN @document='leave' THEN 't2.laAppDate'
	  WHEN @document='timeadjustment' THEN  't2.taAppDate'
	  WHEN @document='officialbusiness' THEN 't2.obAppDate'
	  WHEN @document='offset' THEN 't2.osAppDate'
	  WHEN @document='timeentry' THEN 't2.teAppDate'
	  WHEN @document='schedulechange' THEN 't2.scAppDate'
	  WHEN @document='hrdcert' THEN 't2.requestDate'
      END);
END IF;


-- appDates
IF (pMode=8) THEN 
SET @document = pApplication;
SET result=(CASE 
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
END IF;


-- 7 Date Filter
IF (pMode=9) THEN 
SET @document = pApplication;
SET result=(CASE 
	  WHEN @document='overtime' THEN 't2.otCosCenter'
	  WHEN @document='leave' THEN 't2.laCosCenter'
	  WHEN @document='timeadjustment' THEN 't2.taCosCenter'
	  WHEN @document='officialbusiness' THEN 't2.obCosCenter'
	  WHEN @document='offset' THEN 't2.osCosCenter'
	  WHEN @document='timeentry' THEN 't2.teCosCenter' 
	  WHEN @document='schedulechange' THEN 't2.scCosCenter' 
	  WHEN @document='hrdcert' THEN 't2.costCenter' 
      END);
END IF;
-- ================================= FINAL

-- 100 Date Filter 2
IF (pMode=100) THEN 
SET @document = pApplication;
SET result=(CASE 
	  WHEN @document='overtime' THEN 't1.otAppDate'
	  WHEN @document='leave' THEN 't1.laAppDate'
	  WHEN @document='timeadjustment' THEN  't1.taAppDate'
	  WHEN @document='officialbusiness' THEN 't1.obAppDate'
	  WHEN @document='offset' THEN 't1.osAppDate'
	  WHEN @document='timeentry' THEN 't1.teAppDate'
	  WHEN @document='schedulechange' THEN 't2.scAppDate'
	  WHEN @document='hrdcert' THEN 't1.requestDate'
      END);
END IF;


-- 6 appStatus 2
IF (pMode=101) THEN 
SET @document = pApplication;
SET result=(CASE 
  WHEN @document='overtime' THEN 't1.otStatus'
  WHEN @document='leave' THEN 't1.laStatus'
  WHEN @document='timeadjustment' THEN 't1.taStatus'
  WHEN @document='officialbusiness' THEN 't1.obStatus'
  WHEN @document='offset' THEN 't1.osStatus'
  WHEN @document='timeentry' THEN 't1.teStatus' 
  WHEN @document='schedulechange' THEN 't1.scStatus' 
  WHEN @document='hrdcert' THEN 't1.status' 
END);
END IF;


-- app Dates
IF (pMode=102) THEN 
SET @document = pApplication;
SET result=(CASE 
	  WHEN @document='overtime' THEN CONCAT('',pOptions,'.otAppDate AS appDate')
	  WHEN @document='leave' THEN CONCAT('',pOptions,'.laAppDate AS appDate')
	  WHEN @document='timeadjustment' THEN  CONCAT('',pOptions,'.taAppDate AS appDate')
	  WHEN @document='officialbusiness' THEN CONCAT('',pOptions,'.obAppDate AS appDate')
	  WHEN @document='offset' THEN CONCAT('',pOptions,'.osAppDate AS appDate')
	  WHEN @document='timeentry' THEN CONCAT('',pOptions,'.teAppDate AS appDate')
	  WHEN @document='schedulechange' THEN CONCAT('',pOptions,'.scAppDate AS appDate')
	  WHEN @document='hrdcert' THEN CONCAT('',pOptions,'.requestDate AS appDate')
      END);
END IF;

RETURN result;

END$$
DELIMITER ;





-- FUNCTIONS


DELIMITER $$ 
DROP TRIGGER IF EXISTS `after_useraudittrails_insert`$$ 
CREATE TRIGGER `after_useraudittrails_insert`
AFTER INSERT ON `userAuditTrails`
FOR EACH ROW
BEGIN 

INSERT INTO activity_logs (username,email,user_type,action_type,description,module,ip_address,user_agent,`status`)
VALUES (NEW.identityId
,IFNULL((SELECT emailAddress FROM identity WHERE identityId=NEW.identityId),'')
,'user'
,(CASE  
	WHEN LOWER(NEW.activity) LIKE '%login%' THEN 'login'
	WHEN LOWER(NEW.activity) LIKE '%load%' THEN 'retrive'
	WHEN LOWER(NEW.activity) LIKE '%view%' THEN 'retrive'
	WHEN LOWER(NEW.activity) LIKE '%logout%' THEN 'logout'
	WHEN LOWER(NEW.activity) LIKE '%send request%' THEN 'insert'
	WHEN LOWER(NEW.activity) LIKE '%post%' THEN 'insert'
	WHEN LOWER(NEW.activity) LIKE '%approval%' THEN 'update'
	WHEN LOWER(NEW.activity) LIKE '%change password%' THEN 'update'
	WHEN LOWER(NEW.activity) LIKE '%send email%' THEN 'email'
	ELSE CONCAT('unkown ->',NEW.activity) 
	END)
,NEW.details
,NEW.activity
,JSON_UNQUOTE(JSON_EXTRACT(NEW.machainDetails,'$[0].ip'))
,JSON_UNQUOTE(JSON_EXTRACT(NEW.machainDetails,'$[0].browser'))
,LOWER(NEW.status)
);

END;
$$ 
DELIMITER ;




