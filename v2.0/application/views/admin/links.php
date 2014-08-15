<?php
    if(isset($status)) {
        echo $status;
    }
?>

    <h2>All Links</h2>

    <table class="table table-condensed">

        <th>
            <td>Link Id</td>
            <td>Image</td>
            <td>Link, Name and Categories</td>
            <td>Link Description</td>
            <td>Current Status</td>
            <td>Update Status</td>
            <td>Delete Link</td>
        </th>

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
                    echo '<td><a href="' . site_url("links/updateStatusAccepted/" . $link["id"]) . '">Accept Link</a><br>';
                    echo '<a href="' . site_url("links/updateStatusRejected/" . $link["id"]) . '">Reject Link</a><br>';
                    echo '<a href="' . site_url("links/updateStatusInactive/" . $link["id"]) . '">Inactive Link</a></td>';
                    echo '<td><a href="' . site_url("links/setDelete/" . $link["id"]) . '">Delete Link</a></td>';
                echo '</tr>';
            }
        ?>
    </table>
