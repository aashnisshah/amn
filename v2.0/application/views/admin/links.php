<?php
    if(isset($status)) {
        echo $status;
    }
?>

    <a href="<?php echo site_url("links/index/all"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            All
        </button>
    </a>
    <a href="<?php echo site_url("links/index/pending"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Pending
        </button>
    </a>
    <a href="<?php echo site_url("links/index/accepted"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Accepted
        </button>
    </a>
    <a href="<?php echo site_url("links/index/rejected"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Rejected
        </button>
    </a>
    <a href="<?php echo site_url("links/index/inactive"); ?>">
        <button id="addLinkButton" class="btn btn-info btn-lg" type="button">
            Inactive
        </button>
    </a>

    <h2><?php echo ucfirst($header); ?> Links</h2>

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
                    echo '<td><a href="' . site_url("links/updateStatus/" . $link["id"]) . '/accepted">Accept Link</a><br>';
                    echo '<a href="' . site_url("links/updateStatus/" . $link["id"]) . '/rejected">Reject Link</a><br>';
                    echo '<a href="' . site_url("links/updateStatus/" . $link["id"]) . '/inactive">Inactive Link</a></td>';
                    echo '<td><a href="' . site_url("links/delete/" . $link["id"]) . '">Delete Link</a></td>';
                echo '</tr>';
            }
        ?>
    </table>
