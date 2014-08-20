<?php

    if(isset($message)) {
        echo $message;
    }

?>

<button id="addLinkButton" class="btn btn-info btn-lg" type="button">Add A New Link</button>

<div id="addNewLink" class="newlink defaultHide" display="none">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('links/newLink', $attributes);
    ?>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">Link URL: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="url" placeholder="http://">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Link Name: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="">
            </div>
        </div>
        <?php if(count($categories) > 0) { ?>
        <div class="form-group">
            <label for="groups" class="col-sm-2 control-label">Groups: </label>
            <div class="col-sm-10">
                <?php
                        echo form_multiselect('groups[]', $categories, array(), 'class="form-control"');
                ?>
            </div>
        </div>
        <?php } ?>
        <div class="form-group">
            <label for="image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="image" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="description" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Submit New Link</button>
            </div>
        </div>
    </form>
</div>

<br>
