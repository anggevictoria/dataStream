<?php
include ('../class/data.php'); // Adjust path as per your actual directory structure

// Function to fetch data for a specific year
function fetchDataByYear($year) {
    $data = new Data();
    $filteredData = $data->filterDataByYear($year);
    return $filteredData;
}

// Manually set the year for debugging
$year = '2021'; // Set the desired year for debugging

// If 'all' is selected, fetch all data without filtering by year
if ($year == 'all') {
    $data = new Data();
    $responseData = $data->fetchData();
} else {
    // Fetch data for the specified year
    $responseData = fetchDataByYear($year);
}

// Output as JSON
header('Content-Type: application/json');
echo "<pre>";
print_r($responseData);
echo "</pre>";

echo json_encode($responseData);
?>
