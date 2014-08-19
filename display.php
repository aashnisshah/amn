<?php
    $query = "";

    if($show == "all") {
        $query = "SELECT * FROM links WHERE status=\"Accepted\"";
    } else {
        // TODO: Figure out how to search for categories specifically
        // $query = "SELECT * FROM links WHERE status=\"Accepted\" AND WHERE `groups` LIKE '%$cat%'";
    }

    if($order == "alph") {
        $query .= ' ORDER BY name';
    } else if ($order == "rand") {
        $query .= ' ORDER BY RAND()';
    }

    if($number != 0) {
        $query .= ' LIMIT '.$number.'';
    }

    $con=mysqli_connect("localhost","root","root","amn");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }

    $mysql_query = mysqli_query($con, $query);

    $linksOutput = "<ul>";

    while($links = mysqli_fetch_array($mysql_query)) {
        $linksOutput .= "<li class=\"missinglink\" id=" . $links['id'] . ">";
        $linksOutput .= "<a href=\"" . $links['url'] . "\">";
        $linksOutput .= $links['name'] . "</a></li>";
    }

    $linksOutput .= "</ul>";

    echo $linksOutput;

    mysqli_close($con);