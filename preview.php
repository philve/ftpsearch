<?php
require_once "config.php";
require_once "FTP/ftp.php";

if (isset($_GET["filename"]) && isset($_GET["host"])) {
    $filename = urldecode($_GET["filename"]);
    $host = urldecode($_GET["host"]);

    // Connect to the FTP server
    $ftp = new FTP($host, FTP_USER, FTP_PASSWORD, FTP_TIMEOUT);

    // Download the file from the FTP server
    $content = $ftp->downloadFile($filename);

    // Determine the file's MIME type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime_type = finfo_buffer($finfo, $content);

    // Set the Content-Type header to the file's MIME type
    header("Content-Type: $mime_type");

    // Display the file in the user's browser
    echo $content;
} else {
    echo "Error: missing parameters";
}
