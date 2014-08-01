<?php

    if(isset($message)) {
        echo $message;
    }
    echo '<h2>Categories</h2>';
    echo validation_errors();
    echo form_open('categories/newCategory');
    echo form_label("Category Name ");
    echo form_input("name");
    echo '<br>';
    echo form_label("Category Description: ");
    echo form_input("description");
    echo '<br>';
    echo form_submit("","Add Category");
    echo form_close();

    echo '<h2>Current Categories</h2>';
    echo '<ul><li>Some</li><li>Categories</li></ul>';

    foreach($categories as $cat) {
        echo $cat['id'] . '   ';
        echo $cat['name'] . '   ';
        echo $cat['description'] . '   ';
        echo '<br>';
    }

?>
