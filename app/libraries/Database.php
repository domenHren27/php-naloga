<?php 
    class Database {
        private $dbHost = DB_HOST;
        private $dbUser = DB_USER;
        private $dbPass = DB_PASS;
        public $dbName = DB_NAME;

        public $statement;
        private $dbHandler;
        private $error;

        
        
        
        public function __construct()
        {
            // R::setup( 'mysql:host=localhost;dbname=' . $this->dbName,
            // $this->dbUser, $this->dbPass );

            $conn = 'mysql:host' . $this->dbHost . ';dbname=' . $this->dbName;
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            try {
                $this->dbHandler = new PDO($conn, $this->dbUser, $this->dbPass, $options);
                
            } catch (PDOException $e) {
                $this->error = $e->getMessage();
                echo $this->error;
            }
        }
        //Pisanje querryov
        public function query($sql) {
            $this->statement = $this->dbHandler->prepare($sql);
        }

        //Bind values
        public function bind($parameter, $value, $type = null) {
            switch (is_null($type)) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
            $this->statement->bindValue($parameter, $value, $type);
            
        }
        //Izvrši pripravljeno izvjavo
        public function execute()
        {
            return $this->statement->execute();
        }

        //Vrne listo objektov
        public function resultSet()
        {
            $this->execute();
            return $this->statement->fetchAll(PDO::FETCH_OBJ);
        }
        //Vrne specifičen objekt
        public function single()
        {
            $this->execute();
            return $this->statement->fetch(PDO::FETCH_OBJ);
        }
        //Prešteje vrstice
        public function rowCount()
        {
            //Manjka execute
            $this->execute();
            return $this->statement->rowCount();
        }
    }