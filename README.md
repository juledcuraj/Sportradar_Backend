Sportradar Coding Academy Coding Exercise (BE)

Overview
Sportradar Sports Events Calendar is a PHP-based web application that allows users to manage and view upcoming and finished sports events. Users can add new events, filter by sport or date, and review details for each match. The project also includes backend tests to ensure data integrity and the correctness of critical database functions.


Setup and Installation

Prerequisites

•	PHP (version 8.2 or higher)

•	MySQL

•	Composer

•	XAMPP


Instructions to Set Up the Application

1.	Clone the Repository

git clone https://github.com/juledcuraj/Sportradar_Backend.git

Navigate to the project directory:

cd Sportradar_Backend

2.	Set Up the Database
   
o	The database dump files are located in the database folder of the repository.

o	Import sportradar_backend.sql and sportradar_test.sql(copy of main DB) into your MySQL database using phpMyAdmin or any database management tool.

o	Make sure to adjust the database settings in db_connection.php and tests/bootstrap.php to match your local setup.

3. Steps to Import:

o	Open phpMyAdmin and create two databases: sportradar_backend and sportradar_test.

o	Use the Import feature in phpMyAdmin to load the SQL files from the database folder into their respective databases.

4.	Install Dependencies
   
o	Make sure you have Composer installed, then run:

composer install

5.	Start Your Local Server
   
o	If using XAMPP, start Apache and MySQL.

o	Navigate to http://localhost/Sportradar_Backend in your browser to view the application

6.	Run Tests
   
o	Execute the PHPUnit tests in the terminal to ensure everything is working correctly:

vendor\bin\phpunit --configuration phpunit.xml

Assumptions and Decisions Made

•	Frontend Validation: Basic HTML5 validation is used to ensure that users fill in all required fields before submission.

•	Test Database: A separate sportradar_test database is used for testing purposes to maintain data integrity.

•	Dependency Management: Composer is used for managing PHP dependencies, including PHPUnit for testing.

•	Database Upload: The database has been included in the sportradar_backend.sql file of this repository to simplify setup.

