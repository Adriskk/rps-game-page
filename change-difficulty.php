<?php

require('data.php');
session_start();

$status = 'ERROR';

    if (isset($_POST['diff'])) $DIFFICULTY = $_POST['diff'];

    switch ($DIFFICULTY) {
        case 'amateur': {$_SESSION['difficulty'] = serialize($EASY); } break;
        case 'intermediate': {$_SESSION['difficulty'] = serialize($INTM); } break;
        case 'expert': {$_SESSION['difficulty'] = serialize($EXPERT); } break;
        default: {$_SESSION['difficulty'] = serialize($EASY); } break;
    }

    // IF COOKIE ISSET
    if (isset($_COOKIE['diff'])) unset($_COOKIE['diff']);

    // SET COOKIE
    setcookie('diff', $DIFFICULTY, 0, '/');

    $status = 'OK';

echo $status;
