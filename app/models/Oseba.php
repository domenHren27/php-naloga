<?php 

    class Oseba {
        
        public function __construct()
        {
            $this->db = new Database;
        }

        public function findAllOsebaById($id) {
            
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.osebe WHERE user_id = :user_id ORDER BY oseba_davcna ASC');

            $this->db->bind(':user_id', $id);
    
            $results = $this->db->resultSet();
    
            return $results;
        }

        public function addOseba($data)
        {
            if($data['oseba_davcna']) {
                $this->db->query('INSERT INTO ' . $this->db->dbName  . '.osebe (oseba_ime, oseba_email, oseba_telefon, oseba_davcna, user_id) VALUES (:oseba_ime, :oseba_email, :oseba_telefon, :oseba_davcna, :user_id)');

                $this->db->bind(':oseba_email', $data['oseba_email']);
                $this->db->bind(':oseba_ime', $data['oseba_ime']);
                $this->db->bind(':oseba_telefon', $data['oseba_telefon']);
                $this->db->bind(':oseba_davcna', $data['oseba_davcna']);
                $this->db->bind(':user_id', $_SESSION['user_id']);
            } else {
                $this->db->query('INSERT INTO ' . $this->db->dbName  . '.osebe (oseba_ime, oseba_email, oseba_telefon, user_id) VALUES (:oseba_ime, :oseba_email, :oseba_telefon, :user_id)');
                $this->db->bind(':oseba_email', $data['oseba_email']);
                $this->db->bind(':oseba_ime', $data['oseba_ime']);
                $this->db->bind(':oseba_telefon', $data['oseba_telefon']);
                $this->db->bind(':user_id', $_SESSION['user_id']);
            }
            

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        

        public function findOsebaByIme($oseba_ime)
        {
            //Pirpravi izjavo
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe WHERE oseba_ime = :oseba_ime');

            //Bind-aj ime
            $this->db->bind(':oseba_ime', $oseba_ime);
            //$this->db->bind(':user_id', $_SESSION['user_id']);

            //Poglej če obstaja oseba
            $result = $this->db->single();
            
            //var_dump($result);
            return $result;
        }

        public function findOsebaByDavcna($osebaDavcna)
        {
            //Pirpravi izjavo
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe WHERE oseba_davcna = :oseba_davcna');

            //Bind-aj ime
            $this->db->bind(':oseba_davcna', $osebaDavcna);

            //Poglej če obstaja oseba
            if($this->db->rowCount() > 0) {
            
                return true;
            } else {
                return false;
            }
        }

        public function findById($id)
        {
            //Pripravi statment
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe WHERE oseba_id = :skupina_id');

            $this->db->bind(':skupina_id', $id);

            $result = $this->db->single();           
            
            return $result;
        }

        public function updateOseba($data) {
            
            if($data['oseba_davcna']) {
                $this->db->query('UPDATE ' . $this->db->dbName . '.osebe SET oseba_ime = :oseba_ime, oseba_email = :oseba_email, oseba_telefon = :oseba_telefon, oseba_davcna = :oseba_davcna WHERE oseba_id = :oseba_id');
                $this->db->bind(':oseba_id', $data['oseba_id']);
                $this->db->bind(':oseba_email', $data['oseba_email']);
                $this->db->bind(':oseba_ime', $data['oseba_ime']);
                $this->db->bind(':oseba_telefon', $data['oseba_telefon']);
                $this->db->bind(':oseba_davcna', $data['oseba_davcna']);
            } else {
                $this->db->query('UPDATE ' . $this->db->dbName . '.osebe SET oseba_ime = :oseba_ime, oseba_email = :oseba_email, oseba_telefon = :oseba_telefon WHERE oseba_id = :oseba_id');
                $this->db->bind(':oseba_id', $data['oseba_id']);
                $this->db->bind(':oseba_email', $data['oseba_email']);
                $this->db->bind(':oseba_ime', $data['oseba_ime']);
                $this->db->bind(':oseba_telefon', $data['oseba_telefon']);
            }
            
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        

        public function deleteOseba($id) {
            $this->db->query('DELETE FROM ' . $this->db->dbName . '.osebe WHERE oseba_id = :oseba_id');
    
            $this->db->bind(':oseba_id', $id);
    
            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function findOsebaByEmail($email) {

            
            //Pripravi statment
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe WHERE oseba_email = :oseba_email');

            

            
    
            //Email param will be binded with the email variable
            $this->db->bind(':oseba_email', $email);

            
    
            if($this->db->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        }

        public function addToSkupina($osebaId, $skupinaId)
        {
        
            $this->db->query('INSERT INTO ' . $this->db->dbName  . '.osebe_skupine (oseba_id, skupina_id) VALUES (:oseba_id, :skupina_id)');

            $this->db->bind(':oseba_id', $osebaId);
            $this->db->bind(':skupina_id', $skupinaId);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        //Povezava med tabelama
        public function hasSkupinaMany($oseba_id)
        {
            $this->db->query('SELECT * FROM ' . $this->db->dbName .'.osebe_skupine WHERE oseba_id = :oseba_id');

            $this->db->bind(':oseba_id', $oseba_id);

            $result = $this->db->resultSet(); 

            return $result;
        }
    }