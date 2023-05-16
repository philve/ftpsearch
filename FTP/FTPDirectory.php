<?php
class FTPDirectory extends FTPFile {
    public function __construct($path, $name) {
        parent::__construct($path, $name, 0, 0);
    }

    public function isDirectory() {
        return true;
    }
}
