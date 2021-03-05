<?php

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });


    class Amateur extends AbstractDifficulty {

        public function move($user_latest, $ai_latest) : string {

            $move = $this->preprocess($user_latest, $ai_latest);

            // RETURN RANDOM
            return $move;
        }

        protected function preprocess($user_latest, $ai_latest) : string {

            // RANDOM MOVE
            if (count($ai_latest)-1 > 0) $index = count($ai_latest)-1;
            else $index = 0;

            $ai_move = 'rock';

            if ($index != 0) {
                while ($ai_move == $ai_latest[$index]) {
                    $ai_move = $this->moves[rand(0, 2)];
                }

            } else {
                $ai_move = $this->moves[rand(0, 2)];
            }

            return $ai_move;
        }

    }