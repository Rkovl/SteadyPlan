<?php
/*
 *Database connection functions.
 */
class Database {
    private static $instance = null;
    private $connection;
    private const DEFAULT_CONN_STRING = "";

    // Private constructor prevents direct instantiation
    private function __construct() {
    }

    // Prevent cloning of the instance
    private function __clone() {}

    // Prevent unserializing of the instance
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }

    // Get the singleton instance
    public static function getInstance($conn_string = self::DEFAULT_CONN_STRING) {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        if(self::$instance->connection === null) {
            self::$instance->connect($conn_string);
        }

        return self::$instance;
    }

    private function connect($conn_string) {
        $database_url = "";

        if($conn_string === self::DEFAULT_CONN_STRING) {
            if (file_exists($_SERVER['DOCUMENT_ROOT'] . '/.env.local')) {
                $lines = file($_SERVER['DOCUMENT_ROOT'] . '/.env.local', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                foreach ($lines as $line) {
                    putenv($line);
                }
            }

            $database_url = getenv('DATABASE_URL');

            if (!$database_url) {
                error_log("DB Connection failed: DATABASE_URL environment variable is not set");
                $this->connection = null;
                return;
            }
        } else {
            $database_url = $conn_string;
        }

        try {
            // Parse the DATABASE_URL
            $url = parse_url($database_url);

            if ($url === false) {
                throw new PDOException("Invalid DATABASE_URL format");
            }

            $host = $url['host'] ?? 'localhost';
            $port = $url['port'] ?? 5432;
            $dbname = ltrim($url['path'] ?? '', '/');
            $user = $url['user'] ?? '';
            $password = $url['pass'] ?? '';

            if (empty($dbname)) {
                throw new PDOException("Database name not found in DATABASE_URL");
            }

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