<br>

<button id="addLinkButton" class="btn btn-info btn-lg" type="button">Add A New Category</button>

<div id="addNewLink" class="newlink defaultHide">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('categories/newCategory', $attributes);
    ?>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">Category Name: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" placeholder="e.g. Awesome Blogs">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Category Description: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="description" placeholder="e.g. These blogs are really awesome and I should read them everyday.">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Create New Category</button>
            </div>
        </div>
    </form>
</div>

<br>
