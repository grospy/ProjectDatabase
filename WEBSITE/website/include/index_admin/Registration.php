<?php

global $connection;
if (isset($_POST['setReg'])) {
    $startDATE = $_POST["date1xx"];
    $SQL = "insert into registration (registrationID, opendate, closedate, type, minstudyload) values ('','$startDATE', null, '1','1')";
        if ($connection->query($SQL) === TRUE) {
        } else {
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
}
if (isset($_POST["openReg"])) {
    setdate();
} else {
    status();
}

function status()
{
    switch (regType()) {
        case 0:
            closed();
            break;
        case 1:
            open();
            break;
        case 2:
            opening();
            break;
    }
}

function setdate()
{
    echo " <SCRIPT LANGUAGE = \"JavaScript\" ID = \"jscal1xx\" >
        var date = new Date();
        date.setDate(date.getDate() - 1);
        var cal1xx = new CalendarPopup(\"testdiv1\");
        cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
        cal1xx . showNavigationDropdowns();

        </SCRIPT >";

    echo "<FORM method='post'>
                <b>Open on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"\" SIZE = 25 readonly>
                <A HREF = \"#\" onClick = \"cal1xx.select(document.forms[0].date1xx,'anchor1xx','yyyy-MM-dd'); return false;\"  NAME = \"anchor1xx\" ID = \"anchor1xx\" >Calendar</A ><br/>
                <input type='submit' value = 'set' name =\"setReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >";


}

function closed()
{
    echo "<h4>Status:</h4>";
    echo "CLOSED";
    echo "<form method='post'><input type='submit' name='openReg' value='OPEN'></form>";
}

function open()
{
    echo "<h4>Status:</h4>";
    echo "OPEN";
}

function opening()
{
    echo "<h4>Status:</h4>";
    echo "OPENING";
}