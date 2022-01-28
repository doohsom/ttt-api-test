<html>
    <head>
        <title></title>
        <link rel="stylesheet" href="../../node_modules/bootstrap/dist/css/bootstrap.min.css" >
    </head>
    <body>
    <!-- As a heading -->
    <nav class="navbar navbar-light bg-light">
        <span class="navbar-brand mb-0 h1">List games by id</span>
    </nav>
    <div class="row">
    <div class="col-sm-3">&nbsp;</div>
    <div class="col-sm-6 bg-light p-3 border">



        <form action="/api/read-game" method="get">
            <div class="mb-3">
                <label class="form-label" for="userX">Game ID</label>
                <input type="text" class="form-control" name="game_id" placeholder="Game ID" required>
            </div>

            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
        </form>


    </div>
    </div>
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    </body>

</html>