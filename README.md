# Web app for uploading and retrieving a file

## Prerequisites   

Your task is to build a small web application using PHP and MySQL. The user should be able to upload a CSV file (upload file.csv) to be read by the application and inserted into the database that you will design.
The uploaded data should then be displayed in a table below the upload form. The file only contains year, month, day and name. You have to calculate the weekday and display the data in rows as shown below:

Weekday the XXth of Month:  | Name


The list should be arranged in date order with the oldest date first.
The user should also be able to export the list as displayed in the interface to a CSV file using an export button.
The code must be well structured and of high enough quality to be used in our projects. Below you will see an example of how it could look like, but feel free to add you touch to it.


## Requirement

* PHP 7.3 or higher
* MYSQL
* COMPOSER

## Setup

Run `composer update` to install all dependencies, and autoloading.

In document-root you find setup_database.sql, execute it to setup the database.

## Run the project

If you use the PHP-built-in server use this command from a terminal, standing in your workspace directory  `sudo php -S localhost:80 -t getweekdays.test/public`
 
