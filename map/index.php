<?php

#set the default values
$dateMap = "2019-12-31";
$hourMap = 8;

#set data from the request
if (isset($_GET['submitted']) && $_GET['submitted'] == '1') {
    $dateMap = $_GET['dateMap'];
    $hourMap = intval($_GET['hourMap']);
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Task 4 - Advance topics in web development</title>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <h1>Task 4 - maps visualisation</h1>
        <form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>">
            <h1>Show the average readings of NO, NO2 and NOX of all stations on the map at a specific time</h1>
            <h3>Note that the values will equal 0 if no readings are found for the station</h3>
            
            <div class="input_field">
                <label class="input_label">Date: </label>
                <input type="date" 
                    name="dateMap" 
                    value=<?php echo $dateMap; ?>
                    min="2015-01-01"
                    max="2019-12-31" /> 
            </div>

            <div class="input_field">
                <label for="hourMap">Hour (24:00 format): </label>
                <input required type="number" name="hourMap" min="0" max="23" value="<?php echo($hourMap) ?>" />
            </div>

            <input type="hidden" name="submitted" value="1" />
            
            <div class="input_field">
                <button type="submit" >Process map</button>
            </div>
        </form>

        <div id="map"></div>

        <div><?php require 'map.php'; ?></div>

        <script
            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDieBIT2N8ssHbliZ-iarhFx64PBE-CAWE&callback=initMap&v=weekly"
            defer
        ></script>
    </body>
</html>