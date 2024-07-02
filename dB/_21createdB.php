<?php
include '../Class/data.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_login";

try {
    // Create connection
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $create_table_sql = "CREATE TABLE IF NOT EXISTS year2021 (
        id INT AUTO_INCREMENT PRIMARY KEY,
        date DATE NOT NULL,
        county VARCHAR(255) DEFAULT NULL,
        state VARCHAR(255) DEFAULT NULL,
        vehicle_primary_use VARCHAR(255) NOT NULL,
        electric_vehicle_ev_total INT NOT NULL,
        non_electric_vehicles INT NOT NULL,
        total_vehicles INT NOT NULL,
        percent_electric_vehicles FLOAT NOT NULL
    )";
    $conn->exec($create_table_sql);

    // Get filtered data
    $allData = getEVData();
    $filteredData = array_filter($allData, function($item) {
        return strpos($item['date'], '2021') !== false;
    });

    // Prepare insert statement
    $stmt = $conn->prepare("INSERT INTO year2021 (date, county, state, vehicle_primary_use, electric_vehicle_ev_total, non_electric_vehicles, total_vehicles, percent_electric_vehicles) 
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

    echo "Data inserted successfully.";

} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
