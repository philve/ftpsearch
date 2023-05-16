<?php
class FTP {
    private $conn;

    public function __construct($host, $user, $password, $timeout) {
        $this->conn = ftp_connect($host, 21, $timeout);

        if (!$this->conn) {
            throw new Exception("Unable to connect to FTP server");
        }

        $login_result = ftp_login($this->conn, $user, $password);

        if (!$login_result) {
            throw new Exception("Unable to log in to FTP server");
        }

        ftp_pasv($this->conn, true);
    }

    public function listDir($path, $recursive = false) {
        $files = array();

        $this->listDirRecursive($files, $path, $recursive);

        return $files;
    }

    private function listDirRecursive(&$files, $path, $recursive) {
        $list = ftp_nlist($this->conn, $path);

        if ($list) {
            foreach ($list as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }

                $path = $path . '/' . $file;
                $is_dir = ftp_size($this->conn, $path) == -1;

                if ($is_dir) {
                    if ($recursive) {
                        $this->listDirRecursive($files, $path, $recursive);
                    }

                    $files[] = new FTPDirectory($path, $file);
                } else {
                    $files[] = new FTPFile($path, $file, ftp_size($this->conn, $path), ftp_mdtm($this->conn, $path));
                }
            }
        }
    }

    public function downloadFile($path) {
        $handle = fopen('php://temp', 'r+');

        if (!ftp_fget($this->conn, $handle, $path, FTP_BINARY)) {
            throw new Exception("Unable to download file from FTP server");
        }

        rewind($handle);
        $content = stream_get_contents($handle);
        fclose($handle);

        return $content;
    }

    public function __destruct() {
        if ($this->conn) {
            ftp_close($this->conn);
        }
    }
}
