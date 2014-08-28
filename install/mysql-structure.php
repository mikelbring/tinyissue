<?php
return array(
"# Create Activity Table
CREATE TABLE IF NOT EXISTS `activity` (
  `id` int(11) unsigned NOT NULL auto_increment,
  `description` varchar(255) character set UTF8 default NULL,
  `activity` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

	"# Create Permissions Table
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `permission` varchar(255) character set UTF8 default NULL,
  `description` text character set UTF8,
  `auto_has` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

	"# Create Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set UTF8 default NULL,
  `status` tinyint(2) default '1',
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Projects Issues Table
CREATE TABLE IF NOT EXISTS `projects_issues` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `created_by` bigint(20) default NULL,
  `closed_by` bigint(20) default NULL,
  `updated_by` bigint(20) default NULL,
  `assigned_to` bigint(20) default NULL,
  `project_id` bigint(20) default NULL,
  `status` tinyint(2) default '1',
  `weight` bigint(20) default '1',
  `title` varchar(255) character set UTF8 default NULL,
  `body` text character set UTF8,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  `closed_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Projects Issues Attachments Table
CREATE TABLE IF NOT EXISTS `projects_issues_attachments` (
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Projects Issues Comments Table
CREATE TABLE IF NOT EXISTS `projects_issues_comments` (
  `id` bigint(20) NOT NULL auto_increment,
  `created_by` bigint(20) default '0',
  `project_id` bigint(20) default NULL,
  `issue_id` bigint(20) default '0',
  `comment` text character set UTF8,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Projects Users Table
CREATE TABLE IF NOT EXISTS `projects_users` (
  `id` bigint(20) NOT NULL auto_increment,
  `user_id` bigint(20) default '0',
  `project_id` bigint(20) default '0',
  `role_id` bigint(20) default '0',
	`created_at` datetime default NULL,
 	`updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Roles Table
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `name` varchar(255) character set UTF8 default NULL,
  `role` varchar(255) character set UTF8 default NULL,
  `description` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Roles Permissions Table
CREATE TABLE IF NOT EXISTS `roles_permissions` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `role_id` bigint(11) default NULL,
  `permission_id` bigint(20) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Sessions Table
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` varchar(40) character set UTF8 NOT NULL,
  `last_activity` int(10) NOT NULL,
  `data` text character set UTF8 NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Settings Table
CREATE TABLE IF NOT EXISTS `settings` (
  `id` int(11) NOT NULL auto_increment,
  `key` varchar(255) character set UTF8 default NULL,
  `value` text character set UTF8,
  `name` varchar(255) character set UTF8 default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create ToDo Table
CREATE TABLE IF NOT EXISTS `users_todos` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `issue_id` bigint(20) default NULL,
  `user_id` bigint(20) default NULL,
  `status` tinyint(2) default '1',
  `weight` bigint(20) default 1,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",


"# Create Users Table
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL auto_increment,
  `role_id` bigint(20) unsigned NOT NULL default '1',
  `email` varchar(255) default NULL,
  `password` varchar(255) default NULL,
  `firstname` varchar(255) default NULL,
  `lastname` varchar(255) default NULL,
  `language` varchar(5) default NULL,
  `created_at` datetime default NULL,
  `updated_at` datetime default NULL,
  `deleted` int(1) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"# Create Users Activity Table
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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",




"#Insert Permisions Data
INSERT IGNORE INTO `permissions` (`id`, `permission`, `description`, `auto_has`) VALUES
	(1, 'issue-view', 'View issues in project assigned to', NULL),
	(2, 'issue-create', 'Create issues in projects assigned to', NULL),
	(3, 'issue-comment', 'Comment in issues in projects assigned to', '1'),
	(4, 'issue-modify', 'Modify issues in projects assigned to', '1'),
	(11, 'project-all', 'View, modify all projects and issues', '1,2,3,4'),
	(6, 'administration', 'Administration tools, such as user management and application settings.', NULL),
	(9, 'project-create', 'Create a new project', NULL),
	(10, 'project-modify', 'Modify a project assigned to', NULL);",


"#Insert Roles Data
INSERT IGNORE INTO `roles` (`id`, `name`, `role`, `description`)
VALUES
	(1,'User','user','Only can read the issues in the projects they are assigned to'),
	(2,'Developer','developer','Can update issues in the projects they are assigned to'),
	(3,'Manager','manager','Can update issues in all projects, even if they aren\'t assigned'),
	(4,'Administrator','administrator','Can update all issues in all projects, create users and view administration');",

"#Insert Roles Permissions Data
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
	(20, 4, 4);",

" #Insert Activity Types
INSERT IGNORE INTO `activity` (`id`, `description`, `activity`)
VALUES
	(1,'Opened a new issue','create-issue'),
	(2,'Commented on a issue','comment'),
	(3,'Closed an issue','close-issue'),
	(4,'Reopened an issue','reopen-issue'),
	(5,'Reassigned an issue','reassign-issue');
"
);