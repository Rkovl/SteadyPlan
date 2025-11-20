<?php

class Database {
    private $connection;

    public function __construct() {
        $this->connect();
    }

    private function connect() {
        if(file_exists(__DIR__.'/../.env.local')){
            $lines = file(__DIR__.'/../.env.local', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                putenv($line);
            }
        }

        $conn_string = getenv('DATABASE_URL');

        try {
            $this->connection = pg_connect($conn_string);
            if (!$this->connection) {
                throw new Exception("Failed to connect to database");
            }
            $db_status = "DB Connection successful";
        } catch (Exception $e) {
            $db_status = "DB Connection failed: " . $e->getMessage();
            $conn = null;
        }


    }

    public function getConnection() {
        return $this->connection;
    }

}
?>