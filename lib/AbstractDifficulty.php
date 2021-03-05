<?php


abstract class AbstractDifficulty {
    public $latest = [];

    protected $moves = [
        0 => 'rock',
        1 => 'paper',
        2 => 'scissors'
    ];

    protected $cycle = [
        'rock' => 'paper',
        'paper' => 'scissors',
        'scissors' => 'rock'
    ];

    protected $WIN_PATTERNS = [
        'rock' => 'scissors',
        'paper' => 'rock',
        'scissors' => 'paper'
    ];

    public $latest_AI = [];

    // ABSTRACT METHODS
    abstract public function move($user_latest, $ai_latest) : string;
    abstract protected function preprocess($user_latest, $ai_latest) : string;

    // PARENT METHOD
    public function add(string $last){
        array_push($this->latest, $last);
    }
}