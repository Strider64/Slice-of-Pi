<?php

namespace Library\Read;

use PDO;
use Library\Database\Database as DB;

abstract class Read {

    protected $query = \NULL;
    protected $stmt = \NULL;
    protected $data = [];

    public function getUserIds() {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT id, username, full_name, private FROM users';
        $this->stmt = $pdo->prepare($this->query);
        $this->stmt->execute();
        $this->data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->data;
    }

    public function dailyRead($blogDate) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE DATE_FORMAT(date_added, "%Y-%m-%e")=:date_added ORDER BY author  ASC';
        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':date_added' => $blogDate]); // Execute the query with the supplied user's parameter(s):
        $this->data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->data;
    }

    public function read($page_name, $column_pos, $sort_by = "ASC") {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        if ($sort_by === "DESC") {
            $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE page_name=:page_name AND column_pos=:column_pos ORDER BY myDate DESC, author  DESC';
        } else {
            $this->query = 'SELECT id, user_id, author, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added, date_added as myDate FROM cms WHERE page_name=:page_name AND column_pos=:column_pos ORDER BY user_id ASC, myDate DESC';
        }


        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name, ':column_pos' => $column_pos]); // Execute the query with the supplied user's parameter(s):
        $this->data = $this->stmt->fetchAll(PDO::FETCH_OBJ);
        return $this->data;
    }

    abstract public function display();
}
