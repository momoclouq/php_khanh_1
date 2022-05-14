<?php

#set the default values
$date2 = "2019-12-31";
$station2 = 188;
$pollutant2 = "nox";

#set data from the request
if (isset($_GET['submitted']) && $_GET['submitted'] == '1') {
    $date2 = $_GET['date2'];
    $station2 = $_GET['station2'];
    $pollutant2 = $_GET['pollutant2'];
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task 3.2 - Advanced topics in web development</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="container">

    <div id="chart"></div>

    <div><?php require 'chart2.php'; ?></div>

    <form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>">
         <div class="input_field">
            <label class="input_label">Pollutant: </label>
            <select name="pollutant2" required>
                <option value="no">NO - nitrogen monoxide</option>
                <option value="no2">NO2 - Nitrogen dioxide</option>
                <option value="nox">NOX - nitrogen oxides</option>
            </select>
        </div>

        <div class="input_field">
            <label class="input_label">Date: </label>
            <input type="date" 
                name="date2" 
                value=<?php echo $date2; ?>
                min="2015-01-01"
                max="2019-12-31" /> 
        </div>

        <div class="input_field">
            <label class="input_label">Stations: </label>
            <select name="station2" required>
                <option value="188">188 - AURN Bristol Centre</option>
                <option value="203">203 - Brislington Depot</option>
                <option value="206">206 - Rupert Street</option>
                <option value="209">209 - IKEA M32</option>
                <option value="213">213 - Old Market</option>
                <option value="215">215 - Parson Street School</option>
            </select>
        </div>

        <input type="hidden" name="submitted" value="1" />

        <div class="input_field">
            <button class="submit_btn" type="submit">Visualize</button>
        </div>

    </form>

    </div>

</body>

</html>