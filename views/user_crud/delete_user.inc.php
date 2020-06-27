<?php
    require 'config/auth.inc.php';

    if ($p != 'delete_user') {
        readfile('views/unfound.tmpl.html');
    } else {
        if (isset($_GET['id']) && ctype_digit($_GET['id'])) {
            $id = $_GET['id'];
        } else {
            header($http[400]);
            header('Location: ./?p=read_users');
        };

        $ok = true;
        if (DBCONTEXT === 'mysql') {
            require 'connections/mysql.inc.php';
            $db = new MySQLDBContext();
        } else if (DBCONTEXT === 'pgsql') {
            require 'connections/postgresql.inc.php';
            $db = new PostgreSQLDBContext();
        };
        $db->query("SELECT * FROM users WHERE id=$id");

        $line = $db->fetch_result();
        $db->free_result();
        if ($line != null && $line != false) {
            $isAdmin = $line['isadmin'];
            if ($isAdmin === '1') {
                $ok = false;
            }
        } else {
            header($http[400]);
            header('Location: ./?p=read_users&badRequest=1');
        };

        if ($ok === true) {
            $db->query("DELETE FROM users WHERE id=$id");
            printf('<div class="container p-3 my-3 bg-dark text-white"><h1 class="text-center">User deleted.</h1>
                <p class="text-center">You will be redirected in %s seconds, if not <a href="?p=read_users">clic here</a> to go back to the Read page.</p>
                </div>',
                REDIRECT_TIMEOUT);
        
            $redirect = printf('<meta http-equiv="refresh" content="%s; url=?p=read_users">', REDIRECT_TIMEOUT);
            header($http[200]);
            header( $redirect );
        } else {
            header($http[401]);
            header('Location: ./?p=read_users&unauthorized=1');
        };
    }
?>