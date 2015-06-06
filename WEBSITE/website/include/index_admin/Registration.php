<?php
if (isset($_POST['clickSetReg'])) {
    setRegistration();
} else if (isset($_POST['clickEditReg'])) {
    editRegistration();
} else if (isset($_POST["openReg"])) {
    setRegistrationForm();
} else if (isset($_POST["editReg"])) {
    editRegistrationForm();
} else if (isset($_POST["endReg"])) {
    endRegistrationForm();
} else if (isset($_POST["endRegConfirm"])) {
    endRegistration();
} else if (isset($_POST["endReg2"])) {
    endRegistrationForm2();
} else if (isset($_POST["endReg2Confirm"])) {
    endRegistration2();
} else if (isset($_POST["openRegNow"])) {
    openRegNow();
} else if (isset($_POST["openRegNowConfirm"])) {
    openRegNowConfirm();
} else if (isset($_POST["grades"])) {
    grades();
} else if (isset($_POST["setPassed"]) || isset($_POST["setFailed"])) {
    submitStatus();
} else if (isset($_POST["nextReg"])) {
    nextReg();
} else if (isset($_POST["nextRegConfirm"])) {
    nextRegConfirm();
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
            open2();
            break;
        case 3:
            opening();
            break;
        case 4:
            over();
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


    $result = $connection->query("Select *,date_format(closedate, '%b %e, %Y') as closedate, datediff(closedate, CURDATE()) as diff, date_format(closedate2, '%b %e, %Y') as closedate2, datediff(closedate2, CURDATE()) as diff2 from registration where CURRENT = 1");
    $closeDate = mysqli_result($result, 0, 'closedate');
    $diff = mysqli_result($result, 0, 'diff');
    $closeDate2 = mysqli_result($result, 0, 'closedate2');
    $diff2 = mysqli_result($result, 0, 'diff2');
    $mc = mysqli_result($result, 0, 'minimumcredits');
    echo "<b>Closing on:</b> $closeDate - <i>($diff day(s) from today)</i><br /><br />";
    echo "<b>Second registration closing on:</b> $closeDate2 - <i>($diff2 day(s) from today)</i><br /><br />";
    echo "<b>Minimum credits:</b> $mc";
    echo "<hr style='visibility: hidden'>
        <form method='post'>
            <input type='submit' name='editReg' value='Edit'>
            <input type='submit' name='endReg' value='End now'>
    </form>";


}

function open2()
{
    global $connection;
    echo "<h4>Status: <span style='color:#3cda19;'>Open - <i>(Second registration)</i></span></h4>";


    $result = $connection->query("Select *,date_format(closedate, '%b %e, %Y') as closedate, datediff(closedate, CURDATE()) as diff, date_format(closedate2, '%b %e, %Y') as closedate2, datediff(closedate2, CURDATE()) as diff2 from registration where CURRENT = 1");
    $closeDate2 = mysqli_result($result, 0, 'closedate2');
    $diff2 = mysqli_result($result, 0, 'diff2');
    $mc = mysqli_result($result, 0, 'minimumcredits');
    echo "<b>Closing on:</b> $closeDate2 - <i>($diff2 day(s) from today)</i><br /><br />";
    echo "<b>Minimum credits:</b> $mc";
    echo "<hr style='visibility: hidden'><form method='post'><input type='submit' name='editReg' value='Edit'>
            <input type='submit' name='endReg2' value='End now'></form>";


}

function opening()
{
    global $connection;
    echo "<h4>Status: <span style='color:#dac308;'>Closed</span></h4>";
    echo "<b>Opening on:</b> ";
    $result = $connection->query("Select *,date_format(closedate, '%b %e, %Y') as closedate, date_format(opendate, '%b %e, %Y') as opendate, date_format(closedate2, '%b %e, %Y') as closedate2, datediff(opendate, CURDATE()) as diff from registration where CURRENT = 1");
    $openDate = mysqli_result($result, 0, 'opendate');
    $closeDate = mysqli_result($result, 0, 'closedate');
    $closeDate2 = mysqli_result($result, 0, 'closedate2');
    $mc = mysqli_result($result, 0, 'minimumcredits');
    $diff = mysqli_result($result, 0, 'diff');
    echo $openDate . " - <i>($diff day(s) from today)</i><br /><br />";
    echo "<b>Closing on</b> $closeDate<br /><br />";
    echo "<b>Second registration closing on</b> $closeDate2<br /><br />";
    echo "<b>Minimum credits:</b> $mc";
    echo "<hr style='visibility: hidden'><form method='post'><input type='submit' name='editReg' value='Edit'><input type='submit' name='openRegNow' value='Open Now'></form>";

}

function over()
{

    global $connection;
    echo "<h4>Status: <span style='color:#4cdacc;'>Over</span></h4>";

    echo "<hr style='visibility: hidden'>
<form method='post'>
<input type='submit' name='grades' value='Input pass/fail'>
<input type='submit' name='nextReg' value='Start next registration'>
</form>";

}

function grades()
{
    global $connection;
    echo "<h4>Input pass/fail</h4>
		<form name='submitStatus' method='post'> ";
    echo "    <input type='button' name='Check_All' value='Check All' onClick=\"CheckAll(1)\"><input type='button' name='Un_CheckAll' value='Uncheck All' onClick=\"UnCheckAll(1)\"><i>Change selected to:</i>
			<input type='submit' name='setPassed' value='Passed'><input type='submit' name='setFailed' value='Failed'><br/>";
    $regSQL = "SELECT * from registration where CURRENT = '1';";
    $regResult = $connection->query($regSQL);
    echo $connection->error;
    if (mysqli_num_rows($regResult)) {
        $regID = mysqli_result($regResult, 0, 'registrationID');
        $SQL = "SELECT * from course where courseID in(select c.courseID from enrolledstudent en inner join course c on en.courseID = c.courseID where en.registrationID = '$regID' group by c.courseID);";
        $result = $connection->query($SQL);
        for ($i = 0; $i < mysqli_num_rows($result); $i++) {
            $courseID = mysqli_result($result, $i, 'courseID');

            echo "
			
			<table cellspacing=\"0\" class=\"PSLEVEL1GRIDWBO\" id=\"IH_PT_INS\$scroll$0\" dir=\"ltr\" cols=\"1\" width=\"851\"
           cellpadding=\"0\">
        <tbody>
        <tr>
            <td class=\"PSLEVEL1GRIDLABEL\" align=\"left\">
                <div id=\"win1divIH_PT_INSGP$0\">" . mysqli_result($result, $i, 'name') . "</div>
            </td>
        </tr>
        <tr>
            <td>
                <table  border=\"0\" cellpadding=\"2\" cellspacing=\"0\" cols=\"9\" width=\"100%\" class=\"PSLEVEL1GRID\"
                       style=\"border-style:none\">
                    <tbody>
                    <tr>
                        <th width='25px' align=\"left\" class=\"PSLEVEL1GRIDCOLUMNHDR\">&nbsp;</th>
                        <th align=\"left\" class=\"PSLEVEL1GRIDCOLUMNHDR\">Student</th>
                        <th width='100px' align=\"left\" class=\"PSLEVEL1GRIDCOLUMNHDR\">Status</th>
                    </tr>";

            $SQLstudent = "SELECT *,concat(p.personID,' - ',p.firstName,' ',p.lastName) as student, p.personID, en.status from course c inner join enrolledstudent en on c.courseID = en.courseID inner join person p on p.personID  = en.studentID where c.courseID = '$courseID';";
            $resultStudent = $connection->query($SQLstudent);
            for ($j = 0; $j < mysqli_num_rows($resultStudent); $j++) {
                $courseID = mysqli_result($result, $i, 'courseID');
                $studentID = mysqli_result($resultStudent, $j, 'personID');
                echo "<tr id=\"trIH_PT_INS$0_row1\" valign=\"center\">
                    <td align=\"left\" class=\"PSLEVEL1GRIDROW\">
                            <input type='checkbox' name='statusForm[]' class='statusForm' value=" . $courseID . "_" . $studentID . ">
						</td>
                        <td align=\"left\" class=\"PSLEVEL1GRIDROW\">
                            " . mysqli_result($resultStudent, $j, 'student') . "
                        </td>
                        <td align=\"left\" class=\"PSLEVEL1GRIDROW\">
                            " . statusCheck($courseID, $studentID) . "
                        </td> </tr>";
            }
            echo "
							</tbody>
						</table>
					</td>
				</tr>
			</tbody>
		</table>";
        }
    }
    echo "
		<input type='button' name='Check_All' value='Check All' onClick=\"CheckAll(1)\"><input type='button' name='Un_CheckAll' value='Uncheck All' onClick=\"UnCheckAll(1)\">

            <i>Change selected to:</i>
			<input type='submit' name='setPassed' value='Passed'><input type='submit' name='setFailed' value='Failed'><br/>
			<input type='submit' name='backToReg' value='Back'>
		</form>";
}

function statusCheck($courseID, $studentID)
{
    global $connection;
    $regSQL = "SELECT * from registration where CURRENT = '1';";
    $regResult = $connection->query($regSQL);
    $regID = mysqli_result($regResult, 0, 'registrationID');
    $checkStatusSQL = "SELECT status from enrolledStudent where studentID='$studentID' and courseID='$courseID' and registrationID='$regID';";
    $result = $connection->query($checkStatusSQL);
    switch (mysqli_result($result, 0, 'status')) {
        case '1':
            return "<Span style='color: lightgreen'>Passed</Span>";
            break;
        case '0':
            return "<Span style='color: darkred'>Failed</Span>";
            break;
        default:
            return "<Span style='color: #ffd552'>Pending</Span>";
            break;
    }
}

function nextReg()
{
    Echo "<span class='errorMsg' style='font-size: 100%'> Are you sure you want to close this registration period and start the next one?</span><hr style='visibility: hidden'>
            <form method='post'>
                <input type='submit' value = 'Yes' class = 'back' name =\"nextRegConfirm\">
                <input type='submit' value = 'No' name =\"backToReg\">
            </FORM >";
}

function nextRegConfirm()
{
    global $connection;
    if ($connection->query("UPDATE registration set current = '0';")) {
        status();
        echo "<span class = 'confirmMsg'> Registration closed successfully.";
    } else {
        echo $connection->error;
    }


}

function submitStatus()
{
    global $connection;

    if (isset($_POST['setPassed'])) {
        if (!isset($_POST['statusForm'])) {
            grades();
            echo "<span class='errorMsg'> No students selected! </span>";
        } else {
            $regSQL = "SELECT * from registration where CURRENT = '1';";
            $regResult = $connection->query($regSQL);
            $regID = mysqli_result($regResult, 0, 'registrationID');/*
			$clearStatusSQL = "update enrolledstudent set status=0 WHERE registrationID='$regID' ";
            $connection->query($clearStatusSQL);*/
            $passedStudent = $_POST['statusForm'];
            foreach ($passedStudent as $aStudent) {
                //echo $aStudent ."<br/>";
                $inputData = explode('_', "$aStudent");
                $courseID = $inputData[0];
                $studentID = $inputData[1];
                $updateStatusSQL = "update enrolledstudent set status=1 where courseID='$courseID' and studentID='$studentID' and registrationID='$regID' ";
                $connection->query($updateStatusSQL);
            }
            grades();
            echo "<span class='confirmMsg'>Successfully updated status(es)!</span>";
        }
    } elseif (isset($_POST['setFailed'])) {
        if (!isset($_POST['statusForm'])) {
            grades();
            echo "<span class='errorMsg'> No students selected! </span>";
        } else {
            $regSQL = "SELECT * from registration where CURRENT = '1';";
            $regResult = $connection->query($regSQL);
            $regID = mysqli_result($regResult, 0, 'registrationID');/*
			$clearStatusSQL = "update enrolledstudent set status=0 WHERE registrationID='$regID' ";
            $connection->query($clearStatusSQL);*/
            $passedStudent = $_POST['statusForm'];
            foreach ($passedStudent as $aStudent) {
                //echo $aStudent ."<br/>";
                $inputData = explode('_', "$aStudent");
                $courseID = $inputData[0];
                $studentID = $inputData[1];
                $updateStatusSQL = "update enrolledstudent set status=0 where courseID='$courseID' and studentID='$studentID' and registrationID='$regID' ";
                $connection->query($updateStatusSQL);
            }
            grades();
            echo "<span class='confirmMsg'>Successfully updated status(es)!</span>";
        }
    }

}


function setRegistrationForm()
{
    isset($_POST['date1xx']) ? $d1 = $_POST['date1xx'] : $d1 = "";
    isset($_POST['date1xx']) ? $d2 = $_POST['date2xx'] : $d2 = "";
    isset($_POST['date3xx']) ? $d3 = $_POST['date3xx'] : $d3 = "";
    isset($_POST['minstudents']) ? $ms = $_POST['minstudents'] : $ms = "10";
    isset($_POST['mincredits']) ? $mc = $_POST['mincredits'] : $mc = "60";

    echo "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"jscal1xx\">
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var cal1xx = new CalendarPopup(\"testdiv1\");
            cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal1xx.showNavigationDropdowns();
            var cal2xx = new CalendarPopup(\"testdiv1\");
            cal2xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal2xx.showNavigationDropdowns();
            var cal3xx = new CalendarPopup(\"testdiv1\");
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

                <br /><b>Minimum credits:</b><br />
                <input type = 'number' value = '$mc'  name='mincredits' style ='width:50px;'><span style='font-size: 80%'> (Classes with participants lower than this number will be closed after closing date)</span><br />

                <br /><b>Close second registration:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date3xx\" VALUE = \"$d3\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal3xx.select(document.forms[0].date3xx,'anchor3xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor3xx\" ID = \"anchor3xx\" >Calendar</A ><br/>


                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickSetReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >";
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
    $minimumcredits = mysqli_result($result, 0, 'minimumcredits');


    isset($_POST['date1xx']) ? $d1 = $_POST['date1xx'] : $d1 = $open;
    isset($_POST['date1xx']) ? $d2 = $_POST['date2xx'] : $d2 = $close;
    isset($_POST['date3xx']) ? $d3 = $_POST['date3xx'] : $d3 = $close2;
    isset($_POST['minstudents']) ? $ms = $_POST['minstudents'] : $ms = $minimumstudents;
    isset($_POST['mincredits']) ? $mc = $_POST['mincredits'] : $mc = $minimumcredits;

    echo "<SCRIPT LANGUAGE=\"JavaScript\" ID=\"jscal1xx\">
            var date = new Date();
            date.setDate(date.getDate() - 1);
            var cal1xx = new CalendarPopup(\"testdiv1\");
            cal1xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal1xx.showNavigationDropdowns();
            var cal2xx = new CalendarPopup(\"testdiv1\");
            cal2xx.addDisabledDates(null,formatDate(date,\"yyyy-MM-dd\"));
            cal2xx.showNavigationDropdowns();
            var cal3xx = new CalendarPopup(\"testdiv1\");
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

                <br /><b>Minimum credits:</b><br />
                <input type = 'number' value = '$mc'  name='mincredits' style ='width:50px;'><span style='font-size: 80%'><br />

                <b>Close second:</b><br />
                <INPUT TYPE = \"text\" NAME = \"date3xx\" VALUE = \"$d3\" SIZE = 15 readonly>
                <A HREF = \"#\" onClick = \"cal3xx.select(document.forms[0].date3xx,'anchor3xx','MM/dd/yyyy'); return false;\"  NAME = \"anchor3xx\" ID = \"anchor3xx\" >Calendar</A ><br/>

                <input type='submit' value = 'back' class = 'back' name =\"backToReg\">
                <input type='submit' value = 'set' name =\"clickEditReg\">
            </FORM >
            <DIV ID = \"testdiv1\"></DIV >";
}

function endRegistrationForm()
{
    Echo "<span class='errorMsg' style='font-size: 100%'> Are you sure you want to end registration now?</span><hr style='visibility: hidden'>";
    Echo "  <form method='post'>
                <input type='submit' value = 'Yes' class = 'back' name =\"endRegConfirm\">
                <input type='submit' value = 'No' name =\"backToReg\">
            </FORM >";
}

function endRegistration()
{
    global $connection;
    $yesterday = new DateTime();
    $yesterday->add(DateInterval::createFromDateString('yesterday'));
    $yesterday = $yesterday->format('Y-m-d');
    $SQL = "update registration set closedate = '$yesterday' where CURRENT =1";

    if ($connection->query($SQL)) {
        start2v2();
        status();
    } else {
        endRegistrationForm();
        echo "<span class='errorMSG'>$connection->error</span>";
    }
}

function endRegistrationForm2()
{
    Echo "<span class='errorMsg' style='font-size: 100%'> Are you sure you want to end the second registration now?</span><hr style='visibility: hidden'>";
    Echo "  <form method='post'>
                <input type='submit' value = 'Yes' class = 'back' name =\"endReg2Confirm\">
                <input type='submit' value = 'No' name =\"backToReg\">
            </FORM>";
}

function endRegistration2()
{
    global $connection;
    $yesterday = new DateTime();
    $yesterday->add(DateInterval::createFromDateString('yesterday'));
    $yesterday = $yesterday->format('Y-m-d');
    $SQL = "update registration set closedate2 = '$yesterday' where CURRENT =1";

    if ($connection->query($SQL)) {
        endProcessv2();
        status();
    } else {
        endRegistrationForm2();
        echo "<span class='errorMsg'>$connection->error</span>";
    }
}

function openRegNow()
{
    Echo "<span class='errorMsg' style='font-size: 100%'> Are you sure you want to open registration now?</span><hr style='visibility: hidden'>";
    Echo "  <form method='post'>
                <input type='submit' value = 'Yes' class = 'back' name =\"openRegNowConfirm\">
                <input type='submit' value = 'No' name =\"backToReg\">
            </FORM >";
}

function openRegNowConfirm()
{
    global $connection;
    $yesterday = new DateTime();
    $yesterday->add(DateInterval::createFromDateString('yesterday'));
    $yesterday = $yesterday->format('Y-m-d');
    $SQL = "update registration set opendate = '$yesterday' where CURRENT =1";

    if ($connection->query($SQL)) {
        start1v2();
        status();
    } else {
        endRegistrationForm();
        echo "<span class='errorMSG'>$connection->error</span>";
    }
}

function setRegistration()
{
    global $connection;

    if (!$_POST['date1xx'] || !$_POST['date2xx'] || !$_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>All dates have to be set.</span>";
    } else if ($_POST['date1xx'] > $_POST['date2xx'] || $_POST['date1xx'] > $_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Closing date(s) have to be after opening date.</span>";
    } else if ($_POST['date2xx'] > $_POST['date3xx']) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Second closing date has to be after first closing date.</span>";
    } else if ($_POST['minstudents'] == "" || $_POST['minstudents'] < 0) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum students has to be at least 0.</span>";
    } else if ($_POST['mincredits'] == "" || $_POST['mincredits'] < 0) {
        setRegistrationForm();
        echo "<br/><span class='errorMsg'>Minumum credits has to be at least 0.</span>";
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
        $minCredits = $_POST['mincredits'];

        //"Archives" other registrations
        $SQL = "update registration set current = '0'";
        if ($connection->query($SQL) === TRUE) {
            $SQL2 = "UPDATE course set minimumstudents = $minStudents";
            if ($connection->query($SQL2) === TRUE) {
                $SQL = "insert into registration (opendate, closedate, closedate2, minimumstudents, minimumcredits, current) values ('$openDATEy-$openDATEm-$openDATEd', '$closeDATEy-$closeDATEm-$closeDATEd', '$close2DATEy-$close2DATEm-$close2DATEd', $minStudents, $minCredits, '1')";
                if ($connection->query($SQL) === TRUE) {
                    $now = Date('m/d/Y');
                    if ($openDATE == $now) {
                        start1v2();
                    }
                    $_SESSION['tab'] = "123";
                    header("Location:admin.php");
                    exit();
                } else {
                    echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
                }
            } else {
                setRegistrationForm();
                echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
            }
        } else {
            setRegistrationForm();
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
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
        $minCredits = $_POST['mincredits'];


        $SQL = "update registration set opendate = '$openDATEy-$openDATEm-$openDATEd', closedate = '$closeDATEy-$closeDATEm-$closeDATEd', closedate2 = '$close2DATEy-$close2DATEm-$close2DATEd', minimumstudents = $minStudents, minimumcredits = $minCredits where current = 1";
        if ($connection->query($SQL) === TRUE) {
            $now = Date('m/d/Y');
            if ($openDATE == $now) {
                start1v2();
            }
            $_SESSION["tab"] = "123";
            header("Location:admin.php");
            exit();
        } else {
            editRegistrationForm();
            echo "<br/><span class='errorMsg'>" . $connection->error . "</span>";
        }
    }
}
