
<?php
include "/include/top.php";
?>
            <FORM>
                Default calendar using the DIV-style display, with navigation drop-downs enabled.<BR>
                <SCRIPT LANGUAGE="JavaScript" ID="jscal1xx">
                    var cal1xx = new CalendarPopup("testdiv1");
                    cal1xx.showNavigationDropdowns();
                </SCRIPT>
                <INPUT TYPE="text" NAME="date1xx" VALUE="" SIZE=25>
                <A HREF="#" onClick="cal1xx.select(document.forms[0].date1xx,'anchor1xx','MM/dd/yyyy'); return false;"  NAME="anchor1xx" ID="anchor1xx">select</A>
            </FORM>
            <DIV ID="testdiv1" STYLE="position:absolute;visibility:hidden;background-color:white;layer-background-color:white;"></DIV>