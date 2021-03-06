<?php
    class Database {
        // DB Parameters
        private $host = '127.0.0.1:8889';
        private $db_name = 'spotifyproject';
        private $username = 'root';
        private $password = 'root';
        private $conn;

        // DB Connect
        public function connect(){
            $this->conn = null;

            try{
                $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,$this->username,$this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo 'Connection Error: ' . $e->getMessage();
            }

            return $this->conn;
        }
    }