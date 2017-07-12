<?php

namespace Library\Users;

use PDO;
use Library\Database\Database as DB;

//use website_project\database\PDOConnection as PDOConnect;

class Users {

    private $connectPDO;
    private $pdo;
    protected $id = NULL;
    protected $query = NULL;
    protected $stmt = NULL;
    protected $result = NULL;
    protected $queryParams = NULL;
    protected $row = NULL;
    protected $loginStatus = false;
    public $user = NULL;
    public $userArray = [];
    public $username = NULL;

    /* Create (Insert) new users information */

    public function __construct() {
        
    }

// End of constructor:

    /* This method also takes an array of data and utilizes the constructor. */

    public function create($data) {
        if (is_array($data)) { // If statement probably not needed:
            $db = DB::getInstance();
            $pdo = $db->getConnection();
            /* Secure the Password by hashing the user's password. */
            $data['password'] = password_hash($data['password'], PASSWORD_BCRYPT, array("cost" => 15));
            try {

                /* Set the query variable */
                $this->query = 'INSERT INTO users (username, password, full_name, email, confirmation_code, security_level, private, date_added) VALUES (:username, :password, :full_name, :email,  :confirmation_code, :security_level, :private, NOW())';

                /* Prepare the query */
                $this->stmt = $pdo->prepare($this->query);

                /* Execute the query with the stored prepared values */
                $this->result = $this->stmt->execute([
                    ':username' => $data['username'],
                    ':password' => $data['password'],
                    ':full_name' => $data['full_name'],
                    ':email' => $data['email'],
                    ':confirmation_code' => $data['confirmation_code'],
                    ':security_level' => $data['security_level'],
                    ':private' => $data['private']
                ]); // End of execution:
                return \TRUE;
            } catch (PDOException $error) {
                // Check to see if name is already exists:
                $errorCode = $error->errorInfo[1];
                if ($errorCode == MYSQL_ERROR_DUPLICATE_ENTRY) {
                    error_log("Duplicate Name was Enter", 1, "jrpepp@pepster.com");
                } else {
                    throw $error;
                }
            }
        } // End of main if-statement:
    }

    public function read($username, $password) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        /* Setup the Query for reading in login data from database table */
        $this->query = 'SELECT id, username, password, full_name, email, security_level, private  FROM users WHERE username=:username';


        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':username' => $username]); // Execute the query with the supplied user's parameter(s):

        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        $this->user = $this->stmt->fetch();
        if(!$this->user) {
            return FALSE;
        }
        /*
         * If password matches database table match send back true otherwise send back false.
         */
        if (password_verify($password, $this->user->password)) {
            $this->userArray['id'] = $this->user->id;
            $this->userArray['username'] = $this->user->username;
            $this->userArray['full_name'] = $this->user->full_name;
            $this->userArray['email'] = $this->user->email;            
            $this->userArray['security_level'] = $this->user->security_level;
            $this->userArray['private'] = $this->user->private;
            $_SESSION['user'] = (object) $this->userArray;
            return \TRUE;
        } else {
            return \FALSE;
        }
    }

    public function checkSecurityCode($confirmation_code) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();
        $this->query = 'SELECT security_level FROM users WHERE confirmation_code=:confirmation_code';


        $this->stmt = $pdo->prepare($this->query); // Prepare the query:
        $this->stmt->execute([':confirmation_code' => $confirmation_code]); // Execute the query with the supplied user's parameter(s):

        $this->stmt->setFetchMode(PDO::FETCH_OBJ);
        $this->user = $this->stmt->fetch();

        if ($this->user->security_level === 'public') {
            return \TRUE;
        } else {
            return \FALSE;
        }
    }

    public function update($confirmation_code) {
        $db = DB::getInstance();
        $pdo = $db->getConnection();

        $this->query = 'UPDATE users SET security_level=:security_level WHERE confirmation_code=:confirmation_code';


        $this->stmt = $pdo->prepare($this->query);
        $this->result = $this->stmt->execute([':security_level' => 'member', ':confirmation_code' => $confirmation_code]);

        if ($this->result) {
            return \TRUE;
        } else {
            return \FALSE;
        }
    }

    /* Logoff Current User */

    public function delete($id = NULL) {
        unset($id);
        unset($this->user);
        unset($_SESSION['user']);
        $_SESSION['user'] = NULL;
        session_destroy();
        return TRUE;
    }

}

// End of Users class: