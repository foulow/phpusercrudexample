<?php
    require 'auth.inc.php';
    require_once 'config.inc.php';
    
    readfile('header.tmpl.html');

    require 'connections/postgresql.php';
?>

<div class="container p-3 my-3 border">
<h1 class="text-center">List of users</h1>
<ul class="list-group">
<?php
    $db = new PostgreSQLDBContext();
    $db->query("SELECT * FROM users WHERE isAdmin=b'0'");
    
    $lines = $db->fetch_all_results();
    if ($lines != null && $lines != false) {
        foreach ($lines as $line) {
            printf(
                '<li class="list-group-item d-flex justify-content-between"><span style="color: %s">%s (%s)</span>
                    <div>
                        <a href="update_user.php?id=%s" class="btn btn-sm btn-primary active" role="button">Update</a>
                        <a href="delete_user.php?id=%s" class="btn btn-sm btn-danger active" role="button">Delete</a>
                    </div>
                </h1>',
                htmlspecialchars($line['color'], ENT_QUOTES),
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
<a href="create_user.inc.php?style=1" class="btn btn-lg btn-block btn-primary active" role="button">Create a new user</a>
</div>

<?php
    readfile('footer.tmpl.html');
?>