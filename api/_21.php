<?php
include '../Class/data.php';

header('Content-Type: application/json');

$allData = getEVData();
$filteredData = array_filter($allData, function($item) {
    return strpos($item['date'], '2021') !== false;
});

echo json_encode(array_values($filteredData));
?>