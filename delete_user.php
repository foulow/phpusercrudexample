<?php
    require 'auth.inc.php';
    require_once 'config.inc.php';

    if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
        $id = $_GET['id'];
        readfile('header.tmpl.html');
    } else {
        header($http[401]);
        header('Location: read_users.php');
    };

    if (isset($id)) {
        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        $sql = "DELETE FROM users WHERE id=$id";
        $db->query($sql);
        printf('<div class="container p-3 my-3 bg-dark text-white"><h1 class="text-center">User deleted.</h1>
            <p class="text-center">You will be redirected in %s seconds, if not <a href="read_users.php">clic here</a> to go back to the Read page.</p>
            </div>',
            REDIRECT_TIMEOUT);
        $db->close();
    
        $redirect = printf('<meta http-equiv="refresh" content="%s; url=read_users.php">', REDIRECT_TIMEOUT);
        header($http[200]);
        header( $redirect );
    }

    readfile('footer.tmpl.html');
?>