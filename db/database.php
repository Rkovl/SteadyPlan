<?php
class Database {
    private static $instance = null;
    private $connection;

    // Private constructor prevents direct instantiation
    private function __construct() {
        $this->connect();
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    // Get the singleton instance
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
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