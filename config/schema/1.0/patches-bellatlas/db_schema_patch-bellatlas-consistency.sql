-- Changes to bring Bell Atlas schema more closely in line with upstream Symbiota

ALTER TABLE `agents`
  CHANGE COLUMN `guid` `guid` varchar(150) DEFAULT NULL;

ALTER TABLE `omoccurrences`
  DROP COLUMN `preparedBy`;

ALTER TABLE `taxa`
  DROP COLUMN `KingdomID`;

ALTER TABLE `uploadspectemp`
  CHANGE COLUMN `LatestDateCollected` `latestDateCollected` date DEFAULT NULL;

DROP TABLE `x_omoccurloans`;

ALTER TABLE `omexsiccatititles`
  CHANGE COLUMN `sourceIdentifier` `sourceIdentifier` varchar(150) DEFAULT NULL;

SET sql_mode = '';
UPDATE omoccurdeterminations SET dateIdentifiedInterpreted = NULL WHERE dateIdentifiedInterpreted = '0000-00-00';


UPDATE omoccurrences SET eventDate = NULL WHERE YEAR(eventDate) < 1000;
UPDATE omoccurrences SET eventDate = CONCAT(YEAR(eventDate), '-01-01') WHERE MONTH(eventDate) = 0;
UPDATE omoccurrences SET eventDate = CONCAT(YEAR(eventDate), '-', MONTH(eventDate), '-01') WHERE DAY(eventDate) = 0;

UPDATE omoccurdeterminations SET initialTimestamp = '2000-01-01 00:00:00' WHERE YEAR(initialTimestamp) < 1000;
