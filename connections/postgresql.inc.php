<?php
    if ( ! defined('BASE_PATH')) {
        define('BASE_PATH', $_SERVER['DOCUMENT_ROOT']."/");
        require BASE_PATH."unfound.inc.php";
    }

    class PostgreSQLDBContext {

        private $db_connection;
        private $result;

        public function __construct() {
            $connection_string = sprintf('host=%s dbname=%s user=%s password=%s',
                POSTGRESQL_HOST, POSTGRESQL_DATABASE, POSTGRESQL_USER, POSTGRESQL_PASSWORD);
            
            $this->db_connection = pg_connect($connection_string)
                or die('Somthing whent wrong with the connection: ' . pg_last_error());
        }

        public function query($query) {
            $this->result = pg_query($this->db_connection, $query) or die('The query failed: ' . pg_last_error());
        }

        public function fetch_result() {
            if (isset($this->result) && $this->result != false) {
                return pg_fetch_array($this->result, null, PGSQL_ASSOC);
            } else {
                return false;
            };
        }

        public function fetch_all_results() {
            if (isset($this->result) && $this->result != false) {
                return pg_fetch_all($this->result, PGSQL_ASSOC);
            } else {
                return false;
            };
        }

        public function free_result() {
            if (gettype($this->result) != "boolean")
                pg_free_result($this->result);
        }

        public function __destruct() {
            pg_close($this->db_connection);
        }
    }

?>