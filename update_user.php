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

    $ok = true;
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = sprintf('SELECT * FROM users WHERE id=%s',
        $db->real_escape_string($id));
    $result = $db->query($sql);

    $row = $result->fetch_object();
    if ($row != null) {
        $isAdmin = $row->isAdmin;
        if ($isAdmin === '1') {
            $ok = false;
        }
    } else {
        header($http[404]);
        header('Location: read_users.php?badRequest=1');
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

        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $ok = false;
            $messages[$message_count] = 'user name';
            $message_count++;
        } else {
            $name = $_POST['name'];
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
            $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            $sql = sprintf(
                "UPDATE users SET name='%s', gender='%s', color='%s'
                    WHERE id=%s",
                $db->real_escape_string($name),
                $db->real_escape_string($gender),
                $db->real_escape_string($color),
                $id);
            $db->query($sql);
            printf('<div class="text-success"><p>%s
                <br>You will be redirected in %s seconds, if not <a href="read_users.php">clic here</a> to go back to the Read page.</p></div>',
                $messages[$message_count],
                REDIRECT_TIMEOUT);
            $db->close();

            $redirect = printf('<meta http-equiv="refresh" content="%s; url=read_users.php">', REDIRECT_TIMEOUT);
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
        header($http[404]);
        header('Location: read_users.php?badRequest=1');
    } else {
        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        $sql = "SELECT * FROM users WHERE id=$id";
        $result = $db->query($sql);
        foreach ($result as $row) {
            $name = $row['name'];
            $gender = $row['gender'];
            $color = $row['color'];
        }
        $db->close();
    };
?>

<form action="" method="POST">
    <div class="form-group">
        <label for="name">User name</label>
        <input type="text" class="form-control" name="name" id="name" value="<?php
            echo htmlspecialchars($name, ENT_QUOTES);
        ?>">
    </div>
    <div class="form-group">
        <label for="name">Password</label>
        <?php
            printf('<a href="change_password.php?id=%s">change</a>',
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

<?php
    readfile('footer.tmpl.html');
?>