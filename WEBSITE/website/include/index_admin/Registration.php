<?php

global $connection;
if (isset($_POST['clickOpenReg'])) {
    clickOpenReg();
} else if (isset($_POST['clickCloseReg'])) {
    clickCloseReg();
} else if (isset($_POST['closeReg'])) {
    setCloseDate();
} else if (isset($_POST["openReg"])) {
    setOpenDate();
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


function setOpenDate()
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
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"\" SIZE = 25 readonly><A HREF = \"#\" onClick = \"cal1xx.select(document.forms[0].date1xx,'anchor1xx','yyyy-MM-dd'); return false;\"  NAME = \"anchor1xx\" ID = \"anchor1xx\" >Calendar</A ><br/>
                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickOpenReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >";
}

function setCloseDate()
{
    echo " <SCRIPT LANGUAGE = \"JavaScript\" ID = \"jscal1xx\" >
        var date = new Date();
        date.setDate(date.getDate() - 1);
        var cal1xx = new CalendarPopup(\"testdiv1\");
        cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
        cal1xx . showNavigationDropdowns();
        </SCRIPT >";

    echo "<FORM method='post'>
                <b>Close on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"\" SIZE = 25 readonly><A HREF = \"#\" onClick = \"cal1xx.select(document.forms[0].date1xx,'anchor1xx','yyyy-MM-dd'); return false;\"  NAME = \"anchor1xx\" ID = \"anchor1xx\" >Calendar</A ><br/>
                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickCloseReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >";


}

function closed()
{
    echo "<h4>Status:</h4>";
    echo "CLOSED";
    echo "<form method='post'><input type='submit' name='openReg' value='Open'></form>";
}

function open()
{
    global $connection;
    echo "<h4>Status:</h4>";
    echo "<b>Open</b><br />";

    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate, datediff(CURDATE(), closedate) as diff from registration where CURRENT = 1");
    $closeDate = mysqli_result($result,0,'closedate');
    $diff = mysqli_result($result,0,'diff');

    if(!mysqli_result($result,0,'closedate')){
        echo "<form method='post'><input type='submit' name='closeReg' value='Set Close Date'></form>";
    }else {
        echo "<b>Closing on</b> $closeDate";
    }





}

function opening()
{
    global $connection;
    echo "<h4>Status:</h4>";
    echo "<b>Opening on</b> ";
    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate,date_format(opendate, '%b %e, %Y') as opendate, datediff(opendate, CURDATE()) as diff from registration where CURRENT = 1");
    $openDate = mysqli_result($result,0,'opendate');
    $closeDate = mysqli_result($result,0,'closedate');
    $diff = mysqli_result($result,0,'diff');
    echo $openDate . " - <i>($diff day(s) from today)</i><br /><br />";
    if(!mysqli_result($result,0,'closedate')){
        echo "<form method='post'><input type='submit' name='closeReg' value='Set Close Date'></form>";
    }else {
        echo "<b>Closing on</b> $closeDate";
    }
}

function clickOpenReg()
{
    global $connection;
    setOpenDate();
    if ($_POST['date1xx']) {
        $openDATE = $_POST["date1xx"];
        $month = substr($openDATE, 5, 2);
        $day = substr($openDATE, 8, 2);
        $year = substr($openDATE, 0, 2);
        $regID = $month . $day . $year . "-1";

        //"Archives" other registrations
        $SQL = "update registration set current = 0";
        if ($connection->query($SQL) === TRUE) {
            $SQL = "insert into registration (registrationID, opendate, closedate, type, minstudyload, current) values ('$regID','$openDATE', null, '1','1','1')";
            if ($connection->query($SQL) === TRUE) {
                echo "<br/><span class='errorMsg'>Registration opens on $month/$day/$year</span>";
            } else {
                echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
            }
        } else {
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
    } else {
        echo "<br/><span class='errorMsg'>No date selected</span>";

    }
}

function clickCloseReg()
{
    global $connection;
    setCloseDate();
    if ($_POST['date1xx']) {
        $closeDATE = $_POST["date1xx"];
        $month = substr($closeDATE, 5, 2);
        $day = substr($closeDATE, 8, 2);
        $year = substr($closeDATE, 0, 2);

        $SQL = "update registration set closedate = '$closeDATE' where CURRENT = 1";
        if ($connection->query($SQL) === TRUE) {
            echo "<br/><span class='errorMsg'>Registration will close on $month/$day/$year</span>";
        } else {
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
    } else {
        echo "<br/><span class='errorMsg'>No date selected</span>";

    }
}