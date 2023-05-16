<?php
require_once "config.php";
require_once "FTP/ftp.php";
require_once "db.php";

// Get the list of FTP hosts
$hosts = file(HOSTS_FILE, FILE_IGNORE_NEW_LINES);

foreach ($hosts as $host) {
    // Connect to the FTP server
    $ftp = new FTP($host, FTP_USER, FTP_PASSWORD, FTP_TIMEOUT);

    // Get the list of files and directories on the FTP server
    $dir = $ftp->listDir("/", true);

    foreach ($dir as $file) {
        // If the file is not a directory, update its size and date modified in the database
        if (!$file->isDirectory()) {
            $filename = $file->getPath();
            $size = $file->getSize();
            $date_modified = $file->getDateModified();

            update_file($filename, $size, $date_modified, $host);
        }
    }

    // Delete files from the database that no longer exist on the FTP server
    delete_missing_files($host);
}
