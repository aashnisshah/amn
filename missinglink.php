<?php
    include 'settings.php';
    $action = '\'' . $_SERVER['DOCUMENT_ROOT']  . '/' . $tmlpath . '/links/newExternalLink\'';
?>

<form action="<?php echo $action; ?>" method="post" accept-charset="utf-8" class="form-horizontal">        <div class="form-group">
    <label for="name">Link URL: </label>
    <input type="text" name="url" placeholder="http://">
    <label for="name">Link Name: </label>
    <input type="text" name="name" placeholder="">
    <label for="image">Image: </label>
    <input type="text" name="image" placeholder="">
    <label for="description">Description: </label>
    <input type="text" name="description" placeholder="">
    <input type="hidden" name="vermili" value="external" />
    <button type="submit">Submit New Link</button>
</form>
