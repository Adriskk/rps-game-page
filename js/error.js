
var error_msg = $.cookie('error_msg');
var register_error_msg = $.cookie('register_error_msg');

var error_e = document.querySelector('.error');

// TOGGLE

if (error_msg == 1) error_e.style.display = 'block';
else error_e.style.display = 'none';

if (register_error_msg == 1) error_e.style.display = 'block';
else error_e.style.display = 'none';
