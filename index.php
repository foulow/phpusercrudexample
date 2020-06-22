<?php
    readfile('header.tmpl.html');
?>

<div class="container p-3 my-3 bg-primary text-white center">
    <h1 class="text-center">Welcome to the home page.</h1>
    <p class="text-center">Please choose one of the menu options to test the CRUP.</p>
</div>

<?php
    require 'create_user.inc.php';

    readfile('footer.tmpl.html');
?>