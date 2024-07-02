<?php
class EVData2021 {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function get2021Data() {
        $stmt = $this->pdo->prepare("SELECT * FROM year2021");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
