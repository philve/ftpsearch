<?php
require_once "config.php";
require_once "db.php";
require_once "ftpsearch.php";

if (isset($_GET["query"])) {
    $query = $_GET["query"];

    // Search the database for files that match the query
    $results = search_files($query);
} else {
    // Redirect to the home page if no query is provided
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>FTP Search - Results</title>
    <link rel="stylesheet" href="static/css/bootstrap.min.css">
    <link rel="stylesheet" href="static/css/style.css">
</head>
<body>
    <div class="container">
        <h1>FTP Search Results</h1>
        <p>Showing results for "<?php echo $query; ?>"</p>
        <?php if (count($results) === 0): ?>
            <p>No results found.</p>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Filename</th>
                        <th>Size</th>
                        <th>Date Modified</th>
                        <th>Preview</th>
                        <th>Tasks</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $result): ?>
                        <tr>
                            <td><?php echo $result["filename"]; ?></td>
                            <td><?php echo $result["size"]; ?></td>
                            <td><?php echo $result["date_modified"]; ?></td>
                            <td><a href="preview.php?file=<?php echo urlencode($result['filename']); ?>">Preview</a></td>
                            <td><a href="tasks.php?file=<?php echo urlencode($result['filename']); ?>">Tasks</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
    <script src="static/js/jquery.min.js"></script>
    <script src="static/js/script.js"></script>
</body>
</html>
