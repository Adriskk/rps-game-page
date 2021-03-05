<?php

include('data.php');

session_start();

$status = 'OK';

$MOVE = $_POST['move'] ?? null;

    # => ALL RPS GAME MECHANICS

    $status = 'user:';

    switch ($MOVE) {
        case 'rock': { $status .= 'rock'; } break;
        case 'paper': { $status .= 'paper'; } break;
        case 'scissors': { $status .= 'scissors'; } break;
        default: {$status = 'error'; } break;
    }

    // GET AI MOVE BASED ON THE WHOLE GAME
    $AI_MOVE = get_ai_move($_SESSION['difficulty'], $_SESSION['latest_user'], $_SESSION['latest_ai']);

    // SAVE USER MOVE AFTER GETTING AI MOVE
    add_latest($MOVE, $_SESSION['difficulty']);

    // ADD ALL MOVES
    array_push($_SESSION['latest_user'], $MOVE);
    array_push($_SESSION['latest_ai'], $AI_MOVE);

    $status .= ':ai:'.$AI_MOVE;

    $winner = winner_check($MOVE, $AI_MOVE);

    if ($winner == 'win') {$_SESSION['SCORE']['user'] += 1; $status .= ':status:won';}  # => USER WIN
    else if ($winner == 'lose') {$_SESSION['SCORE']['ai'] += 1; $status .= ':status:lost';}  # => USER LOSE

    else if ($winner == 'tie') {  # => TIE
        $_SESSION['SCORE']['user'] += 1;
        $_SESSION['SCORE']['ai'] += 1;
        $status .= ':status:tied';
    }


    $status .= ':refresh:true';

echo $status;