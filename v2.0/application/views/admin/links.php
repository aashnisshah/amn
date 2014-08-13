<?php
    if(isset($status)) {
        echo $status;
    }
?>

    <h2>All Links</h2>

    <table class="table table-condensed">
        <?php
            foreach($allLinks as $link) {
                echo '<tr>';
                    echo '<td>' . $link['id'] . '<td>';
                    echo '<td>' . $link['name'] . '<br>';
                        echo '<a href="' . $link['url'] . '" target="_blank">' . $link['url'] . '</a><br>';
                        echo '<span class="label label-info">' . $link['groups'] . '</span>';
                    echo '</td>';
                    echo '<td>' . $link['description'] . '</td>';
                    echo '<td><img class="linkdisplay" src="' . $link['image'] . '"></td>';
                echo '</tr>';
            }
        ?>
    </table>
