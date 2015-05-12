<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Course
            </td>
            <td>
                Date
            </td>
            <td>
                Capacity
            </td>
            <td>
                Study Load
            </td>
            <td>
                Enroll
            </td>
        </tr>
        <!--------------------------------------------------------------------->

        <?php
        require("database.php");
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);

            $SQL = "SELECT * FROM course";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        //=============================
                        $name = $data['name'];
                        $capacity = $data['capacity'];
                        $studyload = $data['studyload'];
                        $courseID = $data['courseID'];
                        //=============================
                        echo "<tr><td>$name</td><td><a href='dates.php?courseid=" . urlencode($courseID) . "'><button>Show dates</button></a></td><td>$capacity</td><td>$studyload</td><td><button>Enroll</button></td></tr>";
                    }
                }
            } else {
                echo "Database error";
            }
        }

        ?>


    </table>
</div>
<?php
?>