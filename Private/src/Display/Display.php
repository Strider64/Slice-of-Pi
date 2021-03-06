<?php

namespace Library\Display;

use Library\Read\Read;

class Display extends Read {

    protected $row = \NULL;
    protected $stmt = \NULL;
    protected $data = \NULL;
    protected $params = [];
    protected $query = \NULL;

    public function __construct() {
        
    }

    public function setData(array $data) {
        $this->data = $data;
    }

    public function display() {




        foreach ($this->data as $this->row) {
            //echo "<pre>" . print_r($this->row, 1) . "</pre>\n";


            echo '<article class="cms">' . "\n";
            echo "<h2>" . htmlspecialchars($this->row->heading) . "</h2>\n";
            echo '<h3 class="subheading">Created on ' . htmlspecialchars($this->row->date_added) . " by " . htmlspecialchars($this->row->author) . "</h3>\n";
            if (!empty($this->row->image_path)) {
                echo '<figure class="imageStyle">' . "\n";
                echo '<img src="' . htmlspecialchars($this->row->image_path) . '" alt="' . htmlspecialchars($this->row->heading) . '">' . "\n";
                echo '<figcaption>&nbsp;</figcaption>' . "\n";
                echo "</figure>\n";
            } else {
                echo "<br>\n";
            }
            echo "<p>" . htmlspecialchars($this->row->content) . "</p>\n";
            if (isset($_SESSION['user']) && ($_SESSION['user']->security_level === 'sysop' || $_SESSION['user']->id === $this->row->user_id)) {
                echo '<div class="system">' . "\n";
                echo '<a class="delete" href="delete_page.php?id=' . urlencode($this->row->id) . '" onclick="return confirm(\'Are you sure you want to delete?\')">Delete</a>' . "\n";
                echo '<a class="edit" href="edit/' . urlencode($this->row->id) . '">Edit</a>' . "\n";
                echo "</div>\n";
            }
            echo "<br>\n";
            echo "</article>\n";
        }
    }

    public function read($page_name, $column_pos, $sort_by = "ASC", $user_id = 65) {
        $this->data = parent::Read($page_name, $column_pos, $sort_by);
    }

}
