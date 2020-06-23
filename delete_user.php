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

    require 'connections/postgresql.php';

    $ok = true;
    $db = new PostgreSQLDBContext();
    $db->query("SELECT * FROM users WHERE id=$id");

    $line = $db->fetch_result();
    $db->free_result();
    if ($line != null && $line != false) {
        $isAdmin = $line['isadmin'];
        if ($isAdmin === '1') {
            $ok = false;
        }
    } else {
        header($http[404]);
        header('Location: read_users.php?badRequest=1');
    };

    if (isset($id) && $ok === true) {
        $db->query("DELETE FROM users WHERE id=$id");
        printf('<div class="container p-3 my-3 bg-dark text-white"><h1 class="text-center">User deleted.</h1>
            <p class="text-center">You will be redirected in %s seconds, if not <a href="read_users.php">clic here</a> to go back to the Read page.</p>
            </div>',
            REDIRECT_TIMEOUT);
    
        $redirect = printf('<meta http-equiv="refresh" content="%s; url=read_users.php">', REDIRECT_TIMEOUT);
        header($http[200]);
        header( $redirect );
    } else {
        header($http[404]);
        header('Location: read_users.php?badRequest=1');
    };

    readfile('footer.tmpl.html');
?>