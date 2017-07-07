<?php

namespace Library\CMS;

use PDO;
use Library\Database\Database as DB;

class CMS {

    protected $query = \NULL;
    public $stmt = \NULL;
    protected $password = \NULL;
    public $cms = \NULL;
    public $result = \NULL;
    public $count = \NULL;
    public $myURL = \NULL;

    public function __construct() {
        
    }

    public function create(array $data) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'INSERT INTO cms( user_id, author, page_name, column_pos, image_path, heading, content, date_updated, date_added) VALUES ( :user_id, :author, :page_name, :column_pos, :image_path, :heading, :content, NOW(), NOW())';
        $this->stmt = $pdo->prepare($this->query);
        $this->result = $this->stmt->execute([':user_id' => $data['user_id'], 'author' => $data['author'], ':page_name' => $data['page_name'], ':column_pos' => $data['column_pos'], ':image_path' => $data['image_path'], ':heading' => $data['heading'], ':content' => $data['content']]);
        return $data['page_name'];
    }

    public function read($page_name, $column_pos) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT id, user_id, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W, %M %e, %Y") as date_added FROM cms WHERE page_name=:page_name and column_pos=:column_pos';

        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':page_name' => $page_name, ':column_pos' => $column_pos]); // Execute the query with the supplied user's parameter(s):

        return $this->stmt;
    }

    public function readId($id) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT id, user_id, page_name, column_pos, image_path, heading, content, DATE_FORMAT(date_added, "%W %M %e, %Y") as date_added  FROM cms WHERE id=:id';
        $this->stmt = $pdo->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        $this->result = $this->stmt->fetch(PDO::FETCH_OBJ);
        return $this->result;
    }

    public function update(array $data) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'UPDATE cms SET heading=:heading, content=:content, date_updated=NOW() WHERE id =:id';
        $this->stmt = $pdo->prepare($this->query);
        $this->result = $this->stmt->execute([':heading' => $data['heading'], ':content' => $data['content'], ':id' => $data['id']]);

        return \TRUE;
    }

    public function deleteRecord(int $id = NULL) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = "DELETE FROM cms WHERE id=:id";
        $this->stmt = $pdo->prepare($this->query);
        $this->stmt->execute([':id' => $id]);
        return \TRUE;
    }
    public function delete($id = NULL) {
        unset($id);
        unset($this->user);
        unset($_SESSION['user']);
        $_SESSION['user'] = NULL;
        session_destroy();
        return TRUE;
    }

}
