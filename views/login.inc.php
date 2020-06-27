<?php
    require_once 'config/config.inc.php';
    
    if (isset($_GET['isAdmin']) && ctype_digit($_GET['isAdmin'])) {
        $isAdmin = $_GET['isAdmin'];
    };
?>

<div class="container p-3 my-3 border">
<h1 class="text-center">Login form</h1>
<?php
    $name = '';
    $password = '';
    $message = '';

    if (isset($isAdmin)) {
        echo '<div class="text-danger"><p>User has not admin access. </p></div>
            <div class="text-danger"><p>Fist <a href="?p=logout">Log out</a> then, Log in as {user:root; password:root} 
            <br>to access the Read, Update or Delete page.</p></div>';
    };

    if (isset($_POST['name']) && isset($_POST['password'])) {
        $ok = true;
        $name = $_POST['name'];
        $password = $_POST['password'];

        if (DBCONTEXT === 'mysql') {
            require 'connections/mysql.inc.php';
            $db = new MySQLDBContext();
        } else if (DBCONTEXT === 'pgsql') {
            require 'connections/postgresql.inc.php';
            $db = new PostgreSQLDBContext();
        };
        $sql = sprintf("SELECT * FROM users WHERE name='%s'",
            htmlspecialchars($name, ENT_QUOTES));
        $db->query($sql);

        $line = $db->fetch_result();
        if ($line != null && $line != false) {
            $hash = $line['hash'];
            if (password_verify($password, $hash)) {
                $message = 'Login successful.';
                session_start();

                $_SESSION['username'] = $line['name'];
                $_SESSION['isAdmin'] = $line['isadmin'];
            } else {
                $ok = false;
                $message = 'Login failed. Incorrect user name or password.';
            };
        } else {
            $ok = false;
            $message = 'Login failed. Incorrect user name or password.';
        };
        $message_type = ($ok)? 'success' : 'danger';

        if ($ok === true) {
            printf('<div class="text-%s"><p>%s</p>
                <p class="text-center">You will be redirected in %s seconds, if not <a href="?p=home">clic here</a> to go back to the Home page.</p>
                </div>',
                $message_type,
                $message,
                REDIRECT_TIMEOUT);

            $redirect = printf('<meta http-equiv="refresh" content="%s; url=?p=home">', REDIRECT_TIMEOUT);
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