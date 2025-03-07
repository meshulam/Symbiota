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
