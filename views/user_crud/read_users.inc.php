<?php
    if ( ! defined('BASE_PATH')) {
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
        require BASE_PATH."unfound.inc.php";
    }
    
    require BASE_PATH.'config/auth.inc.php';
    
    if ($p != 'read_users') {
        readfile(BASE_PATH.'views/unfound.tmpl.html');
    } else {
        if (isset($_GET['badRequest']) && ctype_digit($_GET['badRequest'])) {
            $badRequest = $_GET['badRequest'];
        } else if (isset($_GET['unauthorized']) && ctype_digit($_GET['unauthorized'])) {
            $badRequest = $_GET['unauthorized'];
        }

        if (isset($badRequest)) {
            readfile(BASE_PATH.'views/bad_request.tmpl.html');
        }
    ?>
        <div class="container p-3 my-3 border">
        <h1 class="text-center">List of users</h1>
        <ul class="list-group">
        <?php
            if (DBCONTEXT === 'mysql') {
                require BASE_PATH.'connections/mysql.inc.php';
                $db = new MySQLDBContext();
            } else if (DBCONTEXT === 'pgsql') {
                require BASE_PATH.'connections/postgresql.inc.php';
                $db = new PostgreSQLDBContext();
            };
            $db->query("SELECT * FROM users WHERE isAdmin=b'0'");
            
            $lines = $db->fetch_all_results();
            if ($lines != null && $lines != false) {
                foreach ($lines as $line) {
                    printf(
                        '<li class="list-group-item d-flex justify-content-between"><span style="color: %s">[ID] %s, [NAME] %s, [GENDER] (%s)</span>
                            <div>
                                <a href="?p=update_user&id=%s" class="btn btn-sm btn-primary active" role="button">Update</a>
                                <a href="?p=delete_user&id=%s" class="btn btn-sm btn-danger active" role="button">Delete</a>
                            </div>
                        </h1>',
                        htmlspecialchars($line['color'], ENT_QUOTES),
                        htmlspecialchars($line['id'], ENT_QUOTES),
                        htmlspecialchars($line['name'], ENT_QUOTES),
                        htmlspecialchars($line['gender'], ENT_QUOTES),
                        htmlspecialchars($line['id'], ENT_QUOTES),
                        htmlspecialchars($line['id'], ENT_QUOTES));
                };
            } else {
                echo '<div class="text-info">
                <p class="text-center">Looks like there are no Users on the Database
                <br>Try to create a new user, to see what happens.</p></div>';
            }
            
        ?>
        </ul>
        <br>
        <a href="?p=create_user" class="btn btn-lg btn-block btn-primary active" role="button">Create a new user</a>
        </div>
    <?php
    }
?>