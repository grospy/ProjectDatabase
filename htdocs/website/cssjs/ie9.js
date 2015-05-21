// Enroll/Withdraw pop-up
function function1(number) {
    document.getElementById('light' + number).style.display = 'block';
    document.getElementById('fade').style.display = 'block'
}
// Close pop-up
function function2(number) {
    document.getElementById('light' + number).style.display = 'none';
    document.getElementById('fade').style.display = 'none'
}

// Tabs compatibility with internet explorer 9
if (window.ltIE9) {
    (function ($) {
        $('.tabs input[type="radio"]:checked')
            .closest('.tab')
            .addClass('checked');
        $('html').on('click', '.tabs input', function () {
            $('input[name="' + this.name + '"]')
                .closest('.tab')
                .removeClass('checked');
            $(this)
                .closest('.tab')
                .addClass('checked');
        });
    })(window.jQuery);
}

