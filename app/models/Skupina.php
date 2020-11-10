<?php 

    class Skupina {
        
        public function __construct()
        {
            $this->db = new Database;
        }
        public function findAllSkupine() {
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.skupine');
    
            $results = $this->db->resultSet();
    
            return $results;
        }

        public function findAllSkupineById($id) {
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.skupine WHERE user_id = :user_id');

            $this->db->bind(':user_id', $id);
    
            $results = $this->db->resultSet();
    
            return $results;
        }

        public function addSkupina($data)
        {
            
            $this->db->query('INSERT INTO ' . $this->db->dbName  . '.skupine (skupina_ime, user_id) VALUES (:skupina_ime, :user_id)');

            $this->db->bind(':skupina_ime', $data['skupina_ime']);
            $this->db->bind(':user_id', $_SESSION['user_id']);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function findSkupinaByIme($skupinaIme)
        {
            //Pirpravi izjavo
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.skupine WHERE skupina_ime = :skupina_ime');

            //Bind-aj ime
            $this->db->bind(':skupina_ime', $skupinaIme);

            //Pogle če obstaja skupina
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function findById($id)
        {
            //Pripravi statment
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.skupine WHERE skupina_id = :skupina_id');

            $this->db->bind(':skupina_id', $id);

            $result = $this->db->single();           
            
            return $result;
        }

        public function updateSkupina($data) {
            $this->db->query('UPDATE ' . $this->db->dbName . '.skupine SET skupina_ime = :skupina_ime WHERE skupina_id = :skupina_id');
            $this->db->bind(':skupina_id', $data['skupina_id']);
            $this->db->bind(':skupina_ime', $data['skupina_ime']);
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function hasOsebaMany($skupina_id)
        {
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe_skupine WHERE skupina_id = :skupina_id');

            $this->db->bind(':skupina_id', $skupina_id);

            $result = $this->db->resultSet(); 

            return $result;
        }

        public function deleteSkupina($id) {
            $this->db->query('DELETE FROM ' . $this->db->dbName . '.skupine WHERE skupina_id = :skupina_id');
    
            $this->db->bind(':skupina_id', $id);
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        
    }