<?php

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });

    class Intermediate extends AbstractDifficulty {

        public function move($user_latest, $ai_latest) : string {
            $move = $this->preprocess($user_latest, $ai_latest);

            // RETURN RANDOM
            return $move;
        }

        protected function preprocess($user_latest, $ai_latest) : string {

            if (count($ai_latest)-1 > 0) $index = count($ai_latest)-1;
            else $index = 0;


            if ($index == 0) {
                // RETURN ROCK AS A FIRST MOVE;
                return $this->moves[0];

            } else {
                // USER WILL PROBABLY CHANGE THE MOVE
                if (($user_latest[count($user_latest)-1] == 'rock') && ($ai_latest[$index] == 'paper')) {
                    // PROBABLY WILL IT BE SCISSORS
                    // SO FOR SCISSORS OPTIMAL MOVE TO WIN WILL BE ROCK
                    return 'rock';
                }

                if (($user_latest[count($user_latest)-1] == 'paper') && ($ai_latest[$index] == 'scissorss')) {

                    return 'paper';
                }

                if (($user_latest[count($user_latest)-1] == 'scissors') && ($ai_latest[$index] == 'rock')) {

                    return 'scissors';
                }

                return 'rock';
            }
        }

    }