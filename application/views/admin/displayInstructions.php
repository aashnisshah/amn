<h2>Get Display Codes</h2>

<hr>

<h4>Code to Display the External Link Form</h4>
    <p>This code allows you to create a form that your site visitors can use to
        submit links to your site. Copy the code below and paste it on any PHP
        page within this server.</p>
<?php
    include 'settings.php';
    echo '<pre>';
    $externalcode = '&lt;?php ';
    $externalcode .= 'include \'' . $_SERVER['DOCUMENT_ROOT']  . '/' . $tmlpath . '/missinglink.php\';';
    $externalcode .= ' ?&gt;';
    echo $externalcode;
    echo '</pre>';

?>

<hr>

<div class="middle-width">
    <p>Select the applicable choices in the form below, then select "generate code",
    and you will be provided with a code that you can place anywhere on your
    website. This code will automatically generate a list of links based on your
    settings, and display them on your website.</p>

    <p>If you would like to style the links further, they have all been assigned
    the class <strong>missinglink</strong>, and will each have an individual
    ID <strong>ml#</strong>, where # is the links ID.</p>
</div>

<hr>
