<?php
include '../dB/conn.php'; // Adjust the path to your connection file
include '../class/EVData2021.php';

header('Content-Type: application/json');

try {
    $evData = new EVData2021($pdo);
    $data = $evData->get2021Data();
    echo json_encode($data);
} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?>
