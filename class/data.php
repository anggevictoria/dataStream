<?php
function getEVData() {
    $url = "https://data.wa.gov/resource/3d5d-sdqb.json";
    $data = file_get_contents($url);
    return json_decode($data, true);
}
?>