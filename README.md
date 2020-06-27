# phpUserCRUDExample
A PHP vanilla User CRUD example with MySQL and PostgreSQL support.

## Configuration
Just change the contants value defined on "config.inc.php" for the connection to your MySQL Server (preferably use localhost).<br>
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

***Note:*** You can generete the db and tables used for this example using the "mysql_db_migration.sql" or "postgre_db_migration.sql" filse on the Migrations folder. Or just create your on database. 

Hopping this can be of any help for thouse learning PHP.
