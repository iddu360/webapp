# YourAd

A classifieds platform to investigate the possibilities of image editing with PHP 7 as part of a student research project

## Requirements

* Web server (Apache or Laravel Valet)
* MySQL
* PHP 7 +
* Composer
* PHP GD Extension (Should be already included in your php installation)
* PHP GMagick Extension
* Twig


## Installation

### Clone this repository

> git clone https://github.com/alexanderkorus/yourad-web-app.git

> composer install

### Install Apache & MySQL & PHP 7 (XAMPP)

 * Download XAMPP and start Apache Server and MySQL Database
 * Make sure that PHP 7 or higher is installed and worked well
 
### Make the public available in localhost, but not the app

 * Copy the sources from the Repo into your www document root of the apache
 * Open httpd.conf of your Apache Configuration
 * Change Localhosts VirtualHost DocumentRoot from '{path}/www' to '{path}/www/public'
 * Restart Apache
 
 Alternative:
 * If you have more than one application, you can create a folder and add a new virtual host configuration
 * Add File yourad.conf in your httpd/conf.d directory (or where ever apache configuration is located)
 * Edit the file and insert following lines:
 ```apacheconfig
 <VirtualHost 127.0.0.1:3000>
     DocumentRoot {$path}/www/yourad/public
     ServerName localhost
     ServerAlias localhost 127.0.0.1
     <Directory "{$path}/www/yourad/public">
     Options FollowSymLinks Indexes
     AllowOverride All
     Order deny,allow
     allow from All
     </Directory>
 </VirtualHost>
 ```
 * Restart Apache and check if the application is available under http://localhost:3000
 

### Create Database and make the connections

* Login into your MySQL Database with phpmyadmin, create a database named yourad and import the SQL Dump from this repository
* Open App/Config.php and replace the Database Connection credentials with your own
* Also make sure that you configure the URL with your own path. If you use apache for example you can use this configuration
    > const URL = 'http://localhost';
    
    or 
    > const URL = 'http://localhost:3000';


### Install Gmagick Extension

* Linux/CentOS
    > yum install GraphicsMagick

* Mac OS:
    > brew install GraphicsMagick

* Windows:

    For Windows take a look at the official documentations: http://php.net/manual/en/gmagick.installation.php 


* Then you can use pecl to install the extension:
    > pecl install gmagick-beta

#### Troubleshooting

#####  Installation of GMagick failed

1. configure: error: not found. Please provide a path to GraphicsMagick-config program.

    >  yum install GraphicsMagick-devel
   
   Then retry it to install it again.

