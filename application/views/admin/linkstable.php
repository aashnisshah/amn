<?php

    if(count($allLinks) < 1) {
        echo "<p>There are currently no links to list.";
    } else {

?>

<table class="table table-condensed">

    <th>
        <td>Link Id</td>
        <td>Image</td>
        <td>Link, Name and Categories</td>
        <td>Link Description</td>
        <td>Current Status</td>
        <td>Update Status</td>
        <td>Edit Link</td>
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
                        if($group != "" && isset($categories[$group])) {
                            echo '<span class="label label-info">' . $categories[$group] . '</span> ';
                        }
                    }
                echo '</td>';
                echo '<td>' . $link['description'] . '</td>';
                echo '<td>' . $link['status'] . '</td>';
                echo '<td><a href="' . site_url("links/updateStatus/" . $link["id"]) . '/accepted">Accept Link</a><br>';
                echo '<a href="' . site_url("links/updateStatus/" . $link["id"]) . '/rejected">Reject Link</a><br>';
                echo '<a href="' . site_url("links/updateStatus/" . $link["id"]) . '/inactive">Inactive Link</a></td>';
                echo '<td><a href="' . site_url("links/edit/" . $link["id"]) . '">Edit Link</a></td>';
                echo '<td><a href="' . site_url("links/delete/" . $link["id"]) . '">Delete Link</a></td>';
            echo '</tr>';
        }
    ?>
</table>

<?php
    }
?>
