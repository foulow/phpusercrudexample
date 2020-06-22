<?php
    require 'auth.inc.php';
    require_once 'config.inc.php';
    
    readfile('header.tmpl.html');
?>

<div class="container p-3 my-3 border">
<h1 class="text-center">List of users</h1>
<ul class="list-group">
<?php
    $db = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
    $sql = 'SELECT * FROM users WHERE isAdmin=0';
    $result = $db->query($sql);
    
    foreach ($result as $row) {
        printf(
            '<li class="list-group-item d-flex justify-content-between"><span style="color: %s">%s (%s)</span>
                <div>
                    <a href="update_user.php?id=%s" class="btn btn-sm btn-primary active" role="button">Update</a>
                    <a href="delete_user.php?id=%s" class="btn btn-sm btn-danger active" role="button">Delete</a>
                </div>
            </h1>',
            htmlspecialchars($row['color'], ENT_QUOTES),
            htmlspecialchars($row['name'], ENT_QUOTES),
            htmlspecialchars($row['gender'], ENT_QUOTES),
            htmlspecialchars($row['id'], ENT_QUOTES),
            htmlspecialchars($row['id'], ENT_QUOTES));
    };

    $db->close();
?>
</ul>
<br>
<a href="create_user.inc.php?style=1" class="btn btn-lg btn-block btn-primary active" role="button">Create a new user</a>
</div>

<?php
    readfile('footer.tmpl.html');
?>