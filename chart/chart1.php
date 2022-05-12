<?php

#value from the ui
$date2;
$station2;
$pollutant2;

#arrays to store immediate value
$levels = array_fill(0, 24, 0);

// echo "date: " . $date2 . ", station: " . $station2 . ", pollutant: " . $pollutant2 . "<br>";

#read the corresponding file
$fileName = "../test/data-" . $station2 . ".xml";
if(!file_exists($fileName)) exit; 
$xml = simplexml_load_file($fileName);

foreach($xml->children() as $record) {
    $recordTime = new DateTime();
    $recordTime->setTimestamp(intval($record['ts']));

    #get the date string
    $formattedTime = $recordTime->format("Y-m-d");
    
    if($formattedTime == $date2) {
      $levels[intval($recordTime->format('H'))] = $record[$pollutant2];
    }
}

#process result
$processedResult = "";

for($i = 0; $i < 24; $i++){
    $processedResult .= "['" . ($i) . "' , " . $levels[$i] . "],";
}

#format pollutant value
$pollutant2 = strtoupper($pollutant2);

$output = <<<js
<script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Hour', '{$pollutant2}'],
          {$processedResult}
        ]);

        var options = {
          title: '24 hour statistics on {$pollutant2} in {$date2}',
          curveType: 'function',
          subtitle: 'Concentration (µg/m³)'
        };

        var chart = new google.visualization.LineChart(document.getElementById('chart'));

        chart.draw(data, options);
      }
    </script>
js;

echo $output;

?>
