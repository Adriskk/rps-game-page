<?php

    # -*- coding: utf-8 -*-

    require('lib/Amateur.php');
    require('lib/Intermediate.php');
    require('lib/Expert.php');

    # = MAIN DATA FILE

    $CONFIG_FILE_PATH = 'config/config.ini';
    $CONFIG = get_ini($CONFIG_FILE_PATH);

    $START = [
        'res/assets/blank.png',
        'res/assets/blank.png'
    ];

    $ASSETS = [
        './res/assets/rock.png',
        './res/assets/paper.png',
        './res/assets/scissors.png',
        './res/assets/blank.png'
    ];

    $PLAYERS = [
        'You',
        'AI'
    ];

    $SCORE = [
        'user'=> 0,
        'ai' => 0
    ];

    $WIN_PATTERNS = [
        'rock' => 'scissors',
        'paper' => 'rock',
        'scissors' => 'paper'
    ];

    $LVL_POINTS = [
        'amateur' => 1,
        'intermediate' => 2,
        'expert' => 3
    ];

    $_SIZE['x'] = $CONFIG[' ELEMENTS ']['x-size'];
    $_SIZE['y'] = $CONFIG[' ELEMENTS ']['y-size'];

    // DIFFICULTY LEVEL OBJECT'S
    $EASY = new Amateur();
    $INTM = new Intermediate();
    $EXPERT = new Expert();


    function get_ini($FILE) {
        return parse_ini_file($FILE, true);
    }


    function winner_check($user, $ai) {
        global $WIN_PATTERNS;

        if ($WIN_PATTERNS[$user] == $ai) return 'win';
        else if ($WIN_PATTERNS[$ai] == $user) return 'lose';
        else if ($user == $ai) return 'tie';

    }

    # => GET AI MOVE
    function get_ai_move($difficulty, $user, $ai) {
        return unserialize($difficulty)->move($user, $ai);
    }


    function add_latest($move, $difficulty) {
        $last = unserialize($difficulty)->latest;
    }


    function ranking($ID, $USER, $AI, $LEVELS) {
        global $LVL_POINTS;

        $data = array();
        $LENGTH = count($ID);


        // MAKE SOME KIND OF 'DICT'
        for ($i=0; $i<$LENGTH; $i++) {
            if (array_key_exists($ID[$i], $data) == false) $data[$ID[$i]] = 0;
        }

        for ($i=0; $i<$LENGTH; $i++) {
            if ($USER[$i] > $AI[$i]) $data[$ID[$i]] += $LVL_POINTS[$LEVELS[$i]];
        }

        asort($data);

        return array_reverse($data, true);
    }