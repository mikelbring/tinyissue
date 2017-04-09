ALTER TABLE `projects`  ADD `default_assignee` bigint(20)  default '1' AFTER `updated_at`;
ALTER TABLE `projects_issues` ADD `weight` bigint(20) NOT NULL DEFAULT '1' AFTER `status`;
ALTER TABLE `projects_issues` ADD `duration` smallint(3) NOT NULL DEFAULT '30' AFTER `created_at`;
ALTER TABLE `projects_issues` DROP `created_at`;
ALTER TABLE `projects_issues` DROP datetime;
ALTER TABLE `users` CHANGE `language` `language` VARCHAR( 5 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'en';

#CREATE issue-tag relationship table
CREATE TABLE `projects_issues_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issue_tag` (`issue_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#CREATE Projects Links Table
CREATE TABLE `projects_links` (
  `id_link` int(11) NOT NULL AUTO_INCREMENT,
  `id_project` int(11) NOT NULL DEFAULT '1',
  `category` enum('dev','git','prod') NOT NULL DEFAULT 'dev',
  `link` varchar(100) NOT NULL,
  `created` date NOT NULL,
  `desactivated` date DEFAULT NULL,
  PRIMARY KEY (`id_link`),
  KEY `id_project_category_desactivated_created` (`id_project`,`category`,`desactivated`,`created`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

#CREATE tags table
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `bgcolor` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE 'utf8_general_ci';

#CREATE ToDo Table
CREATE TABLE IF NOT EXISTS `users_todos` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `issue_id` bigint(20) default NULL,
  `user_id` bigint(20) default NULL,
  `status` tinyint(2) default '1',
  `weight` bigint(20) default 1,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

#INSERT Activity Types
INSERT IGNORE INTO `activity` (`id`, `description`, `activity`)
VALUES
	(1,'Opened a new issue','create-issue'),
	(2,'Commented on a issue','comment'),
	(3,'Closed an issue','close-issue'),
	(4,'Reopened an issue','reopen-issue'),
	(5,'Reassigned an issue','reassign-issue');

#INSERT default tags : id 9
INSERT INTO `tags` (`id`, `tag`, `bgcolor`, `created_at`, `updated_at`) VALUES
(1,	'status:open',		'#c43c35',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(2,	'status:closed',	'#46A546',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(3,	'type:feature',	'#62cffc',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(4,	'type:bug',		'#f89406',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(6,	'resolution:won`t fix','#812323',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(7,	'resolution:fixed',	'#048383',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(8,	'status:testing',	'#FCC307',	'2013-11-30 11:23:01',	'2016-11-30 23:11:01'),
(9,	'status:inProgress','#FF6600',	'2016-11-10 23:12:01',	'2016-11-10 23:12:01');

#INSERT open/closed states
INSERT INTO projects_issues_tags (issue_id, tag_id, created_at, updated_at)
(
	SELECT id as issue_id, IF(status = 1, 1, 2) as tag_id, NOW(), NOW()
	FROM projects_issues
);

#INSERT activity type for tag update
INSERT INTO `activity` (`id`, `description`, `activity`)
VALUES ('6', 'Updated issue tags', 'update-issue-tags');

