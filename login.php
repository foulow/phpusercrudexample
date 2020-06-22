<?php
    require_once 'config.inc.php';
    
    $isAdmin = '-1';
    if (isset($_GET['isAdmin']) && ctype_digit($_GET['isAdmin'])) {
        $isAdmin = $_GET['isAdmin'];
    };

    readfile('header.tmpl.html');
?>

<div class="container p-3 my-3 border">
<h1 class="text-center">Login form</h1>
<?php
    $name = '';
    $password = '';
    $message = '';

    if ($isAdmin === '0') {
        echo '<div class="text-danger"><p>User has not admin access. </p></div>
            <div class="text-danger"><p>Fist <a href="logout.php">Log out</a> then, Log in as {user:root; password:root} 
            <br>to access the Read, Update or Delete page.</p></div>';
    };

    if (isset($_POST['name']) && isset($_POST['password'])) {
        $ok = true;
        $name = $_POST['name'];
        $password = $_POST['password'];

        $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
        $sql = sprintf("SELECT * FROM users WHERE name='%s'",
            $db->real_escape_string($name));
        $result = $db->query($sql);

        $row = $result->fetch_object();
        if ($row != null) {
            $hash = $row->hash;
            if (password_verify($password, $hash)) {
                $message = 'Login successful.';
                session_start();

                $_SESSION['username'] = $row->name;
                $_SESSION['isAdmin'] = $row->isAdmin;
            } else {
                $ok = false;
                $message = 'Login failed. Incorrect user name or password.';
            };
        } else {
            $ok = false;
            $message = 'Login failed. Incorrect user name or password.';
        };
        $message_type = ($ok)? 'success' : 'danger';
        $db->close();

        if ($ok === true) {
            printf('<div class="text-%s"><p>%s</p>
                <p class="text-center">You will be redirected in %s seconds, if not <a href="index.php">clic here</a> to go back to the Home page.</p>
                </div>',
                $message_type,
                $message,
                REDIRECT_TIMEOUT);

            $redirect = printf('<meta http-equiv="refresh" content="%s; url=index.php">', REDIRECT_TIMEOUT);
            header($http[200]);
            header( $redirect );
        } else {
            printf('<div class="text-%s"><p>%s</p>',
                $message_type,
                $message);
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
    <input type="submit"  class="btn btn-primary" name="submit" value="Login">
</form>
</div>

<?php
    readfile('footer.tmpl.html');
?>