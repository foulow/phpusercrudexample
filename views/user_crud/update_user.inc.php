<?php
    require 'config/auth.inc.php';

    if ($p != 'update_user') {
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
    ?>
        <div class="container p-3 my-3 border">
        <h1 class="text-center">Update form</h1>
        <?php
            $name = '';
            $gender = '';
            $color = '';
            
            if (isset($_POST['submit']) && $ok === true) {
                $messages = array(4);
                $message_count = 0;
                $messages[$message_count] = 'User updated.';

                if (!isset($_POST['username']) || $_POST['username'] === '') {
                    $ok = false;
                    $messages[$message_count] = 'username';
                    $message_count++;
                } else {
                    $name = $_POST['username'];
                };
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
                    $sql = sprintf(
                        "UPDATE users SET name='%s', gender='%s', color='%s'
                            WHERE id=%s",
                        htmlspecialchars($name),
                        htmlspecialchars($gender),
                        htmlspecialchars($color),
                        $id);
                    $db->query($sql);
                    $db->free_result();
                    printf('<div class="text-success"><p>%s
                        <br>You will be redirected in %s seconds, if not <a href="?p=read_users">clic here</a> to go back to the Read page.</p></div>',
                        $messages[$message_count],
                        REDIRECT_TIMEOUT);

                    $redirect = printf('<meta http-equiv="refresh" content="%s; url=?p=read_users">', REDIRECT_TIMEOUT);
                    header($http[200]);
                    header($redirect);
                } else {
                    printf('<div class="text-danger"><p>
                    <br>Please, complete the following %s form elements:
                    <br>%s</p></div>',
                    $message_count,
                    implode(', ', $messages));
                };
            } else if ($ok === false) {
                header($http[401]);
                header('Location: ./?p=read_users&unauthorized=1');
            } else {
                $db->query("SELECT * FROM users WHERE id=$id");
                $line = $db->fetch_result();
                if ($line != null && $line != false) {
                    $name = $line['name'];
                    echo '<div hidden><input type="text" name="currentusername" id="currentusername" value='. htmlspecialchars($name) .'></input></div>';
                    $gender = $line['gender'];
                    $color = $line['color'];
                } else {
                    header($http[400]);
                    header('Location: ./?p=read_users&badRequest=1');
                }
            };
        ?>

        <form action="" method="POST" name="update_user_form" id="update_user_form">
            <div class="form-group">
            <label for="username">Username</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php
                    echo htmlspecialchars($name, ENT_QUOTES);
                ?>">
            </div>
            <div class="form-group">
                <label for="name">Password</label>
                <?php
                    printf('<a href="?p=change_password&id=%s">change</a>',
                        $id);
                ?>
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
            <input type="submit"  class="btn btn-primary" name="submit" value="Update">
        </form>
        </div>
        <script src="js/update_user.js"></script>
    <?php
    }
?>