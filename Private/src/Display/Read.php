<?php

namespace Library\Display;

use PDO;
use Library\Database\Database as DB;

abstract class Read {

    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $data = [];


    public function read($page_name, $column_pos) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added FROM cms WHERE page_name=:page_name and column_pos=:column_pos';

        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name, ':column_pos' => $column_pos]); // Execute the query with the supplied user's parameter(s):
        $this->data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->data;
    }
    
    abstract public function display();

}
