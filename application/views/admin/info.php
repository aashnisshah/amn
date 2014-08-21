<h3>Personal Information</h3>

<?php
    if(isset($message)) {
        echo $message . '<br>';
    }

    echo validation_errors();
?>

<div id="adminInfo">
        <?php
            $attributes = array('class' => 'form-horizontal');
            echo form_open('admin/updateInfo', $attributes);
        ?>
        <div class="form-group">
            <label for="url" class="col-sm-2 control-label">Name: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="<?php echo $admin_info['name']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Email: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="email" value="<?php echo $admin_info['email']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Website Link: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="website" value="<?php echo $admin_info['website']; ?>">
            </div>
        </div>

        <h3>Account Information</h3>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Username: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username" value="<?php echo $this->session->userdata['username']; ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">New Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="newpassword">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Confirm Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="confpassword">
            </div>
        </div>

        <br><br>

        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">Current Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="currentpassword">
            </div>
        </div>

        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </div>
    </form>
</div>

<br>
