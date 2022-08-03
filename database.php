<?php
$servername = "localhost";
// REPLACE with your Database name
$dbname = "tubes_pse_data";
// REPLACE with Database user
$username = "root";
// REPLACE with Database user password
$password = "";

function getAllReadings($limit)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM sensor_data order by reading_time desc limit " . $limit;
    if ($result = $conn->query($sql)) {
        return $result;
    } else {
        return false;
    }
    $conn->close();
}
function getLastReadings()
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM sensor_data order by reading_time desc limit 1";
    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    $conn->close();
}

function minReading($limit, $value)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT MIN(" . $value . ") AS min_amount FROM (SELECT " . $value . " FROM sensor_data order by reading_time desc limit " . $limit . ") AS min";
    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    $conn->close();
}

function maxReading($limit, $value)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT MAX(" . $value . ") AS max_amount FROM (SELECT " . $value . " FROM sensor_data order by reading_time desc limit " . $limit . ") AS max";
    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    $conn->close();
}

function avgReading($limit, $value)
{
    global $servername, $username, $password, $dbname;

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT AVG(" . $value . ") AS avg_amount FROM (SELECT " . $value . " FROM sensor_data order by reading_time desc limit " . $limit . ") AS avg";
    if ($result = $conn->query($sql)) {
        return $result->fetch_assoc();
    } else {
        return false;
    }
    $conn->close();
}
