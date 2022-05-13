<?php

    if(isset($_GET['chart']) && $_GET['chart'] == "1") header('Location: ./ui_chart1.php');
    if(isset($_GET['chart']) && $_GET['chart'] == "2") header('Location: ./ui_chart2.php');

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Task 3 - Advance topics in web development</title>
        <link rel="stylesheet" href="style.css" />
    </head>

    <body>
        <h1>Task 3 - charts visualisation</h1>
        <form method="GET" action="<?php print $_SERVER['PHP_SELF']; ?>">
            <div class="input_field">
                <label>Select which chart to show</label>
            </div>

            <div class="input_field">
                <select name="chart" required>
                    <option value="1">A scatter chart showing a years worth of data for NO</option>
                    <option value="2">A line chart showing levels in any 24 hour period on any day</option>
                </select>
            </div>
            
            <div class="input_field">
                <button type="submit">Show chart</button>
            </div>
        </form>
    </body>
</html>