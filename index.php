<?php

    session_start();

    if ((isset($_SESSION['logged'])) && ($_SESSION['logged'] == true)) header('Location: game.php');

    if (isset($_GET['error_msg'])) { $ERROR_MSG = $_GET['error_msg']; $display = 'block'; }
    else { $ERROR_MSG = ''; $display = 'none'; }

    if (isset($_COOKIE['error_msg'])) unset($_COOKIE['error_msg']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLES -->
    <link rel="stylesheet" href="styles/login.css">
    <link rel="stylesheet" href="styles/login-properties.css">

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <title>RPS Game | Login page</title>
</head>
<body>

    <div class="container">
        <div class="header">
            <span class="header-text">
                Login
            </span>
        </div>

        <div class="error" style="display: <?= $display ?>">
            <span class="login-error">
                <?= $ERROR_MSG ?>
            </span>
        </div>

        <div class="content">
            <form action="setup.php?login=1" method="POST">


                    <div class="box">
                        <span class="box-span">Username</span>
                        <input type="text" name="username" class="text-inpt" required>
                    </div>

                    <div class="box">
                        <span class="box-span">Password</span>
                        <input type="password" name="passwd" class="passwd-inpt" required>
                    </div>

                    <div class="box">
                        <input type="submit" class="submit-inpt" name="submit" value="Login">
                    </div>

            </form>
        </div>

        <div class="register">
            <a href="register.php"> <span class="register-text">Not registered yet? - register here</span> </a>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- <script src="js/error.js"></script> -->
</body>
</html>