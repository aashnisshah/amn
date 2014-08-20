<?php

    if(isset($code)) {
?>
        <h4>Codes to Display Your Links</h4>

        <div class="middle-width">
            <p>Based on your specifications, we have generated the following code.
            Copy the code, and paste it wherever you would like the links to appear.
            Make sure that the page you paste these codes on are on the same server,
            and that the page is a PHP file. If you would like to change these settings,
            or display a different set of links elsewhere on your site, make the necessary
            changes to the form below.</p>

            <?php echo '<pre>' . $code . '</pre>'; ?>

        <hr>
<?php
    }
?>
