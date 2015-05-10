<div class="scrollingtable">
    <div>
        <div>
            <table>
                <caption>Top Caption</caption>
                <thead>
                <tr>
                    <th>
                        <div label="Course ID"/>
                    </th>
                    <th>
                        <div label="Year"/>
                    </th>
                    <th>
                        <div label="Term"/>
                    </th>
                    <th>
                        <div label="Grade"/>
                    </th>
                    <th class="scrollbarhead"/>
                    <!--ALWAYS ADD THIS EXTRA CELL AT END OF HEADER ROW-->
                </tr>
                </thead>
                <tbody>
                <?php
                require_once ('.\include/database.php');
                $number = $_SESSION['number'];
                $number = htmlspecialchars($number);

                $db = new mysqli($server, $user_name, $pass_word, $database);

                if ($db) {
                    $number = quote_smart($number, $db);

                    $SQL = "SELECT * FROM grade WHERE student_number =  $number";

                    $result = $db->query($SQL);
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
                </tbody>
            </table>
        </div>
        Faux bottom caption
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