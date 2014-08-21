<?php

    include 'settings.php';

    /**
        This is an example of showing the new link form
    */
    include $_SERVER['DOCUMENT_ROOT']  . '/' . $tmlpath . '/missinglink.php';

    /**
        This is an example of showing all links in a random order
    */
    $show="all"; $cat=""; $order="rand"; $number="0";
    include $_SERVER['DOCUMENT_ROOT']  . '/' . $tmlpath . '/display.php';
?>
