<?php
class Database
{
    private $connection;

    public function __construct($host, $username, $password, $db)
    {
        $this->connection = new mysqli("localhost", "root", "", "chatbook_db");
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function read($query)
    {
        $result = $this->connection->query($query);

        if (!$result) {
            return false; // You should handle the error here
        } else {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function save($query)
    {
        $result = $this->connection->query($query);

        if (!$result) {
            return false; // You should handle the error here
        } else {
            return true;
        }
    }
}

// Usage
$DB = new Database("localhost", "root", "", "chatbook_db");
