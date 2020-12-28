<?php
    if ( ! defined('BASE_PATH')) {
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
        require "unfound.inc.php";
    }
    
    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;
    use Monolog\Handler\FirePHPHandler;

    $logger = new Logger('name');
    $logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
    $logger->pushHandler(new FirePHPHandler());

    $logger->info('Monologer instantiated as expected.');
?>
