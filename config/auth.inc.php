<?php
    session_start();

    if (!isset($_SESSION['isAdmin'])) {
        header($http[401]);
        header('Location: ./?p=login');
    } 
    else if (!($_SESSION['isAdmin'] === '1')) {
        header($http[401]);
        header('Location: ./?p=login&isAdmin=0');
    };
?>