<?php

#value from the ui
$year;
$hour;
$station;

#arrays to store immediate value
$sums = array_fill(0, 12, 0);
$counts = array_fill(0, 12, 0);

#read the corresponding file
$fileName = "../test/data-" . $station . ".xml";
if(!file_exists($fileName)) exit; 
$xml = simplexml_load_file($fileName);

foreach($xml->children() as $record) {
    $recordTime = new DateTime();
    $recordTime->setTimestamp(intval($record['ts']));
    
    $recordMonth = intval($recordTime->format('m'));
    $recordHour = intval($recordTime->format('H'));
    $recordYear = intval($recordTime->format('Y'));

    if($recordYear == intval($year) && $recordHour == intval($hour)){
        $noValue = floatval($record['no']);

        $sums[$recordMonth - 1] += floatval($noValue);
        $counts[$recordMonth - 1] += 1;
    }
}

#process result
$processedResult = "";

#set the maximum NO time to get the correct limit
$maxNO = 0;

for($i = 0; $i < 12; $i++){
    if ($counts[$i] == 0) $average = 0;
    else $average = $sums[$i] / $counts[$i];

    if ($maxNO < $average) $maxNO = $average;
    $processedResult .= "[" . ($i + 1) . " , " . $average . "],";
}

#turn maxNO to int for google chart API limit
$maxNO = ceil($maxNO);

$output = <<<js
<script type="text/javascript">
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Month', 'NO level'],
    {$processedResult}
  ]);

  var options = {
    title: 'Average NO at time {$hour} hour, year: {$year} from {$xml['name']} station',
    hAxis: {
        title: 'Month', 
        minValue: 1, 
        maxValue: 12, 
        gridlines: {
            count: 6
        }
    },
    vAxis: {title: 'NO', minValue: 0, maxValue: {$maxNO}},
    legend: 'none'
  };

  var chart = new google.visualization.ScatterChart(document.getElementById('chart'));

  chart.draw(data, options);
}
</script>
js;

echo $output;

?>