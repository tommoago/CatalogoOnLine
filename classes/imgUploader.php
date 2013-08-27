<?php
class imgUploader {

    var $exts = array(".png", ".gif", ".png", ".jpg", ".jpeg"); //all the extensions that will be allowed to be uploaded 
    var $maxSize = 200000000; //if you set to "0" (no quotes), there will be no limit 
    var $uploadTarget = "C:\DEV\WP\php\melarossa\images\uploads/"; //make sure you have the '/' at the end 
    var $fileName = ""; //this will be automatically set. you do not need to worry about this 
    var $tmpName = ""; //this will be automatically set. you do not need to worry about this 
    var $pathName = "";

    public function startUpload($filename, $tmpName) {
        $this->fileName = $filename;
        $this->tmpName = $tmpName;
        if (!$this->isWritable()) {
            die("Sorry, you must CHMOD your upload target to 777!");
        }
        if (!$this->checkExt()) {
            die("Sorry, you can not upload this filetype!");
        }
        if (!$this->checkSize()) {
            die("Sorry, the file you have attempted to upload is too large!");
        }
        if ($this->fileExists()) {
            die("Sorry, this file already exists on our servers!");
        }
        if (!$this->uploadIt()) {
            echo "Sorry, your file could not be uploaded for some unknown reason!";
        } 
    }

    public function uploadIt() {
        $this->pathName = $this->uploadTarget . time() . $this->fileName;
        return ( move_uploaded_file($this->tmpName, $this->pathName) ? true : false );
    }

    public function checkSize() {
        return ( ( filesize($this->tmpName) > $this->maxSize ) ? false : true );
    }

    public function getExt() {
        return strtolower(substr($this->fileName, strpos($this->fileName, "."), strlen($this->fileName) - 1));
    }

    public function checkExt() {
        return ( in_array($this->getExt(), $this->exts) ? true : false );
    }

    public function isWritable() {
        return ( is_writable($this->uploadTarget) );
    }

    public function fileExists() {
        return ( file_exists($this->uploadTarget . time() . $this->fileName) );
    }
    
    public function getPathName() {
        return $this->pathName;
    }
}

?>