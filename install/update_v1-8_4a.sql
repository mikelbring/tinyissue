SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

INSERT INTO activity (id, description,activity) VALUES (9, 'User starts or stop following issue or project', 'Follow');

DROP TABLE IF EXISTS `following`;
CREATE TABLE `following` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `issue_id` int(11) NOT NULL,
  `project` tinyint(2) NOT NULL DEFAULT 0,
  `attached` tinyint(2) NOT NULL DEFAULT 1,
  `tags` tinyint(2) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
