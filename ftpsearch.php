<?php
require_once "config.php";
require_once "FTP/ftp.php";
require_once "db.php";

// Search for files that match a query on all FTP servers listed in hosts.list
function search_files($query) {
    global $conn;

    // Get the list of FTP hosts
    $hosts = file("hosts.list", FILE_IGNORE_NEW_LINES);

    $files = array();

    foreach ($hosts as $host) {
        // Connect to the FTP server
        $ftp = new FTP($host, FTP_USER, FTP_PASSWORD, FTP_TIMEOUT);

        // Get the list of files and directories on the FTP server
        $dir = $ftp->listDir("/", true);

        foreach ($dir as $file) {
            // If the file name matches the query, add it to the list of files
            if (strpos($file->getName(), $query) !== false) {
                $filename = $file->getPath();
                $size = $file->getSize();
                $date_modified = $file->getDateModified();

                // Insert the file into the database if it doesn't already exist
                if (!file_exists_in_db($filename, $host)) {
                    insert_file($filename, $size, $date_modified, $host);
                }

                $files[] = array(
                    "filename" => $filename,
                    "size" => $size,
                    "date_modified" => $date_modified,
                    "host" => $host
                );
            }
        }
    }

    return $files;
}

// Check if a file exists in the database
function file_exists_in_db($filename, $host) {
    global $conn;

    $sql = "SELECT * FROM files WHERE filename='$filename' AND host='$host'";

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        return true;
    } else {
        return false;
    }
}
