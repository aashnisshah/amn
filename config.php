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
        <div id="settings">

            <h2>Let's Get Going!</h2>

            <form action="config/setup" method="post" accept-charset="utf-8" class="form-horizontal">        <div class="form-group">
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Your Name: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">Your Email: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="email" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="username" class="col-sm-2 control-label">Your Username: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">Your Password: </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="password" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="passconf" class="col-sm-2 control-label">Confirm Password: </label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name="passconf" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <label for="website" class="col-sm-2 control-label">Your Website: </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="website" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                    <div class="">
                        <input type="hidden" name="vermili" value="external" />
                        <button type="submit" class="btn btn-success">Submit Settings</button>
                    </div>
                </div>
            </form>
        </div>

        <br>
    </div>

    </body>
</html>
