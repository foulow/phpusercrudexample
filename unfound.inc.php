<?php
    header($http[404]);
    readfile(BASE_PATH.'views/header.tmpl.html');
    echo '<div class="container p-3 my-3 border center"><h1 class="text-center">404 Not Found.</h1>';
    $protocol = "http".(isset($_SERVER['HTTPS']) ? 's' : '') ."://";
    $host = "{$protocol}{$_SERVER['HTTP_HOST']}";
    $actual_route = "{$host}{$_SERVER['REQUEST_URI']}";
    echo '<p class="text-danger text-center">The page you are trying to access: <b>'.$actual_route.'</b> was not found. <a href="'.$host.'/?p=home">Clic here</a> to go back to the Home page.</p></div>';
    readfile(BASE_PATH.'views/footer.tmpl.html');
    die();
?>
