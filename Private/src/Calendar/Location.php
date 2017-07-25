<?php

namespace Library\Calendar;

use Library\Database\Database as DB;
use DateTime;
use DateTimeZone;
use PDO;

abstract class Location {

    protected $php_self = \NULL;
    protected $path_parts = \NULL;
    protected $basename = \NULL;
    protected $location;
    public $pdo = \NULL;

    public abstract function fileLocation();


    public function changeDate($location) {

    }

    public function myPDO() {
        $db = DB::getInstance();
        return $this->pdo = $db->getConnection();
    }

    protected function returnLocation() {
        $this->php_self = filter_input(INPUT_SERVER, 'PHP_SELF', FILTER_SANITIZE_URL);
        $this->path_parts = pathinfo($this->php_self);
        $this->basename = $this->path_parts['basename'];
        return $this->path_parts['filename'] . "/";
    }

}
