<?php

// Include your database connection logic here
$servername = "localhost";
$username = "Munkh";
$password = "12345678";
$dbname = "household_goods_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you receive the search parameter via GET
$searchParam = isset($_GET['search']) ? $_GET['search'] : '';

// Implement your database query logic here
$sql = "SELECT * FROM goods_info WHERE name LIKE '%$searchParam%' OR category LIKE '%$searchParam%'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch data and return it in JSON format
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $response = array('status' => 'success', 'data' => $rows);
} else {
    // If no results, return an empty JSON array or an appropriate message
    $response = array('status' => 'success', 'data' => array());
}
// Close the database connection
$conn->close();

// Send the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);

?>
