<?php

    if(isset($message)) {
        echo $message;
    }
?>


<h2>Edit Category <i><?php echo $category['name']; ?></i></h2>

<div id="editCategory">
    <?php
        $attributes = array('class' => 'form-horizontal');
        $hidden = array('id' => $category['id']);
        echo form_open('categories/updatecategory', $attributes, $hidden);
    ?>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="<?php echo $category['name']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Description: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="description" value="<?php echo $category['description']; ?>">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Update Category Information</button>
            </div>
        </div>
    </form>
</div>

<br>
