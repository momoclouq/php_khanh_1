<?php 

#value from the ui
$dateMap;
$hourMap;

define("IDS", array('188', '203', '206', '209', '213', '215', '228', '270', '271', '375', '395', '452', '447', '459', '463', '481', '500', '501'));

#arrays to store immediate value
$length = count(IDS);
$geocodes = array_fill(0, $length, array("0", "0"));
$noLevels = array_fill(0, $length, 0);
$no2Levels = array_fill(0, $length, 0);
$noxLevels = array_fill(0, $length, 0);

#process all files for data
for ($i = 0; $i < $length; $i++) {
   #read the corresponding file
    $fileName = "../test/data-" . IDS[$i] . ".xml";
    if(!file_exists($fileName)) exit; 
    $xml = simplexml_load_file($fileName);

    #get the position of the site
    if(!$xml['geocode']) {
        $geocodes[$i] = array("not available", "not available");
        continue;
    }
    $geocodes[$i] = explode(",", $xml['geocode']);

    foreach ($xml->children() as $record) {
        $recordTime = new DateTime();
        $recordTime->setTimestamp(intval($record['ts']));

        #get the date/hour string for comparision
        $formattedDate = $recordTime->format("Y-m-d");
        $formattedHour = $recordTime->format('H');
        
        if($formattedDate == $dateMap && $formattedHour == $hourMap) {
            $noLevels[$i] = intval($record['no']);
            $no2Levels[$i] = intval($record['no2']);
            $noxLevels[$i] = intval($record['nox']);

            echo "NO: " . $noLevels[$i] . " - NO2: " . $no2Levels[$i] . " - NOX: " . $noxLevels[$i] . "<br>"; 
        }
    }
}

$output1 = <<<js

<script type="text/javascript">
    function initMap() {
        const uluru = { lat: 51.4572041156, lng: -2.58564914143 };
        
        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 7,
            center: uluru,
        });

        let markers = [];

js;

for($i = 0; $i < $length; $i++){
    $latitude = $geocodes[$i][0];
    $longitude = $geocodes[$i][1];

    //skip if the station does not have any data
    if ($latitude == "not available" || $longitude == "not available") continue;

    $no = $noLevels[$i];
    $no2 = $no2Levels[$i];
    $nox = $noxLevels[$i];

    //process intval latitude and longitude
    $latitude = intval($latitude);
    $longitude = intval($longitude);

    $temp = <<<tempx

    markers.push(new google.maps.Marker({
        position: { lat: {$latitude}, lng: {$longitude} },
        map: map,
        title: "NO: {$no} - NO2: {$no2} - NOX: {$nox}"
    }));

    tempx;
    
    $output1 .= $temp;
}

$output2 = <<<jsx
}

window.initMap =  initMap;
</script>
jsx;

echo $output1 . $output2;

?>