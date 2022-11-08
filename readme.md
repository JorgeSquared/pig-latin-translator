Pig Latin Translator: a simple Nette Web Project
=================

This is a simple, web application built on top of the 
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

- Web Project for Nette 3.1 requires PHP 7.2


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


Make directories `temp/` and `log/` writable.


Web Server Setup
----------------

The simplest way to get the project started is to start
the built-in PHP server in the root directory of your project:

	php -S localhost:8000 -t www

Then visit `http://localhost:8000` in your browser to see the Homepage.
