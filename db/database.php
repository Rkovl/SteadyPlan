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

        $database_url = getenv('DATABASE_URL');

        try {
            // Parse the DATABASE_URL
            $url = parse_url($database_url);

            $host = $url['host'] ?? 'localhost';
            $port = $url['port'] ?? 5432;
            $dbname = ltrim($url['path'], '/');
            $user = $url['user'] ?? '';
            $password = $url['pass'] ?? '';

            // Build PDO connection string
            $dsn = "pgsql:host={$host};port={$port};dbname={$dbname}";

            $this->connection = new PDO($dsn, $user, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            error_log("DB Connection failed: " . $e->getMessage());
            $this->connection = null;
        }
    }

    public function getConnection() {
        return $this->connection;
    }

}
?>