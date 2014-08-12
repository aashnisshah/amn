<?php

    if(isset($status)) {
        echo $status;
    }
    
    echo '<h2>All Links</h2>';

    echo '<table>';
    foreach($allLinks as $link) {
        echo '<tr><td>' . $link['name'] . '</td>';
        echo '<td><a href="' . $link['url'] . '">'.  $link['url'] .'</a></td></tr>';
    }
    echo '</table>';

    echo '<h2>All Accepted Links</h2>';

    echo '<table>';
    foreach($accepted as $link) {
        echo '<tr><td>' . $link['name'] . '</td>';
        echo '<td><a href="' . $link['url'] . '">'.  $link['url'] .'</a></td></tr>';
    }
    echo '</table>';

    echo '<h2>All Pending Links</h2>';

    echo '<table>';
    foreach($pending as $link) {
        echo '<tr><td>' . $link['name'] . '</td>';
        echo '<td><a href="' . $link['url'] . '">'.  $link['url'] .'</a></td></tr>';
    }
    echo '</table>';

    echo '<h2>All Rejected Links</h2>';

    echo '<table>';
    foreach($rejected as $link) {
        echo '<tr><td>' . $link['name'] . '</td>';
        echo '<td><a href="' . $link['url'] . '">'.  $link['url'] .'</a></td></tr>';
    }
    echo '</table>';
?>
