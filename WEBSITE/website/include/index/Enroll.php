<?php
if (isset($_SESSION["message"])) {
    echo "<span class = 'message'>" . $_SESSION["message"] . "</span>";
    $_SESSION["message"] = "";
}
?>
</h3>
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
        echo courses();?>


    </table>
</div>