<?php
require("../top.php");
require("../database.php");
require("../functions.php");
if (isset($_SESSION["message"])) {
    echo $_SESSION["message"];
    $_SESSION["message"] = "";
}
?>
<div class="CSSTableGenerator">
    <table>
        <tr>
            <td>
                Course
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
        <?php
        //$number = $_SESSION['number'];
        $number = 559942;
        $number = htmlspecialchars($number);

        if ($connection) {


        }
        ?>
    </table>
</div>
