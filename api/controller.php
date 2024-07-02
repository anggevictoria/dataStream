<?php
include ('../class/data.php'); // Adjust path as per your actual directory structure

// Function to fetch data for a specific year
function fetchDataByYear($year) {
    $data = new Data();
    $filteredData = $data->filterDataByYear($year); // Assuming filterDataByYear exists in Data class
    return $filteredData;
}

// Check if the year parameter is set
if (isset($_GET['year'])) {
    $year = $_GET['year'];
    
    // If 'all' is selected, fetch all data without filtering by year
    if ($year == 'all') {
        $data = new Data();
        $responseData = $data->fetchData(); // Assuming fetchData exists in Data class
    } else {
        // Fetch data for the specified year
        $responseData = fetchDataByYear($year);
    }
    
    // Output as JSON
    header('Content-Type: application/json');
    echo json_encode($responseData);
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Year parameter is required."));
}
?>
