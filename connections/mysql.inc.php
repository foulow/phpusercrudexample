<?php

    class MySQLDBContext {

        private $db_connection;
        private $result;

        public function __construct() {
            $this->db_connection = new mysqli(MYSQL_HOST, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DATABASE);
            if ($this->db_connection->connect_errno)
                die("Failed to connect to MySQL: (" 
                    . $this->db_connectionconnect_errno 
                    . ") " . $this->db_connection->connect_error
                );
        }

        public function query($query) {
            $this->result = mysqli_query($this->db_connection, $query);
            if ($this->db_connection->error)
                die('The query failed: ' . $this->db_connection->error);
        }

        public function fetch_result() {
            if (isset($this->result) && $this->result != false) {
                return mysqli_fetch_array($this->result, MYSQLI_BOTH);
            } else {
                return false;
            };
        }
        
        public function fetch_all_results() {
            if (isset($this->result) && $this->result != false) {
                return mysqli_fetch_all($this->result, MYSQLI_ASSOC);
            };

            return false;
        }

        public function free_result() {
            if (gettype($this->result) != "boolean")
                mysqli_free_result($this->result);
        }

        public function __destruct() {
            mysqli_close($this->db_connection);
        }
    }

?>