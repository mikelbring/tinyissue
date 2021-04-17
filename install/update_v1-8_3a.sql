INSERT INTO activity (id, description,activity) VALUES (8, 'Move an issue from project A to project B', 'Changed issue`s project');

CREATE TABLE `update_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `Footprint` varchar(25) DEFAULT NULL,
  `Description` varchar(100) DEFAULT NULL,
  `DteRelease` datetime DEFAULT NULL,
  `DteInstall` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

