<?php

    class PostgreSQLDBContext {

        private $connection;
        private $result;

        public function __construct() {
            $connection_string = sprintf('host=%s port=%s dbname=%s user=%s password=%s',
                POSTGRESQL_HOST, POSTGRESQL_PORT, POSTGRESQL_DATABASE, POSTGRESQL_USER, POSTGRESQL_PASSWORD);
            
            $this->connection = pg_connect($connection_string)
                or die('Somthing whent wrong with the connection: ' . pg_last_error());
        }

        public function query($query) {
            $this->result = pg_query($this->connection, $query) or die('The query failed: ' . pg_last_error());
        }

        public function fetch_result() {
            if (isset($this->result) && $this->result != null) {
                return pg_fetch_array($this->result, null, PGSQL_ASSOC);
            } else {
                return false;
            };
        }

        public function fetch_all_results() {
            if (isset($this->result) && $this->result != null) {
                return pg_fetch_all($this->result, PGSQL_ASSOC);
            } else {
                return false;
            };
        }

        public function free_result() {
            pg_free_result($this->result);
        }

        public function __destruct() {
            pg_close($this->connection);
        }
    }

?>