<?php
class Crud {
    // --- PROPERTIES ---
    private $conn;

    // --- CONSTRUCT ---
    public function __construct() {
        $servername = "localhost";
        $username = "root";
        $password = "MAMPsetup0191";
        $dbName = "educom_wiki";

        $dsn = 'mysql:host=' . $servername . ';dbname=' . $dbName;
        $this->conn = new PDO($dsn, $username, $password);
        $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $this->conn;      
    }

    // --- PUBLIC METHODS ---
    public function create(string $sql, array $var) : int {
        // returns int: last ID | bool: false
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $this->conn->lastInsertId();
    }

    public function readAll(string $sql) : array {
        // returns array: selected data | bool: false
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll();
    }

    public function read(string $sql, array $var) : array {
        // returns array: selected data | bool: false
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->fetchAll();
    }

    public function selectOne(string $sql, array $params=[], bool $as_object=false)
    {
        if ($this->_execute($sql,$params)) {	
            return $this->stmt->fetch($as_object ? \PDO::FETCH_OBJ : \PDO::FETCH_ASSOC);
        }				
        return false;
    }

    public function update(string $sql, array $var) : int {
        // returns int: affected rows | bool: false
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->rowCount();
    }

    public function delete(string $sql, array $var) : int {
        // returns int: affected rows | bool: false
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($var);
        return $stmt->rowCount();
    }
}