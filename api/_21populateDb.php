<?php
// This codes invokes the updateData2021() method from the updateData.php class.


include '../Class/updateData.php';
include '../dB/conn.php';

$dataUpdater = new DataUpdater($pdo);
$result = $dataUpdater->updateData2021();

// Return the result as JSON
echo json_encode(['message' => $result]);
?>
