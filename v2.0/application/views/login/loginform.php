Please Login To Continue!

<?php
    echo validation_errors();
    echo form_open('verifylogin');
    echo form_label("Username: ");
    echo form_input("username");
    echo form_label("Password: ");
    echo form_password("password");
    echo form_submit("","Login");
    echo form_close();
?>
