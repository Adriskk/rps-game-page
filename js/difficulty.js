
// ALL CLASSES OF DIFFICULTY LEVEL
var amateur = 'amateur';
var intermediate = 'intermediate';
var expert = 'expert';

var to_click = 'to-click';
var difficulty_C = '.difficulty';
var active = 'active';

var cookie = $.cookie('diff');

var amateur_e = document.querySelector('.' + amateur);
var intermediate_e = document.querySelector('.' + intermediate);
var expert_e = document.querySelector('.' + expert);

switch (cookie) {
    case 'amateur': {amateur_e.classList.add(active); } break;
    case 'intermediate': {intermediate_e.classList.add(active); } break;
    case 'expert': {expert_e.classList.add(active); } break;
}


// WHEN USER CLICKS A TILE GET SRC OF CLICKED TILE
$(difficulty_C).click(function () {

    var clicked = $(this);
    var difficulty = '';

    console.log(clicked);

    if (clicked.hasClass(to_click)) {

        if (clicked.hasClass(amateur)) {
            console.log('AMATEUR');
            difficulty = 'amateur';
        }

        else if (clicked.hasClass(intermediate)) {
            console.log('INTER');
            difficulty = 'intermediate';
        }

        else if (clicked.hasClass(expert)) {
            console.log('EXPERT');
            difficulty = 'expert';
        }

        // PREPARE DATA SEND METHOD
        var data = new FormData();

        data.append('diff', difficulty);
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "change-difficulty.php");

        // HANDLE RESPONSES FROM FILE
        xhr.onload = function () {

            console.log('Response ' + this.response);

            if (this.response.startsWith('OK')) {
                // DELETE CLASS FROM LAST LEVEL BUTTON
                var elements = document.querySelectorAll(difficulty_C);

                for (var element of elements) {element.classList.remove(active); element.classList.add(to_click);}

                var current = document.querySelector('.' + difficulty);
                current.classList.add(active);
                current.classList.remove(to_click);


                // location.reload();
                console.log('OK!');
            }



        };

        xhr.send(data);

        return false;

    }




});