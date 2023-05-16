<?php
require_once "config.php";

// Connect to database 
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

// Check connection 
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Initialize database
function init_db() {
    global $conn;

    $sql = "CREATE TABLE IF NOT EXISTS files (
        id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        size BIGINT NOT NULL,
        date_modified DATETIME NOT NULL,
        host VARCHAR(255) NOT NULL
    )";

    if (mysqli_query($conn, $sql)) {
        echo "Table created successfully<br>";
    } else {
        echo "Error creating table: " . mysqli_error($conn) . "<br>";
    }
}

// Insert a file into the database
function insert_file($filename, $size, $date_modified, $host) {
    global $conn;

    $filename = mysqli_real_escape_string($conn, $filename);
    $sql = "INSERT INTO files (filename, size, date_modified, host) VALUES ('$filename', $size, '$date_modified', '$host')";

    if (mysqli_query($conn, $sql)) {
        echo "File inserted successfully<br>";
    } else {
        echo "Error inserting file: " . mysqli_error($conn) . "<br>";
    }
}

// Search for files that match a query 
function search_files($query) {
    global $conn;

    $sql = "SELECT * FROM files WHERE filename LIKE '%$query%'";

    $result = mysqli_query($conn, $sql);

    $files = array();

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $files[] = $row;
        }
    }

    return $files;  
}
