<?php

namespace Library\FormValidation;

use Library\Database\Database as DB;

class FormValidation {

    private $query;
    private $stmt;
    public $row;
    public $result;
    public $userAvailability = \NULL;
    public $content = \NULL;
    public $validEmail = \NULL;
    public $verifyEmail = \NULL;
    public $validPassword = \NULL;
    public $verifyPassword = \NULL;
    public $data = [];
    public $valid = [];
    public $resultArray = [];
    public $message = '';

    public function __construct(array $data) {
        $this->data = $data;
        if (is_array($this->data) && !empty($this->data)) {
            
            $this->valid['content'] = $this->contentCheck();
            $this->valid['userAvailability'] = $this->usernameCheck();
            $this->valid['validPassword'] = $this->passwordCheck();
            $this->valid['verifyPassword'] = $this->verifyPassword();
            $this->valid['validEmail'] = $this->emailCheck();
            $this->valid['verifyEmail'] = $this->verifyEmail();
            
        }
        
        $this->result = $this->validate();
        
    }

    public function check(array $data) {
        self::__construct($data);
    }

    protected function contentCheck() {

        /* Make sure user just didn't type spaces in an attempt to make valid */
        foreach ($this->data as $key => $value) {
            $this->data[$key] = isset($value) ? trim($value) : '';
        }
        /* if nothing is in the data field then there is not data */
        if (in_array("", $this->data, true)) {
            return \FALSE; // No Data:
        } else {
            return \TRUE; // All Fields contain Data:
        }
    }

    protected function usernameCheck() {
        $db = DB::getInstance();
        $pdo = $db->getConnection();

        $this->query = "SELECT 1 FROM users WHERE username = :username";
        $this->stmt = $pdo->prepare($this->query);
        $this->stmt->bindParam(':username', $this->data['username']);
        $this->stmt->execute();
        $this->row = $this->stmt->fetch();
        if ($this->row) {
            /* If there is at least one match then username is already taken */
            return \FALSE;
        } else {
            return \TRUE;
        }
    }

    protected function passwordCheck() {
        /*
         * 
         * Explaining !preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password)
         * $ = beginning of string
         * \S* = any set of characters
         * (?=\S{8,}) = of at least length 8
         * (?=\S*[a-z]) = containing at least one lowercase letter
         * (?=\S*[A-Z]) = and at least one one uppercase letter
         * (?=\S*[\d]) = and at least one number
         * (?=\S*[\W]) = and at least a special character (non-word character)
         * $ = end of the string:
         * 
         */
        if (preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$', $this->data['password'])) {
            return \TRUE; // Valid Password:
        } else {
            return \FALSE; // Invalid Password:
        }
    }

    protected function verifyPassword() {
        if ($this->data['password'] === $this->data['verify_password']) {
            return \TRUE;
        } else {
            return \FALSE;
        }
    }

    protected function emailCheck() {
        if (filter_var($this->data['email'], FILTER_VALIDATE_EMAIL)) {
            return \TRUE; // Valid
        } else {
            return \FALSE; // Invalid
        }
    }

    protected function verifyEmail() {
        if ($this->data['email'] === $this->data['verify_email']) {
            return \TRUE;
        } else {
            return \FALSE;
        }
    }

    protected function validate() {
        foreach ($this->valid as $status) {
            if (!$status) {
                return \FALSE;
            }
        }
        return \TRUE;
    }

}
