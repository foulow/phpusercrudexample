<?php
    require_once 'config.inc.php';
    
    $style = '0';
    if (isset($_GET['style']) && ctype_digit($_GET['style'])) {
        $style = $_GET['style'];
        if ($style === '1') readfile('header.tmpl.html');
    };
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

        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $ok = false;
            $messages[$message_count] = 'user name';
            $message_count++;
        } else {
            $name = $_POST['name'];
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

            $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            $sql = sprintf(
                "INSERT INTO users (name, gender, color, hash) VALUES (
                    '%s','%s','%s', '%s')",
                $db->real_escape_string($name),
                $db->real_escape_string($gender),
                $db->real_escape_string($color),
                $db->real_escape_string($hash));
            $db->query($sql);
            printf('<div class="text-success"><p>%s</p></div>',
                $messages[$message_count]);
            $db->close();
        } else {
            printf('<div class="text-danger"><p>
            <br>Please, complete the following %s form elements:
            <br>%s</p></div>',
            $message_count,
            implode(', ', $messages));
        };
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
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group">
        <label for="name">Repeat password</label>
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

<?php
    if ($style === '1') readfile('footer.tmpl.html');
?>