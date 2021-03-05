<?php

include('db/db.php');
include('data.php');
session_start();

$config = get_ini($CONFIG_FILE_PATH);
$MIN_PASSWD_LEN = $config[' DATA ']['min_passwd_length'];
$MAX_PASSWD_LEN = $config[' DATA ']['max_passwd_length'];


// SETUP FOR LOGIN FILE (INDEX.PHP)
if ((isset($_GET['login'])) && ($_GET['login'] == 1)) {

    // GET POST DATA
    $USERNAME = $_POST['username'] ?? null;
    $PASSWORD = $_POST['passwd'] ?? null;

    $USERNAME = trim($USERNAME);
    $PASSWORD = trim($PASSWORD);

    $USERNAME = str_replace(' ', '', $USERNAME);
    $PASSWORD = str_replace(' ', '', $PASSWORD);

    // GET THE PASSWORD FOR A GIVEN USERNAME
    $result = check_if_user_exists($USERNAME);

    if ($result != false) {

        $correct = password_verify($PASSWORD, $result[0]['passwd']);
        if ($correct == true) {
            $_SESSION['logged'] = true;
            $_SESSION['ID'] = $result[0]['id'];
            $_SESSION['username'] = $USERNAME;
            header('Location: game.php');

        } else {
            if (isset($_COOKIE['error_msg'])) unset($_COOKIE['error_msg']);
            setcookie('error_msg', 1, 0, '/');

            header("Location: index.php?error_msg=Your username or password isn't valid");
        }


    } else {
        if (isset($_COOKIE['error_msg'])) unset($_COOKIE['error_msg']);
        setcookie('error_msg', 1, 0, '/');

        header("Location: index.php?error_msg=Your username or password isn't valid");

    }

// SETUP FOR REGISTER FILE (REGISTER.PHP)
} else if ((isset($_GET['register'])) && ($_GET['register'] == 1)) {

    // GET POST DATA
    $USERNAME = $_POST['username'] ?? null;
    $PASSWORD = $_POST['passwd'] ?? null;
    $PASSWORD_AGAIN = $_POST['passwd_again'] ?? null;

    $USERNAME = str_replace(' ', '', $USERNAME);
    $PASSWORD = str_replace(' ', '', $PASSWORD);
    $PASSWORD_AGAIN = str_replace(' ', '', $PASSWORD_AGAIN);

    $USERNAME = trim($USERNAME);
    $PASSWORD = trim($PASSWORD);
    $PASSWORD_AGAIN = trim($PASSWORD_AGAIN);

    var_dump(strlen($PASSWORD), $MAX_PASSWD_LEN);

    if ((strlen($PASSWORD) > $MAX_PASSWD_LEN) || (strlen($PASSWORD) < $MIN_PASSWD_LEN)) {
        if (isset($_COOKIE['register_error_msg'])) unset($_COOKIE['register_error_msg']);
        setcookie('register_error_msg', 1, 0, '/');

        header("Location: register.php?register_error_msg=Your password length has to be between 8 to 15 chars!");
        return;
    }


    if ($PASSWORD == $PASSWORD_AGAIN) {

        // HASH THE PASSWORD
        $PASSWORD = password_hash($PASSWORD, PASSWORD_DEFAULT);

        $result = add_user_data($USERNAME, $PASSWORD);

        // IF USER ALREADY EXISTS IN DATABASE
        if (gettype($result) != 'array') {
            if (isset($_COOKIE['register_error_msg'])) unset($_COOKIE['register_error_msg']);
            setcookie('register_error_msg', 1, 0, '/');

            header("Location: register.php?register_error_msg=".$result);
        }

        // WHEN ALL IS CORRECT

        $_SESSION['logged'] = true;
        $_SESSION['ID'] = get_last_id();
        $_SESSION['username'] = $USERNAME;

        header('Location: game.php');

    } else {
        if (isset($_COOKIE['register_error_msg'])) unset($_COOKIE['register_error_msg']);
        setcookie('register_error_msg', 1, 0, '/');

        header("Location: register.php?register_error_msg=Your passwords aren't the same! ");
    }


}


