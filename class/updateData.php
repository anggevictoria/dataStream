<?php
// updateData.php

include '../Class/data.php';
include '../dB/conn.php';

class DataUpdater {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function updateData2021() {
        try {
            // Get filtered data
            $allData = getEVData();
            $filteredData = array_filter($allData, function($item) {
                return strpos($item['date'], '2021') !== false;
            });

            // Prepare insert statement
            $stmt = $this->conn->prepare("INSERT INTO year2021 (date, county, state, vehicle_primary_use, electric_vehicle_ev_total, non_electric_vehicles, total_vehicles, percent_electric_vehicles) 
                                        VALUES (:date, COALESCE(:county, ''), COALESCE(:state, ''), :vehicle_primary_use, :electric_vehicle_ev_total, :non_electric_vehicles, :total_vehicles, :percent_electric_vehicles)");

            foreach ($filteredData as $row) {
                // Bind parameters
                $stmt->bindParam(':date', $row['date']);
                
                // Handle NULL value for county and convert it to empty string
                $county = isset($row['county']) ? $row['county'] : null;
                $stmt->bindParam(':county', $county);

                // Handle NULL value for state and convert it to empty string
                $state = isset($row['state']) ? $row['state'] : null;
                $stmt->bindParam(':state', $state);

                $stmt->bindParam(':vehicle_primary_use', $row['vehicle_primary_use']);
                $stmt->bindParam(':electric_vehicle_ev_total', $row['electric_vehicle_ev_total']);
                $stmt->bindParam(':non_electric_vehicles', $row['non_electric_vehicles']);
                $stmt->bindParam(':total_vehicles', $row['total_vehicles']);
                $stmt->bindParam(':percent_electric_vehicles', $row['percent_electric_vehicles']);

                // Execute the statement
                $stmt->execute();
            }

            return "Data inserted successfully.";

        } catch(PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }
}

// Ensure that $pdo is available in the global scope
global $pdo;

// Usage
$dataUpdater = new DataUpdater($pdo);
echo $dataUpdater->updateData2021();
?>
