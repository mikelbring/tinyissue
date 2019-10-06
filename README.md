# Bugs

[Visit the project](http://bugs.rcmission.net/)

![Printscreen](http://bugs.rcmission.net/)

# Installing Bugs

- Create a MySQL Database  ( note name and password, you will need them during install process )
- Make /uploads/ write-able ( CHMOD -R  770 )
- set  www-data  ( CHOWN -R www-data:www-data )  as owner of the Bugs's main directory and sub-directories
- Open index.php ... it should bring you to ./install/index.php page and open the installation forms

Enjoy!

# Upgrading from a previous installation

- backup config.app.php and your uploads folder.
- simply replace the codebase with the new version (via an ftp client such as Filezilla).
- make sure your uploads folder and config.app.php are still there
- If necessary, add this line to your config.app.php -> please see the last config.app.example.php


## Requirements:

- Tested on: Apache, IIS
- PHP 7.0+    
- MySQL 5+
- PDO Extension for PHP (MySQL)
- MCrypt Extension for PHP : soon MCrypt will be removed from Bugs project
- Javascript Enabled - Bugs also uses heavy Javascript to make it easier to use

### How to contribute

We welcome and appreciate all contributions. The `develop` branch is the branch you should base all pull requests and development off of.
The `master` branch is tagged releases only.

For any coding contribution, please use a git tool ( visit https://git-scm.com/book/fr/v2/D%C3%A9marrage-rapide-Installation-de-Git to know more ).
Then, push you modification throw a new branch. NEVER push on master. 

# Changelog
- v.1.8 : Responsive template.  Now matches the window size wherever you use BUG ( tablet, phone, computer ) 
    - built during summer 2019, first release on Sept 29th
    - includes the very first searching tools which scan all projects and all issues for regular expression
- v.1.7 : July 2019 
	- reports are now totally integrated to BUGS which produces pdf files
- v.1.6 : February 2019 
	- correction file 1i: update system now also updates the config file
								 23 mars 2019
	- correction file 1h: Priority ( 1 - 5 ) to every issue ( 0 = closed )
								 ckeditor appears on every textarea ( for new issue, for edit issue, for new or edit project)
								 20 mars 2019
	- correction file 1g: Perfect install system, logo BUGS during install
								 8 mars 2019
	- all what planned in [Nice changes to come](https://github.com/pixeline/bugs/projects) is now running good.
	- CAUTION : we don't support PHP 5.x since BUGS 1.5, under 1.6 many functions are unusable for that reason
								 
- v.1.5.2b : 23 septembre 2018
	- Wysyg text editor  ( you can install the one you like )
	- sorting project's issues
	- filtering project's issues
	- upload and attach file to an issue
	- automatized installation (better than before)
	- linked to report system (optionnal, report system from another git deposit)
	- some problems appear under PHP 5.x
- v.1.5.2 : 15 March 2017
	- reassign issue
	- email system based on PHPmail: work every time you change assignation
	- projects sorted by name
	- percentage work done
	- percentage time passed before deadline
	- every single word on screen may be translated by app/application/language files
	- install in many language
	
- v1.5 : 12 July 2015:
	- fix: Time Display format now configurable, see config.example.php
	- fix: SQL « tags » table not included during installation
	- fix: Bugs assets now load correctly if inside a subfolder

various layout tweaks.

- v1.2 : 28 August 2014: 
	- French translation updates
	- Various fixes
	- Multilingual email (code by [Wolfgang Gassler](http://wolfgang.gassler.org/) - [source](https://github.com/mikelbring/tinyissue/pull/197))
	- Kanban-style planning board (code by [Steve McCullough](http://irrational.ca/) - [source](https://github.com/mikelbring/tinyissue/pull/194))
- v1.1 : 26 August 2014: 
	- Tags (code by [Anton Kanevsky](http://about.me/akanevsky) - [source](https://github.com/mikelbring/tinyissue/pull/180) )
	- Visual identity. Project rebaptized Bugs. As in "Hugs", with a B.
- v1.0 : 25 August 2014:
	- project forked from Tiny Issue 1.3, by [Michael Hasselbring](http://michaelhasselbring.com), [Zachary Hoover](http://zachoover.com) and [Suthan Sangaralingham](http://suthanwebs.com/)

# Main Developers

- [Alexandre Plennevaux](https://pixeline.be) ... to 2016
- [Patrick Allaire, ptre](http://cartefoi.net) from 2016 to now
