<div class="CSSTableGenerator" >
    <table >
        <tr>
            <td>
                Course ID
            </td>
            <td >
                Year
            </td>
            <td>
                Term
            </td>
            <td>
                Grade
            </td>
        </tr>
        <!--------------------------------------------------------------------->



        <?php
        require("./include/database.php");
        $number = $_SESSION['number'];
        $number = htmlspecialchars($number);

        if ($connection) {
            $number = quote_smart($number, $connection);

            $SQL = "SELECT * FROM grade WHERE student_number =  $number";

            $result = $connection->query($SQL);
            $num_rows = mysqli_num_rows($result);
            if ($result) {
                if ($num_rows > 0) {
                    for ($x = 0; $x < $num_rows; $x++) {
                        $result->data_seek($x);
                        $data = $result->fetch_array();
                        $courseID = $data['courseID'];
                        $year = $data['year'];
                        $term = $data['term'];
                        $grade = $data['grade'];
                        echo "<tr><td>$courseID</td><td>$year</td><td>$term</td><td>$grade</td></tr>";
                    }
                }
            } else {
                echo "Database error";
            }
        }

        ?>



    </table>
</div>


















<div class="scrollingtable">
    <div>
        <div>
            <table>
                <thead>
                <tr>
                    <td>
                        <div label="Course ID"/>
                    </td>
                    <td>
                        <div label="Year"/>
                    </td>
                    <td>
                        <div label="Term"/>
                    </td>
                    <td>
                        <div label="Grade"/>
                    </th>
                    <td class="scrollbarhead"/>
                    <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!--[if lte IE 9]>
<style>.scrollingtable > div > div > table {
    margin-right: 17px;
}</style><![endif]-->


<!--more versatile way of doing column label; requires 2 identical copies of label-->
<!--<th>
  <div><div>Column 4</div><div>Column 4</div></div>
</th>-->

<?php
function quote_smart($value, $handle)
{
    if (get_magic_quotes_gpc()) {
        $value = stripslashes($value);
    }

    if (!is_numeric($value)) {
        $value = "'" . mysqli_real_escape_string($handle, $value) . "'";
    }
    return $value;
}
?>