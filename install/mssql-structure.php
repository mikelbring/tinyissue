<?php
return array(
"--Create Activity Table
CREATE TABLE activity (
  id int identity NOT NULL,
  \"description\" varchar(255),
  activity varchar(255),
  PRIMARY KEY (id)
)",

"--Create Permissions Table
CREATE TABLE permissions (
  id bigint identity NOT NULL,
  permission varchar(255),
  \"description\" text,
  auto_has varchar(255),
  PRIMARY KEY  (id)
)",

"--Create Projects Table
CREATE TABLE projects (
  id bigint identity NOT NULL,
  name varchar(255),
  \"status\" tinyint,
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY  (id)
)",

"--Create Projects Issues Table
CREATE TABLE projects_issues (
  id bigint identity NOT NULL,
  created_by bigint,
  closed_by bigint,
  updated_by bigint,
  assigned_to bigint,
  project_id bigint,
  \"status\" tinyint default '1',
  title varchar(255),
  body text,
  created_at datetime,
  updated_at datetime,
  closed_at datetime,
  PRIMARY KEY  (id)
)",

"--Create Projects Issues Attachments Table
CREATE TABLE projects_issues_attachments (
  id bigint identity NOT NULL,
  issue_id bigint,
  comment_id bigint default '0',
  uploaded_by bigint,
  filesize bigint,
  filename varchar(250),
  fileextension varchar(255),
  upload_token varchar(100),
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY  (id)
)",

"--Create Projects Issues Comments Table
CREATE TABLE projects_issues_comments (
  id bigint identity NOT NULL,
  created_by bigint default '0',
  project_id bigint,
  issue_id bigint,
  comment text,
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY  (id)
)",

"--Create Projects Users Table
CREATE TABLE projects_users (
  id bigint identity NOT NULL,
  user_id bigint default '0',
  project_id bigint default '0',
  role_id bigint default '0',
  created_at datetime,
  updated_at datetime,
  PRIMARY KEY  (id)
)",

"--Create Roles Table
CREATE TABLE roles (
  id bigint identity NOT NULL,
  name varchar(255),
  role varchar(255),
  description varchar(255),
  PRIMARY KEY  (id)
)",

"--Create Roles Permissions Table
CREATE TABLE roles_permissions (
  id bigint identity NOT NULL,
  role_id bigint default NULL,
  permission_id bigint,
  PRIMARY KEY  (id)
)",

"--Create Sessions Table
CREATE TABLE sessions (
  id varchar(255),
  last_activity int,
  data text,
  PRIMARY KEY (id)
)",

"--Create Settings Table
CREATE TABLE settings (
  id int identity NOT NULL,
  \"key\" varchar(255),
  value text,
  name varchar(255),
  PRIMARY KEY  (id)
)",

"--Create Users Table
CREATE TABLE users (
  id bigint identity NOT NULL,
  role_id bigint NOT NULL default '1',
  email varchar(255) default NULL,
  \"password\" varchar(255) default NULL,
  firstname varchar(255) default NULL,
  lastname varchar(255) default NULL,
  created_at datetime default NULL,
  updated_at datetime default NULL,
  deleted int NOT NULL default '0',
  PRIMARY KEY  (id)
)",

"--Create Users Activity Table
CREATE TABLE users_activity (
  id bigint identity NOT NULL,
  user_id bigint default NULL,
  parent_id bigint default NULL,
  item_id bigint default NULL,
  action_id bigint default NULL,
  type_id int default NULL,
  data text,
  created_at datetime default NULL,
  updated_at datetime default NULL,
  PRIMARY KEY  (id)
)",




"--Insert Permisions Data
INSERT INTO permissions (id, permission, description, auto_has) VALUES
	(1, 'issue-view', 'View issues in project assigned to', NULL),
	(2, 'issue-create', 'Create issues in projects assigned to', NULL),
	(3, 'issue-comment', 'Comment in issues in projects assigned to', '1'),
	(4, 'issue-modify', 'Modify issues in projects assigned to', '1'),
	(11, 'project-all', 'View, modify all projects and issues', '1,2,3,4'),
	(6, 'administration', 'Administration tools, such as user management and application settings.', NULL),
	(9, 'project-create', 'Create a new project', NULL),
	(10, 'project-modify', 'Modify a project assigned to', NULL);",


"--Insert Roles Data
INSERT INTO roles (id, name, role, description)
VALUES
	(1,'User','user','Only can read the issues in the projects they are assigned to'),
	(2,'Developer','developer','Can update issues in the projects they are assigned to'),
	(3,'Manager','manager','Can update issues in all projects, even if they arent assigned'),
	(4,'Administrator','administrator','Can update all issues in all projects, create users and view administration');",

"--Insert Roles Permissions Data
INSERT INTO roles_permissions (id, role_id, permission_id) VALUES
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

"--Insert Activity Types
INSERT INTO activity (id, description, activity)
VALUES
	(1,'Opened a new issue','create-issue'),
	(2,'Commented on a issue','comment'),
	(3,'Closed an issue','close-issue'),
	(4,'Reopened an issue','reopen-issue'),
	(5,'Reassigned an issue','reassign-issue')"
);