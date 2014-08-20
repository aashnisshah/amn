<br>

<h3>Please Login To Continue!</h3>

<?php
    if(isset($this->session->userdata['loginfail'])){
        echo '<h4>The password or username you entered was incorrect.</h4>';
        $this->session->unset_userdata('loginfail');
    }
?>

<div id="loginform">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('verifylogin', $attributes);
        echo validation_errors();
    ?>
        <div class="form-group">
            <label for="username" class="col-sm-2 control-label">Username: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="username">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="col-sm-2 control-label">Password: </label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Login</button>
            </div>
        </div>
    </form>
</div>

<br>
