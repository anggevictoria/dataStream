<?php
class Data
{
    private $url = "https://data.wa.gov/resource/3d5d-sdqb.json";

    public function fetchData()
    {
        $data = file_get_contents($this->url);
        $json = json_decode($data, true);

        if (!$json) {
            // Handle JSON decoding error
            return [];
        }

        // Filter out unnecessary keys and handle missing keys
        $filteredData = array_map(function ($item) {
            return [
                'date' => isset($item['date']) ? date('F j, Y', strtotime($item['date'])) : '',
                'county' => isset($item['county']) ? $item['county'] : '',
                'state' => isset($item['state']) ? $item['state'] : '',
                'vehicle_primary_use' => isset($item['vehicle_primary_use']) ? $item['vehicle_primary_use'] : '',
                'electric_vehicle_ev_total' => isset($item['electric_vehicle_ev_total']) ? $item['electric_vehicle_ev_total'] : '',
                'non_electric_vehicles' => isset($item['non_electric_vehicles']) ? $item['non_electric_vehicles'] : '',
                'total_vehicles' => isset($item['total_vehicles']) ? $item['total_vehicles'] : '',
                'percent_electric_vehicles' => isset($item['percent_electric_vehicles']) ? number_format($item['percent_electric_vehicles'], 2) : ''
            ];
        }, $json);

        // Sort by date descending
        usort($filteredData, function ($a, $b) {
            return strtotime($b['date']) - strtotime($a['date']);
        });

        return $filteredData;
    }

    public function filterDataByYear($year)
    {
        $data = $this->fetchData();
        $filteredData = array_filter($data, function ($item) use ($year) {
            // Parse the date and get the year
            $itemYear = date('Y', strtotime($item['date']));
            return $itemYear == $year;
        });
    
        return array_values($filteredData); // Reset array keys after filtering
    }
    
}

/*
// Usage
$data = new Data();
$filteredData = $data->fetchData();

// Now $filteredData contains dates formatted as 'Month Day, Year' and 'Percent Electric Vehicles' rounded to 2 decimal places
foreach ($filteredData as $item) {
    echo 'Date: ' . $item['date'] . '<br>';
    echo 'County: ' . $item['county'] . '<br>';
    echo 'State: ' . $item['state'] . '<br>';
    echo 'Vehicle Primary Use: ' . $item['vehicle_primary_use'] . '<br>';
    echo 'Electric Vehicle Total: ' . $item['electric_vehicle_ev_total'] . '<br>';
    echo 'Non-Electric Vehicles: ' . $item['non_electric_vehicles'] . '<br>';
    echo 'Total Vehicles: ' . $item['total_vehicles'] . '<br>';
    echo 'Percent Electric Vehicles: ' . $item['percent_electric_vehicles'] . '<br>';
    echo '<br>';
}*/
