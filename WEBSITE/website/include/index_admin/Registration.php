<?php
if (isset($_POST['clickSetReg'])) {
    setRegistration();
} else if (isset($_POST['clickEditReg'])) {
    editRegistration();
} else if (isset($_POST["openReg"])) {
    setRegistrationForm();
} else if (isset($_POST["editReg"])) {
    editRegistrationForm();
} else if (isset($_POST["deleteReg"])) {
    deleteReg();
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


    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate, datediff(closedate, CURDATE()) as diff, date_format(closedate2, '%b %e, %Y') as closedate2, datediff(closedate2, CURDATE()) as diff2 from registration where CURRENT = 1");
    $closeDate = mysqli_result($result, 0, 'closedate');
    $diff = mysqli_result($result, 0, 'diff');
    $closeDate2 = mysqli_result($result, 0, 'closedate2');
    $diff2 = mysqli_result($result, 0, 'diff2');
    echo "<b>Closing on:</b> $closeDate - <i>($diff day(s) from today)</i><br /><br />";
    echo "<b>Second registration closing on:</b> $closeDate2 - <i>($diff2 day(s) from today)</i>";
    echo "<hr style='visibility: hidden'><form method='post'><input type='submit' name='editReg' value='Edit'></form>";


}

function opening()
{
    global $connection;
    echo "<h4>Status: <span style='color:#dac308;'>Closed</span></h4>";
    echo "<b>Opening on:</b> ";
    $result = $connection->query("Select date_format(closedate, '%b %e, %Y') as closedate, date_format(opendate, '%b %e, %Y') as opendate, date_format(closedate2, '%b %e, %Y') as closedate2, datediff(opendate, CURDATE()) as diff from registration where CURRENT = 1");
    $openDate = mysqli_result($result, 0, 'opendate');
    $closeDate = mysqli_result($result, 0, 'closedate');
    $closeDate2 = mysqli_result($result, 0, 'closedate2');
    $diff = mysqli_result($result, 0, 'diff');
    echo $openDate . " - <i>($diff day(s) from today)</i><br /><br />";
    echo "<b>Closing on</b> $closeDate";
    echo "<b>Second registration closing on</b> $closeDate2";

}

function setRegistrationForm()
{
    isset($_POST['date1xx']) ? $d1 = $_POST['date1xx'] : $d1 = "";
    isset($_POST['date1xx']) ? $d2 = $_POST['date2xx'] : $d2 = "";
    isset($_POST['date3xx']) ? $d3 = $_POST['date3xx'] : $d3 = "";
    isset($_POST['minstudents']) ? $ms = $_POST['minstudents'] : $ms = "";

    echo "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"jscal1xx\">
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var cal1xx = new CalendarPopup(\"testdiv1\");
            cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal1xx.showNavigationDropdowns();
            var cal2xx = new CalendarPopup(\"testdiv2\");
            cal2xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal2xx.showNavigationDropdowns();
            var cal3xx = new CalendarPopup(\"testdiv3\");
            cal3xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal3xx.showNavigationDropdowns();
            </SCRIPT>";

    echo "<FORM method='post'>
                <b>Open on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"$d1\" SIZE = 15 readonly>
                <A HREF=\"#\" onClick=\"cal1xx.select(document.forms[0].date1xx,'anchor1xx','MM/dd/yyyy'); return false;\"  NAME=\"anchor1xx\" ID=\"anchor1xx\">Calendar</A><br/>

                <b>Close on:</b>
                <span style='font-size: 80%'><i>(Second registration will start)</i></span><br />
                <INPUT TYPE = \"text\" NAME = \"date2xx\" VALUE = \"$d2\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal2xx.select(document.forms[0].date2xx,'anchor2xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor2xx\" ID = \"anchor2xx\" >Calendar</A ><br/>
                <br /><b>Minimum students:</b><br />
                <input type = 'number' value = '$ms'  name='minstudents' style ='width:50px;'><span style='font-size: 80%'> (Classes with participants lower than this number will be closed after closing date)</span><br />

                <b>Close second registration:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date3xx\" VALUE = \"$d3\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal3xx.select(document.forms[0].date3xx,'anchor3xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor3xx\" ID = \"anchor3xx\" >Calendar</A ><br/>


                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickSetReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >
            <DIV ID = \"testdiv2\"></DIV >
            <DIV ID = \"testdiv3\"></DIV >";
}

function editRegistrationForm()
{
    global $connection;
    $SQL = "SELECT *, DATE_FORMAT(opendate, '%m/%d/%Y') as od, DATE_FORMAT(closedate, '%m/%d/%Y') as cd, DATE_FORMAT(closedate2, '%m/%d/%Y') as cd2 FROM REGISTRATION WHERE CURRENT = 1;";
    $result = $connection->query($SQL);

    $open = mysqli_result($result, 0, 'od');
    $close = mysqli_result($result, 0, 'cd');
    $close2 = mysqli_result($result, 0, 'cd2');
    $minimumstudents = mysqli_result($result, 0, 'minimumstudents');


    isset($_POST['date1xx']) ? $d1 = $_POST['date1xx'] : $d1 = $open;
    isset($_POST['date1xx']) ? $d2 = $_POST['date2xx'] : $d2 = $close;
    isset($_POST['date3xx']) ? $d3 = $_POST['date3xx'] : $d3 = $close2;
    isset($_POST['minstudents']) ? $ms = $_POST['minstudents'] : $ms = $minimumstudents;

    echo "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"jscal1xx\">
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var cal1xx = new CalendarPopup(\"testdiv1\");
            cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal1xx.showNavigationDropdowns();
            var cal2xx = new CalendarPopup(\"testdiv2\");
            cal2xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal2xx.showNavigationDropdowns();
            var cal3xx = new CalendarPopup(\"testdiv3\");
            cal3xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal3xx.showNavigationDropdowns();
            </SCRIPT>";

    echo "<FORM method='post'>
                <b>Open on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date1xx\" VALUE = \"$d1\" SIZE = 15 readonly>
                <A HREF=\"#\" onClick=\"cal1xx.select(document.forms[0].date1xx,'anchor1xx','MM/dd/yyyy'); return false;\"  NAME=\"anchor1xx\" ID=\"anchor1xx\">Calendar</A><br/>

                <b>Close on:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date2xx\" VALUE = \"$d2\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal2xx.select(document.forms[0].date2xx,'anchor2xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor2xx\" ID = \"anchor2xx\" >Calendar</A ><br/>

                <br /><b>Minimum students:</b><br />
                <input type = 'number' value = '$ms'  name='minstudents' style ='width:50px;'><span style='font-size: 80%'>(Classes with participants lower than this number will be closed after closing date)<br />

                <b>Close second:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date3xx\" VALUE = \"$d3\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal3xx.select(document.forms[0].date3xx,'anchor3xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor3xx\" ID = \"anchor3xx\" >Calendar</A ><br/>


                <input type='submit' value = 'delete' class = 'back' name =\"deleteReg\">
                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickEditReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >
            <DIV ID = \"testdiv2\"></DIV >
            <DIV ID = \"testdiv3\"></DIV >";
}

function setRegistration()
{
    global $connection;

    if (!$_POST['date1xx'] || !$_POST['date2xx'] || !$_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>All dates have to be set.</span>";
    } else if ($_POST['date1xx'] >= $_POST['date2xx'] || $_POST['date1xx'] >= $_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Closing date(s) have to be after opening date.</span>";
    } else if ($_POST['date2xx'] >= $_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Second closing date has to be after first closing date.</span>";
    } else if ($_POST['minstudents'] == "" || $_POST['minstudents'] < 0) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum students has to be at least 0.</span>";
    } else if ($_POST['minstudents'] == "" || $_POST['minstudents'] < 0) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum students has to be at least 0.</span>";
    } else {
        $openDATE = $_POST["date1xx"];
        $openDATEm = substr($openDATE, 0, 2);
        $openDATEd = substr($openDATE, 3, 2);
        $openDATEy = substr($openDATE, 6, 4);

        $closeDATE = $_POST["date2xx"];
        $closeDATEm = substr($closeDATE, 0, 2);
        $closeDATEd = substr($closeDATE, 3, 2);
        $closeDATEy = substr($closeDATE, 6, 4);

        $close2DATE = $_POST["date3xx"];
        $close2DATEm = substr($close2DATE, 0, 2);
        $close2DATEd = substr($close2DATE, 3, 2);
        $close2DATEy = substr($close2DATE, 6, 4);

        $minStudents = $_POST['minstudents'];

        //"Archives" other registrations
        $SQL = "update registration set current = '0'";
        if ($connection->query($SQL) === TRUE) {
            $SQL = "insert into registration (opendate, closedate, closedate2, type, minimumstudents, current) values ('$openDATEy-$openDATEm-$openDATEd', '$closeDATEy-$closeDATEm-$closeDATEd', '$close2DATEy-$close2DATEm-$close2DATEd', '1', $minStudents, '1')";
            if ($connection->query($SQL) === TRUE) {
                $_SESSION['tab'] = "123";
                header("Location:admin.php");
                exit();
            } else {
                echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
            }
        } else {
            setRegistrationForm();
            echo "<br/><span class='errorMsg'>" . $connection->error . "2</span>";
        }
    }
}

function editRegistration()
{
    global $connection;


    if (!$_POST['date1xx'] || !$_POST['date2xx'] || !$_POST['date3xx']) {
        editRegistrationForm();
        echo "<br/><span class='errorMsg'>All dates have to be set.</span>";
    } else if ($_POST['date1xx'] > $_POST['date2xx'] || $_POST['date1xx'] > $_POST['date3xx']) {
        editRegistrationForm();
        echo "<br/><span class='errorMsg'>Closing date(s) have to be after opening date.</span>";
    } else if ($_POST['date2xx'] > $_POST['date3xx']) {
        editRegistrationForm();
        echo "<br/><span class='errorMsg'>Second closing date has to be after first closing date.</span>";
    } else if ($_POST['minstudents'] == "" || $_POST['minstudents'] < 0) {
        editRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum students has to be at least 0.</span>";
    } else if ($_POST['minstudents'] == "" || $_POST['minstudents'] < 0) {
        editRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum students has to be at least 0.</span>";
    } else {
        $openDATE = $_POST["date1xx"];
        $openDATEm = substr($openDATE, 0, 2);
        $openDATEd = substr($openDATE, 3, 2);
        $openDATEy = substr($openDATE, 6, 4);

        $closeDATE = $_POST["date2xx"];
        $closeDATEm = substr($closeDATE, 0, 2);
        $closeDATEd = substr($closeDATE, 3, 2);
        $closeDATEy = substr($closeDATE, 6, 4);

        $close2DATE = $_POST["date3xx"];
        $close2DATEm = substr($close2DATE, 0, 2);
        $close2DATEd = substr($close2DATE, 3, 2);
        $close2DATEy = substr($close2DATE, 6, 4);

        $minStudents = $_POST['minstudents'];

        $SQL = "update registration set opendate = '$openDATEy-$openDATEm-$openDATEd', closedate = '$closeDATEy-$closeDATEm-$closeDATEd', closedate2 = '$close2DATEy-$close2DATEm-$close2DATEd', minimumstudents = $minStudents where current = 1";
        if ($connection->query($SQL) === TRUE) {
            $_SESSION["tab"] = "123";
            header("Location:admin.php");
            exit();
        } else {
            editRegistrationForm();
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
    }
}

function deleteReg()
{
    global $connection;
    $SQL = "UPDATE registration set current = '0'";
    if ($connection->query($SQL) === TRUE) {
        status();
        echo "<br/><span class='errorMsg'> Deleted successfully.</span>";
    } else {
        status();
    }
}