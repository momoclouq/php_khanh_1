<?php
#set time zone
@date_default_timezone_set('GMT');

ini_set('memory_limit', '512M');
ini_set('max_execution_time', '300');
ini_set('auto_detect_line_ending', TRUE);

$reader = fopen('air-quality-data-2004-2019.csv', 'r');

#define constants
define("HEADERS" , "siteID,ts,nox,no2,no,pm10,nvpm10,vpm10,nvpm2.5,pm2.5,vpm2.5,co,o3,so2,loc,lat,long\n");
define("SITEIDS" , array('188', '203', '206', '209', '213', '215', '228', '270','271', '375', '395', '452', '447', '459', '463', '481', '500', '501'));

#create files and add header
foreach (SITEIDS as $siteID) {
    $currentFile = fopen('data-' . $siteID . '.csv', 'w');
    
    if(!$currentFile) {
        echo "Cannot create/open the file for some reasons, please check again!";
        exit;
    }

    #assign opened file to corresponding variable for later use
    ${'data-' . $siteID} = $currentFile; 

    fwrite($currentFile, HEADERS);
}

#skip the first header line
fgets($reader);

#process data
while (true) {
    $currentLine = fgets($reader); #get current line

    if (!$currentLine) break;

    list($date_time, $NOx, $NO2, $NO, $siteID, $PM10, $NVPM10, $VPM10, $NVPM2_5, $PM2_5, $VPM2_5, $CO, $O3, $SO2, $temperature, $RH, $air_pressure, $location, $geo_point_2d, $dateStart, $dateEnd, $current) = explode(';', $currentLine);

    if($NOx == '' && $CO == ''){
        continue;
    }

    #process point 2d
    list($latitude, $longitude) = explode(',', $geo_point_2d);

    $outputLine = $siteID . ',' 
    . strtotime($date_time) . ',' 
    . $NOx . ',' 
    . $NO2 . ',' 
    . $NO . ',' 
    . $PM10 . ',' 
    . $NVPM10 . ',' 
    . $VPM10 . ',' 
    . $NVPM2_5 . ',' 
    . $PM2_5 . ',' 
    . $VPM2_5 . ',' 
    . $CO . ',' 
    . $O3 . ',' 
    . $SO2 . ',' 
    . $location . ',' 
    . $latitude . ',' 
    . $longitude;

    fwrite(${'data-' . $siteID}, $outputLine . "\n");
}

#close all the files
foreach (SITEIDS as $siteID) {
    fclose(${'data-' . $siteID});
}

?>