<?php
class imgUploader {

    var $exts = array('png', 'gif', 'png', 'jpg', 'jpeg'); //all the extensions that will be allowed to be uploaded 
    var $maxSize = 200000000; //if you set to '0' (no quotes), there will be no limit 
    var $uploadTarget = '../../../images/uploads/'; //make sure you have the '/' at the end ../images/uploads/
    var $fileName = ''; //this will be automatically set. you do not need to worry about this 
    var $tmpName = ''; //this will be automatically set. you do not need to worry about this 
    var $pathName = '';

    public function startUpload($filename, $tmpName) {
        $message = '';
        $this->fileName = $filename;
        $this->tmpName = $tmpName;
        if (!$this->isWritable()) {
             $message = 'Sorry, you must CHMOD your upload target to 777!';
        }
        if (!$this->checkExt()) {
            $message = 'Sorry, you can not upload this filetype!';
        }
        if (!$this->checkSize()) {
            $message = 'Sorry, the file you have attempted to upload is too large!';
        }
        if ($this->fileExists()) {
            $message = 'Sorry, this file already exists on our servers!';
        }
        if (!$this->uploadIt()) {
            $message = 'Sorry, your file could not be uploaded for some unknown reason!';
        } 
        
        return $message;
    }

    public function uploadIt() {
        $finalName = time() . $this->fileName;
        $this->pathName = '../images/uploads/' . $finalName;
        return ( move_uploaded_file($this->tmpName, $this->uploadTarget . $finalName) ? true : false );
    }

    public function checkSize() {
        return ( ( filesize($this->tmpName) > $this->maxSize ) ? false : true );
    }

    public function checkExt() {
        return (in_array(strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION)), $this->exts) ? true : false );
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