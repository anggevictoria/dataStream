<?php
// Include database connection file
require '../dB/conn.php';

// Include EVData2021 class file
require '../class/EVData2021.php';

header('Content-Type: application/json');

try {
    // Create a PDO instance
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=UTF8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Instantiate EVData2021 object with PDO instance
    $evData = new EVData2021($pdo);

    // Get data from the EVData2021 object
    $data = $evData->get2021Data();

    // Output JSON encoded data
    echo json_encode($data);

} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
} catch (Exception $e) {
    // Handle other exceptions
    echo json_encode(['error' => $e->getMessage()]);
}
?>
