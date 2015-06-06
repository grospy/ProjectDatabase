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

function CheckAll(x)
{	if(x==1) {var form="statusForm"};
	if(x==2) {var form="courseForm"};
	var checkbox = document.getElementsByClassName(form);
	for (i = 0; i < checkbox.length; i++)
	checkbox[i].checked = true ;
}

function UnCheckAll(x)
{	if(x==1) {var form="statusForm"};
	if(x==2) {var form="courseForm"};
	var checkbox = document.getElementsByClassName(form);
	for (i = 0; i < checkbox.length; i++)
	checkbox[i].checked = false ;
}

function printSchedule() {
	var restorepage = document.body.innerHTML;
	var printcontent = document.getElementById('printthis').outerHTML;
	document.body.innerHTML = printcontent;
	window.print();
	document.body.innerHTML = restorepage;
}