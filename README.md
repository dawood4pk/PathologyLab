# PathologyLab
PathologyLab based on PHP's MVC framework CodeIgniter.

# Steps to create and initialize the database:
1. Create the instance of the MySQL database with the name of: ‘pathology_lab’
2. Then Import the ‘pathology_lab.sql’ file which is resided inside the ‘trunk\db’ directory.
3. If you want to change the database’s user credentials, which you can set/change at the following file: ‘trunk\application\config -> database.php’ [@LOC:79 & @LOC:80]


#Steps to prepare the source code to build/run properly:
1. Copy the ‘PathologyLab.git’ directory into the WAMP/XAMP’s www/htaccess directory.
2. Make sure the ‘mod_rewrite’ is enabled because CodeIgniter without this module can’t work.
Note: My assumption is that the WAMP/XAMP server is installed and MySQL database is up and localhost is ready to use.

#Admin Credential:
Username: admin
Password: admin

# PathologyLab's Objective:
PathologyLab reporting system - which will be use to publish medical test result reports to patients.

# PathologyLab's Functional Specifications:

PathologyLab's is a Reporting web application where medical test result reports will be published to the patients:

1. Admin users should be able to log in to the system to perform following privileged tasks. Patients cannot access these pages.
1.1. Reports CRUD (Multiple tests and results in each report)
1.2. Patients CRUD (including pass code)

2 Lab sends a text message to the patient with a pass code to log in (out of scope).

3. Patient user could log in using username that is assigned to him/her (auto complete field) and pass code sent to him. And then can do the following:
3.1. Display list of his reports.
3.2. Display a report details as a page.
3.3. Export a report as PDF
3.4. Mail a report as PDF

4. Any functionally that will add value to the application.

#Current Status:
There is plenty of room for improvement inside the first commit - especially the UI/UX part and the defensive coding, related to manage all use cases. Deactivate the table’s record instead of actual deletion. Date on which record added/updated etc.