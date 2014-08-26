ALTER TABLE `users`
	ADD `language` varchar(5) default NULL ;
ALTER TABLE `projects`
	ADD `default_assignee` bigint(20) unsigned NULL;