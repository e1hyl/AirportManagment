<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Airplane and Hangar Table</title>
    <link rel="stylesheet" href="style_Airport_Airplane.css">
    <!-- <style>
        table {
            width: 50%;
            border-collapse: collapse;
            align-items: center;
        }
        th, td{
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #f2f2f2;
        }
    </style> -->
</head>
<body>

<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "airport_managment"; // Corrected database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get selected airline from query parameter (assuming it's passed via URL)
$selectedAirline = $_GET['airline']; // Assuming you're passing 'airline' as a query parameter

// SQL query to retrieve airplane details for the selected airline
$sql_airplanes = "SELECT a.*, c.CoName
                  FROM airplane a
                  LEFT JOIN cooperation c ON a.a_id = c.Aid
                  WHERE c.CoName = ?";

// Prepare the SQL statement with parameter
$stmt_airplanes = $conn->prepare($sql_airplanes);

if ($stmt_airplanes === false) {
    die('Error preparing airplane statement: ' . $conn->error);
}

// Bind the parameter to the statement
$stmt_airplanes->bind_param('s', $selectedAirline); // 's' indicates a string parameter

// Execute the statement
$stmt_airplanes->execute();

// Get result set for airplanes
$result_airplanes = $stmt_airplanes->get_result();

// Display airplane details in a table
if ($result_airplanes->num_rows > 0) {
    echo "<h2>Airplanes:</h2>";
    echo "<table>";
    echo "<tr><th>Airport</th><th>Airplane Model</th><th>Capacity</th><th>Weight</th></tr>";
    while ($row_airplane = $result_airplanes->fetch_assoc()) {
        // Display airplane details as table rows
        echo "<tr>";
        echo "<td>" . $row_airplane['airName'] . "</td>";
        echo "<td>" . $row_airplane['model'] . "</td>";
        echo "<td>" . $row_airplane['capacity'] . "</td>";
        echo "<td>" . $row_airplane['weight'] . "</td>";
        // Add more details as needed
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No airplanes found for this airline.</p>";
}

// Close the airplane statement
$stmt_airplanes->close();

// SQL query to retrieve hangar details for the selected airline
$sql_hangars = "SELECT h.H_id, h.capacity
FROM hangar h
LEFT JOIN cooperation c ON h.Aid = c.Aid
WHERE c.CoName = ?";
// Prepare the SQL statement with parameter
$stmt_hangars = $conn->prepare($sql_hangars);

if ($stmt_hangars === false) {
    die('Error preparing hangar statement: ' . $conn->error);
}

// Bind the parameter to the statement
$stmt_hangars->bind_param('s', $selectedAirline); // 's' indicates a string parameter

// Execute the statement
$stmt_hangars->execute();

// Get result set for hangars
$result_hangars = $stmt_hangars->get_result();

// Display hangar details in a table
if ($result_hangars->num_rows > 0) {
    echo "<h2>Hangars:</h2>";
    echo "<table>";
    echo "<tr><th>Hangar ID</th><th>Capacity</th></tr>";
    while ($row_hangar = $result_hangars->fetch_assoc()) {
        // Display hangar details as table rows
        echo "<tr>";
        echo "<td>" . $row_hangar['H_id'] . "</td>";
        echo "<td>" . $row_hangar['capacity'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hangars found for this airline.</p>";
}

// Close the hangar statement and connection
$stmt_hangars->close();
$conn->close();
?>

</body>
</html>
