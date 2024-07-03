<?php
// Example usage in a separate script (like test.php)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include __DIR__ . '/dB/conn.php'; // Adjust path as necessary
include __DIR__ . '/class/EVData2021.php'; // Adjust path as necessary

// Debug output array
$debugOutput = [];

try {
    // Database connection check
    if ($pdo) {
        $debugOutput[] = ['debug' => 'Database connection successful.'];
    } else {
        $debugOutput[] = ['debug' => 'Database connection failed.'];
    }

    // Instantiate EVData2021 object
    $evData = new EVData2021($pdo);

    // Check if EVData2021 object was instantiated
    if ($evData) {
        $debugOutput[] = ['debug' => 'EVData2021 object instantiated successfully.'];
    } else {
        $debugOutput[] = ['debug' => 'Failed to instantiate EVData2021 object.'];
    }

    // Fetch data from EVData2021
    $data = $evData->getData();
    if ($data) {
        $debugOutput[] = ['debug' => 'Data fetched successfully from database.', 'data' => $data];
    } else {
        $debugOutput[] = ['debug' => 'No data fetched from database.'];
    }

    // Output debug array as JSON
    echo json_encode($debugOutput);
} catch (Exception $e) {
    // Handle any exceptions
    $debugOutput[] = ['error' => $e->getMessage()];
    echo json_encode($debugOutput);
}
?>
