<?php

#set the default values
$year = 2019;
$hour = 8;
$station = 188;

#set data from the request
if (isset($_GET['submitted']) && $_GET['submitted'] == '1') {
    $year = $_GET['year'];
    $hour = $_GET['hour'];
    $station = $_GET['station'];
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task 3.1 - Advanced topics in web development</title>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="container">

    <div id="chart"></div>

    <div><?php require 'chart1.php'; ?></div>

    <form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>">
        <div class="input_field">
            <label class="input_label">Year: </label>
            <select name="year" required>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
            </select>
        </div>

        <div class="input_field">
            <label for="hour">Hour (24:00 format): </label>
            <input required type="number" name="hour" min="0" max="23" value="<?php print($hour) ?>" />
        </div>

        <div class="input_field">
            <label class="input_label">Stations: </label>
            <select name="station" required>
                <option value="188">188 - AURN Bristol Centre</option>
                <option value="203">203 - Brislington Depot</option>
                <option value="206">206 - Rupert Street</option>
                <option value="209">209 - IKEA M32</option>
                <option value="213">213 - Old Market</option>
                <option value="215">215 - Parson Street School</option>
                <option value="228">228 - Temple Meads Station</option>
                <option value="270">270 - Wells Road</option>
                <option value="271">271 - Trailer Portway P&R</option>
                <option value="375">375 - Newfoundland Road Police Station</option>
                <option value="395">395 - Shiner's Garage</option>
                <option value="452">452 - AURN St Pauls</option>
                <option value="447">447 - Bath Road</option>
                <option value="459">459 - Cheltenham Road \ Station Road</option>
                <option value="463">463 - Fishponds Road</option>
                <option value="481">481 - CREATE Centre Roof'</option>
                <option value="500">500 - Temple Way</option>
                <option value="501">501 - Colston Avenue</option>
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