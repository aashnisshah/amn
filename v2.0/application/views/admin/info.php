<?php

    if(isset($message)) {
        echo $message;
    }
    echo '<h2>Personal Information</h2>';
    echo validation_errors();
    echo form_open('admin/updateInfo');
    echo form_label("Name: ");
    echo form_input("name", set_value("name", $admin_info['name']));
    echo '<br>';
    echo form_label("Email: ");
    echo form_input("email", set_value("email", $admin_info['email']));
    echo '<br>';
    echo form_label("Website Link: ");
    echo form_input("website", set_value("website", $admin_info['website']));
    echo '<br>';
    echo '<h2>Account Information</h2>';
    echo form_label("Username: ");
    echo form_input("username", $this->session->userdata['username']);
    echo '<br>';
    echo form_label("New Password: ");
    echo form_password("newpassword");
    echo '<br>';
    echo form_label("Confirm Password: ");
    echo form_password("confpassword");
    echo '<br>';
    echo '<br>';
    echo form_label("Current Password: ");
    echo form_password("currentpassword");
    echo '<br>';
    echo form_submit("","Update");
    echo form_close();

?>
