<?php 

    class Api {
        
        public function __construct()
        {
            $this->db = new Database;
        }

        public function findAllApiById($id) {
            
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.sms_api WHERE id = :id');

            $this->db->bind(':id', $id);
    
            $results = $this->db->single();
    
            return $results;
        }

        public function findByIme($ime) {
            
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.sms_api WHERE ime = :ime');

            $this->db->bind(':ime', $ime);
    
            $results = $this->db->single();
    
            return $results;
        }

        public function findAndComper() {
            
            $this->db->query('SELECT * FROM ' . $this->db->dbName . '.sms_api');
    
            $apis = $this->db->resultSet();
            
            if ((int)$apis[0]->st_sms >= (int)$apis[1]->st_sms) {
                return $apis[0]->ime;
            }
            else {
                return $apis[1]->ime;
            }
            
        }

        public function decrementOne($ime)
        {
            $api = $this->findByIme($ime);

            $num = $api->st_sms;

            echo $api->id;

            if((int)$api->st_sms == 0) {

                //Zaključi 
                return false;
            }

            $num = (int)$num - 1;

            $this->db->query('UPDATE ' . $this->db->dbName . '.sms_api SET st_sms = :st_sms WHERE id = :id');
            $this->db->bind(':id', $api->id);
            $this->db->bind(':st_sms', (int)$num);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
            
        }
    }