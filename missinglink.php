<html>
    <head>
        <meta charset="utf-8">
        <title>The Missing Link</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.css" rel="stylesheet">
        <link href="css/flat-ui.css" rel="stylesheet">
        <link href="css/prettify.css" rel="stylesheet">
        <link href="css/our.css" rel="stylesheet">
    </head>

    <body>

    <div class="container ourcenter">
        <div id="addNewLink" class="newlink" display="none">
            <form action="links/newExternalLink" method="post" accept-charset="utf-8" class="form-horizontal">        <div class="form-group">
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
                        <input type="hidden" name="vermili" value="external" />
                        <button type="submit" class="btn btn-success">Submit New Link</button>
                    </div>
                </div>
            </form>
        </div>

        <br>
    </div>

    </body>
</html>
