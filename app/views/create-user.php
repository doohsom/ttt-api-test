<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" >
    </head>
    <body>
    <!-- As a heading -->
    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">Set username</span>
    </nav>
    <div class="row">
    <div class="col-sm-3">&nbsp;</div>
    <div class="col-sm-6 bg-light p-3 border">



        <form action="/api" method="post">
            <div class="mb-3">
                <label class="form-label" for="userX">User X</label>
                <input type="text" class="form-control" name="user_x" placeholder="User X" required>
            </div>
            <div class="mb-3">
                <label class="form-label" for="userO">User O</label>
                <input type="text" class="form-control" name="user_o" placeholder="User O" required>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>

    </div>
    </div>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>
</html>