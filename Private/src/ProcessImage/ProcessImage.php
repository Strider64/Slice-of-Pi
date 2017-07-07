<?php

namespace Library\ProcessImage;

use PDO;
use Library\Database\Database as DB;

class ProcessImage {

    protected static $allowedExts = array("jpg", "jpeg", "gif", "png");
    protected static $allowedTypes = array("image/gif", "image/jpeg", "image/png", "image/pjpeg");
    protected $name;  // Image Name:
    public $newName = \NULL;
    protected $type;  // Image Type:
    protected $extension;   // Image Extension:	
    protected $error = \NULL; // Image Error:
    protected $size;  // Image Size:
    protected $tmpDir;
    protected $tmpName;  // Image Temporary Name:
    protected $preExt = '../public/assets/uploads/img-';
    protected $unique = \NULL;
    protected $myDate = \NULL;
    public $username = \NULL;
    public $file = \NULL;
    public $status = \NULL;

    /*
     * 
     */

    public function __construct($file = \NULL, $username = "Strider") {

        $this->file = $file;
        $this->username = $username;
    }

    /*
     * Searches the contents of a file for a PHP embed tag
     * The problem with this check is that file_get_contents() reads 
     * the entire file into memory and then searches it (large, slow).
     * Using fopen/fread might have better performance on large files.
     */
    protected function setImageExt() {
        return pathinfo($this->file['name'], PATHINFO_EXTENSION);
    }

    protected function file_contains_php() {
        $contents = file_get_contents($this->file['tmp_name']);
        $position = strpos($contents, '<?php');
        return $position !== false;
    }

    public function processImage() {
        $this->status = $this->file_contains_php();
//        $this->setFileName();
//        $this->checkFileType();
//        $this->checkFileExt();
//        //$this->checkFileSize();
//        $this->getTMPName();

        
        if ($this->status) {
            return $this->status; // Bad Image
        } else {
            $this->extension = $this->setImageExt(); // Set Extension if Image is valid:
            return $this->status; // Good Image
        }
    }


    public function checkFileType() {
        if (!in_array($this->file['type'], self::$allowedTypes)) {
            $this->status = TRUE; // Improper Image Type
        } else {
            $this->status = FALSE;
        }
        return $this->status;
    }

    public function checkFileExt() {
        if (!in_array($this->extension, self::$allowedExts)) {
            $this->status = TRUE; // Improper Image Extension:
        } else {
            $this->status = FALSE;
        }
        return $this->status;
    }

    public function checkFileSize() {
        $this->size = $this->file['size'];
        if ($this->size > 800000) {
            $this->status = TRUE; // Failed image size:
        }
    }

    /*
     * If image passes validation then name the file and move the image to assets/uploads
     */
    protected function uniqueName() {
        $this->myDate = new \DateTime("NOW", new \DateTimeZone("America/Detroit"));
        return $this->username . $this->myDate->format("U") . ".";
    }

    protected function getTMPName() {
        return $this->file['tmp_name'];
    }

    public function saveIMG() {
        $this->unique = $this->uniqueName();
        $this->tmpName = $this->getTMPName();
        $this->newName = strtolower($this->preExt . $this->unique . $this->extension);
        if (!$this->file['error']) {
            move_uploaded_file($this->tmpName, $this->newName);
            return $this->newName;
        }
    }

}
