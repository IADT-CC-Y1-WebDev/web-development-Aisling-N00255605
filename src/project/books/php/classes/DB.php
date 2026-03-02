<?php
class DB
{
    private static $instance = null;

    private $connection;
    private function __construct()
    {
        try {
            $this->connection = new PDO(DB_DSN, DB_USER, DB_PASS, DB_OPTIONS);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function __clone() {}

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize a singleton.");
    }
}
?>