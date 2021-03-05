// -*- coding: utf -8 -*-

// connect.js -> a script that enables ajax function to connect
// with php script

var rock = './res/assets/rock.png';
var paper = './res/assets/paper.png';
var scissors = './res/assets/scissors.png';
var blank = './res/assets/blank.png';

var status = 'You ';

// CLICKABLE CLASS
clickable = 'clickable';

// WHEN USER CLICKS A TILE GET SRC OF CLICKED TILE
$('.button').click(function () {
    var user_image = $('.user');
    var ai_image = $('.ai');

    if (user_image.hasClass(clickable)) {

        // CONNECTING METHOD: AJAX

        // var src = this.getAttribute('src');
        // var player = this.getAttribute('id');

        var classes = $(this)[0].className.split(' ');
        var move = '';

        if (classes.includes('rock')) move = 'rock';
        else if (classes.includes('paper')) move = 'paper';
        else move = 'scissors';

        console.log('Player move: ' + move);

        var data = new FormData();

        // data.append('src', src);
        // data.append('player', player);
        data.append('move', move);

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "mechanics.php");


        // HANDLE RESPONSES FROM FILE
        xhr.onload = function () {

            // RESPONSES FROM mechanics.php

            console.log('Response: ' + this.response);

            splited = this.response.split('.');

            for (split in splited) {

                // IF 'SET' ISSET IN RESPONSE
                if (splited[split].startsWith('user:')) {

                    set = splited[split].split(':');
                    to_set = set[1];

                    // SET CIRCLE OR CROSS SWITCH TO EXTRACTED VALUE
                    switch (to_set) {

                        // TO CIRCLE
                        case 'rock':
                            user_image.attr({
                                "src": rock
                            });

                        break;

                        // TO CROSS
                        case 'paper':
                            user_image.attr({
                                "src": paper
                            });
                        break;

                        // TO CROSS
                        case 'scissors':
                            user_image.attr({
                                "src": scissors
                            });
                        break;

                        // ERROR
                        default:
                            console.log("SWITCH ERROR OCCURED! ");

                            user_image.attr({
                                "src": blank
                            });
                    }
                }


                if (splited[split].indexOf('ai:')) {

                    index = splited[split].indexOf('ai:');
                    set = splited[split].slice(index, splited[split].length);

                    to_set = set.split(':')[1];

                    // SET CIRCLE OR CROSS SWITCH TO EXTRACTED VALUE
                    switch (to_set) {

                        // TO CIRCLE
                        case 'rock':
                            ai_image.attr({
                                "src": rock
                            });

                        break;

                        // TO CROSS
                        case 'paper':
                            ai_image.attr({
                                "src": paper
                            });
                        break;

                        // TO CROSS
                        case 'scissors':
                            ai_image.attr({
                                "src": scissors
                            });
                        break;

                        // ERROR
                        default: {
                            console.log("SWITCH ERROR OCCURED! ");

                            ai_image.attr({
                                "src": blank
                            });
                        }
                    }
                }

                if (splited[split].indexOf('status:')) {
                    index = splited[split].indexOf('status:');
                    set = splited[split].slice(index, splited[split].indexOf('resfresh:'));

                    to_set = set.split(':')[1];

                    status += to_set + '!';
                }

                if (splited[split].indexOf('refresh:')) {
                    index = splited[split].indexOf('resfresh:');
                    set = splited[split].slice(index-3, splited[split].length);
                    to_set = set.split(':')[0];

                    if ((set == 'true') || (set == true)) {
                        // REMOVE CLICKABLE CLASS FROM EACH ELEMENT
                        user_image.removeClass(clickable);
                        ai_image.removeClass(clickable);

                        // SET STATUS
                        $('.game-status').text(status);

                        // CSS
                        $('.game-status').css('color', '#fff');
                        $('.game-status').css('user-select', 'auto');
                        console.log('Status: ' + status);

                        $('.again').click(function () {
                            location.reload();
                        });
                    }
                }


                if (splited[split].startsWith('new:')) {

                    new_v = splited[split].split(':');
                    variable = new_v[1];
                    key = new_v[2];

                }

            }

        };


        xhr.send(data);

        return false;
    }

});

