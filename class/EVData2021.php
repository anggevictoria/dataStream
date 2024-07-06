<?php
// EVData2021.php

class EVData2021 {
    private $pdo;
    private $data; // Variable to store fetched data

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function fetchDataFromDB() {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM year2021");
            $stmt->execute();
            $this->data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $this->data;
        } catch (PDOException $e) {
            // Handle database error (optional)
            throw new Exception("Error fetching data: " . $e->getMessage());
        }
    }

    public function getData() {
        // Return stored data or fetch if not already fetched
        if (!$this->data) {
            $this->fetchDataFromDB();
        }
        return $this->data;
    }
}

