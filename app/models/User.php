<?php 
    class User {
        private $db;

        public function __construct()
        {
            $this->db = new Database;
        }

        // public function getUsers()
        // {
        //     $this->db->query("SELECT * FROM " . $this->db->dbName . ".users");

        //     $result = $this->db->resultSet();

        //     return $result;
        // }

        public function login($username, $password)
        {
            
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.users WHERE username = :username');

            $this->db->bind(':username', $username);

            $row = $this->db->single();
            
            $hashedPassword = $row->password;

            

            if (password_verify($password, $hashedPassword)) {
                return $row;
            } else {
                return false;
            }
        }

        public function register($data)
        {
            $this->db->query('INSERT INTO ' . $this->db->dbName .'.users (username, email, password) VALUES(:username, :email, :password)');

            //Bind values
            $this->db->bind(':username', $data['username']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':password', $data['password']);
            
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
                
            
        }

        public function findUserByEmail($email) {

            
            //Pripravi statment
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.users WHERE email = :email');

            

            
    
            //Email param will be binded with the email variable
            $this->db->bind(':email', $email);

            
    
            //Check if email is already registered
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }
    }