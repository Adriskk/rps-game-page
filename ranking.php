<?php
    include('data.php');
    require('db/db.php');
    session_start();

    if ((!isset($_SESSION['logged'])) && ($_SESSION['logged'] != true)) header('Location: logout.php');

    function str_starts_with ( $haystack, $needle ) {
        return strpos($haystack, $needle ) === 0;
    }

    $_SESSION['page'] = 'RANKING';


    $config = get_ini($CONFIG_FILE_PATH);

    $INTERPRETER = $config[' PYTHON ']['interpreter_path'];
    $IS_ENV = $config[' PYTHON ']['env_variable'];

    $LEVELS_SCRIPT = $config[' PYTHON ']['levels_script_path'];
    $WINRATE_SCRIPT = $config[' PYTHON ']['winrate_script_path'];
    $RANKING_SCRIPT = $config[' PYTHON ']['ranking_script_path'];
    $DIR_SCRIPT = $config[' PYTHON ']['dir_script_path'];

    $SAVE_PATH = $config[' PYTHON ']['save_path'];

    # => STILL ERROR HERE
    if (gettype($_SESSION['ID']) == 'array') $_SESSION['ID'] = $_SESSION['ID'][0];

    $levels = get_levels($_SESSION['ID']);
    $new_levels = '';

    for ($i=0; $i<count($levels); $i++) {
        $new_levels .= $levels[$i][0];
        if ($i != count($levels)-1) $new_levels .= '.';
    }

    // EXEC + ARGS (new levels)
    // $result = exec($_TO_EXEC.' '.$SAVE_PATH.' '.$new_levels);
    // var_dump($result);

    $all_user_data = get_user_data($_SESSION['ID'], 'stats', 'user');

    $POINTS = [
        'user' => [],
        'ai' => []
    ];


    for ($i=0; $i<count($all_user_data); $i++) {
        array_push($POINTS['user'], $all_user_data[$i][0]);
        array_push($POINTS['ai'], $all_user_data[$i][1]);
    }


    if ($INTERPRETER == '') {
        if (intval($IS_ENV) == 1) $_TO_EXEC = 'python';
        else $_TO_EXEC = $INTERPRETER;
    }

    $user = '';
    $ai = '';

    for ($i=0; $i<count($POINTS['user']); $i++) {
        $user .= $POINTS['user'][$i];
        $ai .= $POINTS['ai'][$i];

        if ($i != count($POINTS['user'])-1) {$user .= '.'; $ai .= '.';}
    }

    $all_data = get_user_data($_SESSION['ID'], 'stats', 'all');

    $IDs = [];
    $POINTS['user'] = [];
    $POINTS['ai'] = [];
    $LEVELS = [];


    for ($i=0; $i<count($all_data); $i++) {
        array_push($IDs, $all_data[$i][0]);
        array_push($POINTS['user'], $all_data[$i][1]);
        array_push($POINTS['ai'], $all_data[$i][2]);
        array_push($LEVELS, $all_data[$i][3]);
    }

    $all_user = '';
    $all_ai = '';
    $all_ids = '';
    $all_levels = '';

    for ($i=0; $i<count($POINTS['user']); $i++) {
        $all_user .= $POINTS['user'][$i];
        $all_ai .= $POINTS['ai'][$i];
        $all_ids .= $IDs[$i];
        $all_levels .= $LEVELS[$i];

        if ($i != count($POINTS['user'])-1) {
            $all_user .= '.';
            $all_ai .= '.';
            $all_ids .= '.';
            $all_levels .= '.';
        }
    }

    $_SESSION['LEVELS_CHART'] = 'No charts to show up <br> - play one game and reset the score to submit a game';
    $_SESSION['WINRATE_CHART'] = 'No charts to show up <br> - play one game and reset the score to submit a game';

    // IF INTERPRETER ISSET IN CONFIG FILE
    if (($INTERPRETER != '') || ($_TO_EXEC == 'python')) {

        $dir_res = exec($_TO_EXEC.' '.$DIR_SCRIPT.' '.$SAVE_PATH.' '.$_SESSION['username']);

        // IF USER DIRECTORY EXISTS
        if ($dir_res == 'OK') {
            // SET THE FULL PATH
            $FULL_PATH = $SAVE_PATH.$_SESSION['username'].'/';
            // var_dump($FULL_PATH);

            $levels_res = exec($_TO_EXEC.' '.$LEVELS_SCRIPT.' '.$FULL_PATH.' '.$new_levels);

            if ($levels_res != "") $_SESSION['LEVELS_CHART'] = $levels_res;
            else $_SESSION['LEVELS_CHART'] = 'No charts to show up <br> - play one game and reset the score to submit a game';

            $winrate_res = exec($_TO_EXEC.' '.$WINRATE_SCRIPT.' '.$FULL_PATH.' '.$user.' '.$ai);
            // var_dump($winrate_res);

            if ($winrate_res != "") $_SESSION['WINRATE_CHART'] = $winrate_res;
            else $_SESSION['WINRATE_CHART'] = 'No charts to show up <br> - play one game and reset the score to submit a game';

            $ranking_res = exec($_TO_EXEC.' '.$RANKING_SCRIPT.' '.$all_ids.' '.$all_user.' '.$all_ai.' '.$all_levels);
            $ranking = explode('.', $ranking_res);

            // var_dump($POSITIONS);

        }

    }

    // var_dump($IDs);
    // var_dump($POINTS['user']);
    // var_dump($POINTS['ai']);
    // var_dump($LEVELS);

    $ranking = ranking($IDs, $POINTS['user'], $POINTS['ai'], $LEVELS);
    $POSITIONS = [];
    $pos = 1;

    var_dump($ranking);

    foreach ($ranking as $index=>$position) {

        $username = get_username(intval($index));
        array_push($POSITIONS, [$pos, $username]);
        $pos += 1;
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- STYLES -->
    <link rel="stylesheet" href="styles/ranking.css">
    <link rel="stylesheet" href="styles/properties.css">
    <link rel="stylesheet" href="styles/nav.css">

    <!-- GOOGLE FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Play:wght@400;700&display=swap" rel="stylesheet">

    <title>RPS Game | Ranking & Statistics</title>
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

    <div class="container">
        <div class="ranking">
            <span class="ranking-header">RANKING</span>

            <?php
                for ($i=0; $i<count($POSITIONS); $i++) {
                    echo '<span class="position">
                            <span class="num-pos"> #'.$POSITIONS[$i][0].'</span>
                            <span class="username">'.$POSITIONS[$i][1].'</span>
                          </span>';
                }
            ?>
        </div>

        <div class="charts">
            <?php
                if (($_SESSION['WINRATE_CHART'] != null) && (str_starts_with($_SESSION['WINRATE_CHART'], 'No') == false)) {
                    echo '<img src="'.$_SESSION['WINRATE_CHART'].'" class="chart">';
                    echo '<img src="'.$_SESSION['LEVELS_CHART'].'" class="chart">';

                } else {
                    echo '<span class="no-chart">'.$_SESSION['WINRATE_CHART'].'</span>';
                    echo '<span class="no-chart">'.$_SESSION['LEVELS_CHART'].'</span>';
                }
            ?>

        </div>

    </div>

    <div class="interface">
        <div class="function-buttons">

            <a href="game.php" class="a-tag">
                <div class="function to-click">
                    <span class="function-span">Play</span>

                    <div class="icon-div">
                        <img src="res/assets/icons/play-icon.png" class="icon">
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

</body>
</html>