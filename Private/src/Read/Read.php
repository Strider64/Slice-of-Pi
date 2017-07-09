<?php

namespace Library\Read;

use PDO;
use Library\Database\Database as DB;

abstract class Read {

    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $data = [];

    public function read($page_name, $column_pos, $sort_by = "ASC") {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        if ($sort_by === "DESC") {
            $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE page_name=:page_name and column_pos=:column_pos ORDER BY myDate DESC';
        } else {
            $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE page_name=:page_name and column_pos=:column_pos ORDER BY myDate ASC';
        }


        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name, ':column_pos' => $column_pos]); // Execute the query with the supplied user's parameter(s):
        $this->data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->data;
    }

    abstract public function display();
}
