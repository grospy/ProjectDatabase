<?php
require('include/top.php');
?>
<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Date
            </td>
            <td>
                Time start
            </td>
        </tr>
        <?php

        $courseID = $_GET['courseid'];


        require("include/database.php");

        if ($connection) {

            $SQL = "SELECT * FROM lesson WHERE courseid = '$courseID'";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        //=============================
                        $date = $data['date'];
                        $time = $data['time_start'];
                        //=============================
                        echo "<tr><td>$date</td><td>$time</td></tr>";
                    }
                }
            } else {
                echo "Database error";
            }
        }

        ?>
    </table>
</div>
<a href="index.php">Back</a>
<?php
require('include/bot.php');
