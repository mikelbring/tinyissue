#----- First line of this file .... please let it here, first with NO carriage return before nor after. -----
#--#Create Activity Table
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` varchar(255) character set UTF8 default NULL,
  `activity` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Permissions Table
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `permission` varchar(255) character set UTF8 default NULL,
  `description` text character set UTF8,
  `auto_has` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set UTF8 default NULL,
  `status` tinyint(2) default '1',
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  `default_assignee` bigint(20)  default '1',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Projects Issues Table
CREATE TABLE `projects_issues` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_by` bigint(20) NOT NULL DEFAULT '1',
  `closed_by` bigint(20) DEFAULT NULL,
  `updated_by` bigint(20) DEFAULT NULL,
  `assigned_to` bigint(20)  default '1',
  `project_id` bigint(20) DEFAULT NULL,
  `status` tinyint(2) DEFAULT '1',
  `weight` bigint(20) NOT NULL DEFAULT '1',
  `title` varchar(255) DEFAULT NULL,
  `body` text,
  `created_at` datetime DEFAULT NULL,
  `duration` smallint(3) NOT NULL DEFAULT '30',
  `updated_at` datetime DEFAULT NULL,
  `closed_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) AUTO_INCREMENT = 2 ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Projects Issues Attachments Table
CREATE TABLE `projects_issues_attachments` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `issue_id` bigint(20) default NULL,
  `comment_id` bigint(20) default '0',
  `uploaded_by` bigint(20) default NULL,
  `filesize` bigint(20) default NULL,
  `filename` varchar(250) character set UTF8 default NULL,
  `fileextension` varchar(255) character set UTF8 default NULL,
  `upload_token` varchar(100) character set UTF8 default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Projects Issues Comments Table
CREATE TABLE IF NOT EXISTS `projects_issues_comments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created_by` bigint(20) default '0',
  `project_id` bigint(20) default NULL,
  `issue_id` bigint(20) default '0',
  `comment` text character set UTF8,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create issue-tag relationship table
CREATE TABLE `projects_issues_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issue_tag` (`issue_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Projects Links Table
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
#--

#--#Create Projects Users Table
CREATE TABLE IF NOT EXISTS `projects_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) default '0',
  `project_id` bigint(20) default '0',
  `role_id` bigint(20) default '0',
	`created_at` datetime default NULL,
 	`updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Roles Table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set UTF8 default NULL,
  `role` varchar(255) character set UTF8 default NULL,
  `description` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Roles Permissions Table
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `role_id` bigint(11) default NULL,
  `permission_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Sessions Table
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(40) character set UTF8 NOT NULL,
  `last_activity` int(10) NOT NULL,
  `data` text character set UTF8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) character set UTF8 default NULL,
  `value` text character set UTF8,
  `name` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create tags table
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `bgcolor` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE 'utf8_general_ci';
#--

#--#Create ToDo Table
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
#--

#--#Create Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `role_id` bigint(20) unsigned NOT NULL default '1',
  `email` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `language` varchar(5) default 'en',
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  `deleted` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Create Users Activity Table
CREATE TABLE IF NOT EXISTS `users_activity` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `user_id` bigint(20) default NULL,
  `parent_id` bigint(20) default NULL,
  `item_id` bigint(20) default NULL,
  `action_id` bigint(20) default NULL,
  `type_id` int(11) default NULL,
  `data` text character set UTF8,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
#--

#--#Insert Permisions Data
INSERT IGNORE INTO `permissions` (`id`, `permission`, `description`, `auto_has`) VALUES
	(1, 'issue-view', 'View issues in project assigned to', NULL),
	(2, 'issue-create', 'Create issues in projects assigned to', NULL),
	(3, 'issue-comment', 'Comment in issues in projects assigned to', '1'),
	(4, 'issue-modify', 'Modify issues in projects assigned to', '1'),
	(6, 'administration', 'Administration tools, such as user management and application settings.', NULL),
	(9, 'project-create', 'Create a new project', NULL),
	(10, 'project-modify', 'Modify a project assigned to', NULL),
	(11, 'project-all', 'View, modify all projects and issues', '1,2,3,4');
#--

#--#Insert Roles Data
INSERT IGNORE INTO `roles` (`id`, `name`, `role`, `description`)
VALUES
	(1,'User','user','Only can read the issues in the projects they are assigned to'),
	(2,'Developer','developer','Can update issues in the projects they are assigned to'),
	(3,'Manager','manager','Can update issues in all projects, even if they aren\'t assigned'),
	(4,'Administrator','administrator','Can update all issues in all projects, create users and view administration');
#--

#--#Insert Roles Permissions Data
INSERT IGNORE INTO `roles_permissions` (`id`, `role_id`, `permission_id`) VALUES
	(1, 1, 1),
	(2, 1, 2),
	(3, 1, 3),
	(4, 2, 1),
	(5, 2, 2),
	(6, 2, 3),
	(7, 2, 4),
	(8, 3, 11),
	(9, 3, 1),
	(10, 3, 2),
	(11, 3, 3),
	(12, 3, 4),
	(13, 4, 1),
	(14, 4, 2),
	(15, 4, 3),
	(16, 4, 6),
	(17, 4, 9),
	(18, 4, 10),
	(19, 4, 11),
	(20, 4, 4);
#--

#--#Insert Activity Types
INSERT IGNORE INTO `activity` (`id`, `description`, `activity`)
VALUES
	(1,'Opened a new issue','create-issue'),
	(2,'Commented on a issue','comment'),
	(3,'Closed an issue','close-issue'),
	(4,'Reopened an issue','reopen-issue'),
	(5,'Reassigned an issue','reassign-issue'),
	(6,'Updated issue tags','update-issue-tags'),
	(7,'Attached a file to issue','attached-file');
#--

#--#Create default tags : id 9
INSERT INTO `tags` (`id`, `tag`, `bgcolor`, `created_at`, `updated_at`) VALUES
(1,	'status:open',		'#c43c35',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(2,	'status:closed',	'#46A546',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(3,	'type:feature',	'#62cffc',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(4,	'type:bug',		'#f89406',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(6,	'resolution:won`t fix','#812323',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(7,	'resolution:fixed',	'#048383',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(8,	'status:testing',	'#FCC307',	'2013-11-30 11:23:01',	'2016-11-30 23:11:01'),
(9,	'status:inProgress','#FF6600',	'2016-11-10 23:12:01',	'2016-11-10 23:12:01');
#--

#--#Import open/closed states
INSERT INTO projects_issues_tags (issue_id, tag_id, created_at, updated_at)
(
	SELECT id as issue_id, IF(status = 1, 1, 2) as tag_id, NOW(), NOW()
	FROM projects_issues
);
#--

#--#Ccreate activity type for tag update
INSERT INTO `activity` (`id`, `description`, `activity`)
VALUES ('6', 'Updated issue tags', 'update-issue-tags');
#----- Last line of this file .... Anything bellow this line will be lost. -----

#--#Create a first admin user:
##--# email = myemail@email.com
##--# password = admin
INSERT INTO `users` (`id`, `role_id`, `email`, `password`, `firstname`, `lastname`, `language`, `created_at`, `updated_at`, `deleted`) VALUES
(NULL,	4,	'myemail@email.com',	'XhS.DHsB8wt1o',	'admin',	'admin',	'en',	NOW(),	NOW(),	0)