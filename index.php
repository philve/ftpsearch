<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FTP Search - Home</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <div class="container">
        <h1>FTP Search</h1>
        <form action="search.php" method="get">
            <div class="form-group">
                <input type="text" name="query" class="form-control" placeholder="Search for files...">
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/script.js"></script>
</body>
</html>
