# phpUserCRUDwithMySQL
A PHP vanilla User CRUD example with MySQL

## Configuration
Just change the contants value defined on "config.inc.php" for the connection to your MySQL Server (preferably use localhost).<br>
    // Database connection constant definitions.
    define('MYSQL_HOST', '{server_name}');
    define('MYSQL_USER', '{user_name}');
    define('MYSQL_PASSWORD', '{user_password}');
    define('MYSQL_DATABASE', '{database_name}');


***Note:*** You can generete the db and tables used for this example using the "php.sql" file on the Migration folder.
Or just create your on table and defaul root user with the following squeries (PostgreSQL queries):<br>
    CREATE DATABASE `databasename`;
    CREATE TABLE users (
        id SERIAL PRIMARY KEY,
        name VARCHAR(50) NOT NULL,
        gender VARCHAR(1) NOT NULL,
        color VARCHAR(10) NOT NULL,
        hash VARCHAR(100) NOT NULL,
        isadmin BIT(1) NOT NULL DEFAULT b'0',
    );
    ALTER TABLE users
        ALTER COLUMN id ADD GENERATED ALWAYS AS IDENTITY ;
    COMMIT;
    INSERT INTO users (id, name, gender, color, hash, isadmin) VALUES (
        1, 'root', 'o', '#0f0', '$2y$10$7LylyImbz7K3yWzT7JTzNO/ziSj.7Fo/TEF1n19qw9eeO54CpjkzW', b'1'
    );

This will create a database with a table users and a registry for a user:root with a password:root hashed and with admin status.

Hope this is usefull.
