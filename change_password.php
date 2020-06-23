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
?>

<div class="container p-3 my-3 border">
<h1 class="text-center">Password change form</h1>
<?php
    $password='';
    $new_password='';
    $rpd_password='';

    if (isset($_POST['submit'])) {
        $ok = true;
        $messages = array(5);
        $message_count = 0;
        $messages[$message_count] = 'Password changed.';

        if (!isset($_POST['password']) || $_POST['password'] === '') {
            $ok = false;
            $messages[$message_count] = 'password';
            $message_count++;
        } else {
            $password = $_POST['password'];

            $db = new PostgreSQLDBContext();
            $db->query("SELECT * FROM users WHERE id=$id");
            $line = $db->fetch_result();
            $db->free_result();
            if ($line != null && $line != false) {
                $hashed_password = $line['hash'];
            }

            if(!password_verify($password, $hashed_password)) {
                $ok = false;
                $messages[$message_count] = 'current password mistyped';
                $message_count++;
            };
        };
        if (!isset($_POST['new_password']) || $_POST['new_password'] === '') {
            $ok = false;
            $messages[$message_count] = 'new password';
            $message_count++;
        } else {
            $new_password = $_POST['new_password'];
        };
        if (!isset($_POST['rpd_password']) || $_POST['rpd_password'] === '') {
            $ok = false;
            $messages[$message_count] = 'repeat password';
            $message_count++;
        } else {
            $rpd_password = $_POST['rpd_password'];
        };
        if (!($new_password === $rpd_password)) {
            $ok = false;
            $messages[$message_count] = 'passwords entered did not match';
            $message_count++;
        }

        if ($ok === true) {
            $hash = password_hash($new_password, PASSWORD_DEFAULT);

            $sql = sprintf("UPDATE users SET hash='%s'
                WHERE id=%s",
                htmlspecialchars($hash),
                $id);
            $db->query($sql);
            printf('<div class="text-success"><p>%s
                <br>You will be redirected in %s seconds, if not <a href="update_user.php?id=%s">clic here</a> to go back to the Update page.</p></div>',
                $messages[$message_count],
                REDIRECT_TIMEOUT,
                $id);

            header($http[200]);
            $redirect = printf('<meta http-equiv="refresh" content="%s; url=update_user.php?id=%s">', REDIRECT_TIMEOUT, $id);
            header($redirect);
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
        <label for="name">Current password</label>
        <input type="password" class="form-control" name="password" id="password">
    </div>
    <div class="form-group">
        <label for="name">New password</label>
        <input type="password" class="form-control" name="new_password" id="new_password">
    </div>
    <div class="form-group">
        <label for="name">Repeat password</label>
        <input type="password" class="form-control" name="rpd_password" id="rpd_password">
    </div>
    <input type="submit"  class="btn btn-primary" name="submit" value="Change">
</form>
</div>

<?php
    readfile('footer.tmpl.html');
?>