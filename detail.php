<?php

// Include your database connection logic here
$servername = "your_server_name";
$username = "your_username";
$password = "your_password";
$dbname = "household_goods_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Assuming you receive the row record number via GET
$rowRecordNumber = isset($_GET['row']) ? $_GET['row'] : '';

// Implement your database query logic here using a prepared statement
$sql = "SELECT * FROM goods_info WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $rowRecordNumber); // Assuming 'id' is an integer, adjust the type accordingly

// Execute the statement
$stmt->execute();

// Get the result
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch data and return it in JSON format
    $rows = array();
    while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
    }
    $response = array('status' => 'success', 'data' => $rows);
} else {
    // If no results, return an error message
    $response = array('status' => 'error', 'message' => 'Record not found');
}

// Close the statement and the database connection
$stmt->close();
$conn->close();

// Send the response in JSON format
header('Content-Type: application/json');
echo json_encode($response);

?>
