<?php
    // root constant definition to prevent direct file access.
    define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
    
    require_once "vendor/autoload.php";
    require_once "config/config.inc.php";

    // uncomment for server-side output log funtionality.
    require_once "logger.inc.php";
    /* replace composer.json `require` section with this:
        "require": {
            "ext-memcached": "*",
            "monolog/monolog": "^2.2"
        }
       and run `composer install` on the terminal
    */
    readfile('views/header.tmpl.html');
    if ($p == 'home') {
        readfile('views/greetings.tmpl.html');
        require 'views/user_crud/create_user.inc.php';
    } else if ($p == 'login') {
        require 'views/login.inc.php';
    } else if ($p == 'logout') {
        require 'views/logout.inc.php';
    } else {
        if (file_exists("views/user_crud/".$p.".inc.php")){
            require "views/user_crud/".$p.".inc.php";
        }else{
            echo '<div class="container p-3 my-3 border center"><h1 class="text-center">404 Not Found.</h1>';
            echo '<p class="text-danger text-center">The page you are trying to access: <b>'.$p.'</b> was not found. <a href="?p=home">Clic here</a> to go back to the Home page.</p></div>';
        }
    }
    readfile(BASE_PATH.'views/footer.tmpl.html');
?>