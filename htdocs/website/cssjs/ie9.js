/**
 * Created by Louis on 5/11/2015.
 */
function function1(number) {
    document.getElementById('light' + number).style.display = 'block';
    document.getElementById('fade').style.display = 'block'
}
function function2(number) {
    document.getElementById('light' + number).style.display = 'none';
    document.getElementById('fade').style.display = 'none'
}

// in HTML <head>:
// <!--[if lt IE 9]><script>window.ltIE9=true</script><![endif]-->
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

