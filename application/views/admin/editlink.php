<?php

    if(isset($message)) {
        echo $message;
    }
?>


<h2>Edit Link <i><?php echo $link['name']; ?></i></h2>

<div id="addNewLink" class="newlink">
    <?php
        $attributes = array('class' => 'form-horizontal');
        $hidden = array('original' => $link);
        echo form_open('links/updatelink', $attributes, $hidden);
    ?>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">Link URL: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="url" placeholder="<?php echo $link['url']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Link Name: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="<?php echo $link['name']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="groups" class="col-sm-2 control-label">Groups: </label>
            <div class="col-sm-10">
                <?php
                    $groupsCombined = $link['groups'];
                    $groupsSplit = explode(" ", $groupsCombined);
                    foreach($groupsSplit as $group) {
                        if($group != "") {
                            echo '<span class="label label-info pull-left margin-right">' . $categories[$group] . '</span> ';
                        }
                    }
                    echo '<br>';
                    echo form_multiselect('groups[]', $categories, array(), 'class="form-control"');
                ?>
            </div>
        </div>
        <div class="form-group">
            <?php echo '<img class="editformdisplay" src="' . $link['image'] . '">'; ?>
            <br><br>
            <label for="image" class="col-sm-2 control-label">Image: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="image" placeholder="">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="description" placeholder="<?php echo $link['description']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-sm-2 control-label">Status: </label>
            <div class="col-sm-10">
                <?php
                    $options = array('Pending' => 'Pending',
                                    'Accepted' => 'Accepted',
                                    'Rejected' => 'Rejected',
                                    'Inactive' => 'Inactive');
                    $batch = ucfirst($link['status']);
                    echo form_dropdown('status', $options, $batch, 'class="form-control"');
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Update Link Information</button>
            </div>
        </div>
    </form>
</div>

<br>
