var form = document.querySelector('.prevent-double-submit');
var submit = document.querySelector('.prevent-button');
var spinner = document.querySelector('.spinner');

form.addEventListener('submit', function() {

    submit.setAttribute('disabled', 'true');
    spinner.removeAttribute('hidden');

});
