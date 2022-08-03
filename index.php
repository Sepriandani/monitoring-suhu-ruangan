<?php
include_once('database.php');

if ($_GET["readingsCount"]) {
    $data = $_GET["readingsCount"];
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    $readings_count = $_GET["readingsCount"];
}
// default readings count set to 20
else {
    $readings_count = 20;
}

$last_reading = getLastReadings();
$last_reading_temp = $last_reading["temp"];
$last_reading_humi = $last_reading["humid"];
$last_reading_orang = $last_reading["orang"];
$last_reading_time = $last_reading["reading_time"];

$min_temp = minReading($readings_count, 'temp');
$max_temp = maxReading($readings_count, 'temp');
$avg_temp = avgReading($readings_count, 'temp');

$min_humi = minReading($readings_count, 'humid');
$max_humi = maxReading($readings_count, 'humid');
$avg_humi = avgReading($readings_count, 'humid');
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>
<header class="header">
    <h1> Monitoring Kondisi Ruangan</h1>
    <form method="get">
        <input type="number" name="readingsCount" min="1" placeholder="Number of readings (<?php echo $readings_count; ?>)">
        <input type="submit" value="UPDATE">
    </form>
</header>

<body>

    <p>Last reading: <?php echo $last_reading_time; ?></p>
    <section class="content">
        <div class="box gauge--1">
            <h3>TEMPERATURE</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="temp">--</p>

        </div>
        <div class="box gauge--2">
            <h3>HUMIDITY</h3>
            <div class="mask">
                <div class="semi-circle"></div>
                <div class="semi-circle--mask"></div>
            </div>
            <p style="font-size: 30px;" id="humi">--</p>
        </div>
        <div class="orang">
            <h3>PENGUNJUNG</h3>
            <div class="mask">
                <i class="fas fa-user-alt fa-7x" style="color: #3498db;"></i>
            </div>
            <p style="font-size: 30px;" id="orang">--</p>
        </div>
    </section>
    <?php
    echo   '<h2> View Latest ' . $readings_count . ' Readings</h2>
            <table cellspacing="5" cellpadding="5" id="tableReadings">
                <tr>
                    <th>ID</th>
                    <th>Temperatur</th>
                    <th>Humidity</th>
                    <th>Pengunjung</th>
                    <th>Timestamp</th>
                </tr>';

    $result = getAllReadings($readings_count);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $row_id = $row["id"];
            $row_temp = $row["temp"];
            $row_humid = $row["humid"];
            $row_orang = $row["orang"];
            $row_reading_time = $row["reading_time"];

            echo '<tr>
                    <td>' . $row_id . '</td>
                    <td>' . $row_temp . '</td>
                    <td>' . $row_humid . '</td>
                    <td>' . $row_orang . '</td>
                    <td>' . $row_reading_time . '</td>
                  </tr>';
        }
        echo '</table>';
        $result->free();
    }
    ?>

    <script>
        var temp = <?php echo $last_reading_temp; ?>;
        var humid = <?php echo $last_reading_humi; ?>;
        var orang = <?php echo $last_reading_orang; ?>;
        setTemperature(temp);
        setHumidity(humid);
        setOrang(orang);

        function setTemperature(curVal) {
            //set range for Temperature in Celsius -5 Celsius to 38 Celsius
            var minTemp = -5.0;
            var maxTemp = 38.0;

            var newVal = scaleValue(curVal, [minTemp, maxTemp], [0, 180]);
            $('.gauge--1 .semi-circle--mask').attr({
                style: '-webkit-transform: rotate(' + newVal + 'deg);' +
                    '-moz-transform: rotate(' + newVal + 'deg);' +
                    'transform: rotate(' + newVal + 'deg);'
            });
            $("#temp").text(curVal + ' ºC');
        }

        function setHumidity(curVal) {
            //set range for Humidity percentage 0 % to 100 %
            var minHumi = 0;
            var maxHumi = 100;

            var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
            $('.gauge--2 .semi-circle--mask').attr({
                style: '-webkit-transform: rotate(' + newVal + 'deg);' +
                    '-moz-transform: rotate(' + newVal + 'deg);' +
                    'transform: rotate(' + newVal + 'deg);'
            });
            $("#humi").text(curVal + ' %');
        }

        function setOrang(curVal) {
            //set range for Orang percentage 0 % to 100 %
            var minHumi = 0;
            var maxHumi = 100;

            var newVal = scaleValue(curVal, [minHumi, maxHumi], [0, 180]);
            $("#orang").text(curVal + ' orang');
        }

        function scaleValue(value, from, to) {
            var scale = (to[1] - to[0]) / (from[1] - from[0]);
            var capped = Math.min(from[1], Math.max(from[0], value)) - from[0];
            return ~~(capped * scale + to[0]);
        }
    </script>
</body>

</html>