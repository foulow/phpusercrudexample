<?php
    if ( ! defined('BASE_PATH')) {
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
        require BASE_PATH."unfound.inc.php";
    }
    //* Replace for `.user.ini` file configuration. 
        ini_set('session.save_handler', 'memcached');
        ini_set('session.save_path', getenv('MEMCACHIER_SERVERS'));
        if(version_compare(phpversion('memcached'), '3', '>=')) {
            ini_set('memcached.sess_persistent', 1);
            ini_set('memcached.sess_binary_protocol', 1);
        } else {
            ini_set('session.save_path', 'PERSISTENT=myapp_session ' . ini_get('session.save_path'));
            ini_set('memcached.sess_binary', 1);
        }
        ini_set('memcached.sess_sasl_username', getenv('MEMCACHIER_USERNAME'));
        ini_set('memcached.sess_sasl_password', getenv('MEMCACHIER_PASSWORD'));
    //*/
    session_start();

    if (!isset($_SESSION['isAdmin'])) {
        header($http[401]);
        header('Location: ./?p=login');
    } 
    else if (!($_SESSION['isAdmin'] === '1')) {
        header($http[401]);
        header('Location: ./?p=login&isAdmin=0');
    };
?>