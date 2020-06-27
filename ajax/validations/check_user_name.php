<?php
    header('Access-Control-Allow-Origin: *; Content-Type: application/text charset=UTF-8');

    require "../../config/config.inc.php";

    if( !isset($_POST['username']) ) { 
        echo 'false';
        die();
    };
    $requested_name  = $_POST['username'];
    if ( isset($_POST['currentusername']) ) {
        $old_name = $_POST['currentusername'];
    } else {
        $old_name = "";
    }
    
    if (DBCONTEXT === 'mysql') {
        require '../../connections/mysql.inc.php';
        $db = new MySQLDBContext();
    } else if (DBCONTEXT === 'pgsql') {
        require '../../connections/postgresql.inc.php';
        $db = new PostgreSQLDBContext();
    };
    $db->query("SELECT name FROM users");

    $user_names = $db->fetch_all_results();
    foreach( $user_names as $user) {
        if ($requested_name === $user['name'] && $old_name != $user['name']) {
            echo 'false';
            die();
        }
    }
    echo 'true';
?>