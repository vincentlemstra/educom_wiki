<?php

class Crud {
    // --- PROPERTIES ---
    private $conn;

    // --- CONSTRUCT ---
    public function __construct() 
    {
        $host = '127.0.0.1';
        $dbname = 'wiki';
        $pass = 'pannekoek';
        $user = 'root';

        $dsn = 'mysql:host=' . $host . ';dbname=' . $dbname;
        $this->conn = new PDO($dsn, $user, $pass);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $this->conn;
    }

    public function create(string $sql, array $var) : int {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $this->conn->lastInsertId();
    }

    public function readAll(string $sql) : array | bool {
        // returns array: selected data | if no results bool: false
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function readOne(string $sql, array $var) : array | bool {
        // returns array: selected data | f no results bool: false
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->fetch();
    }

    public function readMultiple(string $sql, array $var) : array | bool {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->fetchAll();
    }

    public function update(string $sql, array $var) : int {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->rowCount();
    }

    public function delete(string $sql, array $var) : int {
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->rowCount();
    }
}