<?php
class FTPFile {
    private $path;
    private $name;
    private $size;
    private $date_modified;

    public function __construct($path, $name, $size, $date_modified) {
        $this->path = $path;
        $this->name = $name;
        $this->size = $size;
        $this->date_modified = $date_modified;
    }

    public function getPath() {
        return $this->path;
    }

    public function getName() {
        return $this->name;
    }

    public function getSize() {
        return $this->size;
    }

    public function getDateModified() {
        return $this->date_modified;
    }

    public function isDirectory() {
        return false;
    }
}
