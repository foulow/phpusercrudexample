<?php
    if ( ! defined('BASE_PATH')) {
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
        require BASE_PATH."unfound.inc.php";
    }

    if ($p != 'create_user' && $p != 'home') {
        readfile(BASE_PATH.'views/unfound.tmpl.html');
    } else {
    ?>
        <div class="container p-3 my-3 border">
        <h1 class="text-center">New user form</h1>
        <?php
            $name = '';
            $password = '';
            $rpd_password = '';
            $gender = '';
            $color = '';
            
            if (isset($_POST['submit'])) {
                $ok = true;
                $messages = array(5);
                $message_count = 0;
                $messages[$message_count] = 'User created.';

                if (!isset($_POST['username']) || $_POST['username'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'username';
                    $message_count++;
                } else {
                    $name = $_POST['username'];
                };
                if (!isset($_POST['password']) || $_POST['password'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'password';
                    $message_count++;
                } else {
                    $password = $_POST['password'];
                };
                if (!isset($_POST['rpd_password']) || $_POST['rpd_password'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'repeat password';
                    $message_count++;
                } else {
                    $rpd_password = $_POST['rpd_password'];
                };
                if (!($password === $rpd_password)) {
                    $ok = false;
                    $messages[$message_count] = 'passwords entered did not match';
                    $message_count++;
                }
                if (!isset($_POST['gender']) || $_POST['gender'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'gender';
                    $message_count++;
                } else {
                    $gender = $_POST['gender'];
                };
                if (!isset($_POST['color']) || $_POST['color'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'favorite color';
                    $message_count++;
                } else {
                    $color = $_POST['color'];
                };

                if ($ok === true) {
                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    if (DBCONTEXT === 'mysql') {
                        require BASE_PATH.'connections/mysql.inc.php';
                        $db = new MySQLDBContext();
                    } else if (DBCONTEXT === 'pgsql') {
                        require BASE_PATH.'connections/postgresql.inc.php';
                        $db = new PostgreSQLDBContext();
                    };
                    $sql = sprintf(
                        "INSERT INTO users (name, gender, color, hash) VALUES (
                            '%s','%s','%s', '%s')",
                        htmlspecialchars($name, ENT_QUOTES),
                        htmlspecialchars($gender, ENT_QUOTES),
                        htmlspecialchars($color, ENT_QUOTES),
                        htmlspecialchars($hash, ENT_QUOTES));
                    if (isset($logger)) $logger->info('Adding a new user', ['username' => $name]);
                    $db->query($sql);
                    printf('<div class="text-success"><p>%s</p></div>',
                        $messages[$message_count]);
                    $name = '';
                    $password = '';
                    $rpd_password = '';
                    $gender = '';
                    $color = '';
                } else {
                    printf('<div class="text-danger"><p>
                    <br>Please, complete the following %s form elements:
                    <br>%s</p></div>',
                    $message_count,
                    implode(', ', $messages));
                };
            };
        ?>

        <form action="" method="POST" name="create_user_form" id="create_user_form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php
                    echo htmlspecialchars($name, ENT_QUOTES);
                ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="rpd_password">Repeat password</label>
                <input type="password" class="form-control" name="rpd_password" id="rpd_password">
            </div>
            <div class="form-group">
                <div><label>Gender</label></div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="gender" id="gender-f" value="f"<?php
                        if ($gender === 'f') {
                            echo ' checked';
                        };
                    ?>>
                    <label class="form-check-label" for="gender-f">female</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="gender" id="gender-m" value="m"<?php
                        if ($gender === 'm') {
                            echo ' checked';
                        };
                    ?>>
                    <label class="form-check-label" for="gender-m">male</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="form-check-input" name="gender" id="gender-o" value="o"<?php
                        if ($gender === 'o') {
                            echo ' checked';
                        };
                    ?>>
                    <label class="form-check-label" for="gender-o">other</label>
                </div>
            </div>
            <div class="form-group">
                <div><label>Favorite color</label></div>
                    <select class="form-control" name="color" id="color">
                        <option value="">Please select</option>
                        <option value="#f00"<?php
                            if ($color === '#f00') {
                                echo ' selected';
                            };
                        ?>>red</option>
                        <option value="#0f0"<?php
                            if ($color === '#0f0') {
                                echo ' selected';
                            };
                        ?>>green</option>
                        <option value="#00f"<?php
                            if ($color === '#00f') {
                                echo ' selected';
                            };
                        ?>>blue</option>
                    </select><br>
            </div>
            <input type="submit"  class="btn btn-primary" name="submit" value="Create">
        </form>
        </div>
        <script src="js/create_user.js"></script>
    <?php
    }
?>
