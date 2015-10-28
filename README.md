# PathologyLab
Pathology Lab based on PHP's MVC framework CodeIgniter.

My assumption is that the WAMP/XAMP server is installed and MySQL database is up and localhost is ready to use.

# Steps to create and initialize the database:

1. Create the instance of  the MySQL database with the name of: ‘pathology_lab’
2. Then Import the ‘pathology_lab.sql’ file which is resided inside the ‘trunk\db’ directory.
3. If you want to change the database’s user credentials, which you can set/change at the following file: ‘trunk\application\config -> database.php’ [@LOC:79 & @LOC:80]


#Steps to prepare the source code to build/run properly:

1. Copy the ‘PathologyLab.git’ directory into the WAMP/XAMP’s www/htaccess directory.
2. Make sure the ‘mod_rewrite’ is enabled because CodeIgniter without this module can’t work.

#Comments:

There is plenty of room for improvement inside the first commit - especially the UI/UX part and the defensive coding, related to manage all use cases. Deactivate the table’s record instead of actual deletion. Date on which record added/updated etc.

#Admin Credential:
Username: admin
Password: admin