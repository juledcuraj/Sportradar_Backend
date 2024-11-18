<?php
function getTestDbConnection() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "sportradar_test"; // Your testing database

    // Create a test database connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection to test database failed: " . $conn->connect_error);
    }

    return $conn;
}
