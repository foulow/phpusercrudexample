# phpUserCRUDxample
A PHP vanilla User CRUD example with MySQL and PostgreSQL support.

## First steps
To get this repository ready for personal use you can open a terminal and run the following commands:

    $ git clone https://github.com/foulow/phpusercrudxample.git
    $ cd phpusercrudxample
    $ rm -rf ./.git/
    $ git init
    $ git add .
    $ git commit -m "Initial commit"


## Configuration
Just change the constants value defined on the `config/config.inc.php` file for the connection to your MySQL Server (preferably use localhost).<br>

    // Database connection constant definitions.
    define('MYSQL_HOST', '{server_name}');
    define('MYSQL_USER', '{user_name}');
    define('MYSQL_PASSWORD', '{user_password}');
    define('MYSQL_DATABASE', '{database_name}');

    // Database connection constant definitions for PostgreSQL.
    define('POSTGRESQL_HOST', '{server_name}');
    define('POSTGRESQL_DATABASE', '{database_name}');
    define('POSTGRESQL_USER', '{user_name}');
    define('POSTGRESQL_PASSWORD', '{database_name}');

    // set the dbcontext to be use mysql :=> MySQL, pgsql :=> PostgreSQL
    define('DBCONTEXT', 'mysql');

***Note:*** You can generate the database and tables used for this example using the "mysql_db_migration.sql" or "postgre_db_migration.sql" files on the Migrations folder. Or just create your own database. 


## Quick Tests
For a quick test you can run it locally by installing php and composer then run it with:
<br>

    $ composer update
    $ php -S localhost:8080

Or remotely with a heroku account and running:

    $ heroku git:remote -a YOUR_HEROKU_PROJECT_NAME_HERE
    $ git add .
    $ git commit -m "DO NOT FORGET TO COMMIT YOUR CHANGES"
    $ git push heroku master

***Note:*** Make sure you have a MySQL or PostgreSQL server configure in your `config/config.inc.php` file before going online. And heroku handle sessions differently so you will need a in-memory-storage service like 'MemCachier' in order for the logins to work.

And that should be it. Hopping this can be of any help for those embargoing in the road of PHP learning.
