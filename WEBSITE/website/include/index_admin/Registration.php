<?php
if (isset($_POST['clickSetReg'])) {
    clickSetReg();
} else if (isset($_POST['clickCloseReg'])) {
    clickCloseReg();
} else if (isset($_POST['closeReg'])) {
    setCloseDate();
} else if (isset($_POST["openReg"])) {
    setRegistration();
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

function closed()
{
    echo "<h4>Status: <span style='color:darkred;'>Closed</span></h4>";
    echo "<form method='post'><input type='submit' name='openReg' value='Open'></form>";
}

function open()
{
    global $connection;
    echo "<h4>Status: <span style='color:#3cda19;'>Open</span></h4>";


    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate, datediff(closedate, CURDATE()) as diff from registration where CURRENT = 1");
    $closeDate = mysqli_result($result, 0, 'closedate');
    $diff = mysqli_result($result, 0, 'diff');

    if (!mysqli_result($result, 0, 'closedate')) {
        echo "<form method='post'><input type='submit' name='closeReg' value='Set Close Date'></form>";
    } else {
        echo "<b>Closing on</b> $closeDate - <i>($diff day(s) from today)</i>";
    }


}

function opening()
{
    global $connection;
    echo "<h4>Status: <span style='color:#dac308;'>Closed</span></h4>";
    echo "<b>Opening on</b> ";
    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate,date_format(opendate, '%b %e, %Y') as opendate, datediff(opendate, CURDATE()) as diff from registration where CURRENT = 1");
    $openDate = mysqli_result($result, 0, 'opendate');
    $closeDate = mysqli_result($result, 0, 'closedate');
    $diff = mysqli_result($result, 0, 'diff');
    echo $openDate . " - <i>($diff day(s) from today)</i><br /><br />";
    if (!mysqli_result($result, 0, 'closedate')) {
        echo "<form method='post'><input type='submit' name='closeReg' value='Set Close Date'></form>";
    } else {
        echo "<b>Closing on</b> $closeDate";
    }
}

function setRegistration()
{
    isset($_POST['date1xx']) ? $d1 = $_POST['date1xx'] : $d1 = "";
    isset($_POST['date1xx']) ? $d2 = $_POST['date2xx'] : $d2 = "";
    isset($_POST['minstudents']) ? $d3 = $_POST['minstudents'] : $d3 = "0";

    echo "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"jscal1xx\">
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var cal1xx = new CalendarPopup(\"testdiv1\");
            cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal1xx.showNavigationDropdowns();
            var cal2xx = new CalendarPopup(\"testdiv2\");
            cal2xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal2xx.showNavigationDropdowns();
            </SCRIPT>";

    echo "<FORM method='post'>
                <b>Open on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"$d1\" SIZE = 25 readonly>
                <A HREF=\"#\" onClick=\"cal1xx.select(document.forms[0].date1xx,'anchor1xx','MM/dd/yyyy'); return false;\"  NAME=\"anchor1xx\" ID=\"anchor1xx\">Calendar</A><br/>

                <b>Close on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date2xx\" VALUE = \"$d2\" SIZE = 25 readonly>
                <A HREF = \"#\" onClick = \"cal2xx.select(document.forms[0].date2xx,'anchor2xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor2xx\" ID = \"anchor2xx\" >Calendar</A ><br/>
                <br /><b>Minimum students:</b><br />
                <input type = 'number' value = '$d3' name='minstudents'><span style='font-size: 80%'>(Classes with participants lower than this number will be closed after closing date)<br />

                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickSetReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >
            <DIV ID = \"testdiv2\"></DIV >";
}

function clickSetReg()
{
    global $connection;

    if ($_POST['date1xx'] && $_POST['date2xx'] && $_POST['minstudents'] >= 0 && $_POST['minstudents'] != "" && ($_POST['date1xx'] < $_POST['date2xx'])) {
        $openDATE = $_POST["date1xx"];
        $openDATEm = substr($openDATE, 0, 2);
        $openDATEd = substr($openDATE, 3, 2);
        $openDATEy = substr($openDATE, 6, 4);

        $closeDATE = $_POST["date2xx"];
        $closeDATEm = substr($closeDATE, 0, 2);
        $closeDATEd = substr($closeDATE, 3, 2);
        $closeDATEy = substr($closeDATE, 6, 4);

        $minStudents = $_POST['minstudents'];

        $regID = $openDATEm . $openDATEd . $openDATEy . "-1";

        //"Archives" other registrations
        $SQL = "update registration set current = 0";
        if ($connection->query($SQL) === TRUE) {
            $SQL = "insert into registration (registrationID, opendate, closedate, type, minimumstudents, current) values ('$regID','$openDATEy-$openDATEm-$openDATEd', '$closeDATEy-$closeDATEm-$closeDATEd', '1', $minStudents, '1')";
            if ($connection->query($SQL) === TRUE) {
                $_SESSION['tab'] = '123';
                header("Location:admin.php");
            } else {
                echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
            }
        } else {
            setRegistration();
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
    } else if (!$_POST['date1xx'] || !$_POST['date2xx']) {
        setRegistration();
        echo "<br/><span class='errorMsg'>Both dates have to be set.</span>";
    } else if ($_POST['minstudents'] == "") {
        setRegistration();
        echo "<br/><span class='errorMsg'>Minimum students can't be empty.</span>";
    } else if ($_POST['minstudents'] < 0) {
        setRegistration();
        echo "<br/><span class='errorMsg'>Minimum students can't less than 0.</span>";
    } else {
        setRegistration();
        echo "<br/><span class='errorMsg'>Closing date has to be after Opening date.</span>";

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