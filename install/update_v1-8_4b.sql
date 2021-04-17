SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

DELETE FROM activity WHERE id =9;
INSERT INTO activity (id, description,activity) VALUES (9, 'User starts or stop following issue or project', 'Follow');

#--Create the update history system table
CREATE TABLE IF NOT EXISTS `update_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Footprint` varchar(25) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `DteRelease` datetime DEFAULT NULL,
  `DteInstall` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
#--


CREATE TABLE IF NOT EXISTS `following` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `project` tinyint(2) NOT NULL DEFAULT 0,
  `attached` tinyint(2) NOT NULL DEFAULT 1,
  `tags` tinyint(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
