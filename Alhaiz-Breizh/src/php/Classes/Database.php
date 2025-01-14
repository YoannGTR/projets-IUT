<?php

namespace Classes;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $connection;
    private $host;
    private $username;
    private $password;
    private $database;

    private function __construct()
    {
        try {
            $this->host = $_ENV['MYSQL_HOST'];
            $this->username = $_ENV['MYSQL_USER'];
            $this->password = $_ENV['MYSQL_PASSWORD'];
            $this->database = $_ENV['MYSQL_DATABASE'];

            $this->connection = new PDO("mysql:host=$this->host;dbname=$this->database", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new Database();
        }

        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function prepare($query)
    {
        return $this->connection->prepare($query);
    }

    public function executeQuery($query, $params = [])
    {
        try {
            $stmt = $this->prepare($query);
            foreach ($params as $key => &$value) {
                $stmt->bindParam($key, $value);
            }
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($result !== false) {
                return $result;
            }
        } catch (PDOException $e) {
            echo $e;
            return false;
        }
    }

    public function generateUUID()
    {
        return $this->executeQuery('SELECT UUID() as uuid')[0]['uuid'];
    }
}
