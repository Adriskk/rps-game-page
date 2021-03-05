<?php
    # -*- coding: utf-8 -*-
    # => THIS IS A EXPERT LEVEL AI THAT PLAYS WITH A USER
    # => BEFORE ANALYZING HIS LIST OF MOVES
    # => ACCURACY: 60 - 70%;

    spl_autoload_register(function ($class_name) {
        include $class_name . '.php';
    });


    class Expert extends AbstractDifficulty {
        private $start = [
            'rock',
            'scissors'
        ];

        public function move($user_latest, $ai_latest) : string {
            $move = $this->preprocess($user_latest, $ai_latest);

            // RETURN RANDOM
            return $move;
        }

        protected function preprocess($user_latest, $ai_latest) : string {

            if (count($user_latest) <= 2) {
                return $this->moves[rand(0, 1)];
            }

            // GET PERCENTAGE
            $percentage = $this->calc_perc($user_latest);

            $rock_PERC = $percentage[0];
            $paper_PERC = $percentage[1];
            $scissors_PERC = $percentage[2];


            // GET ALL MOVES THAT USER IS DOUBLING WHEN HE WINS
            $streaks = $this->doubling_moves($user_latest, $ai_latest);

            $bigg_streak = 0;
            $bigg_move = '';

            for ($i=0; $i<count($streaks); $i++) {
                // GET THE BIGGEST STREAK AND MOVE WITH IT
                if ($streaks[$i][0] > $bigg_streak) $bigg_streak = $streaks[$i][0];
            }

            // GET THE CHANCE OF USER PLAYING IN CYCLE MODE (CHANGES HIS MOVE TO THE NEXT IN THE CLOCK WISE EX. ROCK -> PAPER -> SCISSORS -> ROCK)
            $cycle = $this->cycle_change($user_latest, $ai_latest);

            $index = count($user_latest)-1;


            // IF THE USER WON THE LAST GAME
            if (($this->won($user_latest[$index], $ai_latest[$index]) == true) || $this->won($user_latest[$index], $ai_latest[$index]) == 'tie') {

                $result = $this->get_the_biggest($percentage);

                if (($user_latest[$index-1] == $user_latest[$index-2]) && ($bigg_streak > 1)) {
                    // IF USER IS DUBLING HIS MOVES AFTER WIN

                    $prediction = $user_latest[$index];
                    $move = $this->return_move($prediction);

                    return $move;

                } else if ($result[0] >= 40) {
                    // AFTER ALL IF USER IS CHOOSING ONE OF THE MOVES THE MOST TIMES

                    $prediction = $this->moves[$result[1]];
                    $move = $this->return_move($prediction);

                    return $move;
                }

            // IF USER LOST THE LAST GAME
            } else {
                $result = $this->get_the_biggest($percentage);

                if (($cycle * 100) >= 10) {
                    // IF CYCLE CHANGE MODE OCCURS IN USER GAMEPLAY

                    // GET THE LAST USER MOVE
                    $last = $user_latest[$index];

                    $prediction = $this->cycle[$last];
                    $move = $this->return_move($prediction);

                    return $move;

                } else if ($result[0] >= 45) {
                    // AFTER ALL IF USER IS CHOOSING ONE OF THE MOVES THE MOST TIMES
                    $prediction = $this->moves[$result[1]];
                    $move = $this->return_move($prediction);

                    return $move;
                }
            }

            return $this->moves[rand(0, 1)];

        }


        private function return_move($prediction) {
            if ($this->WIN_PATTERNS['rock'] == $prediction) $move = 'rock';
            if ($this->WIN_PATTERNS['paper'] == $prediction) $move = 'paper';
            if ($this->WIN_PATTERNS['scissors'] == $prediction) $move = 'scissors';

            return $move;
        }


        private function get_the_biggest(array $array) : array {

            $biggest = 0;
            $index = 0;

            // GET THE BIGGEST PERCENTAGE
            for ($i=0; $i<2; $i++) if ($array[$i] > $biggest) $biggest = $array[$i]; $index = $i;

            return [$biggest, $index];
        }


        private function calc_perc(array $user_latest) : array {
            # ==> TODO
            # => DO ALL PERCENTAGES AND CALC ON IT
            # ==>

            $rock = [];
            $paper = [];
            $scissors = [];

            foreach ($user_latest as $move) {
                if ($move == 'rock') array_push($rock, $move);
                if ($move == 'paper') array_push($paper, $move);
                if ($move == 'scissors') array_push($scissors, $move);
            }

            // GET ALL MOVES PERCENTAGE
            $ALL_MOVES = count($user_latest);

            $rock_PERC = (count($rock) / $ALL_MOVES) * 100;  // * 100 BECAUSE WE WANT TO BE MORE ACCURATE (IT'S TWO CHOICE GAME OF COURSE)
            $paper_PERC = (count($paper) / $ALL_MOVES) * 100;
            $scissors_PERC = (count($scissors) / $ALL_MOVES) * 100;

            return [$rock_PERC, $paper_PERC, $scissors_PERC];

        }


        private function doubling_moves(array $user_latest, array $ai_latest) : array {

            $all = [];
            $streak = 0;

            for ($i=0; $i<count($user_latest); $i++) {

                // GET ALL WINNING STREAKS FROM USER MOVES
                if ($i > 0) {
                    if (($streak == 0) && ($this->won($user_latest[$i], $ai_latest[$i]) == true)) $streak++;
                    else if (($user_latest[$i] == $user_latest[$i-1]) && ($this->won($user_latest[$i], $ai_latest[$i]) == true)) $streak++;
                    else array_push($all, [$streak, $user_latest[$i-1]]);
                }

            }

            return $all;
        }


        private function cycle_change(array $user_latest, array $ai_latest) : float {

            $moves = [];
            $perc = 0;

            for ($i=0; $i<count($user_latest); $i++) {
                if ($this->won($user_latest[$i], $ai_latest[$i]) == false) array_push($moves, $user_latest[$i]);
                else array_push($moves, ' ');
            }

            for ($i=0; $i<count($moves); $i++) {
                if (($moves[$i] != ' ') && $i > 0) {

                    if ($this->cycle[$moves[$i]] == $moves[$i-1]) $perc++;
                }
            }

            $perc = $perc / count($user_latest);  // KNOW WHAT'S THE CHANCE THAT USER WILL CHANGE HIS MOVE AFTER LOSE IN CYCLE MODE

            return $perc;
        }


        private function won(string $user, string $ai) {

            if ($this->WIN_PATTERNS[$user] == $ai) return true;
            else if ($this->WIN_PATTERNS[$user] != $ai) return false;
            else return 'tie';
        }

    }