<?php
// _21populateDb.php

// Include necessary files
include '../Class/data.php';
include '../dB/conn.php'; // Adjust the path as per your file structure

// Instantiate DataUpdater class with database connection
$dataUpdater = new DataUpdater($conn);

// Call the updateData2021 method
$message = $dataUpdater->updateData2021();

// Output the result message
echo $message;
?>
