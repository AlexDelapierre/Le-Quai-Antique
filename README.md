# Le-Quai-Antique
***
Le Quai Antique is a restaurant website 

## Table of Contents
1. [Technologies](#technologies)
2. [Installation](#installation)
3. [Creating an administrator](#creating-an-administrator)
4. [Utilisation](#utilisation)
5. [Annexes](#annexes)

## Technologies
***
A list of technologies used within the project:

### Front-end :
* HTML 5 
* CSS 3 
* Bootstrap 
* JavaScript 
### Back-end :
* PHP 8.1 
* Symfony 5.4 (Version LTS) 
* MySQL 

## Installation
***
To install the project locally.

```
# Project retrieval
$ git clone git@github.com:AlexDelapierre/Le-Quai-Antique.git

# Moving into the folder
$ cd ../path/to/the/file

# Installation of dependencies
$ composer install

# Database creation
$ php bin/console doctrine:database:create

# Creation of tables in the database (migration)
$ php bin/console doctrine:migrations:migrate

# If there is a problem with the migrations
$ php bin/console doctrine:schema:update --force

# Creation of fixtures in the database 
$ php bin/console doctrine:fixtures:load
```

## Creating an administrator
***
To Create an administrator for the web application's back office :

```
# To create an administrator account, you need to enter this command in the console and follow the instructions : 
$ php bin/console app:create-admin
```

## Utilisation 
***
To use the local web server.

```
# To use the local web server of Symfony CLI
$ symfony server:start

# If you are using Composer, you need to install the Web Server Bundle
$ composer require symfony/web-server-bundle --dev
$ php bin/console server:start
```
## Annexes
***
The following supporting documents are available in the public/annexes folder :

* Charte_graphique.pdf
* documentation_technique.pdf




