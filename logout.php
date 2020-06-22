<?php
    require_once 'config.inc.php';

    session_start();

    readfile('header.tmpl.html');

    if (isset($_SESSION['username'])) {
        unset($_SESSION['username']);
    }

    if (isset($_SESSION['isAdmin'])) {
        unset($_SESSION['isAdmin']);
    }

    printf('<div class="container p-3 my-3 bg-dark text-white"><h1 class="text-center">User logged out.</h1>
        <p class="text-center">You will be redirected in %s seconds, if not <a href="login.php">clic here</a> to go back to the Login page.</p>
        </div>',
        REDIRECT_TIMEOUT);

    $redirect = printf('<meta http-equiv="refresh" content="%s; url=login.php">', REDIRECT_TIMEOUT);
    header($http[200]);
    header( $redirect );

    readfile('footer.tmpl.html');
?>