<?php  
    class DataBase {
        //DB Params
        private $host = 'localhost';
        private $db_name = 'php_blog';
        private $username = 'root';
        private $password = '';
        private $conn;

        //DB connect
        public function connect(){
            $this->conn = null;

            try{            
                            // new PDO(DSN, username, password)
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch(PDOexception $e){
                echo 'connection error: ' . $e.getMessage();
            }

            return $this->conn;
        }
    }
