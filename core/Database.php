<?php

class Database {

    public $pdo;
    
    public function __construct($config) {
        $dsn = 'mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'];

        try {
            $this->pdo = new PDO(
                $dsn, 
                $config['username'], 
                $config['password'], 
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]
            );
        } catch(PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($query, $params = []) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
}