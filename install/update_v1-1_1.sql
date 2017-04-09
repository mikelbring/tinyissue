ALTER TABLE `projects_users` ADD `updated_at` DATETIME  NULL  AFTER `role_id`;
ALTER TABLE `projects_users` ADD `created_at` DATETIME  NULL  AFTER `updated_at`;
UPDATE TABLE `projects_users` SET created_at = NOW(), updated_at = NOW();
ALTER TABLE `roles` CHANGE `key` `role` VARCHAR(255)  CHARACTER SET latin1  NULL  DEFAULT NULL;
ALTER TABLE `activity` CHANGE `key` `activity` VARCHAR(255)  CHARACTER SET latin1  NULL  DEFAULT NULL;
