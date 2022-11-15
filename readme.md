Pig Latin Translator: a simple Nette Web Project
=================

This is a simple, web database application built on top of the 
[Nette](https://nette.org) skeleton project.

It is meant as a solution to a programming problem called
"Pig Latin Translator" whose implementation is an entry point
to apply for a job at [PeckaDesign](https://www.peckadesign.cz/kariera/junior-php-developer)

[Nette](https://nette.org) is a popular tool for PHP web development.
It is designed to be the most usable and friendliest as possible. It focuses
on security and performance and is definitely one of the safest PHP frameworks.

If you like Nette, **[please make a donation now](https://nette.org/donate)**. Thank you!


Requirements
------------

- Web Project for Nette 3.1 requires at least PHP 7.2,
however for a smooth user experience, we recommend to run
the app under PHP 8.0 at least (due to some syntactic
sugar used in the code).
- You shall need user privileges that enable you to create
MySQL databases that communicate with the PHP built-in webserver
on host `localhost`, port `3306`, or an euivalent of it (a docker LAMP
stack, or any of its equivalents, would be nice here, for example).


Installation
------------

This project was completely set up as a skeleton Web Project
using Composer command
```shell
composer create-project nette/web-project path/to/install
```
If you don't have Composer yet,
download it following [the instructions](https://doc.nette.org/composer). Then use command:

	composer create-project nette/web-project path/to/install
	cd path/to/install


Make directories `temp/` and `log/` writable (if on Linux).

Install packages
----------------
As a de facto composer project, you should definitely first run
the `composer install` command, after cloning the project itself.
This will install the neccessary packages needed
to run the project properly (like PHPUnit, for example).

Creating a database and its structure
----------------

As mentioned above, since this is not too sophisticated
project that would create a database copy automatically
and populate it with some fixture data, you will have to
create your datbase manually. Probably the simplest (depending
on your actual user rights), is to connect to your MySQL server:
```shell
mysql -u root -p
```
(this way you check that you know the username and password
at least) and create a database called, say, `pig_latin`:
```shell
create database pig_latin;
```
Then, go to the `config` folder and find the `local.neon`
file where you put the following configuration (with your
actual values of `user` and `password` filled), just like this:
```neon
database:
	dsn: 'mysql:host=127.0.0.1;dbname=pig_latin'
	user: root
	password: heslo
```
Finally, you should create a simple table, equivalent to this
SQL command:
```mysql
CREATE TABLE `translations` (
                         `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                         `content` text NOT NULL,
                         `translation` text
) ENGINE=InnoDB CHARSET=utf8;
```
This should be just enough to be ready to go :steam_locomotive: 

Web Server Setup
----------------

The simplest way to get the project started is to start
the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the Homepage
and you should be ready to go :rocket: 

Running tests
-----------------

To check everything works just fine, you
could run the command
```shell
./vendor/bin/phpunit tests/PigLatinTest.php
```
and see whether the translator works as expected :smile: 

PHPStan Analysis
------------------
To run the statical analysis of the code, we can run the command
```shell
vendor/bin/phpstan analyse -l 8 app tests
```
(which will find some errors, since the code is by far not complete)
