# This Repository is not being updated by me anymore. Yup, time to fork and roll, buddy!

Why? It reached a point where it is good enough for my needs and Bugs' main objective was to be simple enough for non-web developers to report issues. And for that, it should never suffer from Featuritis. Laravel has become too bloated for me, and I don't have the time needed to maintain this properly. 
I've started a port using the awesome [FatFreeFramework](https://fatfreeframework.com) but it's too early to make that repository open. Have fun!

#But it is still on its way

Users are still maintaining it, I'd borrow my management rights to them.  You'll still find updates as long as those users will do any.  Keep coming here and using Bugs. 

# Bugs

[Visit the project](http://pixeline.github.io/bugs/)

![Printscreen](http://pixeline.github.io/bugs/images/bugs-index.png "Main screen")

# Installing Bugs

- Create a MySQL Database  ( note name and password, you will need them during install process )
- Make /uploads/ write-able ( CHMOD -R  770 )
- set  www-data  ( CHOWN -R www-data:www-data )  as owner of the Bugs's main directory and sub-directories
- Open index.php ... it should bring you to ./install/index.php page and open the installation forms
- Delete or rename /install/

Enjoy!

# Upgrading from a previous installation

- backup config.app.php and your uploads folder.
- simply replace the codebase with the new version (via an ftp client such as Filezilla).
- make sure your uploads folder and config.app.php are still there
- If necessary, add this line to your config.app.php
```php
'my_bugs_app'=>array(
'name'=> 'Bugs',
'date_format'=>'F jS \a\t g:i A',
),
```

## Requirements:

- Tested on: Apache, IIS
- PHP 5.3+  :  ready for PHP 7.0.18; not yet for 7.1
- MySQL 5+
- PDO Extension for PHP (MySQL)
- MCrypt Extension for PHP : soon MCrypt will be removed from Bugs project
- Javascript Enabled - Bugs also uses heavy Javascript to make it easier to use

### How to contribute

We welcome and appreciate all contributions. The `develop` branch is the branch you should base all pull requests and development off of.
The `master` branch is tagged releases only.

# Changelog

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

- [Alexandre Plennevaux](https://pixeline.be)
