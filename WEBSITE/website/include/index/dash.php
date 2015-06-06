<link href="cssjs/studentbuttonstyle.css" rel="stylesheet" type="text/css">

</head>
<body>

<div id='fade' class='black_overlay'></div>

<img src="image/Inholland_logo.png" id="logotop">

<div id="webtitle">
    International Business Innovation Studies</br>
    Elective Courses Enrolment
</div>
<div id="welcome">
    Welcome, <?php echo htmlspecialchars($_SESSION['name'] . ".") ?>

    <?php
    if ($connection) {
        if (true) { //if the student is still in the registration period
            $registrationSQL = "select DATE_FORMAT(opendate, '%M %e, %Y') as opendate, DATE_FORMAT(closedate, '%M %e, %Y') as closedate, DATE_FORMAT(closedate2, '%M %e, %Y') as closedate2  from registration WHERE current = 1";
            $result = $connection->query($registrationSQL);
            $num_rows = mysqli_num_rows($result);
            if ($num_rows > 0) {
                $now = Date('F j,Y');
                $open = mysqli_result($result, 0, 'opendate');
                $close = mysqli_result($result, 0, 'closedate');
                $close2 = mysqli_result($result, 0, 'closedate2');

                if ($now >= $open && $now <= $close) {//open
                    echo "<br/>Last day to register:</br>$close";
                } else if ($now > $close && $now <= $close2) {//open2
                    echo "<br/>Second registration closes:</br>$close2";
                } else if ($now < $open) {//will open
                    echo "<br/>Registration starts:</br>$open";
                }
            }
        }
    }
    ?>
    <br/>
    <span id="logout"><a href="logout.php">Log out</a></span>
</div>