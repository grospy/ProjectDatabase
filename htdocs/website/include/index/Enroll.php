<?php
if (isset($_SESSION["message"])) {
    echo "<p class = 'message'>" . $_SESSION["message"] . "</p>";
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
        <?php courses(); ?>


    </table>
</div>