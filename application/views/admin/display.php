<?php

    if(isset($message)) {
        echo $message;
    }

?>

<div id="display" class="newlink">
    <?php
        $attributes = array('class' => 'form-horizontal');
        echo form_open('display/generateCode', $attributes);
    ?>
        <div class="form-group btn-group col-sm-12" data-toggle="buttons">
            <div class="col-sm-3">
                <label for="show" class="control-label pull-right">Show: </label>
            </div>
            <div class="col-sm-7">
                <label class="btn btn-primary active margin-right margin-bottom">
                    <input type="radio" name="show" id="show" value="all" checked> All Links
                </label>
                <label class="btn btn-primary margin-right margin-bottom">
                    <input type="radio" name="show" id="show" value="cat"> Filtered By Categories
                </label>
            </div>
        </div>
        <?php if(count($categories) > 0){ ?>
        <div class="form-group btn-group col-sm-12">
            <div class="col-sm-3">
                <label for="categories" class="control-label pull-right">Categories: </label>
            </div>
            <div class="col-sm-7">
                <?php
                    foreach($categories as $cat) {
                        echo '<label class="btn btn-primary active margin-right margin-bottom">';
                        echo '<input type="checkbox" name="cat" id="cat" value="'. $cat .'"> ' . $cat;
                        echo '</label>';
                    }

                ?>
            </div>
        </div>
        <?php } ?>
        <div class="btn-group form-group" data-toggle="buttons">
            <div class="col-sm-3">
                <label for="order" class="control-label pull-right">Order: </label>
            </div>
            <div class="col-sm-7">
                <label class="btn btn-primary active margin-right margin-bottom">
                    <input type="radio" name="order" id="order" value="sub" checked> As Submitted
                </label>
                <label class="btn btn-primary margin-right margin-bottom">
                    <input type="radio" name="order" id="order" value="alph"> Alphabetized
                </label>
                <label class="btn btn-primary margin-right margin-bottom">
                    <input type="radio" name="order" id="order" value="rand"> Randomly
                </label>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-3">
                <label for="number" class="control-label pull-right">Number of Links: </label>
            </div>
            <div class="col-sm-7">
                <input type="text" class="form-control" name="number" value="0">
            </div>
        </div>
        <div class="form-group">
            <div class="">
                <button type="submit" class="btn btn-success">Generate Code</button>
            </div>
        </div>
    </form>
</div>

<br>
