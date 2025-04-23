-- schema changes specific to bell atlas, to be applied after 3.x patches

-- make uploadspectemp column types consistent with omoccurrences
ALTER TABLE `uploadspectemp` 
  CHANGE COLUMN `labelProject` `labelProject` VARCHAR(250) DEFAULT NULL,
  CHANGE COLUMN `taxonRemarks` `taxonRemarks` text,
  CHANGE COLUMN `identificationReferences` `identificationReferences` text,
  CHANGE COLUMN `identificationRemarks` `identificationRemarks` text,
  CHANGE COLUMN `recordNumber` `recordNumber` varchar(45) DEFAULT NULL COMMENT 'Collector Number',
  CHANGE COLUMN `eventID` `eventID` varchar(150) DEFAULT NULL,
  CHANGE COLUMN `waterBody` `waterBody` varchar(75) DEFAULT NULL,
  CHANGE COLUMN `georeferenceRemarks` `georeferenceRemarks` varchar(500) DEFAULT NULL;


-- 2025-04-23 Add text preparedBy column, replaces preparedByUid
ALTER TABLE `ommaterialsample` ADD COLUMN `preparedBy` VARCHAR(45) DEFAULT NULL AFTER `preparedByUid`;
