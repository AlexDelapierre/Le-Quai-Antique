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
Creating an administrator for the web application's back office :

1. To create an administrator account, you need to navigate to the UserFixtures file located : 
"src/DataFixtures/UserFixtures.php" and modify the $admin variable in the load function with the desired values.
You should keep the value 'ROLE_ADMIN' for $admin->setRoles(['ROLE_ADMIN']);

2. Next, you need to run this command to reload the fixtures :
php bin/console doctrine:fixtures:load

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

