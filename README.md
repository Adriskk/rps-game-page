# Rock Paper Scissors
*This is a simple game website to play rock paper scissors 
with register, login, levels and charts*

## Description

Fully responsive website with registering users,
3-level AI (Amateur, Intermediate, Expert) 
and charts (winrate, played games)
in the stats page.

Page is using python and matplotlib module
to generate charts

![game.php](https://user-images.githubusercontent.com/65545676/110085530-80d36680-7d91-11eb-9d50-f86f3479dee9.png)


## Setup

To setup python - head into the config file 
and paste your full path to the interpreter

```ini
[ PYTHON ]

; PATH TO THE PYTHON INTERPRETER ;
interpreter_path =

; YOU CAN CHANGE THE VALUE TO TRUE HERE IF YOU HAVE ENV PYTHON VAR (1) ;
; ELSE LEAVE IT FALSE (0) ;
env_variable = 0
```

To find out where your python interpeter is
type in cmd:
```cmd
where python
```
If python interpeter and env variable is not set
- charts will not be generated, but ranking will be by php.

To setup the database - import the 127_0_0_1.sql to your 
host.
