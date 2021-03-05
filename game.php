<?php

    # -*- coding: utf-8 -*-

    include('data.php');
    require('db/db.php');

    session_start();

    if ((!isset($_SESSION['logged'])) && ($_SESSION['logged'] != true)) header('Location: logout.php');

    if (!isset($_SESSION['SCORE'])) $_SESSION['SCORE'] = $SCORE;

    if (gettype($_SESSION['ID']) == 'array') $_SESSION['ID'] = $_SESSION['ID'][0];

    $_SESSION['page'] = 'GAME';

    # => IF RESET BUTTON CLICKED
    if (isset($_GET['reset']) && $_GET['reset'] == 1) {

        // ADD DATA TO THE DATABASE
        add_rank($_SESSION['ID'], $_SESSION['SCORE'], $_COOKIE['diff']);

        $_SESSION['SCORE']['user'] = 0;
        $_SESSION['SCORE']['ai'] = 0;

        unset($_GET);

        # =>  REDIRECT TO THE SAME FILE
        header("Location: redirection.php");
    }

    if (!isset($_SESSION['difficulty'])) $_SESSION['difficulty'] = serialize($EASY);
    $DIFFICULTY = $_SESSION['difficulty'];

    if (!isset($_COOKIE['diff'])) setcookie('diff', $DIFFICULTY, 0, '/');

    if (!isset($_SESSION['latest_user'])) $_SESSION['latest_user'] = [];

    if (!isset($_SESSION['latest_ai'])) $_SESSION['latest_ai'] = [];

    // var_dump($_SESSION['difficulty']);

    // var_dump($_SESSION['ID']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPS GAME</title>

    <!-- STYLES -->
    <link rel="stylesheet" href="styles/game.css">
    <link rel="stylesheet" href="styles/properties.css">
    <link rel="stylesheet" href="styles/nav.css">

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <!-- NAV -->
    <div class="nav">
        <span class="page-name">
            <span>R</span>ock <span>P</span>aper <span>S</span>cissors <span class="page-type"> - <?= $_SESSION['page'] ?> </span>
        </span>

        <span class="user-nav">
            <span class="logged-as"> LOGGED AS <span class="nick"> <?= $_SESSION['username'] ?> </span> </span>
            <a href="logout.php"> <span class="logout-btn"> <span class="logout-span">Logout</span> </span> </a>
        </span>

    </div>

    <!-- MAIN -->
    <div class="images-container ranking-container" id="redirection">
        <?php

            $type = 'user';

            for($i=0; $i<2; $i++) {
                if ($i == 1) {
                    echo '<div class="tile">';
                    echo '<span class="versus">VS</span>';
                    echo '<span class="score">'.$_SESSION['SCORE']['user'].' : '.$_SESSION['SCORE']['ai'].'</span>';
                    echo '<a href="game.php?reset=1" class="reset-btn">RESET</a>';
                    echo '<span class="game-status" id="game-status">STATUS</span>';
                    echo '</div>';
                }

                echo '<div class="tile">';
                    echo '<span class="players">'.$PLAYERS[$i].'</span>';
                    echo '<img class="image clickable '.$type.'" src="'.$START[$i].'" width="'.$_SIZE['x'].'" height="'.$_SIZE['y'].'">';
                echo '</div>';

                $type = 'ai';
            }

        ?>
    </div>

    <div class="interface">

        <div class="user-buttons">
            <span class="choose">Choose your move</span>

            <div class="button to-click clickable rock">
                <span class="user-buttons-span">ROCK</span>

                <div class="icon-div">
                    <img src='res/assets/icons/rock-icon.png' class="icon">
                </div>

            </div>

            <div class="button to-click clickable paper">
                <span class="user-buttons-span">PAPER</span>

                <div class="icon-div">
                    <img src='res/assets/icons/paper-icon.png' class="icon">
                </div>

            </div>

            <div class="button to-click clickable scissors">
                <span class="user-buttons-span">SCISSORS</span>

                <div class="icon-div">
                    <img src='res/assets/icons/scissor-icon.png' class="icon">
                </div>

            </div>

        </div>



        <div class="difficulty-buttons">
            <span class="choose">Change AI difficulty</span>

            <div class="difficulty to-click amateur">
                <span class="level">Amateur</span>
            </div>

            <div class="difficulty to-click intermediate">
                <span class="level">Intermediate</span>
            </div>

            <div class="difficulty to-click expert">
                <span class="level">Expert</span>
            </div>

        </div>



        <div class="function-buttons">
            <span class="func">Options</span>

            <div class="function to-click again">
                <span class="function-span">Play again</span>

                <div class="icon-div">
                    <img src="res/assets/icons/again-icon.png" class="icon">
                </div>

            </div>

            <a href="ranking.php" class="a-tag">
                <div class="function to-click">
                    <span class="function-span">Ranking</span>

                    <div class="icon-div">
                        <img src="res/assets/icons/trophy-icon.png" class="icon">
                    </div>

                </div>
            </a>


            <a href="logout.php" class="a-tag">
                <div class="function to-click">
                    <span class="function-span">Log out</span>

                    <div class="icon-div">
                        <img src="res/assets/icons/logout-icon.png" class="icon">
                    </div>

                </div>
            </a>

        </div>

    </div>

    <footer>
        <div class="logo">
            <span class="footer-logo">RockPaperScissors</span>
        </div>

        <div class="copyright">
            <span class="C">&copy 2021 RockPaperScissors</span>
        </div>

        <div class="author">
            <span class="author-span">Adrian Iskra - II P</span>
        </div>
    </footer>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
    <script src='js/move-connect.js'></script>
    <script src='js/difficulty.js'></script>
</body>
</html>