<?php
$servername = "localhost";
// REPLACE with your Database name
$dbname = "tubes_pse_data";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

// Keep this API Key value to be compatible with the ESP32 code provided in the project page. If you change this value, the ESP32 sketch needs to match
$api_key_value = "tPmAT5Ab3j7F9";

$key =  "";
$temp = $humid = $orang = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $key = test_input($_GET["key"]);
    if ($key == $api_key_value) {
        $temp = test_input($_GET["temp"]);
        $humid = test_input($_GET["humid"]);
        $orang = test_input($_GET["orang"]);

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "INSERT INTO sensor_data (temp, humid, orang)
        VALUES ('" . $temp . "', '" . $humid . "', '" . $orang . "')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        $conn->close();
    } else {
        echo "Wrong API Key provided.";
    }
} else {
    echo "No data posted with HTTP POST.";
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
