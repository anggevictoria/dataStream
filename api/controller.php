<?php
include_once('../class/data.php'); // Adjust path as per your actual directory structure

// Function to fetch data for a specific year
function fetchDataByYear($year) {
    $data = new Data();
    $filteredData = $data->filterDataByYear($year); // Assuming filterDataByYear exists in Data class
    return $filteredData;
}

// Handle API requests
if (isset($_GET['year'])) {
    $year = $_GET['year'];
    $responseData = fetchDataByYear($year);

    // Output as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Year parameter is required."));
}
?>
