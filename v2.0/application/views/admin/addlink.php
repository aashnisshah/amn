<?php

    if(isset($message)) {
        echo $message;
    }
    echo '<h2>Links</h2>';
    echo validation_errors();
    echo form_open('links/newLink');
    echo form_label("Link URL: ");
    echo form_input("url");
    echo '<br>';
    echo form_label("Link Name: ");
    echo form_input("name");
    echo '<br>';
    echo form_label("Groups: ");
    echo form_input("groups");
    echo '<br>';
    echo form_label("Image: ");
    echo form_input("image");
    echo '<br>';
    echo form_submit("","Add Link");
    echo form_close();

?>
