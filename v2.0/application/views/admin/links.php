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
                    echo '<td><img class="linkdisplay" src="' . $link['image'] . '"></td>';
                    echo '<td>' . $link['name'] . '<br>';
                        echo '<a href="' . $link['url'] . '" target="_blank">' . $link['url'] . '</a><br>';
                        $groupsCombined = $link['groups'];
                        $groupsSplit = explode(" ", $groupsCombined);
                        foreach($groupsSplit as $group) {
                            if($group != "") {
                                echo '<span class="label label-info">' . $categories[$group] . '</span> ';
                            }
                        }
                    echo '</td>';
                    echo '<td>' . $link['description'] . '</td>';
                    echo '<td>' . $link['status'] . '</td>';
                    echo '<td><a href="' . site_url("links/setDelete/" . $link["id"]) . '">Delete Link</a>';
                echo '</tr>';
            }
        ?>
    </table>
