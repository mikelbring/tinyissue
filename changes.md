# Tiny Issue Change Log

## Tiny Issue v1.3.1

- Bug fixes
- Small UI Changes
- Language fixes

### Upgrading from v1.3

- Replace the `app` folder

## Tiny Issue v1.3

- Added support for user language (issue#84)
- Login will take you back to where you wanted to go (issue#68)
- Minor CSS updates and bug fixes

### Upgrading from v1.2.3

- Run the `install/update_v1-1_3.sql` in your database
- Replace the `app` folder

## Tiny Issue v1.2.3

- Added support for SMTP encryption protocol
- Added Markdown support
- General bug fixes

### Upgrading from v1.2.2

- Replace the `app` folder

## Tiny Issue v1.2.2

- Added activity log to issue page
- Bug Fix: Assigning users to a project with no users, after creating the project
- Bug Fix: Admin stats and version

### Upgrading from v1.2.1

- Replace the `app` folder

## Tiny Issue v1.2.1

- Minor bug fixes
- Convert raw queries to query builder
- Added localization, now we have a language file for all text
- Added additional requirement checks in installer

### Upgrading from v1.2

- Replace the `app` folder

## Tiny Issue v1.2

- Feature: Requirement check on installation
- Feature: Added ability to edit a issue title / body
- Feature: Autolink URLs in comment and issue body
- Install: Will now check for installation when going to root by seeing if config.app.php exists
- Config: Added more mail settings to config
- Included .htaccess for mod-rewrite

### Upgrading from v1.1.1

- Replace the `app` folder

## Tiny Issue v1.1.1

- Bug fix: Your issue count was not returning the right value
- Bug fix: The activity view was not account for issues assigned to no one

### Upgrading from v1.1

- Replace the `app` folder

## Tiny Issue v1.1

- Upgraded Laravel 2.x to Laravel 3.1.4, should fix some bugs related to PHP 5.4
- Bug fix: Added a URL option in the config to specify your URL, should fix path bug on non-apache servers

### Upgrading from v1.0

- Move `app/assets/uploads` to `/uploads`
- Run the `install/update_v1-1_1.sql` in your database
- Replace the `app` folder