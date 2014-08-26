-- create tags table
CREATE TABLE `tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tag` varchar(255) NOT NULL,
  `bgcolor` varchar(50) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag` (`tag`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE 'utf8_general_ci';

-- create default tags
TRUNCATE `tags`;
INSERT INTO `tags` (`id`, `tag`, `bgcolor`, `created_at`, `updated_at`) VALUES
(1,	'status:open',	'#c43c35',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(2,	'status:closed',	'#46a546',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(3,	'type:feature',	'#62cffc',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(4,	'type:bug',	'#f89406',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(6,	'resolution:won''t fix',	'#812323',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(7,	'resolution:fixed',	'#048383',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01'),
(8,	'status:testing',	'#6c8307',	'2013-11-30 11:23:01',	'2013-11-30 11:23:01');

-- create issue-tag relationship table
CREATE TABLE `projects_issues_tags` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `issue_id` bigint(20) unsigned NOT NULL,
  `tag_id` bigint(20) unsigned NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `issue_tag` (`issue_id`,`tag_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- import open/closed states
INSERT INTO projects_issues_tags (issue_id, tag_id, created_at, updated_at)
(
	SELECT id as issue_id, IF(status = 1, 1, 2) as tag_id, NOW(), NOW()
	FROM projects_issues
);

-- create activity type for tag update
INSERT INTO `activity` (`id`, `description`, `activity`)
VALUES ('6', 'Updated issue tags', 'update-issue-tags');