# Update from 1-3.2 to 1-6.0

CREATE TABLE  IF NOT EXISTS `update_history` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Description` varchar(100) NULL,
  `Footprint` varchar(25) NULL,
  `DteRelease` datetime NULL,
  `DteInstall` datetime NULL
);

INSERT IGNORE INTO `update_history` (`Footprint`, `Description`, `DteRelease`, `DteInstall`)
VALUES ('------------------------------', 'Version 1.6.0', '2017-05-01', NULL);

