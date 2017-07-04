<?php

namespace Library\Display;

use PDO;

class Display extends Read {

    protected $row = \NULL;
    public $stmt = \NULL;

    public function __construct() {
        
    }

    public function display() {
        while ($this->row = $this->stmt->fetch(PDO::FETCH_OBJ)) {
            echo '<article class="content">' . "\n";
            echo "<h1>" . htmlspecialchars($this->row->heading) . '<span class="date_added">Created on ' . $this->row->date_added . '</span></h1>' . "\n";

            if (isset($_SESSION['user']) && ($_SESSION['user']->security_level === 'sysop' || $_SESSION['user']->user_id === $this->row->user_id)) {
                echo '<a class="editBtn" href="edit_page.php?id=' . urlencode($this->row->id) . '">Edit</a>' . "\n";
            }

            if ($this->row->image_path) {
                echo '<figure class="imageStyle">' . "\n";
                echo '<img src="' . htmlspecialchars($this->row->image_path) . '" alt="' . htmlspecialchars($this->row->heading) . '">' . "\n";
                echo '<figcaption>&nbsp;</figcaption>' . "\n";
                echo "</figure>\n";
            }
            echo "<p>" . htmlspecialchars($this->row->content) . "</p>\n";
            echo "</article>\n";
        }
    }
    
    public function read($page_name, $column_pos) {
        $this->stmt = parent::READ($page_name, $column_pos);
        $this->display();
    }

}
