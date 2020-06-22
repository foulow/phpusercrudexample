<?php
    session_start();

    if (!isset($_SESSION['isAdmin'])) {
        header($http[401]);
        header('Location: login.php');
    } 
    else if (!($_SESSION['isAdmin'] === '1')) {
        header($http[401]);
        header('Location: login.php?isAdmin=0');
    };
?>