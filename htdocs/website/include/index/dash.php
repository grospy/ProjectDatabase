<img src="image/Inholland_logo.png" id="logotop">
    <div id="webtitle">
        International Business Innovation Studies</br>
        Elective Courses Enrolment
    </div>
    <div id="welcome">
        Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?>
        <br/>Registration period:</br>
    <?php
    if ($connection) {
        if (true) { //if the student is still in the registration period
            //$registrationSQL = "select DATE_FORMAT(openRegDate, '%a, %e-%b-%Y %r') as openRegDate, DATE_FORMAT(closeRegDate, '%a, %e-%b-%Y %r') as closeRegDate from registration order by closeRegDate DESC limit 1";
            $registrationSQL = "select DATE_FORMAT(opendate, '%b %e') as opendate, DATE_FORMAT(closedate, '%b %e, %Y') as closedate from registration order by closedate DESC limit 1";
            $result = $connection->query($registrationSQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                for ($x = 0; $x < $num_rows; $x++) {
                    $result->data_seek($x);
                    $data = $result->fetch_array();
                    $openDate = $data['opendate'];
                    $closeDate = $data['closedate'];


                    echo $openDate." to ".$closeDate;
                }
            }
        }
    }
    ?>
        <br/>
        <span id="logout"><a href="logout.php">Log out</a></span>
    </div>