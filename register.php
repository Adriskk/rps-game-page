<?php

    session_start();

    if (isset($_GET['register_error_msg'])) { $ERROR_MSG = $_GET['register_error_msg']; $display = 'block'; }
    else { $ERROR_MSG = ''; $display = 'none'; }

    if (isset($_COOKIE['register_error_msg'])) unset($_COOKIE['register_error_msg']);


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

    <title>RPS Game | Register an account</title>
</head>
<body>

<div class="container">
        <div class="header">
            <span class="header-text">
                New account
            </span>
        </div>

        <div class="error" style="display: <?= $display ?>">
            <span class="login-error">
                <?= $ERROR_MSG ?>
            </span>
        </div>

        <div class="content">
            <form action="setup.php?register=1" method="POST">


                    <div class="box">
                        <span class="box-span">Username *</span>
                        <input type="text" name="username" class="text-inpt" required>
                    </div>

                    <div class="box">
                        <span class="box-span">Password *</span>
                        <input type="password" name="passwd" class="passwd-inpt" required>
                    </div>

                    <div class="box">
                        <span class="box-span">Password *</span>
                        <input type="password" name="passwd_again" class="passwd-inpt" required>
                    </div>

                    <div class="box">
                        <input type="submit" class="submit-inpt" name="submit" value="Register">
                    </div>

            </form>
        </div>

        <div class="register">
            <span class="register-text">* - required</span>
            <a href="index.php"> <span class="register-text">Back to login page</span> </a>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <!-- <script src="js/error.js"></script> -->

</body>
</html>