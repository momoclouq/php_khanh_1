<?php

define("IDS", array('188', '203', '206', '209', '213', '215', '228', '270', '271', '375', '395', '452', '447', '459', '463', '481', '500', '501'));

function createRecWithData($writer, $ts, $nox, $no2, $no)
{
    $writer->startElement('rec');

    $writer->writeAttribute('ts', $ts);
    $writer->writeAttribute('nox', $nox);
    $writer->writeAttribute('no', $no);
    $writer->writeAttribute('no2', $no2);

    $writer->endElement();
}

foreach (IDS as $id) {
    $file = fopen("data-" . $id . ".csv", "r");

    if(!$file) {
        echo "File could not be opened or read, please check again!";
        exit;
    }

    #remove headers line
    fgets($file);

    $writer = new XMLWriter();
    $writer->openUri('data-' . $id . '.xml');
    $writer->startDocument('1.0', 'UTF-8');
    $writer->setIndent(2);

    #create station element
    $writer->startElement('station');

    #read the first line
    $firstLine = fgets($file);
    
    if($firstLine){
        [$siteID, $ts, $nox, $no2, $no,,,,,,,,,, $loc, $lat, $long] = explode(',', $firstLine);

        #field for station element
        $writer->writeAttribute('id', $siteID);
        $writer->writeAttribute('name', $loc);
        $writer->writeAttribute('geocode', $lat . ',' . trim($long));
    
        #write record for the first line
        createRecWithData($writer, $ts, $nox, $no2, $no);
    
        while (true) {
            $currentLine = fgets($file);
    
            if(!$currentLine) break;
    
            [, $ts, $nox, $no2, $no,,,,,,,,,,,,] = explode(',', $currentLine);
    
            createRecWithData($writer, $ts, $nox, $no2, $no);
        }
    }

    $writer->endElement(); //end station element

    $writer->endDocument(); 

    fclose($file);
}
